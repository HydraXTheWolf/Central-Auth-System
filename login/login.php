<?php

function login($username, $password, $config) {
$con = new mysqli($config['db']['address'], $config['db']['user'], $config['db']['pass'], $config['db']['name'], $config['db']['port']);
	if (!($stmt = $con->prepare("SELECT * FROM `".$config['db']['table-prefix']."users` WHERE `username`=?"))) {
		die(json_encode(array('code' => 1, 'message' => $con->error)));
	}

	if (!$stmt->bind_param("s", $username)) {
		die(json_encode(array('code' => 1, 'message' => $con->error)));
	}

	if (!$stmt->execute()) {
		die(json_encode(array('code' => 1, 'message' => $con->error)));
	}

	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		if(password_verify($password, $row['password'])) {
			die(json_encode(array('code' => 0, 'message' => "SUCESS", 'id' => $row['id'], 'regodate' => $row['regodate'])));
		} else {
			die(json_encode(array('code' => 5, 'message' => "INVALID PASSWORD")));
		}
	} else {
		die(json_encode(array('code' => 6, 'message' => "UNKNOWN USER")));
	}
}