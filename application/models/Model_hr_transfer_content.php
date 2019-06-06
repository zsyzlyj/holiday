<?php 

class Model_hr_transfer_content extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	/* get the brand data */
	public function getData(){
		$sql = "SELECT * FROM hr_transfer_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getDept(){
		$sql = "SELECT distinct(dept) FROM hr_transfer_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getGender(){
		$sql = "SELECT distinct(gender) FROM hr_transfer_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getSection(){
		$sql = "SELECT distinct(section) FROM hr_transfer_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getPost(){
		$sql = "SELECT distinct(position) FROM hr_transfer_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getMarry(){
		$sql = "SELECT distinct(marry) FROM hr_transfer_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getDegree(){
		$sql = "SELECT distinct(highest_degree) FROM hr_transfer_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function search($name){
		#echo var_dump($this->db->where_in('content13', $dept)->from('hr_transfer_content')->get()->result_array());
		return array_merge(
			$this->db->where('name', $name)->from('hr_transfer_content')->get()->result_array()
		);
	}
	/*
	public function getGender(){
		$sql = "SELECT distinct(content6) FROM hr_transfer_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getGender(){
		$sql = "SELECT distinct(content6) FROM hr_transfer_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getGender(){
		$sql = "SELECT distinct(content6) FROM hr_transfer_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	*/
	public function getByDept($dept = null){
		if($dept){
			$query=$this->db->where_in('attr13', $dept)->from('hr_transfer_content')->get();
			#$sql = "SELECT * FROM hr_transfer_content WHERE locate(?,content13)";
			#$query = $this->db->query($sql, array($dept));
			return $query->result_array();
		}
	}

	public function getById($userId = null){
		if($userId){
			$sql = "SELECT * FROM hr_transfer_content WHERE user_id = ?";	
			$query = $this->db->query($sql, array($userId));
			return $query->row_array();
		}
	}
	
	public function getByDate($date = null){
		if($date){
			$sql = "SELECT * FROM hr_transfer_content WHERE locate(?,date_tag)";	
			$query = $this->db->query($sql, array($date));
			return $query->result_array();
		}
	}
	public function getByDateAndId($id,$date){
		if($date and $id){
			$query=$this->db->where_in('user_id', $id)->get_where('hr_transfer_content',array('date_tag'=>$date));
			#$sql = "SELECT * FROM (select * from hr_transfer_content where user_id in ?) as t WHERE locate(?,date_tag)";	
			#$query = $this->db->query($sql, array($id,$date));
			return $query->row_array();
		}
	}
	public function getByDateAndIdset($id,$date){
		if($date and $id){
			$query=$this->db->where_in('user_id', $id)->get_where('hr_transfer_content',array('date_tag'=>$date));
			#$sql = "SELECT * FROM (select * from hr_transfer_content where user_id in ?) as t WHERE locate(?,date_tag)";	
			#$query = $this->db->query($sql, array($id,$date));
			return $query->result_array();
		}
	}
	public function getByDateAndDept($dept,$date){
		if($date and $dept){	
			$sql = "SELECT * FROM (select * from hr_transfer_content where locate(?,department)) as t WHERE locate(?,date_tag)";	
			$query = $this->db->query($sql, array($dept,$date));
			return $query->result_array();
		}
	}
	public function exportData($id = null){
		$sql = "SELECT * FROM hr_transfer_content";
		return $this->db->query($sql);
	}
	public function exportmydeptData($dept=null){
		if($dept){
			$sql = "SELECT * FROM hr_transfer_content WHERE locate(?,department)";
			$query = $this->db->query($sql, array($dept));
			return $query;
		}

	}
	public function create($data){
		if($data){
			$insert = $this->db->insert('hr_transfer_content', $data);
			return ($insert == true) ? true : false;
		}
	}
	public function createbatch($data){
		if($data){
			$insert = $this->db->insert_batch('hr_transfer_content', $data);
			return ($insert == true) ? true : false;
		}
	}
	public function delete(){
		$sql='delete from hr_transfer_content';
		$delete = $this->db->query($sql);
		return ($delete == true) ? true : false;
	}
	public function getDatetag(){
		$sql="select distinct date_tag from hr_transfer_content order by date_tag";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function deleteByDate($date){
		$sql="delete from hr_transfer_content where date_tag=?";
		$delete = $this->db->query($sql,array($date));
		return ($delete == true)  ? true : false;
	}
}