<?php 

class Model_holiday extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the brand data */
	public function getHolidayData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM holiday where name = ?";
			$query = $this->db->query($sql, array($name));
			return $query->row_array();
		}

		$sql = "SELECT * FROM holiday";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getHolidayById($userId = null) 
	{
		
		if($userId) {
			$sql = "SELECT * FROM holiday WHERE user_id = ?";	
			$query = $this->db->query($sql, array($userId));
			return $query->row_array();
		}
		$sql = "SELECT * FROM holiday";
		$query = $this->db->query($sql);
		return $query->result();
	}
	public function getHolidayByDept($dept = null) 
	{
		
		if($dept) {
			$sql = "SELECT * FROM holiday WHERE department = ?";	
			$query = $this->db->query($sql, array($dept));
			return $query->row_array();
		}
		$sql = "SELECT * FROM holiday";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function exportHolidayData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM holiday where name = ?";
			$query = $this->db->query($sql, array($name));
			return $query->row_array();
		}

		$sql = "SELECT * FROM holiday";
		return $this->db->query($sql);
	}
	
	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('holiday', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('name', $id);
			$update = $this->db->update('holiday', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('name', $id);
			$delete = $this->db->delete('holiday');
			return ($delete == true) ? true : false;
		}
	}

	public function countTotalholiday()
	{
		$sql = "SELECT * FROM holiday";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

}