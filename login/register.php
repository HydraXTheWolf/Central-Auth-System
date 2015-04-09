<?php

//A sucessful register will look something like this:
//{"code":0,"message":"SUCESS","userid":3}
function register($username, $password, $config) {
$password = password_hash($password, PASSWORD_BCRYPT);
$con = new mysqli($config['db']['address'], $config['db']['user'], $config['db']['pass'], $config['db']['name'], $config['db']['port']);
if($con->connect_error) {
	return json_encode(array('code' => 1, 'message' => $con->error));
}

if (!($stmt = $con->prepare("INSERT INTO `".$config['db']['table-prefix']."users` (username, password, regodate) VALUES (?, ?, ?);"))) {
    return json_encode(array('code' => 1, 'message' => $con->error));
}

if (!$stmt->bind_param("ssi", $username, $password, time())) {
    return json_encode(array('code' => 1, 'message' => $con->error));
}

if (!$stmt->execute()) {
	if($con->errno == 1062) {
		return json_encode(array('code' => 4, 'message' => $con->error));
	}
    return json_encode(array('code' => 1, 'message' => $con->error));
}
//user has to be registered to get to this point

if (!($stmt = $con->prepare("SELECT * FROM `".$config['db']['table-prefix']."users` WHERE `username`=?"))) {
    return json_encode(array('code' => 1, 'message' => $con->error));
}

if (!$stmt->bind_param("s", $username)) {
    return json_encode(array('code' => 1, 'message' => $con->error));
}

if (!$stmt->execute()) {
    return json_encode(array('code' => 1, 'message' => $con->error));
}

$result = $stmt->get_result();

if ($result->num_rows > 0) {
	return json_encode(array('code' => 0, 'message' => "SUCESS", 'userid' => $result->fetch_assoc()['id']));
} else {
	return json_encode(array('code' => 1, 'message' => $con->error));
}

}