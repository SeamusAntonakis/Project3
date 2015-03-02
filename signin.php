<?php

$page_title = 'DataCast - Login';
include('includes/header.php');

if(isset($error) && !empty($errors)){
	echo '<p id = "err_msg">Oops! There was a problem:<br>';
	foreach($errors as $msg){
		echo " - $msg<br>";
	}
	echo 'Please try again or <a href = "register.php">Register</a></p>';
}
?>

<div class = "centerbox">
	<div class = "centered">
		<h1>Login</h1>
		<form action = "login_action.php" method = "POST">
			<p>
			<input class = "cred" type = "text" name = "email" placeholder = "Email address">
			</p><p>
			<input class = "cred" type = "password" name = "pass" placeholder = "Password">
			</p><p>
			<input class = "credbutton" type = "submit" value = "Login">
			</p>
		</form>
		<p>Or Register <a href = "signup.php">here</a></p>
	</div>
</div>
 <!-- <?php include ('includes/footer.html'); ?> -->