<?php 

class Model_notice extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	/* get the brand data */
	public function getNoticeData(){
		$sql = "SELECT * FROM notice order by pubtime desc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function getWageNoticeData(){
		$sql = "SELECT * FROM notice where notice.type='wage' or notice.type='tax' order by pubtime desc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getHolidayNoticeData(){
		$sql = "SELECT * FROM notice where notice.type='holiday' or notice.type='plan' order by pubtime desc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getNoticeLatestHoliday(){
		$sql = "SELECT * FROM notice where notice.type='holiday' order by pubtime desc limit 1";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	public function getNoticeLatestPlan(){
		$sql = "SELECT * FROM notice where notice.type='plan' order by pubtime desc limit 1";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	public function getNoticeLatestWage(){
		$sql = "SELECT * FROM notice where notice.type='wage' order by pubtime desc limit 1";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	public function getNoticeLatestTax(){
		$sql = "SELECT * FROM notice where notice.type='tax' order by pubtime desc limit 1";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	public function getHrNoticeData(){
		$sql = "SELECT * FROM notice where notice.type='hr'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getNoticeLatestHr(){
		$sql = "SELECT * FROM notice where notice.type='hr' order by pubtime desc limit 1";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	public function create($data){
		if($data){
			$insert = $this->db->insert('notice', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function delete($id){
		if($id){
			$this->db->where('pubtime', $id);
			$delete = $this->db->delete('notice');
			return ($delete == true) ? true : false;
		}
	}

}