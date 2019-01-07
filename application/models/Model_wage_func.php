<?php 

class Model_wage_func extends CI_Model{
	public function __construct(){
		parent::__construct();
	}
	public function getFuncData(){
		$sql = "SELECT * FROM wage_func";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function createbatch($data = ''){
		if($data){
			$create = $this->db->insert_batch('wage_func', $data);
			return ($create == true) ? true : false;
		}
	}
	public function edit($data = array(), $id = null){
		$this->db->where('name', $id);
		$update = $this->db->update('wage_func', $data);
			
		return ($update == true) ? true : false;	
	}
}