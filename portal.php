<?php
	$page_title = 'DataCast - Portal';
	include('includes/header.php');
	require('../connect_db.php');

	if(!isset($_SESSION['user_id'])){
		echo '<p>You need to <a href = "login.php">login</a> before doing anything here.</p>';
		exit();
	}

	echo "<h3>You have privileges on:</h3>";
	
	$q = "SELECT dbname,userdatabase.dbid FROM userdatabase INNER JOIN portal ON userdatabase.dbid=portal.dbid AND portal.user_id={$_SESSION['user_id']};";

	$r = mysqli_query($dbc,$q);
	if(!$r){
		echo $dbc->error;
	}

	$num = mysqli_num_rows($r);
	
	if($num > 0){

		while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
			echo '<p>- <a href = accessdb.php?dbid=' . $row['dbid'] . '>' . $row['dbname'] . '</a></p>';
		}
	} else{
		echo '<p>You don\'t have access to any other databases.</p>';
	}


	 # <?php include ('includes/footer.html');
?>