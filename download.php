<?php

$page_title = 'DataCast - Create Table';
include('includes/header.php');
require('../connect_db.php');

echo '
<div class = "centerbox">
	<div class = "centered">';

	$target_file = "C:\Abyss Web Server\htdocs\downloads\dump.sql";

	require("../dump_db.php");

	if (!$return) {
    	echo "<p>sql file create successfully</p>";
	} else {
   		echo "<p>sql file not created</p>";
	}	

	# echo $output;

	$r = unlink($target_file);
    if($r){
        echo '<p>file deleted successfully</p>';
    } else{
    	echo '<p>could not delete file</p>';
    }


    echo "<p>return to <a href = \"create_table.php?db={$_GET["db"]}\">creator</a></p>";

echo '
	</div>
</div>';
