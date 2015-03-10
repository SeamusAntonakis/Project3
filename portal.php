<?php
$page_title = 'DataCast - Portal';
include('includes/header.php');
if(!isset($_SESSION['user_id'])){
	echo '<p>You need to <a href = "login.php">login</a> before doing anything here.</p>';
}
 # <?php include ('includes/footer.html');
?>