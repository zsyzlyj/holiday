<?php 

class Model_wage_apply extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	/* get the brand data */
	public function getApplyData(){
		$sql = "SELECT * FROM wage_apply";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getApplyById($userId = null){
		if($userId){
			$sql = "SELECT * FROM wage_apply WHERE user_id = ?";	
			$query = $this->db->query($sql, array($userId));
			return $query->result_array();
		}
	}
	public function getApplyByIdAndStatus($id,$status){
		if($status and $id){
			#$query=$this->db->where_in('user_id', $id)->get_where('wage',array('date_tag'=>$date));
			$sql = "SELECT * FROM (select * from wage_apply where locate(?,user_id)) as t WHERE locate(?,submit_status)";	
			$query = $this->db->query($sql, array($id,$status));
			return $query->result_array();
		}
	}
	
	public function create($data){
		if($data){
			$insert = $this->db->insert('wage_apply', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data=array(),$id){
		$this->db->where('id',$id);
		$update = $this->db->update('wage_apply', $data);
		return ($update == true) ? true : false;	
	}
}