<?php 

class Model_wage extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the brand data */
	public function getWageData()
	{
		$sql = "SELECT * FROM wage";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getWageById($userId = null) 
	{
		if($userId) {
			$sql = "SELECT * FROM wage WHERE user_id = ?";	
			$query = $this->db->query($sql, array($userId));
			return $query->row_array();
		}
	}
	public function getWageByDept($dept = null) 
	{
		if($dept) {	
			$sql = "SELECT * FROM wage WHERE locate(?,department)";
			$query = $this->db->query($sql, array($dept));
			return $query->result_array();
		}
	}
	public function exportWageData($id = null)
	{
		$sql = "SELECT * FROM wage";
		return $this->db->query($sql);
	}
	public function exportmydeptWageData($dept=null)
	{
		if($dept) {
			$sql = "SELECT * FROM wage WHERE locate(?,department)";
			$query = $this->db->query($sql, array($dept));
			return $query;
		}

	}
	
	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('wage', $data);
			return ($insert == true) ? true : false;
		}
	}
	
	public function deleteAll()
	{
		$sql='delete from wage';
		$delete = $this->db->query($sql);
		return ($delete == true) ? true : false;
	}

}