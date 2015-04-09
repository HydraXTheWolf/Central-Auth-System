<?php

//A successful login will look something like this:
//{"code":0,"message":"SUCESS","user":{"username":"hydrax","password":"$2y$10$stGY3urD.oj01qA8hJY3QOrPCAOukd1pHOojy\/Edy5DhdtZIcgvwG","id":3,"regodate":1428548661,"lastlogin":1428548718}}
function login($username, $password, $config) {
$con = new mysqli($config['db']['address'], $config['db']['user'], $config['db']['pass'], $config['db']['name'], $config['db']['port']);
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
		$row = $result->fetch_assoc();
		if(password_verify($password, $row['password'])) {
			//User logged in, but we need to update lastlogin first
			if (!($stmt = $con->prepare("UPDATE `".$config['db']['table-prefix']."users` SET `lastlogin`=? WHERE `username`=?;"))) {
				return json_encode(array('code' => 1, 'message' => $con->error));
			}

			if (!$stmt->bind_param("is", time(), $username)) {
				return json_encode(array('code' => 1, 'message' => $con->error));
			}

			if (!$stmt->execute()) {
				return json_encode(array('code' => 1, 'message' => $con->error));
			}
			return json_encode(array('code' => 0, 'message' => "SUCESS", 'user' => $row));
		} else {
			return json_encode(array('code' => 5, 'message' => "INVALID PASSWORD"));
		}
	} else {
		return json_encode(array('code' => 6, 'message' => "UNKNOWN USER"));
	}
}