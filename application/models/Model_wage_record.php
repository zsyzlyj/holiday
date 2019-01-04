<?php 

class Model_wage_record extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	/* get the brand data */
	public function getRecordByDate($upload_date = null){
		if($upload_date){
			$sql = "SELECT * FROM wage_record WHERE upload_date = ?";
			$query = $this->db->query($sql,array($upload_date));
			return $query->row_array();
		}
	}

	public function create($data){
		if($data){
			$insert = $this->db->insert('wage_record', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data=array(),$id){
		$this->db->where('upload_date',$id);
		$update = $this->db->update('wage_record', $data);
		return ($update == true) ? true : false;	
	}

}