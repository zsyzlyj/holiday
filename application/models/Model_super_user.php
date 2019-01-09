<?php 

class Model_super_user extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	public function getUserData(){
		$sql = "SELECT * FROM super_user WHERE user_id != ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}
	public function getUserById($userId = null){
		if($userId){
			$sql = "SELECT * FROM super_user WHERE user_id = ?";	
			$query = $this->db->query($sql, array($userId));
			return $query->row_array();
		}
	}

	public function create($data = '', $group_id = null){
		if($data && $group_id){
			$create = $this->db->insert('super_user', $data);
			return ($create == true) ? true : false;
		}
	}
	/*
		更新用户的权限
	*/

	public function edit($data = array(), $id = null){
		$this->db->where('user_id', $id);
		$update = $this->db->update('super_user', $data);			
		return ($update == true) ? true : false;	
	}
	public function delete($id){
		$this->db->where('user_id', $id);
		$delete = $this->db->delete('super_user');
		return ($delete == true) ? true : false;
	}

}