<?php
$page_title = 'DataCast - Query';
	include('includes/header.php');

	echo '<div class = "centerbox">
	<div class = "centered">';

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		$db_name = '_' . $_GET["db"];
		require('../secondary.php');
		$q = 'USE ' . $db_name;
		$r = mysqli_query($dbc,$q) or die(mysqli_error($dbc));

		if($r){

			$q = $_POST['query'];

			if (!empty(trim($q))){

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