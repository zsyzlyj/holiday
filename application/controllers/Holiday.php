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
        $this->load->model('model_notice');
	}

    /* 
    * It only redirects to the manage product page
    */
	public function index()
	{
        $holiday_data = $this->model_holiday->getHolidayData();
        $notice_data = $this->model_notice->getNoticeLatest();
        $result = array();
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
                $result[$k]['Totalday']=$result[$k]['Thisyear']+$result[$k]['Lastyear'];
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
        $result = array();
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
    
    public function import()
    {

    }
    public function export()
    {
        $holiday_data = $this->model_holiday->getHolidayData();

        <?php 
 
 
header('Content-Type: application/vnd.ms-excel');
header('Content-Type: application/octet-stream');
header('Cache-Control: max-age=0');
 
 
//连接数据库
$PDO = new PDO('mysql:host=127.0.0.1;dbname=test','username','password');
//写入前1000条数据
$sql='SELECT * FROM `sysuser` LIMIT 0, 1000';
$data=$PDO->query($sql)->fetchAll(PDO::FETCH_ASSOC);
$key=[];
//得到所有键名
foreach($data[0] as $k=>$v){
	$key[]=$k;
}
//引入phpExcel类
require_once('phpExcel.php');
$obj=new PHPExcel();		//创建对象
$str='ABCDEFGHIJKLMNOPQRSTUVWXYZ';
//表格第一行(标题)
for($i=0;$i<count($key);$i++){
	$obj->setActiveSheetIndex(0)->setCellValue($str[$i].'1',$key[$i]);
}
//设置单元格格式 背景颜色
$obj->getActiveSheet()->getStyle( 'A1:'.$str[$i-1].'1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$obj->getActiveSheet()->getStyle( 'A1:'.$str[$i-1].'1')->getFill()->getStartColor()->setARGB('FF808080');
 
 
//写入数据
foreach($data as $ke=>$val){
	$ke+=2;
	for($j=0;$j<count($val);$j++){
		$obj->setActiveSheetIndex(0)->setCellValue($str[$j].$ke,$val[$key[$j]]);
	}
}
//表格默认字体  字体大小
$obj->getDefaultStyle()->getFont()->setName('ARial');
$obj->getDefaultStyle()->getFont()->setSize(12);
 
 
//设置每列的宽
$obj->getActiveSheet()->getDefaultColumnDimension()->setWidth(14);
//具体到某列
$obj->getActiveSheet()->getColumnDimension('F')->setWidth(20);
 
 
// $obj->getDefaultStyle()->getAlignemnt()->setHorizontal(PHPExcel_Style_Alignemnt::HORIZONTAL_CENTER);
 
 
$obj->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
 
 
$obj->getActiveSheet() -> setTitle('用户列表');
$obj-> setActiveSheetIndex(0);
//生成下载文件
$objWriter=PHPExcel_IOFactory::createWriter($obj,'Excel2007');
$filename = '用户列表.xlsx';
// ob_end_clean();//清除缓存以免乱码出现
header('Content-Disposition: attachment; filename="' . $filename . '"');
 
$objWriter -> save('php://output');
--------------------- 
作者：s听风忆雪 
来源：CSDN 
原文：https://blog.csdn.net/qq_36999656/article/details/79787790 
版权声明：本文为博主原创文章，转载请附上博文链接！
    }

}