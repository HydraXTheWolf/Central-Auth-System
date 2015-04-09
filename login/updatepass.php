<?php

//A successful update password will look like this:
//{"code":0,"message":"SUCESS"}
function updatepass($username, $oldpassword, $newpassword, $config) {
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
		if(password_verify($oldpassword, $row['password'])) {
			//User logged in, but we need to update lastlogin first
			if (!($stmt = $con->prepare("UPDATE `".$config['db']['table-prefix']."users` SET `password`=? WHERE `username`=?;"))) {
				die(json_encode(array('code' => 1, 'message' => $con->error)));
			}
			$newpassword = password_hash($newpassword, PASSWORD_BCRYPT);
			if (!$stmt->bind_param("ss", $newpassword, $username)) {
				die(json_encode(array('code' => 1, 'message' => $con->error)));
			}

			if (!$stmt->execute()) {
				die(json_encode(array('code' => 1, 'message' => $con->error)));
			}
			die(json_encode(array('code' => 0, 'message' => "SUCESS")));
		} else {
			die(json_encode(array('code' => 5, 'message' => "INVALID PASSWORD")));
		}
	} else {
		die(json_encode(array('code' => 6, 'message' => "UNKNOWN USER")));
	}

}