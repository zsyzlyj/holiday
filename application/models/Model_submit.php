<?php 

class Model_submit extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the brand data */
	public function getSubmitData()
	{

		$sql = "SELECT * FROM submit";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getSubmitByDept($dept = null) 
	{
		
		if($dept) {	
			$sql = "SELECT * FROM submit WHERE locate(?,department)";
			$query = $this->db->query($sql, array($dept));
			return $query->row_array();
		}
		$sql = "SELECT * FROM submit";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function exportSubmitData($dept = null)
	{
		$sql = "SELECT * FROM submit";
		return $this->db->query($sql);
	}
	public function exportmydeptSubmitData($dept = null)
	{
		if($dept) {
			$sql = "SELECT * FROM submit WHERE locate(?,department)";
			return $this->db->query($sql, array($dept));	
		}

		$sql = "SELECT * FROM submit";
		return $this->db->query($sql);
	}
	
	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('submit', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $dept)
	{
		if($data && $dept) {
			$this->db->where('department', $dept);
			$update = $this->db->update('submit', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($dept)
	{
		if($dept) {
			$this->db->where('department', $dept);
			$delete = $this->db->delete('submit');
			return ($delete == true) ? true : false;
		}
	}

	public function countTotalsubmit()
	{
		$sql = "SELECT * FROM submit";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	public function deleteAll()
	{
		$sql='delete from submit';
		$delete = $this->db->query($sql);
	}
}