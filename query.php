<?php 

$page_title = 'DataCast - Query';
require('includes/header.php');

echo '<div class = "centerbox">
<div class = "centered">';

if(!isset($_SESSION['user_id'])){
	echo '<p>You need to <a href = "login.php">login</a> before doing anything here.</p>';
	exit();
}


if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
# store the name of the database to be queried 

	$db_name = '_' . $_GET["db"];

# connect to the database as a user who has limited permissions
# in this case you can SELECT, UPDATE, INSERT and DELETE

	require('../secondary.php');

# make sure the queries are run against the database provided by 
# the URL

	$q = 'USE ' . $db_name;
	$r = mysqli_query($dbc,$q) or die(mysqli_error($dbc));

	if($r){

# obtain the query

		$q = $_POST['query'];
		$q = trim($q);
		if (!empty($q)){

# make sure the user doesn't try to switch database by checking if 
# USE is at the start of a query

			if(strpos($q,'use') === 0 || strpos($q,'USE') === 0 || strpos($q,'show') === 0 || strpos($q,'SHOW') === 0 ){
				echo '<p>Error: illegal syntax, cannot use SHOW or USE in your queries!</p>';
			} else{

				$r = mysqli_query($dbc,$q);

				if($r){

# display result of query

					echo '<table>
					<tr>';

					$numcol = mysqli_num_fields($r);
					$num = 0;

					$names = mysqli_fetch_fields ($r);

					foreach($names as $name){
						echo '<th>' . $name->name . '</th>';
					}

					echo '</tr>';

					while($row = mysqli_fetch_row($r)){

						echo '<tr>';

						while($num < $numcol){
							echo '<td>';
							echo $row[$num];
							echo '</td>';
							$num++;
						}
						$num = 0;
						echo '</tr>';
					}
					echo '</table>';
				} else{
					echo '<p>Error: ' . mysqli_error($dbc) . '</p>';
				}
			}
		} else{
			echo 'Error: Empty Query';
		}
		
	} else{
			echo '<p>use Error: ' . mysqli_error($dbc) . '</p>' ;
	}
}

?>
<div class = "left">
		<p>Enter your Query:</p>
		<form action= <?php echo 'query.php?db=' . $_GET["db"]; ?> method = "POST" accept-charset = "utf-8">
			<p>
			<textarea name = "query" rows = "5" cols = "50"><?php if (isset($_POST['query'])) echo $_POST['query']; ?></textarea>
			</p>
			<p><input type = "submit" value = "Submit"></p>
		</form>
		</div>
	</div>
</div>