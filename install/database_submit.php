<?php

if(!isset($_POST['user'])) {
	header('Location: database.php?error=1');
}
if(!isset($_POST['pass'])) {
	header('Location: database.php?error=1');
}
if(!isset($_POST['address'])) {
	header('Location: database.php?error=1');
}
if(!isset($_POST['port'])) {
	header('Location: database.php?error=1');
}
if(!isset($_POST['dbname'])) {
	header('Location: database.php?error=1');
}
if(!isset($_POST['tblprefix'])) {
	header('Location: database.php?error=1');
}

if(strlen($_POST['user']) == 0) {
	header('Location: database.php?error=1');
}
if(strlen($_POST['pass']) == 0) {
	header('Location: database.php?error=1');
}
if(strlen($_POST['address']) == 0) {
	header('Location: database.php?error=1');
}
if(strlen($_POST['port']) == 0) {
	header('Location: database.php?error=1');
}
if(strlen($_POST['dbname']) == 0) {
	header('Location: database.php?error=1');
}
if(strlen($_POST['tblprefix']) == 0) {
	header('Location: database.php?error=1');
}

function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}

$configfile = file('../config.php');
$new_file = array();

foreach($configfile as $line) {
	if(startsWith($line, '$db_user = ')) {
		$new_file[] = '$db_user = "'.$_POST['user'].'";'.PHP_EOL;
	} else if(startsWith($line, '$db_pass = ')) {
		$new_file[] = '$db_pass = "'.$_POST['pass'].'";'.PHP_EOL;
	} else if(startsWith($line, '$db_address = ')) {
		$new_file[] = '$db_address = "'.$_POST['address'].'";'.PHP_EOL;
	} else if(startsWith($line, '$db_port = ')) {
		$new_file[] = '$db_port = '.$_POST['port'].';'.PHP_EOL;
	} else if(startsWith($line, '$db_name = ')) {
		$new_file[] = '$db_name = "'.$_POST['dbname'].'";'.PHP_EOL;
	} else if(startsWith($line, '$db_prefix = ')) {
		$new_file[] = '$db_prefix = "'.$_POST['tblprefix'].'";'.PHP_EOL;
	} else if(startsWith($line, '$config[\'installed\'] = ')) {
		$new_file[] = '$config[\'installed\'] = true;'.PHP_EOL;
	} else {
		$new_file[] = $line;
	}
}
file_put_contents('../config.php', $new_file);

?>
<html>
	<body>
		Config updated successfully!
		<br>
		<form action="../index.php">
			<input type="submit" value="Finish">
		</form>
	</body>
</html>