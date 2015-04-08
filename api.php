<?php
require('common.php');

if(!isset($_GET['type'])) {
	die(json_encode(array('code' => 2, "message" => "INVALID QUERY")));
} else if (!isset($_GET['key'])) {
	die(json_encode(array('code' => 2, "message" => "INVALID QUERY")));
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



}