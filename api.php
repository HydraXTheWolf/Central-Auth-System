<?php
require('common.php');
require('login/register.php');
require('login/login.php');
require('login/updatepass.php');

if(!isset($_GET['type'])) {
	die(json_encode(array('code' => 2, "message" => "MISSING TYPE")));
} else if (!isset($_GET['key'])) {
	die(json_encode(array('code' => 2, "message" => "MISSING KEY")));
}

$con = new mysqli($config['db']['address'], $config['db']['user'], $config['db']['pass'], $config['db']['name'], $config['db']['port']);

if($con->connect_error) {
	die(json_encode(array('code' => 1, 'message' => "SQL ERROR")));
}
$sql = "SELECT * FROM `".$config['db']['table-prefix']."apikeys`;";
$result = $con->query($sql);

$keys = array();

if ($result->num_rows > 0) {
	// output data of each row
	while($row = $result->fetch_assoc()) {
		array_push($keys, $row['key']);
	}
} else {
}

switch ($_GET['type']) {
case 'check-key':
	if(in_array($_GET['key'], $keys)) {
		die(json_encode(array('code' => 0, 'message' => "SUCESS")));
	} else {
		die(json_encode(array('code' => 3, 'message' => "INVALID KEY")));
	}
	break;
	
case 'register':
	if(in_array($_GET['key'], $keys)) {
		if(isset($_POST['username'])) {
			if(isset($_POST['password'])) {
				register($_POST['username'], $_POST['password'], $config, $con);
			} else {
				die(json_encode(array('code' => 2, "message" => "MISSING PASSWORD")));
			}
		} else {
			die(json_encode(array('code' => 2, "message" => "MISSING USERNAME")));
		}
	} else {
		die(json_encode(array('code' => 3, 'message' => "INVALID KEY")));
	}
	break;
	
case 'login':
	if(in_array($_GET['key'], $keys)) {
		if(isset($_POST['username'])) {
			if(isset($_POST['password'])) {
				login($_POST['username'], $_POST['password'], $config);
			} else {
				die(json_encode(array('code' => 2, "message" => "MISSING PASSWORD")));
			}
		} else {
			die(json_encode(array('code' => 2, "message" => "MISSING USERNAME")));
		}
	} else {
		die(json_encode(array('code' => 3, 'message' => "INVALID KEY")));
	}
	break;
	
case 'changepass':
	if(in_array($_GET['key'], $keys)) {
		if(isset($_POST['username'])) {
			if(isset($_POST['password'])) {
				if(isset($_POST['newpassword'])) {
					updatepass($_POST['username'], $_POST['password'], $_POST['newpassword'], $config);
				} else {
					die(json_encode(array('code' => 2, "message" => "MISSING NEW PASSWORD")));
				}
			} else {
				die(json_encode(array('code' => 2, "message" => "MISSING OLD PASSWORD")));
			}
		} else {
			die(json_encode(array('code' => 2, "message" => "MISSING USERNAME")));
		}
	} else {
		die(json_encode(array('code' => 3, 'message' => "INVALID KEY")));
	}
	break;


}