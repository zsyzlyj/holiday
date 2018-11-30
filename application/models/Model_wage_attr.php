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

	public function getWageFirstData()
	{
		$sql = "SELECT * FROM wage_first";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getWageSecondData()
	{
		$sql = "SELECT * FROM wage_second";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getWageThirdData()
	{
		$sql = "SELECT * FROM wage_third";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getWageFourthData()
	{
		$sql = "SELECT * FROM wage_fourth";
		$query = $this->db->query($sql);
		return $query->result_array();
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
	public function create_first($data)
	{
		if($data) {
			$insert = $this->db->insert('wage_first', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function create_second($data)
	{
		if($data) {
			$insert = $this->db->insert('wage_second', $data);
			return ($insert == true) ? true : false;
		}
	}
	public function create_third($data)
	{
		if($data) {
			$insert = $this->db->insert('wage_third', $data);
			return ($insert == true) ? true : false;
		}
	}
	public function create_fourth($data)
	{
		if($data) {
			$insert = $this->db->insert('wage_fourth', $data);
			return ($insert == true) ? true : false;
		}
	}
	public function deleteAll()
	{
		$sql='delete from wage_first';
		$delete = $this->db->query($sql);
		$sql='delete from wage_second';
		$delete = $this->db->query($sql);
		$sql='delete from wage_third';
		$delete = $this->db->query($sql);
		$sql='delete from wage_fourth';
		$delete = $this->db->query($sql);
		 return ($delete == true) ? true : false;
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