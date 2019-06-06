
<?php 

class Model_auth extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	/* 
		This function checks if the id exists in the database
	*/
	public function check_id($id){
		if($id){
			$sql = 'SELECT * FROM users WHERE user_id = ?';
			#$sql = 'SELECT * FROM secret_users WHERE secret_id = ?';
			
			$query = $this->db->query($sql, array($id));
			$result = $query->num_rows();
			return ($result == 1) ? true : false;
		}
		return false;
	}

	/* 
		This function checks if the id and password matches with the database
	*/
	public function login($id, $password){
		if($id && $password){
			$sql = "SELECT * FROM users WHERE user_id = ?";
			#$sql = "SELECT * FROM secret_users WHERE secret_id = ?";
			
			$query = $this->db->query($sql, array($id));
			if($query->num_rows() == 1){
				$result = $query->row_array();
				$compare=(md5($password) === $result['password']) ? true : false;
				#$compare=($password === $result['password']) ? true : false;
				
				if($compare === true){
					return $result;	
				}
				else{
					return false;
				}	
			}
			else{
				return false;
			}
		}
	}
	
}