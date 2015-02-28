<?php
$page_title = 'DataCast - Viewer';
include('includes/header.html');
session_start();
if(!isset($_SESSION['user_id'])){
	echo '<p>You need to <a href = "login.php">login</a> before doing anything here.</p>';
}
include('includes/footer.html');
?>