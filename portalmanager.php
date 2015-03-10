<?php
	$page_title = 'DataCast - Portal';
	include('includes/header.php');
	if(!isset($_SESSION['user_id'])){
		echo '<p>You need to <a href = "login.php">login</a> before doing anything here.</p>';
		exit();
	}

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

		if(!empty(trim($_POST['email']))){

			require('../connect_db.php');
			
			$email = trim($_POST['email']);
			$dbn = '_' . $_GET["db"];

			if(isset($_POST['add'])){

				$r = isset($_POST['retrieve'])?1:0;
				$i = isset($_POST['insert'])?1:0;
				$u = isset($_POST['update'])?1:0;
				$d = isset($_POST['delete'])?1:0;

				$q = 'SELECT user_id FROM users WHERE email = \'' . $email . '\'';
				$s = mysqli_query($dbc,$q);
				if (!$s){
			   		printf("Error: %s\n", mysqli_error($dbc));
				} else {

					$row = mysqli_fetch_row($s);
					$id = $row[0];

					if(isset($id)){
						$q = 'INSERT INTO portal (user_id,dbid,retrieve,insrt,updte,dlt) values (';
						$q = $q . $id . ',' . $_GET['db'];
						$q = $q . ',' . $r . ',' . $i . ',' . $u . ',' . $d . ')';

						# echo $q . '<br>';

						$r = mysqli_query($dbc,$q);
						if (!$r) {
					   		printf("Error: %s\n", mysqli_error($dbc));
					   		echo 'User might have already been added!<br>';
						} else{
							echo 'User with email: ' . $email . ' added with permissions...<br>';
						}
					} else{
						echo '<p>User email not registered here!</p>';
					}
				}
			}

			if(isset($_POST['delete']) && !empty(trim($_POST['email']))){
				$email = trim($_POST['email']);
				$q = 'SELECT user_id FROM users WHERE email = \'' . $email . '\'';
				$r = mysqli_query($dbc,$q);
				$row = mysqli_fetch_row($r);
				$id = $row[0];

				$q = 'DELETE FROM portal WHERE user_id=' . $id .' AND dbid=' . $_GET["db"];
				$r = mysqli_query($dbc,$q);
				echo $q;
			}

		} else echo 'Email recquired';
	}
?>


<p>Add a user</p>
<form action = <?php echo 'portalmanager.php?db=' . $_GET["db"] . '&act=add';?> method = "POST">
	<p>
	<input class = "cred" type = "text" name = "email" placeholder = "Email address">
	<input type="checkbox" name="retrieve" value=1>Retrieve
	<input type="checkbox" name="insert" value=1>Insert
	<input type="checkbox" name="update" value=1>Update
	<input type="checkbox" name="delete" value=1>Delete</p>
	<p>
	<input class = "credbutton" type = "submit" name="add" value = "Add User">
	</p>
	<p>
	<input class = "credbutton" type = "submit" name="delete" value = "Delete">
	</p>
</form>
