<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class super_hr extends Admin_Controller {
	public function __construct(){
        parent::__construct();
        $this->data['page_title'] = 'Super';
        //$this->load->model('model_human_info');
        $this->data['user_name'] = $this->session->userdata('user_id');
        $this->data['user_id'] = $this->session->userdata('user_id');
        if($this->data['user_name']==NULL){
            redirect('super_auth/login','refresh');
        }
        $this->data['permission']=$this->session->userdata('permission');
    }
    public function index(){
        $this->data['column_name']="";
        $this->data['hr_data']="";
        $this->render_super_template('super/hr',$this->data);
    }

    public function hr_excel_put(){
        $this->load->library('phpexcel');//ci框架中引入excel类
        $this->load->library('PHPExcel/IOFactory');
        //先做一个文件上传，保存文件
        $path=$_FILES['file'];
        $filename=date("Ym");
        //根据上传类型做不同处理
        if(strstr($_FILES['file']['name'],'xlsx')){
            $reader = new PHPExcel_Reader_Excel2007();
            $filePath = 'uploads/hr/'.$filename.'.xlsx';
            move_uploaded_file($path['tmp_name'],$filePath);
        }
        elseif(strstr($_FILES['file']['name'], 'xls')){
            $reader = IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)
            $filePath = 'uploads/hr/'.$filename.'.xls';
            move_uploaded_file($path['tmp_name'],$filePath);
            
        }
        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ','BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ','CA', 'CB', 'CC', 'CD', 'CE', 'CF', 'CG', 'CH', 'CI', 'CJ', 'CK', 'CL', 'CM', 'CN', 'CO', 'CP', 'CQ', 'CR', 'CS', 'CT', 'CU', 'CV', 'CW', 'CX', 'CY', 'CZ','DA', 'DB', 'DC', 'DD', 'DE', 'DF', 'DG', 'DH', 'DI', 'DJ', 'DK', 'DL', 'DM', 'DN', 'DO', 'DP', 'DQ', 'DR', 'DS', 'DT', 'DU', 'DV', 'DW', 'DX', 'DY', 'DZ'); 
        $PHPExcel = $reader->load($filePath, 'utf-8'); // 载入excel文件
        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
        echo $sheet->getTitle();
        /*
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumm = $sheet->getHighestColumn(); // 取得总列数
        $columnCnt = array_search($highestColumm, $cellName); 

        $batch_counter=0;
        $data = array();
        $attribute = array();
        $this->model_wage->deleteByDate($filename);
        $this->model_wage_attr->deleteByDate($filename);
        
        for($rowIndex = 1; $rowIndex <= $highestRow; $rowIndex++){        //循环读取每个单元格的内容。注意行从1开始，列从A开始
            $temp = array();
            for($colIndex = 0; $colIndex <= $columnCnt; $colIndex++){
                $cellId = $cellName[$colIndex].$rowIndex;  
                $cell = $sheet->getCell($cellId)->getValue();
                $cell = $sheet->getCell($cellId)->getCalculatedValue();
                if($cell instanceof PHPExcel_RichText){ //富文本转换字符串
                    $cell = $cell->__toString();
                }
                $temp[$colIndex] = $cell;
            }
            if($rowIndex==2){
                if($this->model_wage_notice->getWageNoticeByDate($filename)){
                    $notice=array(
                        'content' => $temp[4]
                    );
                    $this->model_wage_notice->update($notice,$filename);
                    unset($notice);
                }
                else{
                    $notice=array(
                        'date_tag' => $filename,
                        'content' => $temp[4]
                    );
                    $this->model_wage_notice->create($notice);
                    unset($notice);
                }
                
            }
            if($rowIndex==3){
                $attr_counter=1;
                foreach($temp as $k => $v){
                    if($v!=''){
                        $attribute['attr_name'.$attr_counter]=$v;
                        $attr_counter++;
                        
                        if($v=='当月月应收合计'){
                            $sum_mark=$attr_counter-5;
                        }
                    }
                }
                $attribute['date_tag']=$filename;
                $attr_counter--;
                if($this->model_wage_attr->getWageAttrDataByDate($filename)){
                    $this->model_wage_attr->update($attribute,$filename);
                }
                else{
                    $this->model_wage_attr->create_attr($attribute);
                }
            }
            if($rowIndex>3){
                $wage=array();
                $counter=0;
                foreach($temp as $k => $v){
                    if($counter==$attr_counter-1){
                        if($v!=''){
                            $wage['content'.($counter-3)]=$v;
                        }
                        else{
                            $wage['content'.($counter-3)]="";
                        }
                        $wage['date_tag']=$filename;
                        break;
                    }
                    if($v!=''){
                        switch($k){
                            case 0:$wage['number']=$v;break;
                            case 1:$wage['department']=$v;break;
                            case 2:$wage['user_id']=$v;break;
                            case 3:$wage['name']=$v;break;
                            default:if(is_numeric($v)) $wage['content'.($counter-3)]=number_format(round((float)$v,2),2,".",""); else $wage['content'.($counter-3)]=$v;break;
                        }
                        $counter++;
                    }
                    elseif(strlen($v)==1 and $v==0){
                        $wage['content'.($counter-3)]='0.00';
                        $counter++;
                    }
                }
                $dept=$wage['department'];
                $wage['total']=$wage['content'.$sum_mark];
                #echo count($wage).'<br />';
                array_push($data,$wage);
                #$this->model_wage->create($wage);
                unset($wage);
                //如果不是多部门，不包含/，那么就记录下来
                if(strpos($dept,'/') != true){
                    $dept_data=array(
                        'dept_name' => $dept,
                    );
                    //如果不存在，则创建
                    if(!$this->model_dept->check_dept($dept))
                        $this->model_dept->create($dept_data);
                }
            }
            unset($temp);
        }
        $this->model_wage->createbatch($data);
        */
    }

    public function hr_import(){
        $this->data['path'] = "uploads/standard/负责人和綜管員角色表模板.xlsx";
        if($_FILES){
            if($_FILES["file"]){
                if($_FILES["file"]["error"] > 0){
                    $this->session->set_flashdata('error', '请选择要上传的文件！');
                    $this->render_super_template('super/hr_import',$this->data);
                }
                else{
                    /*
                    foreach($this->model_hr->getData() as $k => $v){
                        $this->model_hr->delete($v['user_id']);
                    }
                    */
                    $this->hr_excel_put();
                    //$this->index();
                }
            }
        }
        else{
            $this->render_super_template('super/hr_import',$this->data);
        }
    }
}