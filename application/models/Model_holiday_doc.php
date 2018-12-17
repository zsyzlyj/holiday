<?php 

class Model_holiday_doc extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the brand data */
	public function getHolidayDocData()
	{
		$sql = "SELECT * FROM holiday_doc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('holiday_doc', $data);
			return ($insert == true) ? true : false;
		}
	}
	
	public function delete($doc_name)
	{
		if($doc_name) {
			$this->db->where('doc_name', $doc_name);
			$delete = $this->db->delete('holiday_doc');
			return ($delete == true) ? true : false;
		}
	}
	
	

}