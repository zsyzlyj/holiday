<?php 

class Model_wage_doc extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the brand data */
	public function getWageDocData()
	{
		$sql = "SELECT * FROM wage_doc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('wage_doc', $data);
			return ($insert == true) ? true : false;
		}
	}
	
	public function deleteAll()
	{
		$sql='delete from wage_doc';
		$delete = $this->db->query($sql);
		return ($delete == true) ? true : false;
	}

}