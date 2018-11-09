<?php 

class Model_notice extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the brand data */
	public function getNoticeData($id = null)
	{
		$sql = "SELECT * FROM notice order by pubtime desc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getNoticeLatest($id = null)
	{
		$sql = "SELECT * FROM notice order by pubtime desc limit 1";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('notice', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('date', $id);
			$delete = $this->db->delete('notice');
			return ($delete == true) ? true : false;
		}
	}

	public function countTotalnotice()
	{
		$sql = "SELECT * FROM notice";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

}