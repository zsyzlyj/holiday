<?php 

class Model_wage_doc extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	/* get the brand data */
	public function getWageDocData(){
		$sql = "SELECT * FROM wage_doc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getDocType(){
		$sql = "SELECT distinct doc_type FROM wage_doc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function create($data){
		if($data){
			$insert = $this->db->insert('wage_doc', $data);
			return ($insert == true) ? true : false;
		}
	}
	public function delete($date){
		if($date){
			$this->db->where('number', $date);
			$delete = $this->db->delete('wage_doc');
			return ($delete == true) ? true : false;
		}
	}
	public function getWageDocOrder(){
		$sql = "SELECT * from wage_doc_order ORDER BY doc_order";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function updateOrderbatch($data=array()){
		if($data){
			$update = $this->db->update_batch('wage_doc_order', $data, 'doc_type');
			return ($update == true) ? true : false;
		}
	}
	public function createOrderbatch($data=array()){
		if($data){
			$create = $this->db->insert_batch('wage_doc_order', $data);
			return ($create == true) ? true : false;
		}
	}
}