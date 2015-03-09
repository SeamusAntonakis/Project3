<?php
$dbc = mysqli_connect('localhost', 'secondary', 'pass', $db_name)
OR die (mysqli_connect_error());

mysqli_set_charset($dbc, 'etf8');

?>