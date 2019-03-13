<?php 

class Model_wage extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	/* get the brand data */
	public function getWageData(){
		$sql = "SELECT * FROM wage";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getWageById($userId = null){
		if($userId){
			$sql = "SELECT * FROM wage WHERE user_id = ?";	
			$query = $this->db->query($sql, array($userId));
			return $query->row_array();
		}
	}
	public function getWageByDept($dept = null){
		if($dept){
			$sql = "SELECT * FROM wage WHERE locate(?,department)";
			$query = $this->db->query($sql, array($dept));
			return $query->result_array();
		}
	}
	public function getWageByDate($date = null){
		if($date){
			$sql = "SELECT * FROM wage WHERE locate(?,date_tag)";	
			$query = $this->db->query($sql, array($date));
			return $query->result_array();
		}
	}
	public function getWageByDateAndId($id,$date){
		if($date and $id){
			$query=$this->db->where_in('user_id', $id)->get_where('wage',array('date_tag'=>$date));
			#$sql = "SELECT * FROM (select * from wage where user_id in ?) as t WHERE locate(?,date_tag)";	
			#$query = $this->db->query($sql, array($id,$date));
			return $query->row_array();
		}
	}
	public function getWageByDateAndIdset($id,$date){
		if($date and $id){
			$query=$this->db->where_in('user_id', $id)->get_where('wage',array('date_tag'=>$date));
			#$sql = "SELECT * FROM (select * from wage where user_id in ?) as t WHERE locate(?,date_tag)";	
			#$query = $this->db->query($sql, array($id,$date));
			return $query->result_array();
		}
	}
	public function getWageByDateAndDept($dept,$date){
		if($date and $dept){	
			$sql = "SELECT * FROM (select * from wage where locate(?,department)) as t WHERE locate(?,date_tag)";	
			$query = $this->db->query($sql, array($dept,$date));
			return $query->result_array();
		}
	}
	public function exportWageData($id = null){
		$sql = "SELECT * FROM wage";
		return $this->db->query($sql);
	}
	public function exportmydeptWageData($dept=null){
		if($dept){
			$sql = "SELECT * FROM wage WHERE locate(?,department)";
			$query = $this->db->query($sql, array($dept));
			return $query;
		}

	}
	public function create($data){
		if($data){
			$insert = $this->db->insert('wage', $data);
			return ($insert == true) ? true : false;
		}
	}
	public function createbatch($data){
		if($data){
			$insert = $this->db->insert_batch('wage', $data);
			return ($insert == true) ? true : false;
		}
	}
	public function deleteAll(){
		$sql='delete from wage';
		$delete = $this->db->query($sql);
		return ($delete == true) ? true : false;
	}
	public function getDatetag(){
		$sql='select distinct date_tag from wage order by date_tag';
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function deleteByDate($date){
		$sql='delete from wage where locate(?,date_tag)';
		$delete = $this->db->query($sql,array($date));
		return ($delete == true) ? true : false;
	}
	public function countAvg($date_set,$user_id){
		#$query=$this->db->where('user_id',$user_id)->where_in('date_tag', $date_set)->select_avg('total')->from('wage')->get();
		$query=$this->db->select_avg('total')->where('user_id',$user_id)->where_in('date_tag', $date_set)->get('wage');
		return $query->row_array();
	}
	public function countSum($date_set,$user_id){
		#$query=$this->db->where('user_id',$user_id)->where_in('date_tag', $date_set)->select_avg('total')->from('wage')->get();
		$query=$this->db->select_sum('total')->where('user_id',$user_id)->where_in('date_tag', $date_set)->get('wage');
		return $query->row_array();
	}
	public function getDeptByDate($date_set){
		$query=$this->db->from('wage')->where_in('date_tag', $date_set)->get();
		return $query->result_array();
	}
}