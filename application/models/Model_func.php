<?php 

class Model_func extends CI_Model{
	public function __construct(){
		parent::__construct();
	}
	public function getFuncData(){
		$sql = "SELECT * FROM func";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getFuncByType($type = null){
		if($type){
			$sql = "SELECT * FROM func WHERE func_type = ?";	
			$query = $this->db->query($sql, array($type));
			return $query->result_array();
		}
		$sql = "SELECT * FROM func";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function edit($data = array(), $id = null){
		$this->db->where('name', $id);
		$update = $this->db->update('func', $data);
			
		return ($update == true) ? true : false;	
	}
}