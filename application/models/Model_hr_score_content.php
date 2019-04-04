<?php 

class Model_hr_score_content extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	/* get the brand data */
	public function getData(){
		$sql = "SELECT * FROM hr_score_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getName(){
		$sql = "SELECT content2,content1 FROM hr_score_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getByName($id){
		$sql = "SELECT * FROM hr_score_content where content2=?";
		$query = $this->db->query($sql,array($id));
		return $query->row_array();	
	}
	public function getById($id){
		$sql = "SELECT * FROM hr_score_content where content1=?";
		$query = $this->db->query($sql,array($id));
		return $query->row_array();	
	}
	public function getDept(){
		$sql = "SELECT distinct(content13) FROM hr_score_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getGender(){
		$sql = "SELECT distinct(content6) FROM hr_score_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getSection(){
		$sql = "SELECT distinct(content14) FROM hr_score_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getPost(){
		$sql = "SELECT distinct(content15) FROM hr_score_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getMarry(){
		$sql = "SELECT distinct(content11) FROM hr_score_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getDegree(){
		$sql = "SELECT distinct(content44) FROM hr_score_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getEquDegree(){
		$sql = "SELECT distinct(content51) FROM hr_score_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getParty(){
		$sql = "SELECT distinct(content33) FROM hr_score_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getPostType(){
		$sql = "SELECT distinct(content18) FROM hr_score_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function search($name,$dept,$gender,$section,$post,$marry,$degree,$equ_degree,$party,$post_type){
		#echo var_dump($this->db->where_in('content13', $dept)->from('hr_score_content')->get()->result_array());
		return array_merge(
			$this->db->where('content4', $name)->from('hr_score_content')->get()->result_array(),
			$this->db->where_in('content13', $dept)->from('hr_score_content')->get()->result_array(),
			$this->db->where_in('content14', $section)->from('hr_score_content')->get()->result_array(),
			$this->db->where_in('content15', $post)->from('hr_score_content')->get()->result_array(),
			$this->db->where_in('content11', $marry)->from('hr_score_content')->get()->result_array(),
			$this->db->where_in('content44', $degree)->from('hr_score_content')->get()->result_array(),
			$this->db->where_in('content51', $equ_degree)->from('hr_score_content')->get()->result_array(),
			$this->db->where_in('content6', $gender)->from('hr_score_content')->get()->result_array(),
			$this->db->where_in('content33', $party)->from('hr_score_content')->get()->result_array(),
			$this->db->where_in('content18', $post_type)->from('hr_score_content')->get()->result_array()
		);
		#$query=$this->db->where_in('content13', $dept)->where_in('content6', $gender)->where_in('content14', $section)->where_in('content15', $post)->where_in('content11', $marry)->where_in('content44', $degree)->where_in('content51', $equ_degree)->from('hr_score_content')->get();//->where_in('content13', $dept)->where_in('content13', $dept)->from('hr_score_content')->get();
		#return $query->result_array();
	}
	/*
	public function getGender(){
		$sql = "SELECT distinct(content6) FROM hr_score_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getGender(){
		$sql = "SELECT distinct(content6) FROM hr_score_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getGender(){
		$sql = "SELECT distinct(content6) FROM hr_score_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	*/
	public function getDataByDept($dept = null){
		if($dept){
			$query=$this->db->where_in('content13', $dept)->from('hr_score_content')->get();
			#$sql = "SELECT * FROM hr_score_content WHERE locate(?,content13)";
			#$query = $this->db->query($sql, array($dept));
			return $query->result_array();
		}
	}

	public function getDataById($userId = null){
		if($userId){
			$sql = "SELECT * FROM hr_score_content WHERE user_id = ?";	
			$query = $this->db->query($sql, array($userId));
			return $query->row_array();
		}
	}
	
	public function getDataByDate($date = null){
		if($date){
			$sql = "SELECT * FROM hr_score_content WHERE locate(?,date_tag)";	
			$query = $this->db->query($sql, array($date));
			return $query->result_array();
		}
	}
	public function getDataByDateAndId($id,$date){
		if($date and $id){
			$query=$this->db->where_in('user_id', $id)->get_where('hr_score_content',array('date_tag'=>$date));
			#$sql = "SELECT * FROM (select * from hr_score_content where user_id in ?) as t WHERE locate(?,date_tag)";	
			#$query = $this->db->query($sql, array($id,$date));
			return $query->row_array();
		}
	}
	public function getDataByDateAndIdset($id,$date){
		if($date and $id){
			$query=$this->db->where_in('user_id', $id)->get_where('hr_score_content',array('date_tag'=>$date));
			#$sql = "SELECT * FROM (select * from hr_score_content where user_id in ?) as t WHERE locate(?,date_tag)";	
			#$query = $this->db->query($sql, array($id,$date));
			return $query->result_array();
		}
	}
	public function getDataByDateAndDept($dept,$date){
		if($date and $dept){	
			$sql = "SELECT * FROM (select * from hr_score_content where locate(?,department)) as t WHERE locate(?,date_tag)";	
			$query = $this->db->query($sql, array($dept,$date));
			return $query->result_array();
		}
	}
	public function exportDataData($id = null){
		$sql = "SELECT * FROM hr_score_content";
		return $this->db->query($sql);
	}
	public function exportmydeptDataData($dept=null){
		if($dept){
			$sql = "SELECT * FROM hr_score_content WHERE locate(?,department)";
			$query = $this->db->query($sql, array($dept));
			return $query;
		}

	}
	public function create($data){
		if($data){
			$insert = $this->db->insert('hr_score_content', $data);
			return ($insert == true) ? true : false;
		}
	}
	public function createbatch($data){
		if($data){
			$insert = $this->db->insert_batch('hr_score_content', $data);
			return ($insert == true) ? true : false;
		}
	}
	public function delete(){
		$sql='delete from hr_score_content';
		$delete = $this->db->query($sql);
		return ($delete == true) ? true : false;
	}
	public function getDatetag(){
		$sql="select distinct date_tag from hr_score_content order by date_tag";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function deleteByDate($date){
		$sql="delete from hr_score_content where locate(?,date_tag)";
		$delete = $this->db->query($sql,array($date));
		return ($delete == true)  ? true : false;
	}
	public function countAvg($date_set,$user_id){
		#$query=$this->db->where('user_id',$user_id)->where_in('date_tag', $date_set)->select_avg('total')->from('hr_score_content')->get();
		$query=$this->db->select_avg('total')->where('user_id',$user_id)->where_in('date_tag', $date_set)->get('hr_score_content');
		return $query->row_array();
	}
	public function countSum($date_set,$user_id){
		#$query=$this->db->where('user_id',$user_id)->where_in('date_tag', $date_set)->select_avg('total')->from('hr_score_content')->get();
		$query=$this->db->select_sum('total')->where('user_id',$user_id)->where_in('date_tag', $date_set)->get('hr_score_content');
		return $query->row_array();
	}
	public function getDeptByDate($date_set){
		$query=$this->db->from('hr_score_content')->where_in('date_tag', $date_set)->get();
		return $query->result_array();
	}
}