<?php 

class Model_wage_notice extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	/* get the brand data */
	public function getWageNoticeData(){
		$sql = "SELECT * FROM wage_notice";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function create($data){
		if($data){
			$insert = $this->db->insert('wage_notice', $data);
			return ($insert == true) ? true : false;
		}
	}
	public function update($data=array(),$id){
		$this->db->where('date_tag',$id);
		$update = $this->db->update('wage_notice', $data);
		return ($update == true) ? true : false;	
	}
	public function getWageNoticeByDate($date){
		$sql = "SELECT * FROM wage_notice where date_tag = ?";
		$query = $this->db->query($sql,array($date));
		return $query->row_array();
	}
	public function deleteByDate($date){
		if($date){
			$this->db->where('date_tag', $date);
			$delete = $this->db->delete('wage_notice');
			return ($delete == true) ? true : false;
		}
	}
	public function delete($date){
		if($date){
			$this->db->where('date_tag', $date);
			$delete = $this->db->delete('wage_notice');
			return ($delete == true) ? true : false;
		}
	}
}