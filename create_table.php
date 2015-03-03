<?php

$page_title = 'DataCast - Create Table';
include('includes/header.php');
require('../connect_db.php');

echo '
<div class = "centerbox">
	<div class = "centered">';

# prevent anonymous users from using this page's functionality

if(!isset($_SESSION['user_id'])){
	echo "<p>You need to <a href = \"signin.php\">Sign in</a> before doing anything here.</p>";
} else {

# get an array of all the tables from this database

	$q = "SHOW TABLES FROM _" . $_GET["db"];
	$r = mysqli_query($dbc,$q);

# doesnt work get number of rows first and check that way
	
	if(!$r){	
		echo 'You have no tables.<br>';
	} else {

# use the appropriate database based on what's passed through the URL

		$q = "USE _" . $_GET["db"];
		$switch = mysqli_query($dbc,$q);
		if (!$switch) {
   			printf("Error: %s\n", mysqli_error($dbc));
    		exit();
		}

# firstly, print a table name, then explain that tables columns

		while($row = mysqli_fetch_row($r)){

# get explanation of the tables columns

			$q = "EXPLAIN {$row[0]}";
			$s = mysqli_query($dbc, $q);
			if (!$s) {
   				printf("Error: %s\n", mysqli_error($dbc));
    			exit();
			}

# print a table name

			echo "<h4 class = \"tabletitle\">{$row[0]}</h4>";

# print that table's columns with their attributes
			echo '<table>
			<tr>
			<th>Field</th>
			<th>Type</th>
			<th>NULL</th>
			<th>Key</th>
			<th>Default</th>
			<th>Extra</th>
		</tr>';

			while ($subrow = mysqli_fetch_row($s)) {
    			$num = mysqli_num_fields($s);
    			$x = 0;
    			echo '<tr>';
    			while($num != $x){
    				echo '<td>
    				' . $subrow[$x] . '
    				</td>';
    				$x++;
    			}
    			echo '</tr>';
			}
			echo '</table>';
		}
	}

# db_name defined in connect_db.php
# switch back to database containing user information

	$q = "USE $db_name";
	$switch = mysqli_query($dbc,$q);
	if (!$switch) {
   		printf("Error: %s\n", mysqli_error($dbc));
    	exit();
	}
}

echo '
	</div>
</div>';

mysqli_close($dbc);
# include('includes/footer.html');

?>