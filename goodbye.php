<?php
session_start();
if(!isset($_SESSION['user_id'])){
	include('home.php');
}
else{
	$_SESSION = array();
	session_destroy();
	include('home.php');
}

?>