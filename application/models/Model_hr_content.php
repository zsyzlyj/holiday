<?php 

class Model_hr_content extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	/* get the brand data */
	public function getData(){
		$sql = "SELECT * FROM hr_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getDept(){
		$sql = "SELECT distinct(content13) FROM hr_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getGender(){
		$sql = "SELECT distinct(content6) FROM hr_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getSection(){
		$sql = "SELECT distinct(content14) FROM hr_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getPost(){
		$sql = "SELECT distinct(content15) FROM hr_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getMarry(){
		$sql = "SELECT distinct(content11) FROM hr_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getDegree(){
		$sql = "SELECT distinct(content44) FROM hr_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getEquDegree(){
		$sql = "SELECT distinct(content51) FROM hr_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	/*
	public function getGender(){
		$sql = "SELECT distinct(content6) FROM hr_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getGender(){
		$sql = "SELECT distinct(content6) FROM hr_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getGender(){
		$sql = "SELECT distinct(content6) FROM hr_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	*/
	public function getDataByDept($dept = null){
		if($dept){
			$query=$this->db->where_in('content13', $dept)->from('hr_content')->get();
			#$sql = "SELECT * FROM hr_content WHERE locate(?,content13)";
			#$query = $this->db->query($sql, array($dept));
			return $query->result_array();
		}
	}

	public function getDataById($userId = null){
		if($userId){
			$sql = "SELECT * FROM hr_content WHERE user_id = ?";	
			$query = $this->db->query($sql, array($userId));
			return $query->row_array();
		}
	}
	
	public function getDataByDate($date = null){
		if($date){
			$sql = "SELECT * FROM hr_content WHERE locate(?,date_tag)";	
			$query = $this->db->query($sql, array($date));
			return $query->result_array();
		}
	}
	public function getDataByDateAndId($id,$date){
		if($date and $id){
			$query=$this->db->where_in('user_id', $id)->get_where('hr_content',array('date_tag'=>$date));
			#$sql = "SELECT * FROM (select * from hr_content where user_id in ?) as t WHERE locate(?,date_tag)";	
			#$query = $this->db->query($sql, array($id,$date));
			return $query->row_array();
		}
	}
	public function getDataByDateAndIdset($id,$date){
		if($date and $id){
			$query=$this->db->where_in('user_id', $id)->get_where('hr_content',array('date_tag'=>$date));
			#$sql = "SELECT * FROM (select * from hr_content where user_id in ?) as t WHERE locate(?,date_tag)";	
			#$query = $this->db->query($sql, array($id,$date));
			return $query->result_array();
		}
	}
	public function getDataByDateAndDept($dept,$date){
		if($date and $dept){	
			$sql = "SELECT * FROM (select * from hr_content where locate(?,department)) as t WHERE locate(?,date_tag)";	
			$query = $this->db->query($sql, array($dept,$date));
			return $query->result_array();
		}
	}
	public function exportDataData($id = null){
		$sql = "SELECT * FROM hr_content";
		return $this->db->query($sql);
	}
	public function exportmydeptDataData($dept=null){
		if($dept){
			$sql = "SELECT * FROM hr_content WHERE locate(?,department)";
			$query = $this->db->query($sql, array($dept));
			return $query;
		}

	}
	public function create($data){
		if($data){
			$insert = $this->db->insert('hr_content', $data);
			return ($insert == true) ? true : false;
		}
	}
	public function createbatch($data){
		if($data){
			$insert = $this->db->insert_batch('hr_content', $data);
			return ($insert == true) ? true : false;
		}
	}
	public function delete(){
		$sql='delete from hr_content';
		$delete = $this->db->query($sql);
		return ($delete == true) ? true : false;
	}
	public function getDatetag(){
		$sql="select distinct date_tag from hr_content order by date_tag";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function deleteByDate($date){
		$sql="delete from hr_content where locate(?,date_tag)";
		$delete = $this->db->query($sql,array($date));
		return ($delete == true)  ? true : false;
	}
	public function countAvg($date_set,$user_id){
		#$query=$this->db->where('user_id',$user_id)->where_in('date_tag', $date_set)->select_avg('total')->from('hr_content')->get();
		$query=$this->db->select_avg('total')->where('user_id',$user_id)->where_in('date_tag', $date_set)->get('hr_content');
		return $query->row_array();
	}
	public function countSum($date_set,$user_id){
		#$query=$this->db->where('user_id',$user_id)->where_in('date_tag', $date_set)->select_avg('total')->from('hr_content')->get();
		$query=$this->db->select_sum('total')->where('user_id',$user_id)->where_in('date_tag', $date_set)->get('hr_content');
		return $query->row_array();
	}
	public function getDeptByDate($date_set){
		$query=$this->db->from('hr_content')->where_in('date_tag', $date_set)->get();
		return $query->result_array();
	}
}