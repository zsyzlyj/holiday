<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Wage extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Wage';

        $this->load->model('model_wage');
        $this->load->model('model_users');
        $this->load->model('model_manager');
        $this->data['permission'] = $this->session->userdata('permission');
        $this->data['user_name'] = $this->session->userdata('user_name');
	}

    /* 
    * It only redirects to the manage product page
    */
    function importExecl($file='', $sheet=0){  

        $file = iconv("utf-8", "gb2312", $file);   //转码  
    
        if(empty($file) OR !file_exists($file)) {  
            die('file not exists!');  
        }  
    
        include('PHPExcel.php');  //引入PHP EXCEL类  
    
        $objRead = new PHPExcel_Reader_Excel2007();   //建立reader对象  
    
        if(!$objRead->canRead($file)){  
    
            $objRead = new PHPExcel_Reader_Excel5();  
    
            if(!$objRead->canRead($file)){  
    
                die('No Excel!');  
    
            }  
    
        }  
    
       
    
        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');  
    
       
    
        $obj = $objRead->load($file);  //建立excel对象  
    
        $currSheet = $obj->getSheet($sheet);   //获取指定的sheet表  
    
        $columnH = $currSheet->getHighestColumn();   //取得最大的列号  
    
        $columnCnt = array_search($columnH, $cellName);  
    
        $rowCnt = $currSheet->getHighestRow();   //获取总行数  
    
       
    
        $data = array();  
    
        for($_row=1; $_row<=$rowCnt; $_row++){  //读取内容  
    
            for($_column=0; $_column<=$columnCnt; $_column++){  
    
                $cellId = $cellName[$_column].$_row;  
    
                $cellValue = $currSheet->getCell($cellId)->getValue();  
    
                 //$cellValue = $currSheet->getCell($cellId)->getCalculatedValue();  #获取公式计算的值  
    
                if($cellValue instanceof PHPExcel_RichText){   //富文本转换字符串  
    
                    $cellValue = $cellValue->__toString();  
    
                }
                $data[$_row][$cellName[$_column]] = $cellValue;  
            }  
        }
        return $data;  
    
    }
    
	public function index()
	{        
		$this->render_template('wage/', $this->data);
    }
    /*
    * It Fetches the products data from the product table 
    * this function is called from the datatable ajax function
    */
	public function fetchWageData()
	{
		$result = array('data' => array());

        $data = $this->model_wage->getWageData();
        echo $data;
        
		foreach ($data as $key => $value) {
			$result['data'][$key] = array(
				$value['name'],
				$value['indate'],
                $value['companyage'],
                $value['sumage'],
                $value['sumday'],
                $value['lastyear'],
                $value['thisyear'],
                $value['bonus'],
                $value['used'],
                $value['rest'],
            );
            console($result['data']['name']);
		} // /foreach

        echo json_encode($result);
       /* */
	}	

    /*
    * If the validation is not valid, then it redirects to the create page.
    * If the validation for each input field is valid then it inserts the data into the database 
    * and it stores the operation message into the session flashdata and display on the manage product page
    */
	public function create()
	{
		$this->form_validation->set_rules('product_name', 'Product name', 'trim|required');
		$this->form_validation->set_rules('sku', 'SKU', 'trim|required');
		$this->form_validation->set_rules('price', 'Price', 'trim|required');
		$this->form_validation->set_rules('qty', 'Qty', 'trim|required');
        #$this->form_validation->set_rules('store', 'Store', 'trim|required');
		#$this->form_validation->set_rules('availability', 'Availability', 'trim|required');
		
	
        if ($this->form_validation->run() == TRUE) {
            // true case
        	$upload_image = $this->upload_image();

        	$data = array(
        		'name' => $this->input->post('product_name'),
        		'sku' => $this->input->post('sku'),
        		'price' => $this->input->post('price'),
        		'qty' => $this->input->post('qty'),
        		'image' => $upload_image,
        		'description' => $this->input->post('description'),
        		#'attribute_value_id' => json_encode($this->input->post('attributes_value_id')),
        		#'brand_id' => json_encode($this->input->post('brands')),
        		#'category_id' => json_encode($this->input->post('category')),
                #'store_id' => $this->input->post('store'),
        		#'availability' => $this->input->post('availability'),
        	);

        	$create = $this->model_products->create($data);
        	if($create == true) {
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('products/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('products/create', 'refresh');
        	}
        }
        else {
            // false case

        	// attributes 
        	$attribute_data = $this->model_attributes->getActiveAttributeData();

        	$attributes_final_data = array();
        	foreach ($attribute_data as $k => $v) {
        		$attributes_final_data[$k]['attribute_data'] = $v;

        		$value = $this->model_attributes->getAttributeValueData($v['id']);

        		$attributes_final_data[$k]['attribute_value'] = $value;
        	}

        	$this->data['attributes'] = $attributes_final_data;
			$this->data['brands'] = $this->model_brands->getActiveBrands();        	
			$this->data['category'] = $this->model_category->getActiveCategroy();        	
			#$this->data['stores'] = $this->model_stores->getActiveStore();        	

            $this->render_template('products/create', $this->data);
        }	
	}

    public function excel_put(){
        
        $this->load->library("phpexcel");//ci框架中引入excel类
        $this->load->library('PHPExcel/IOFactory');
        //先做一个文件上传，保存文件
        $path=$_FILES['file'];
        $filePath = "uploads/".$path["name"];
        move_uploaded_file($path["tmp_name"],$filePath);
        //根据上传类型做不同处理
        
        if (strstr($_FILES['file']['name'],'xlsx')) {
            $reader = new PHPExcel_Reader_Excel2007();
        }
        else{
            if (strstr($_FILES['file']['name'], 'xls')) {
                $reader = IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)
            }
        }

        $PHPExcel = $reader->load($filePath, 'utf-8'); // 载入excel文件
        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumm = $sheet->getHighestColumn(); // 取得总列数

        $data = array();
        for ($rowIndex = 1; $rowIndex <= $highestRow; $rowIndex++) {        //循环读取每个单元格的内容。注意行从1开始，列从A开始
            for ($colIndex = 'A'; $colIndex <= $highestColumm; $colIndex++) {
                $addr = $colIndex . $rowIndex;
                $cell = $sheet->getCell($addr)->getValue();
                if ($cell instanceof PHPExcel_RichText) { //富文本转换字符串
                    $cell = $cell->__toString();
                }
                $data[$rowIndex][$colIndex] = $cell;
            }
        }

        $column=array();
        $column_name=array();
        $attribute_data=array();
        $first=true;
        $flag=false;
        $counter=0;
        $name="";
        $dept="";
        $Initdate=gmdate("Y-m-d") ;
        $Indate=gmdate("Y-m-d");
        $Totalage=0;
        $Comage=0;
        $Totalday=0;
        $Lastyear=0;
        $Thisyear=0;
        $Bonus=0;
        $Used=0;
        $Rest=0;
        $Jan=0;
        $Feb=0;
        $Mar=0;
        $Apr=0;
        $May=0;
        $Jun=0;
        $Jul=0;
        $Aug=0;
        $Sep=0;
        $Oct=0;
        $Nov=0;
        $Dece=0;
        $User_id="";
        foreach($data as $k => $v){
            if($first){
                $first=false;
                foreach($v as $a =>$b){
                    array_push($column_name,$b);
                }
            }
            else{
                array_push($column,$v);
            }
        }
        /* excel导入时间的方法！ */
        $initflag=0;
        foreach($column as $k => $v)
        {
            foreach($v as $a => $b)
            {
                echo $b.'<br />';

            }
            /*
            $Update_data=array(
                'name' => $name,
                'department' => $dept,
                'initdate' => $Initdate,
                'indate' => $Indate,
                'Companyage' => $Comage,
                'Totalage' => $Totalage,
                'Totalday' => $Totalday,
                'Lastyear' => $Lastyear,
                'Thisyear' => $Thisyear,
                'Bonus' => $Bonus,
                'Used' => $Used,
                'Rest' => $Rest,
                'Jan' => $Jan,
                'Feb' => $Feb,
                'Mar' => $Mar,
                'Apr' => $Apr,
                'May' => $May,
                'Jun' => $Jun,
                'Jul' => $Jul,
                'Aug' => $Aug,
                'Sep' => $Sep,
                'Oct' => $Oct,
                'Nov' => $Nov,
                'Dece' => $Dece,
                'initflag' => $initflag,
                'User_id' => $User_id
            );
*/
            $update_user=true;
            if(1)#($this->model_holiday->getWagebyID($User_id))
            {
                /*
                if(!(serialize($Update_data) == serialize($this->model_holiday->getWagebyID($User_id)))){
                   $update=$this->model_holiday->update($Update_data,$User_id);
                }
                */
            }
            else{
                /*
                $update=$this->model_holiday->create($Update_data);
                if($this->model_users->getUserById($User_id)==1){
                    $Update_user_data=array(
                        'user_id' => $User_id,
                        'username' => $name,
                        'password' => md5('hr'),
                        'permission' => '3'
                    );
            
                    $update_user=$this->model_users->create($Update_user_data,$name);
                }
                $submit_data=array(
                    'department' => $Update_data['department']
                );
                $this->model_submit->create($submit_data);
                $feedback_data=array(
                    'department' => $Update_data['department'],
                );
                $this->model_feedback->create($feedback_data);
                */
            }
            /*
            if($update == true and $update_user == true) {
                $response['success'] = true;
                $response['messages'] = 'Succesfully updated';
            }
            else {
                $response['success'] = false;
                $response['messages'] = 'Error in the database while updated the brand information';			
            }
            */
            
        }
    }
    public function import($filename=NULL)
    {
        
        
        
        if($_FILES){
        if($_FILES["file"])
            {
                if ($_FILES["file"]["error"] > 0)
                {
                    echo "Error: " . $_FILES["file"]["error"] . "<br />";
                }
                else
                {
                    $this->excel_put();
                    $this->index();
                }
            }
        }
        else{
            $this->render_template('wage/import',$this->data);
        }        
    }

    /*
    ==============================================================================
    普通员工
    ==============================================================================
    */

    public function staff()
	{
        $user_id=$this->session->userdata('user_id');
        $wage_data = $this->model_wage->getWageById($user_id);
        $result = array();
        foreach ($wage_data as $k => $v) {
            $result[$k] = $v;
        }
        $this->data['wage_data'] = $result;        
		$this->render_template('wage/staff', $this->data);
    }

    public function mydeptwage()
    {
        $result=array();
        $user_id=$this->session->userdata('user_id');
        $this->data['current_dept']="";
        if($_POST){
            $select_dept=$_POST['selected_dept'];
            $wage_data = $this->model_wage->getWageByDept($select_dept);
            $result = array();
            foreach ($wage_data as $k => $v)
            {
                $result[$k] = $v;
            }

            $this->data['wage_data'] = $result;
            $this->data['current_dept']=$select_dept;

        }
        
        $admin_data = $this->model_manager->getManagerById($user_id);

        $admin_result=array();
        $admin_result=explode('/',$admin_data['dept']);

        $this->data['dept_options']=$admin_result;

        $this->data['wage_data'] = $result;
        
        
		$this->render_template('wage/mydeptwage', $this->data);
    }

    /*
    ==============================================================================
    部门经理
    ==============================================================================
    */
    public function manager()
	{
        $user_id=$this->session->userdata('user_id');
        $wage_data = $this->model_wage->getWageById($user_id);
        $notice_data = $this->model_notice->getNoticeLatest();
        $result = array();
        $notice_result=array();
        foreach ($notice_data as $k => $v) {
            $notice_result[$k] = $v;
        }
        
        foreach ($wage_data as $k => $v) {
            $result[$k] = $v;
        }

        $this->data['wage_data'] = $result;
        $this->data['notice_data'] = $notice_result;
        
        
        

		$this->render_template('wage/index', $this->data);
    }

}