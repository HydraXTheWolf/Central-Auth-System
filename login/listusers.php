<?php

//A Successful list will look something like this:
// {"code":0,"message":"SUCESS","users":{"2":{"username":"hydrax","password":"$2y$10$lanofu96ZAuioLFZxw9YhOA0WGBouvCMUk78JseWLcHFM7lhFVYG6","id":2,"regodate":1428548556,"lastlogin":null}}}
function listusers($config) {
	$users = array();
	$con = new mysqli($config['db']['address'], $config['db']['user'], $config['db']['pass'], $config['db']['name'], $config['db']['port']);

	if (!($stmt = $con->prepare("SELECT * FROM `".$config['db']['table-prefix']."users`;"))) {
		die(json_encode(array('code' => 1, 'message' => $con->error)));
	}

	if (!$stmt->execute()) {
		die(json_encode(array('code' => 1, 'message' => $con->error)));
	}
	$result = $stmt->get_result();
	while ($row = $result->fetch_assoc()) {

        $users[$row['id']] = $row;

    }
	
	
	die(json_encode(array('code' => 0, 'message' => "SUCESS", 'users' => $users)));
	


}