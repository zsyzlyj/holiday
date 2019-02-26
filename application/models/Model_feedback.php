<?php 

class Model_feedback extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	/* get the brand data */
	public function getFeedbackData(){
		$sql = "SELECT * FROM feedback";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getFeedbackByDept($dept = null){
		if($dept){	
			$sql = "SELECT * FROM feedback WHERE locate(?,department)";
			$query = $this->db->query($sql, array($dept));
			return $query->row_array();
		}
		$sql = "SELECT * FROM feedback";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getFeedbackStatus(){		
		$sql = "SELECT department,feedback_status,submit_status,confirm_status FROM feedback";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function exportFeedbackData($dept = null){
		$sql = "SELECT * FROM feedback";
		return $this->db->query($sql);
	}
	public function exportmydeptFeedbackData($dept = null){
		if($dept){
			$sql = "SELECT * FROM feedback WHERE locate(?,department)";
			return $this->db->query($sql, array($dept));	
		}
		$sql = "SELECT * FROM feedback";
		return $this->db->query($sql);
	}
	
	public function create($data){
		if($data){
			$insert = $this->db->insert('feedback', $data);
			return ($insert == true) ? true : false;
		}
	}
	public function createbatch($data){
		if($data){
			$insert = $this->db->insert_batch('feedback', $data);
			return ($insert == true) ? true : false;
		}
	}
	public function update($data, $dept){
		if($data && $dept){
			$this->db->where('department', $dept);
			$update = $this->db->update('feedback', $data);
			return ($update == true) ? true : false;
		}
	}
	public function deleteAll(){
		$sql='delete from feedback';
		$delete = $this->db->query($sql);
	}
}