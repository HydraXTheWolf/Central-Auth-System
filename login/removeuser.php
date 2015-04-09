<?php

//A successful remove user will look like this:
//{"code":0,"message":"SUCESS"}
function removeuser($username, $config) {
	$con = new mysqli($config['db']['address'], $config['db']['user'], $config['db']['pass'], $config['db']['name'], $config['db']['port']);

	if (!($stmt = $con->prepare("DELETE FROM `".$config['db']['table-prefix']."users` WHERE `username`=?;"))) {
		die(json_encode(array('code' => 1, 'message' => $con->error)));
	}

	if (!$stmt->bind_param("s", $username)) {
		die(json_encode(array('code' => 1, 'message' => $con->error)));
	}

	if (!$stmt->execute()) {
		die(json_encode(array('code' => 1, 'message' => $con->error)));
	}
	die(json_encode(array('code' => 0, 'message' => "SUCESS")));
	
}