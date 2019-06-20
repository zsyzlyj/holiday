<?php 

class Model_plan_seven extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	/* get the brand data */
	public function getPlanData(){
		$sql = "SELECT * FROM plan_seven";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getPlanById($userId = null){
		if($userId){
			$sql = "SELECT * FROM plan_seven WHERE user_id = ?";	
			$query = $this->db->query($sql, array($userId));
			return $query->row_array();
		}
		else return null;
	}
	public function getPlanByDept($dept = null){		
		if($dept){	
			$sql = "SELECT * FROM plan_seven WHERE locate(?,department)";
			$query = $this->db->query($sql, array($dept));
			return $query->result_array();
		}
	}
	public function exportPlanData($id = null){
		$sql = "SELECT * FROM plan_seven";
		return $this->db->query($sql);
	}
	public function exportmydeptPlanData($dept=null){
		if($dept){
			$sql = "SELECT * FROM plan_seven WHERE locate(?,department)";
			$query = $this->db->query($sql, array($dept));
			return $query;
		}
	}
	
	public function create($data){
		if($data){
			$insert = $this->db->insert('plan_seven', $data);
			return ($insert == true) ? true : false;
		}
	}
	
	public function createbatch($data){
		if($data){
			$insert = $this->db->insert_batch('plan_seven', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id){
		if($data && $id){
			$this->db->where('user_id', $id);
			$update = $this->db->update('plan_seven', $data);
			return ($update == true) ? true : false;
		}
	}

	public function deleteAll(){
		$sql='delete from plan_seven';
		$delete = $this->db->query($sql);
	}

}