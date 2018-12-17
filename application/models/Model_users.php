<?php 

class Model_users extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getUserData() 
	{
		$sql = "SELECT * FROM users WHERE user_id != ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}
	public function getUserById($userId = null) 
	{
		if($userId) {
			$sql = "SELECT * FROM users WHERE user_id = ?";	
			$query = $this->db->query($sql, array($userId));
			return $query->row_array();
		}
	}

	public function create($data = '', $group_id = null)
	{
		if($data && $group_id) {
			$create = $this->db->insert('users', $data);
			return ($create == true) ? true : false;
		}
	}
	/*
		更新用户的权限
	*/
	public function update($data=array(),$id)
	{
		$this->db->where('user_id',$id);
		$update = $this->db->update('users', $data);
		return ($update == true) ? true : false;	
	}
	public function edit($data = array(), $id = null)
	{
		$this->db->where('user_id', $id);
		$update = $this->db->update('users', $data);
			
		return ($update == true) ? true : false;	
	}

	public function delete($id)
	{
		$this->db->where('user_id', $id);
		$delete = $this->db->delete('users');
		return ($delete == true) ? true : false;
	}

	public function deleteAll()
	{
		$sql='delete from users';
		$delete = $this->db->query($sql);
	}
	public function countTotalUsers()
	{
		$sql = "SELECT * FROM users";
		
		$query = $this->db->query($sql);
		echo $query->num_rows();
		return $query->num_rows();
	}
}