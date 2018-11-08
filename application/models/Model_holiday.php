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
			$sql = "SELECT * FROM holiday WHERE name = ?";	
			$query = $this->db->query($sql, array($userId));
			return $query->row_array();
		}
		$sql = "SELECT * FROM holiday";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getActiveHolidayData()
	{
		$sql = "SELECT * FROM holiday";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
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
			$this->db->where('id', $id);
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