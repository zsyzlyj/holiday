<?php 

class Model_wage_attr extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the brand data */
	public function getWageAttrData()
	{
		$sql = "SELECT * FROM wage_attr";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function getWageTotalData()
	{
		$sql = "SELECT * FROM wage_total";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	public function create_total($data){
		if($data) {
			$insert = $this->db->insert('wage_total', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function create_attr($data)
	{
		if($data) {
			$insert = $this->db->insert('wage_attr', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function delete_total()
	{
		$sql='delete from wage_total';
		$delete = $this->db->query($sql);
	}
	public function delete_attr()
	{
		$sql='delete from wage_attr';
		$delete = $this->db->query($sql);
	}

}