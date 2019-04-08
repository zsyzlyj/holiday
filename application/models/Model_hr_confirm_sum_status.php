<?php 

class Model_hr_confirm_sum_status extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	/* get the brand data */
	public function getData(){
		$sql = "SELECT * FROM hr_confirm_sum_status";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getById($id){
		$sql = "SELECT * FROM hr_confirm_sum_status where user_id = ?";
		$query = $this->db->query($sql,array($id));
		return $query->row_array();
	}

	public function create($data){
		if($data){
			$insert = $this->db->insert('hr_confirm_sum_status', $data);
			return ($insert == true) ? true : false;
		}
	}
	public function update($data=array(),$id){
		$this->db->where('user_id',$id);
		$update = $this->db->update('hr_confirm_sum_status', $data);
		return ($update == true) ? true : false;	
	}
	public function delete(){
		$sql='delete from hr_confirm_sum_status';
		$delete = $this->db->query($sql);
	}
	public function reset(){
		$sql='update hr_confirm_sum_status set status="未确认"';
		$query = $this->db->query($sql);
	}
	public function getStatus(){
		$sql='select * from ((select content2 from hr_score_content) as m join (select user_id,name,status from hr_confirm_sum_status) as n)';
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}