<?php

$page_title = 'DataCast - Create Table';
include('includes/header.html');
require('../connect_db.php');
session_start();

if(!isset($_SESSION['user_id'])){
	echo "<p>You need to <a href = \"login.php\">login</a> before doing anything here.</p>";
}

else{
	$q = "SHOW TABLES FROM $db_name";
	$r = mysqli_query($dbc,$q);
	
	if(!$r){
		echo 'You have no tables.<br>';
	} else{
		echo 'Tables:<br>';
		while($row = mysqli_fetch_row($r)){
			echo "- {$row[0]} <br>";
		}
	}
}
mysqli_close($dbc);
include('includes/footer.html');

?>