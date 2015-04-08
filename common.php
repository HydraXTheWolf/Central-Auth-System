<?php
include("config.php");
$GLOBALS['CAS-ROOT'] = __DIR__;

if($config['installed'] == false) {
header('Location: install/index.php');
} else if(file_exists($GLOBALS['CAS-ROOT']."/install/.ht")) {
header('Location: install/remove.php');
}

