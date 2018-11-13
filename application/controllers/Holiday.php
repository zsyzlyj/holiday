<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Holiday extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Holiday';

        $this->load->model('model_holiday');
        $this->load->model('model_plan');
        $this->load->model('model_notice');
	}

    /* 
    * It only redirects to the manage product page
    */
	public function index()
	{
        $holiday_data = $this->model_holiday->getHolidayData();
        $notice_data = $this->model_notice->getNoticeLatest();

        $notice_result=array();
        foreach ($notice_data as $k => $v) {
            $notice_result[$k] = $v;
        }
        $this->data['user_permission'] = $this->session->userdata('user_permission');
        $result = array();
        foreach ($holiday_data as $k => $v) {
            $result[$k] = $v;
            
            //如果初始化過就不進行初始化 initflag记录是否被初始化过 0未初始化，1初始化完成
            if($result[$k]['initflag']==0){
                $result[$k]['Companyage']=floor((strtotime(date("Y-m-d"))-strtotime($result[$k]['indate']))/86400/365);
                $result[$k]['Totalage']=floor((strtotime(date("Y-m-d"))-strtotime($result[$k]['initdate']))/86400/365);
                if($result[$k]['Companyage']>=1 and $result[$k]['Companyage']<10){
                    $result[$k]['Thisyear']=5;
                }
                else if($result[$k]['Companyage']>=10 and $result[$k]['Companyage']<20){
                    $result[$k]['Thisyear']=10;
                }
                else if($result[$k]['Companyage']>=20){
                    $result[$k]['Thisyear']=15;
                }
                $result[$k]['Totalday']=$result[$k]['Thisyear']+$result[$k]['Lastyear']+$result[$k]['Bonus'];
                $result[$k]['Rest']=$result[$k]['Totalday'];
                $result[$k]['initflag']=1;
                $result[$k]['Used']=$result[$k]['Jan']+$result[$k]['Feb']+$result[$k]['Mar']+$result[$k]['Apr']+$result[$k]['May']+$result[$k]['Jun']+$result[$k]['Jul']+$result[$k]['Aug']+$result[$k]['Sep']+$result[$k]['Oct']+$result[$k]['Nov']+$result[$k]['Dece'];
                //更新数据
                $data = array(
                    'Companyage' => $result[$k]['Companyage'],
                    'Totalage' => $result[$k]['Totalage'],
                    'Thisyear' => $result[$k]['Thisyear'],
                    'Totalday' => $result[$k]['Totalday'],
                    'Rest' => $result[$k]['Rest'],
                    'initflag' => $result[$k]['initflag'],
                    'Used' => $result[$k]['Used'],
                );
    
                $update = $this->model_holiday->update($data, $result[$k]['name']);
            }
            
        }

        $this->data['holiday_data'] = $result;
        $this->data['notice_data'] = $notice_result;
        
		$this->render_template('holiday/index', $this->data);
    }
    
    public function staff()
	{
        $user_id=$this->session->userdata('user_id');

        $user_data=$this->model_users->getUserById($user_id);
        $holiday_data = $this->model_holiday->getHolidayById($user_data['username']);
        $notice_data = $this->model_notice->getNoticeLatest();
        $result = array();
        $notice_result=array();
        foreach ($notice_data as $k => $v) {
            $notice_result[$k] = $v;
        }
        foreach ($holiday_data as $k => $v) {
            $result[$k] = $v;
        }
        //$result['']
        /**/

        $this->data['holiday_data'] = $result;
        $this->data['notice_data'] = $notice_result;
        $this->data['user_permission'] = $this->session->userdata('user_permission');
        

		$this->render_template('holiday/index', $this->data);
    }
    
    /*
    * It Fetches the products data from the product table 
    * this function is called from the datatable ajax function
    */
	public function fetchHolidayData()
	{
		$result = array('data' => array());

        $data = $this->model_holiday->getHolidayData();
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

    /*
    * If the validation is not valid, then it redirects to the edit product page 
    * If the validation is successfully then it updates the data into the database 
    * and it stores the operation message into the session flashdata and display on the manage product page
    */
	public function update($product_id)
	{      
        if(!in_array('updateProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        if(!$product_id) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('product_name', 'Product name', 'trim|required');
        $this->form_validation->set_rules('sku', 'SKU', 'trim|required');
        $this->form_validation->set_rules('price', 'Price', 'trim|required');
        $this->form_validation->set_rules('qty', 'Qty', 'trim|required');
        $this->form_validation->set_rules('store', 'Store', 'trim|required');
        $this->form_validation->set_rules('availability', 'Availability', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            // true case
            
            $data = array(
                'name' => $this->input->post('product_name'),
                'sku' => $this->input->post('sku'),
                'price' => $this->input->post('price'),
                'qty' => $this->input->post('qty'),
                'description' => $this->input->post('description'),
                #'attribute_value_id' => json_encode($this->input->post('attributes_value_id')),
                #'brand_id' => json_encode($this->input->post('brands')),
                #'category_id' => json_encode($this->input->post('category')),
                #'store_id' => $this->input->post('store'),
                #'availability' => $this->input->post('availability'),
            );

            
            if($_FILES['product_image']['size'] > 0) {
                $upload_image = $this->upload_image();
                $upload_image = array('image' => $upload_image);
                
                $this->model_products->update($upload_image, $product_id);
            }

            $update = $this->model_products->update($data, $product_id);
            if($update == true) {
                $this->session->set_flashdata('success', 'Successfully updated');
                redirect('products/', 'refresh');
            }
            else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('products/update/'.$product_id, 'refresh');
            }
        }
        else {
            // attributes 
            $attribute_data = $this->model_attributes->getActiveAttributeData();

            $attributes_final_data = array();
            foreach ($attribute_data as $k => $v) {
                $attributes_final_data[$k]['attribute_data'] = $v;

                $value = $this->model_attributes->getAttributeValueData($v['id']);

                $attributes_final_data[$k]['attribute_value'] = $value;
            }
            
            // false case
            $this->data['attributes'] = $attributes_final_data;
            $this->data['brands'] = $this->model_brands->getActiveBrands();         
            $this->data['category'] = $this->model_category->getActiveCategroy();           
            $this->data['stores'] = $this->model_stores->getActiveStore();          

            $product_data = $this->model_products->getProductData($product_id);
            $this->data['product_data'] = $product_data;
            $this->render_template('products/edit', $this->data); 
        }   
	}
    public function delete($id)
	{
		if($id) {
			if($this->input->post('confirm')) {
				$delete = $this->model_holiday->remove($id);
				if($delete == true) {
                    $this->session->set_flashdata('success', 'Successfully removed');
                    #redirect('holiday/', 'refresh');
                    $this->index();
                }
                else {
                    $this->session->set_flashdata('error', 'Error occurred!!');
                    redirect('holiday/delete/'.$id, 'refresh');
                }
			}	
			else {
				$this->data['user_id'] = $id;
				$this->render_template('holiday/delete', $this->data);
			}	
		}
	}
    /*
    * It removes the data from the database
    * and it returns the response into the json format
    */
	public function remove()
	{
        

        $product_id = $this->input->post('product_id');

        $response = array();
        if($product_id) {
            $delete = $this->model_products->remove($product_id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed"; 
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the product information";
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refersh the page again!!";
        }

        echo json_encode($response);
    }

    public function excel(){
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
 
        $objPHPExcel->setActiveSheetIndex(0);
        
        $result = $this->model_holiday->exportHolidayData();
        // Field names in the first row
        $fields = $result->list_fields();
        $col = 0;
        foreach ($fields as $field)
        {
            $v="";
            #echo gettype($field);
            switch($field)
            {
                case 'name':$v="姓名\t";break;
                case 'department':$v="部门\t";break;
                case 'initdate':$v="开始工作时间\t";break;
                case 'indate':$v="入职时间\t";break;
                case 'Companyage':$v="社会工龄\t";break;
                case 'Totalage':$v="公司工龄\t";break;
                case 'Totalday':$v="可休假总数\t";break;
                case 'Lastyear':$v="去年休假数\t";break;
                case 'Thisyear':$v="今年休假数\t";break;
                case 'Bonus':$v="荣誉休假数\t";break;
                case 'Used':$v="已休假数\t";break;
                case 'Rest':$v="未休假数\t";break;
                case 'Jan':$v="一月\t";break;
                case 'Feb':$v="二月\t";break;
                case 'Mar':$v="三月\t";break;
                case 'Apr':$v="四月\t";break;
                case 'May':$v="五月\t";break;
                case 'Jun':$v="六月\t";break;
                case 'Jul':$v="七月\t";break;
                case 'Aug':$v="八月\t";break;
                case 'Sep':$v="九月\t";break;
                case 'Oct':$v="十月\t";break;
                case 'Nov':$v="十一月\t";break;
                case 'Dece':$v="十二月\t";break;    	
            }
            if($field != 'initflag'){
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $v);
                $col++;
            }
        }
 
        // Fetching the table data
        $row = 2;
        foreach($result->result() as $data)
        {
            $col = 0;
            foreach ($fields as $field)
            {
                if($field != 'initflag')
                {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
                    $col++;
                }
            }
 
            $row++;
        }
 
        $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
 
        $filename = date('YmdHis').".xlsx";
        // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename);
        header("Content-Disposition:filename=".$filename);
        header('Cache-Control: max-age=0');
 
        $objWriter->save('php://output');

    }

    public function download_page()
    {
        $this->render_template('holiday/export',$this->data);
    }

    public function export()
    {
        $this->excel();
        redirect('holiday/index', 'refresh');

    }
    






    public function excel_put(){
        
        $this->load->library("phpexcel");//ci框架中引入excel类
        $this->load->library('PHPExcel/IOFactory');
        //先做一个文件上传，保存文件
        $path=$_FILES['file'];
        $filePath = "uploads/".$path["name"];
        #echo $filePath;
        move_uploaded_file($path["tmp_name"],$filePath);
        //根据上传类型做不同处理
        
        if (strstr($_FILES['file']['name'],'xlsx')) {
            $reader = new PHPExcel_Reader_Excel2007();
            #echo $path["tmp_name"];
        }
        else{
            if (strstr($_FILES['file']['name'], 'xls')) {
                $reader = IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)
                #echo $path["tmp_name"];
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
        $Initdate=date("Y-m-d") ;
        $Indate=date("Y-m-d") ;
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
        foreach($data as $k => $v){
            #echo gettype($v);
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
        $initflag=0;
        foreach($column as $k => $v)
        {
            foreach($v as $a => $b)
            {
                switch($a){
                    case 'A':$name=$b;break;
                    case 'B':$dept=$b;break;
                    case 'C':$Initdate=$b;break;
                    case 'D':$Indate=$b;break;
                    case 'E':$Totalage=$b;break;
                    case 'F':$Comage=$b;break;
                    case 'G':$Totalday=$b;break;
                    case 'H':$Lastyear=$b;break;
                    case 'I':$Thisyear=$b;break;
                    case 'J':$Bonus=$b;break;
                    case 'K':$Used=$b;break;
                    case 'L':$Rest=$b;break;
                    case 'M':$Jan=$b;break;
                    case 'N':$Feb=$b;break;
                    case 'O':$Mar=$b;break;
                    case 'P':$Apr=$b;break;
                    case 'Q':$May=$b;break;
                    case 'R':$Jun=$b;break;
                    case 'S':$Jul=$b;break;
                    case 'T':$Aug=$b;break;
                    case 'U':$Sep=$b;break;
                    case 'V':$Oct=$b;break;
                    case 'W':$Nov=$b;break;
                    case 'X':$Dece=$b;break;
                    case 'Y':$User_id=$b;break;
                }
            }
            
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
                'initflag' => $initflag
            );

            $update_user=true;
            if($this->model_holiday->getHolidaybyID($name))
            {
                $update=$this->model_holiday->update($Update_data,$name);
            }
            else{
                $update=$this->model_holiday->create($Update_data);
                $Update_user_data=array(
                    'user_id' => $User_id,
                    'username' => $name,
                    'password' => md5('hr'),
                    'permission' => '3'
                );
                $update_user=$this->model_users->create($Update_user_data,$name);
            }
            
            if($update == true and $update_user == true) {
                $response['success'] = true;
                $response['messages'] = 'Succesfully updated';
            }
            else {
                $response['success'] = false;
                $response['messages'] = 'Error in the database while updated the brand information';			
            }
            
        }
    }
    public function import($filename=NULL)
    {
        
        $this->data['user_permission'] = $this->session->userdata('user_permission');
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
            $this->render_template('holiday/import',$this->data);
        }        
    }
    




    public function plan_set()
    {
        $user_id=$this->session->userdata('user_id');
        echo $user_id;
        $user_data=$this->model_users->getUserById($user_id);
        echo $user_data['username'];
        $plan_data = $this->model_plan->getPlanData();
        
        $result = array();
        
        if($plan_data)
        {
            foreach($plan_data as $k => $v)
            {
                $result[$k]=$v;
            }
            
        }
        foreach($plan_data as $k => $v)
        {
            $result[$k]=$v;
        }
        $this->data['plan_data'] = $result;
        
        $this->data['user_permission'] = $this->session->userdata('user_permission');
        

		$this->render_template('holiday/plan', $this->data);
    }




















    public function plan()
    {
        $user_id=$this->session->userdata('user_id');
        echo $user_id;
        $user_data=$this->model_users->getUserById($user_id);
        echo $user_data['username'];
        $plan_data = $this->model_plan->getplanById($user_data['username']);
        
        $notice_data = $this->model_notice->getNoticeLatest();
        $result = array();
        

        $notice_result=array();
        if($notice_data)
        {
            foreach ($notice_data as $k => $v) {
                $notice_result[$k] = $v;
            }
        }
        if($plan_data)
        {
            $plan_data['Totalday']=$plan_data['Thisyear']+$plan_data['Lastyear']+$plan_data['Bonus'];
    
            $data = array(
                'Totalday' => $plan_data['Totalday'],
            );

            $update = $this->model_plan->update($data, $plan_data['name']);
        }
        $this->data['plan_data'] = $plan_data;
        $this->data['notice_data'] = $notice_result;
        $this->data['user_permission'] = $this->session->userdata('user_permission');
        

		$this->render_template('holiday/plan', $this->data);
    }
    public function update_plan()
    {
        /*============================================================*/
        /*
            首页必须要的信息，包括用户名（后会改身份证），通知信息
        */
        /*============================================================*/
        $user_id=$this->session->userdata('user_id');
        $user_data=$this->model_users->getUserById($user_id);
        $plan_data = $this->model_plan->getPlanById($user_data['username']);
        $notice_data = $this->model_notice->getNoticeLatest();
        $result = array();
        $notice_result=array();
        foreach ($notice_data as $k => $v) {
            $notice_result[$k] = $v;
        }
        foreach ($plan_data as $k => $v) {
            $result[$k] = $v;
            #echo $v;
        }
        
        $this->data['plan_data'] = $result;
        $this->data['notice_data'] = $notice_result;
        $this->data['user_permission'] = $this->session->userdata('user_permission');
        /**/
        /*============================================================*/

        /*============================================================*/
        $response = array();
        $this->form_validation->set_rules('firstquater', 'firstquater','is_natural|greater_than[-1]');
        $this->form_validation->set_rules('secondquater', 'secondquater','is_natural|greater_than[-1]');
        $this->form_validation->set_rules('thirdquater', 'thirdquater','is_natural|greater_than[-1]');
        $this->form_validation->set_rules('fourthquater', 'fourthquater','is_natural|greater_than[-1]');

        echo $_POST['total'];


        if ($this->form_validation->run() == TRUE) {
            #echo $_POST['total'];
            if($_POST['firstquater']+$_POST['secondquater']+$_POST['thirdquater']+$_POST['fourthquater']<=$_POST['total'])
            {
                $data = array(
                    'firstquater' => $_POST['firstquater'],
                    'secondquater' => $_POST['secondquater'],
                    'thirdquater' => $_POST['thirdquater'],
                    'fourthquater' => $_POST['fourthquater']
                );

                $create = $this->model_plan->update($data,$user_data['username']);
                
                if($create == true) {
                    $this->session->set_flashdata('success', 'Successfully created');
                    $this->plan();
                }
                else {
                    $this->session->set_flashdata('error', 'Error occurred!!');
                    $this->render_template('holiday/plan', $this->data);
                }
            }
            else
            {

                $this->session->set_flashdata('error', '数据错误');
                $this->render_template('holiday/plan', $this->data);
                
            }
            /**/
        }
        else {
            $this->render_template('holiday/plan', $this->data);
        }
    }

    public function authorize()
    {
        $this->render_template('holiday/authorize', $this->data);
    }





   







}