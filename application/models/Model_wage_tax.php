<?php 

class Model_wage_tax extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	/* get the brand data */
	public function getTaxData(){
		$sql = "SELECT * FORM wage_tax";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function getDatetag(){
		$sql='select distinct date_tag from wage_tax order by date_tag';
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getTaxByDate($date = null){
		if($date){
			$query=$this->db->get_where('wage_tax',array('date_tag'=>$date));
			if($query)
				return $query->result_array();
			else return NULL;
		}
	}
	public function getTaxByDateAndId($date = null,$id=null){
		if($date){
			$sql="select * from wage_tax where locate(?,user_id) and locate(?,date_tag)";
			$query = $this->db->query($sql,array($id,$date));
			#$query=$this->db->where_in('user_id', $id)->get_where('wage_tax',array('date_tag'=>$date));
			return $query->row_array();
		}
	}
	public function createbatch($data){
		if($data){
			$insert = $this->db->insert_batch('wage_tax', $data);
			return ($insert == true) ? true : false;
		}
	}
	public function deleteByDate($date){
		$sql='delete from wage_tax where locate(?,date_tag)';
		$delete = $this->db->query($sql,array($date));
		return ($delete == true) ? true : false;
	}
}