<?php 

class Model_wage_apply_status extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	/* get the brand data */
	public function getApplyData(){
		$sql = "SELECT * FROM wage_apply_status";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getApplyById($userId = null){
		if($userId){
			$sql = "SELECT * FROM wage_apply_status WHERE user_id = ?";	
			$query = $this->db->query($sql, array($userId));
			return $query->result_array();
		}
	}
	public function getStatusByIdAndType($id,$type){
		if($type and $id){
			#$query=$this->db->where_in('user_id', $id)->get_where('wage',array('date_tag'=>$date));
			$sql = "SELECT * FROM (select * from wage_apply_status where locate(?,user_id)) as t WHERE locate(?,t.type)";	
			$query = $this->db->query($sql, array($id,$type));
			return $query->row_array();
		}
	}
	
	public function create($data){
		if($data){
			$insert = $this->db->insert('wage_apply_status', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data=array(),$id){
		$this->db->where('user_id',$id);
		$update = $this->db->update('wage_apply_status', $data);
		return ($update == true) ? true : false;	
	}
	public function updateByIdAndType($data=array(),$id,$type){
		$this->db->where('user_id',$id)->where('type',$type);
		$update = $this->db->update('wage_apply_status', $data);
		return ($update == true) ? true : false;	
	}
}