<?php
$db_user = "root";
$db_pass = "alex24";
$db_address = "localhost";
$db_port = 3306;
$db_name = "cas";
$db_prefix = "cas-";

$allow_html_requests = false;
//DO NOT EDIT PAST HERE

$config = array();

$config['db'] = array(
	"user" => $db_user,
	"pass" => $db_pass,
	"address" => $db_address,
	"port" => $db_port,
	"name" => $db_name,
	"table-prefix" => $db_prefix,
	);
$config['installed'] = true;
$config['allow-html-requests'] = $allow_html_requests;
	

unset($db_user);
unset($db_pass);
unset($db_address);
unset($db_port);
unset($db_name);
unset($db_prefix);
?>