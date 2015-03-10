<?php
$page_title = 'DataCast - Creator';
include('includes/header.php');
require('../connect_db.php');

echo '
<div class = "centered">
	<div class = "centerbox">
		<div class = "left">';


if(!isset($_SESSION['user_id'])){
	echo "<p>You need to <a href = \"signin.php\">Sign in</a> before doing anything here.</p>";
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

# the userdatabase table is used to associate a database with a user

			$q = "INSERT INTO userdatabase (dbname, user_id) VALUES ('$dbn','$_SESSION[user_id]')";
			$r = mysqli_query($dbc,$q);

# select the new database ID and use that id to make a new database, 
# this ensures all database names are unique

			$num = mysqli_query($dbc,"SELECT dbid FROM userdatabase ORDER BY dbid DESC LIMIT 1");
			$x = mysqli_fetch_array($num, MYSQLI_ASSOC);

			$i = "CREATE DATABASE IF NOT EXISTS _" . $x['dbid'] ;
			$s = mysqli_query($dbc,$i);

			if(!$r || !$s){
				echo '<p>Error in database creation!</p>';
				echo $dbc->error;
				exit();
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
			echo '- ID: ' . $x['dbid'] . ' <a href = "create_table.php?db=' . $x['dbid'] . '">' . $row['dbname'] . '</a> <a href = "portalmanager.php?db=' . $x['dbid'] . '">Manage Portal</a><br>';
		}
	} else{
		echo '<p>You have no databases.</p>';
	}
}

echo '
		</div>
	</div>
</div>';
# include('includes/footer.html');