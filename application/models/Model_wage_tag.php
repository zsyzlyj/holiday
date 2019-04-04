<?php 

class Model_wage_tag extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	public function getTagData(){
		$sql = "SELECT * FROM wage_tag WHERE user_id != ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}
	public function getTagById($userId = null){
		if($userId){
			$sql = "SELECT * FROM wage_tag WHERE user_id = ?";	
			$query = $this->db->query($sql, array($userId));
			return $query->row_array();
		}
	}
	public function getByDept($dept){
		$sql = "SELECT * FROM wage_tag where locate(?,dept)";
		$query = $this->db->query($sql, array($dept));
		return $query->result_array();
	}
	public function create($data = ''){
		if($data){
			$create = $this->db->insert('wage_tag', $data);
			return ($create == true) ? true : false;
		}
	}
	public function createbatch($data){
		if($data){
			$insert = $this->db->insert_batch('wage_tag', $data);
			return ($insert == true) ? true : false;
		}
	}
	/*
		更新用户的权限
	*/
	public function update($data=array(),$id){
		$this->db->where('user_id',$id);
		$update = $this->db->update('wage_tag', $data);
		return ($update == true) ? true : false;	
	}

	public function delete($id){
		$this->db->where('user_id', $id);
		$delete = $this->db->delete('wage_tag');
		return ($delete == true) ? true : false;
	}
	public function exportData($dept = null){	
		if($dept){	
			$sql = "SELECT * FROM wage_tag WHERE locate(?,dept)";
			$query = $this->db->query($sql, array($dept));
			return $query;
		}
		else return NULL;
	}
	public function deleteAll(){
		$sql='delete from wage_tag';
		$delete = $this->db->query($sql);
	}
	
	public function getModeById($id){
		if($id){
			$sql = "SELECT service_mode FROM wage_tag WHERE user_id = ?";	
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}
	}
}