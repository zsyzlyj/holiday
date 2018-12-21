<?php 

class Model_manager extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getManagerData() 
	{
		$sql = "SELECT * FROM manager WHERE user_id != ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}
	public function getManagerById($userId = null) 
	{
		if($userId) {
			$sql = "SELECT * FROM manager WHERE user_id = ?";	
			$query = $this->db->query($sql, array($userId));
			return $query->row_array();
		}
	}
	public function getManagerByDept($dept = null) 
	{
		if($dept) {
			$sql = "SELECT * FROM manager WHERE locate(?,department)";
			$query = $this->db->query($sql, array($dept));
			return $query->result_array();
		}
	}

	public function create($data = '')
	{
		if($data) {
			$create = $this->db->insert('manager', $data);
			return ($create == true) ? true : false;
		}
	}
	/*
		更新用户的权限
	*/
	public function update($data=array(),$id)
	{
		$this->db->where('user_id',$id);
		$update = $this->db->update('manager', $data);
		return ($update == true) ? true : false;	
	}
	public function edit($data = array(), $id = null, $group_id = null)
	{
		$this->db->where('user_id', $id);
		$update = $this->db->update('manager', $data);

		if($group_id) {
			// user group
			$update_user_group = array('group_id' => $group_id);
			$this->db->where('user_id', $id);
			$user_group = $this->db->update('user_group', $update_user_group);
			return ($update == true && $user_group == true) ? true : false;	
		}
			
		return ($update == true) ? true : false;	
	}

	public function delete($id)
	{
		$this->db->where('user_id', $id);
		$delete = $this->db->delete('manager');
		return ($delete == true) ? true : false;
	}
	public function deleteAll()
	{
		$sql='delete from manager';
		$delete = $this->db->query($sql);
	}
}