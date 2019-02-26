<?php 

class Model_dept extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	public function getDeptData(){
		$sql = "SELECT * FROM department";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function check_dept($dept){
		if($dept){
			$sql = 'SELECT * FROM department WHERE dept_name = ?';
			$query = $this->db->query($sql, array($dept));
			$result = $query->num_rows();
			return ($result == 1) ? true : false;
		}
		return false;
	}
	public function createbatch($data){
		if($data){
			$insert = $this->db->insert_batch('department', $data);
			return ($insert == true) ? true : false;
		}
	}
	public function create($data){
		if($data){
			$insert = $this->db->insert('department', $data);
			return ($insert == true) ? true : false;
		}
	}
	public function deleteAll(){
		$sql='delete from department';
		$delete = $this->db->query($sql);
	}
}