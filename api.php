<?php
if(count(get_included_files()) ==1) exit("Direct access not permitted.");
class CAS_API
{
	private $con;
	private $keys = array();
	private $key;
	public $error;
	private $config;
	
	function __construct($key) {
		require('common.php');
		$this->config = $config;
		$this->con = new mysqli($config['db']['address'], $config['db']['user'], $config['db']['pass'], $config['db']['name'], $config['db']['port']);
		
		if($this->con->connect_error) {
			$this->error = json_encode(array('code' => 1, 'message' => "SQL ERROR"));
		}
		
		$sql = "SELECT * FROM `".$this->config['db']['table-prefix']."apikeys`;";
		$result = $this->con->query($sql);

		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				array_push($this->keys, $row['key']);
			}
		}
		
		$this->error = $this->validKey($key);
	}
	
	public static function http_allowed() {
		require('common.php');
		return $config['allow-html-requests'];
	}
	
	public function validKey($key) {
		if(in_array($key, $this->keys)) {
			return json_encode(array('code' => 0, 'message' => "SUCESS"));
		} else {
			return json_encode(array('code' => 3, 'message' => "INVALID KEY"));
		}
	}

	public function registerUser($username, $password) {
		if(json_decode($this->error, true)['code'] != 0) {
			return $this->error;
		}
		require('login/register.php');
		if(strlen($username) > 0) {
			if(strlen($password) > 0) {
				return register($username, $password, $this->config, $con);
			} else {
				return json_encode(array('code' => 2, "message" => "MISSING PASSWORD"));
			}
		} else {
			return json_encode(array('code' => 2, "message" => "MISSING USERNAME"));
		}
	}

	public function login($username, $password) {
		if(json_decode($this->error, true)['code'] != 0) {
			return $this->error;
		}
		require('login/login.php');
		if(strlen($username) > 0) {
			if(strlen($password) > 0) {
				return login($username, $password, $this->config);
			} else {
				return json_encode(array('code' => 2, "message" => "MISSING PASSWORD"));
			}
		} else {
			return json_encode(array('code' => 2, "message" => "MISSING USERNAME"));
		}
	}
	
	public function removeUser($username) {
		if(json_decode($this->error, true)['code'] != 0) {
			return $this->error;
		}
		require('login/removeuser.php');
		if(strlen($username) > 0) {
			return removeuser($username, $this->config);
		} else {
			return json_encode(array('code' => 2, "message" => "MISSING USERNAME"));
		}
	}
	
	public function listUsers() {
		if(json_decode($this->error, true)['code'] != 0) {
			return $this->error;
		}
		require('login/listusers.php');
		return listusers($this->config);
	}
	
	public function updatePass($username, $oldpass, $newpass) {
		require('login/updatepass.php');
		updatepass($_POST['username'], $_POST['password'], $_POST['newpassword'], $this->config);
	}
}