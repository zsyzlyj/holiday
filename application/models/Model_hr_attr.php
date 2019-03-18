<?php 

class Model_wage_attr extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	/* get the brand data */
	public function getWageAttrData(){
		$sql = "SELECT * FROM wage_attr";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	public function getWageAttrDataByDate($date){
		$sql = "SELECT * FROM wage_attr where date_tag = ?";
		$query = $this->db->query($sql,array($date));
		return $query->row_array();
	}

	public function exportAttrData($id = null){
		$sql = "SELECT * FROM wage_attr";
		return $this->db->query($sql);
	}
	public function create_attr($data){
		if($data){
			$insert = $this->db->insert('wage_attr', $data);
			return ($insert == true) ? true : false;
		}
	}
	public function update($data=array(),$id){
		$this->db->where('date_tag',$id);
		$update = $this->db->update('wage_attr', $data);
		return ($update == true) ? true : false;	
	}
	public function delete_attr(){
		$sql='delete from wage_attr';
		$delete = $this->db->query($sql);
	}
	public function deleteByDate($date){
		$sql='delete from wage_attr where locate(?,date_tag)';
		$delete = $this->db->query($sql,array($date));
		return ($delete == true) ? true : false;
	}
}