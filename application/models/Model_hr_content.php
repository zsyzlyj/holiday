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
		$sql = "SELECT distinct(dept) FROM hr_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getGender(){
		$sql = "SELECT distinct(gender) FROM hr_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getSection(){
		$sql = "SELECT distinct(section) FROM hr_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getPost(){
		$sql = "SELECT distinct(position) FROM hr_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getMarry(){
		$sql = "SELECT distinct(marry) FROM hr_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getDegree(){
		$sql = "SELECT distinct(highest_degree) FROM hr_content";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function search($name){
		#echo var_dump($this->db->where_in('content13', $dept)->from('hr_content')->get()->result_array());
		return array_merge(
			$this->db->where('name', $name)->from('hr_content')->get()->result_array()
		);
	}
	/*
	public function search($name,$dept,$gender,$section,$post,$marry,$degree,$equ_degree,$party,$post_type){
		#echo var_dump($this->db->where_in('content13', $dept)->from('hr_content')->get()->result_array());
		return array_merge(
			$this->db->where('name', $name)->from('hr_content')->get()->result_array()
		);
			/*
			$this->db->where_in('attr13', $dept)->from('hr_content')->get()->result_array(),
			$this->db->where_in('attr14', $section)->from('hr_content')->get()->result_array(),
			$this->db->where_in('attr15', $post)->from('hr_content')->get()->result_array(),
			$this->db->where_in('attr11', $marry)->from('hr_content')->get()->result_array(),
			$this->db->where_in('attr44', $degree)->from('hr_content')->get()->result_array(),
			$this->db->where_in('attr51', $equ_degree)->from('hr_content')->get()->result_array(),
			$this->db->where_in('attr6', $gender)->from('hr_content')->get()->result_array(),
			$this->db->where_in('attr33', $party)->from('hr_content')->get()->result_array(),
			$this->db->where_in('attr18', $post_type)->from('hr_content')->get()->result_array()
			*/

		#$query=$this->db->where_in('content13', $dept)->where_in('content6', $gender)->where_in('content14', $section)->where_in('content15', $post)->where_in('content11', $marry)->where_in('content44', $degree)->where_in('content51', $equ_degree)->from('hr_content')->get();//->where_in('content13', $dept)->where_in('content13', $dept)->from('hr_content')->get();
		#return $query->result_array();
	//}
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
	public function getByDept($dept = null){
		if($dept){
			$query=$this->db->where_in('attr13', $dept)->from('hr_content')->get();
			#$sql = "SELECT * FROM hr_content WHERE locate(?,content13)";
			#$query = $this->db->query($sql, array($dept));
			return $query->result_array();
		}
	}

	public function getById($userId = null){
		if($userId){
			$sql = "SELECT * FROM hr_content WHERE user_id = ?";	
			$query = $this->db->query($sql, array($userId));
			return $query->row_array();
		}
	}
	
	public function getByDate($date = null){
		if($date){
			$sql = "SELECT * FROM hr_content WHERE locate(?,date_tag)";	
			$query = $this->db->query($sql, array($date));
			return $query->result_array();
		}
	}
	public function getByDateAndId($id,$date){
		if($date and $id){
			$query=$this->db->where_in('user_id', $id)->get_where('hr_content',array('date_tag'=>$date));
			#$sql = "SELECT * FROM (select * from hr_content where user_id in ?) as t WHERE locate(?,date_tag)";	
			#$query = $this->db->query($sql, array($id,$date));
			return $query->row_array();
		}
	}
	public function getByDateAndIdset($id,$date){
		if($date and $id){
			$query=$this->db->where_in('user_id', $id)->get_where('hr_content',array('date_tag'=>$date));
			#$sql = "SELECT * FROM (select * from hr_content where user_id in ?) as t WHERE locate(?,date_tag)";	
			#$query = $this->db->query($sql, array($id,$date));
			return $query->result_array();
		}
	}
	public function getByDateAndDept($dept,$date){
		if($date and $dept){	
			$sql = "SELECT * FROM (select * from hr_content where locate(?,department)) as t WHERE locate(?,date_tag)";	
			$query = $this->db->query($sql, array($dept,$date));
			return $query->result_array();
		}
	}
	public function exportData($id = null){
		$sql = "SELECT * FROM hr_content";
		return $this->db->query($sql);
	}
	public function exportmydeptData($dept=null){
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