<?php 

class Model_holiday extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	/* get the brand data */
	public function getHolidayData(){
		$sql = "SELECT * FROM holiday";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getHolidayById($userId = null){
		if($userId){
			$sql = "SELECT * FROM holiday WHERE user_id = ?";	
			$query = $this->db->query($sql, array($userId));
			return $query->row_array();
		}
		else return null;
		/*
		$sql = "SELECT * FROM holiday";
		$query = $this->db->query($sql);
		return $query->result();
		*/
	}
	public function getHolidayByDept($dept = null){	
		if($dept){	
			$sql = "SELECT * FROM holiday WHERE locate(?,department)";
			$query = $this->db->query($sql, array($dept));
			return $query->result_array();
		}
		$sql = "SELECT * FROM holiday";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function exportHolidayData($id = null){
		$sql = "SELECT * FROM holiday";
		return $this->db->query($sql);
	}
	public function exportmydeptHolidayData($dept = null){
		if($dept){
			$sql = "SELECT * FROM holiday WHERE locate(?,department)";
			return $this->db->query($sql, array($dept));	
		}

		$sql = "SELECT * FROM holiday";
		return $this->db->query($sql);
	}
	public function create($data){
		if($data){
			$insert = $this->db->insert('holiday', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function createbatch($data){
		if($data){
			$insert = $this->db->insert_batch('holiday', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function deleteAll(){
		$sql='delete from holiday';
		$delete = $this->db->query($sql);
	}

}