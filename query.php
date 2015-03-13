
<?php 

if(!isset($_GET['db'])){
	require('creator.php');
	exit();
}

require('includes/header.php');

require('../connect_db.php');

if(!isset($_SESSION['user_id'])){
	echo '<p>You need to <a href = "signin.php">Sign in</a> before doing anything here.</p>';
	exit();
}

$q = 'select * from userdatabase where dbid =' . $_GET['db'] . ' AND user_id=' . $_SESSION['user_id'];
$r = mysqli_query($dbc,$q);
$num = mysqli_num_rows($r);

if(!$num>0){
	echo '<p>You seem to be in the wrong place.</p>';
	echo '<a href = "creator.php" >return</a>';
	exit();
}

if(!$r){
	echo '<p>You seem to be in the wrong place.</p>';
	echo '<a href = "creator.php" >return</a>';
	exit();
}


$page_title = 'DataCast - Query';

echo '<div class = "centerbox">
<div class = "centered">';



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

			if(strpos($q,'use') === 0 || strpos($q,'USE') === 0 || strpos($q,'show') === 0 || strpos($q,'SHOW') === 0 || strpos($q,'create') === 0 || strpos($q,'CREATE') === 0 ){
				echo '<p>Error: illegal syntax, cannot use SHOW or USE or CREATE in your queries!</p>';
			} else{

				$r = mysqli_query($dbc,$q);

				if($r){
					if (!is_bool($r)){

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
					}
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