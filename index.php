<?php
error_reporting(0);
require('api.php');
if(CAS_API::http_allowed() == false) {
	die(json_encode(array('code' => 7, 'message' => "HTTP DISALLOWED")));
}
if(!isset($_GET['key']) || strlen($_GET['key']) == 0) {
	die(json_encode(array('code' => 3, 'message' => "INVALID KEY")));
}
if(!isset($_GET['type']) || strlen($_GET['type']) == 0) {
	die(json_encode(array('code' => 2, 'message' => "INVALID QUERY")));
}
$key = $_GET['key'];
$type = $_GET['type'];

$api = new CAS_API($key);

switch($type) {
	case 'listusers':
		echo($api->listUsers());
		break;
		
	case 'login':
		echo($api->login($_POST['username'], $_POST['password']));
		break;
		
	case 'registeruser':
		echo($api->registeruser($_POST['username'], $_POST['password']));
		break;
		
	case 'removeuser':
		echo($api->removeUser($_POST['username']));
		break;
		
	case 'updatepass':
		echo($api->updatePass($_POST['username'], $_POST['password'], $_POST['newpassword']));
		break;

}

?>