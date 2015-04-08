<?php
function register($username, $password, $config) {
$password = password_hash($password, PASSWORD_BCRYPT);
$con = new mysqli($config['db']['address'], $config['db']['user'], $config['db']['pass'], $config['db']['name'], $config['db']['port']);
if($con->connect_error) {
	die(json_encode(array('code' => 1, 'message' => $con->error)));
}

if (!($stmt = $con->prepare("INSERT INTO `".$config['db']['table-prefix']."users` (username, password, regodate) VALUES (?, ?, ?);"))) {
    die(json_encode(array('code' => 1, 'message' => $con->error)));
}

if (!$stmt->bind_param("ssi", $username, $password, time())) {
    die(json_encode(array('code' => 1, 'message' => $con->error)));
}

if (!$stmt->execute()) {
	if($con->errno == 1062) {
		die(json_encode(array('code' => 4, 'message' => $con->error)));
	}
    die(json_encode(array('code' => 1, 'message' => $con->error)));
}
//user has to be registered to get to this point

if (!($stmt = $con->prepare("SELECT * FROM `".$config['db']['table-prefix']."users` WHERE `username`=?"))) {
    die(json_encode(array('code' => 1, 'message' => $con->error."1")));
}

if (!$stmt->bind_param("s", $username)) {
    die(json_encode(array('code' => 1, 'message' => $con->error."2")));
}

if (!$stmt->execute()) {
    die(json_encode(array('code' => 1, 'message' => $con->error."3")));
}

$result = $stmt->get_result();

if ($result->num_rows > 0) {
	die(json_encode(array('code' => 0, 'message' => "SUCESS", 'userid' => $result->fetch_assoc()['id'])));
} else {
	die(json_encode(array('code' => 1, 'message' => $con->error."4")));
}

}