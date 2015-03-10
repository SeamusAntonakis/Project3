<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="includes/style.css">
	<meta charset = "UTF-8">
	<title><?php echo $page_title;?></title>
	<link href="/favicon.ico" rel="Shortcut Icon" />
</head>
<body>
<div class = "headersect">
<ul>
	<li><a class = "button" href = "home.php">Home</a></li>
	<li><a class = "button" href = "portal.php">Portal</a></li>
	<li><a class = "button" href = "creator.php">Creator</a></li>
	<li><a class = "button" href = "about.php">About us</a></li>
	<?php 

# session_start creates a session or resumes the current
# one based on the session identifier passed by GET or POST
# in this way variables are available from other pages of the 
# site with the superglobal $_SESSION. Commonly user data.

	session_start();

# We can tell from $_SESSION[] whether or not a user
# is logged in, if s(he) is then display a different 
# than that viewed by an anonymous user

	if(isset($_SESSION['user_id'])){
		echo '<li class = "right"><a class = "button" href = "goodbye.php">Sign Out</a></li>';
		echo '<li class = "right"><a class = "button" href = ""> ' . $_SESSION['first_name'].' '.$_SESSION['last_name'].'</a></li>';
	} 

	else echo '<li class = "right"><a class = "button" href = "signin.php">Sign In</a></li>';

	?>

</ul>
</div>
