<?php
$page_title = 'DataCast - Creator';
include('includes/header.html');
require('../connect_db.php');
session_start();

if(!isset($_SESSION['user_id'])){
	echo "<p>You need to <a href = \"login.php\">login</a> before doing anything here.</p>";
}

else{
	
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$error = array();
	
		if(empty(trim($_POST['db_name']))){
			$errors[] = 'Enter a database name.';
		} else{
			$dbn = mysqli_real_escape_string($dbc, trim($_POST['db_name']));
		}
		
		if(empty($errors)){
			$q = "SELECT dbname FROM userdatabase WHERE dbname = '$dbn' AND user_id = $_SESSION[user_id]";
			$r = mysqli_query($dbc,$q);
			if(mysqli_num_rows($r) != 0){
				$errors[] = 'You already have a database with this name!';
			}
		}
		
		if(empty($errors)){
			
			
			$q = "INSERT INTO userdatabase (dbname, user_id) VALUES ('$dbn','$_SESSION[user_id]')";
			$r = mysqli_query($dbc,$q);
			
			if($r){
				echo '<p>You created your Database, well done.</p>';
			}

		} else{
			foreach($errors as $msg){
				echo " - $msg<br>";
			}
		}
	}
	
	include('create_form.php');
	
	echo "<h3>Your databases</h3>";
	
	$q = "SELECT dbname FROM userdatabase WHERE user_id = $_SESSION[user_id]";
	$r = mysqli_query($dbc,$q);
	
	$num = mysqli_num_rows($r);
	
	if($num > 0){
		while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
			$q = "SELECT dbid FROM userdatabase WHERE user_id ={$_SESSION['user_id']} AND dbname = '{$row['dbname']}'";
			$db = mysqli_query($dbc,$q);
			$x = mysqli_fetch_array($db, MYSQLI_ASSOC);
			echo '-<a href = "create_table.php?db='.$x['dbid'].'">' . $row['dbname'] . '</a><br>';
		}
	} else{
		echo 'You have no databases.';
	}
}

include('includes/footer.html');