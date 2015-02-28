<?php

# For security purposes this file is placed
# in the directory above the other website 
# files.
$db_name = 'site_db';
$dbc = mysqli_connect('localhost', 'aran', 'pass', $db_name)
OR die (mysqli_connect_error() );

# Set encoding to match PHP script encoding
mysqli_set_charset($dbc, 'etf8' );
