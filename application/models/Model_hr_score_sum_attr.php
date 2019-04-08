<?php 

class Model_hr_score_sum_attr extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	/* get the brand data */
	public function getData(){
		$sql = "SELECT * FROM hr_score_sum_attr";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	public function getHrAttrDataByDate($date){
		$sql = "SELECT * FROM hr_score_sum_attr where date_tag = ?";
		$query = $this->db->query($sql,array($date));
		return $query->row_array();
	}

	public function exportAttrData($id = null){
		$sql = "SELECT * FROM hr_score_sum_attr";
		return $this->db->query($sql);
	}
	public function create($data){
		if($data){
			$insert = $this->db->insert('hr_score_sum_attr', $data);
			return ($insert == true) ? true : false;
		}
	}
	public function update($data=array(),$id){
		$this->db->where('date_tag',$id);
		$update = $this->db->update('hr_score_sum_attr', $data);
		return ($update == true) ? true : false;	
	}
	public function delete(){
		$sql='delete from hr_score_sum_attr';
		$delete = $this->db->query($sql);
	}
	public function deleteByDate($date){
		$sql='delete from hr_score_sum_attr where locate(?,date_tag)';
		$delete = $this->db->query($sql,array($date));
		return ($delete == true) ? true : false;
	}
}