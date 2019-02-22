<?php 

class Model_wage_sp_attr extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	/* get the brand data */
	public function getWageSpData(){
		$sql = "SELECT * FORM wage_sp_attr";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function getDatetag(){
		$sql='select distinct date_tag from wage_sp_attr order by date_tag';
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getWageSpByDate($date = null){
		if($date){
			$query=$this->db->get_where('wage_sp_attr',array('date_tag'=>$date));
			if($query)
				return $query->row_array();
			else return NULL;
		}
	}
	public function getWageSpByDateAndId($date = null,$id=null){
		if($date){
			$query=$this->db->get_where('wage_sp_attr',array('date_tag' => $date, 'user_id' => $id));
			
			return $query->row_array();
		}
	}
	public function create($data){
		if($data){
			$insert = $this->db->insert('wage_sp_attr', $data);
			return ($insert == true) ? true : false;
		}
	}
	public function createbatch($data){
		if($data){
			$insert = $this->db->insert_batch('wage_sp_attr', $data);
			return ($insert == true) ? true : false;
		}
	}
	public function deleteByDate($date){
		$sql='delete from wage_sp_attr where locate(?,date_tag)';
		$delete = $this->db->query($sql,array($date));
		return ($delete == true) ? true : false;
	}

}