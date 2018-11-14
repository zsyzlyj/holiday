<?php 

class Model_plan extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the brand data */
	public function getPlanData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM plan where user_id = ?";
			$query = $this->db->query($sql, array($name));
			return $query->row_array();
		}

		$sql = "SELECT * FROM plan";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getPlanById($userId = null) 
	{
		
		if($userId) {
			$sql = "SELECT * FROM plan WHERE user_id = ?";	
			$query = $this->db->query($sql, array($userId));
			return $query->row_array();
		}
		$sql = "SELECT * FROM plan";
		$query = $this->db->query($sql);
		return $query->result();
	}
	public function exportPlanData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM plan where user_id = ?";
			$query = $this->db->query($sql, array($name));
			return $query->row_array();
		}

		$sql = "SELECT * FROM plan";
		return $this->db->query($sql);
	}
	
	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('plan', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('user_id', $id);
			$update = $this->db->update('plan', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('user_id', $id);
			$delete = $this->db->delete('plan');
			return ($delete == true) ? true : false;
		}
	}

	public function countTotalplan()
	{
		$sql = "SELECT * FROM plan";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

}