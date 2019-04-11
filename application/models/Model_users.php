<?php 

class Model_users extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	public function getUserData(){
		$sql = "SELECT * FROM users WHERE user_id != ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}
	public function getUserById($userId = null){
		if($userId){
			$sql = "SELECT * FROM users WHERE user_id = ?";	
			$query = $this->db->query($sql, array($userId));
			$query->num_rows();
			return $query->row_array();
		}
	}
	public function getIdByName($name){
		$sql = 'SELECT user_id,username FROM users WHERE username = ?';
		$query = $this->db->query($sql, array($name));
		return $query->result_array();
	}
	public function checkUserById($userId = null){
		if($userId){
			$sql = "SELECT * FROM users WHERE user_id = ?";	
			$query = $this->db->query($sql, array($userId));
			return ($query->num_rows() == 1) ? true : false;
		}
		return false;
	}

	public function create($data = ''){
		if($data){
			$create = $this->db->insert('users', $data);
			return ($create == true) ? true : false;
		}
	}
	public function createbatch($data = ''){
		if($data){
			$create = $this->db->insert_batch('users', $data);
			return ($create == true) ? true : false;
		}
	}
	public function update($data=array(),$id){
		$this->db->where('user_id',$id);
		$update = $this->db->update('users', $data);
		return ($update == true) ? true : false;	
	}
	public function updatebatch($data=array()){
		if($data){
			$create = $this->db->update_batch('users', $data, 'user_id');
			return ($create == true) ? true : false;
		}
	}
	public function edit($data = array(), $id = null){
		$this->db->where('user_id', $id);
		$update = $this->db->update('users', $data);
		return ($update == true) ? true : false;	
	}

	public function delete($id){
		$this->db->where('user_id', $id);
		$delete = $this->db->delete('users');
		return ($delete == true) ? true : false;
	}

	public function deleteAll(){
		$sql='delete from users';
		$delete = $this->db->query($sql);
	}
}