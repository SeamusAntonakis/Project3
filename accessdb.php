<?php
	$page_title = 'DataCast - Portal';
	include('includes/header.php');
	require('../connect_db.php');

	if(!isset($_SESSION['user_id'])){
		echo '<p>You need to <a href = "login.php">login</a> before doing anything here.</p>';
		exit();
	}

	#check user has access to database by looking portal, take take all info from portal
	#make page with appropriate functions

	$dbid = $_GET['dbid'];
	$user_id = $_SESSION['user_id'];

	$q = 'SELECT * FROM portal WHERE dbid=' . $dbid . ' AND user_id=' . $user_id;
	$r = mysqli_query($dbc,$q);

	$num = mysqli_num_rows($r);
	if($num > 0){
		$row = mysqli_fetch_array($r, MYSQLI_ASSOC);

		$insert	 	= $row['insrt'];
		$delete 	= $row['dlt'];
		$update		= $row['updte'];
		$retrieve	= $row['retrieve'];

		if($retrieve){

			# search function
		}

		if($insert){

			# insert function
		}

		if($update){

			# search then append data
		}

		if($delete){

			# search then remove
		}


	} else{
		echo 'You seem to be in the wrong place, <a href = "protal.php">return</a>';
	}
	# <?php include ('includes/footer.html');
?>