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

<h1>Login</h1>
<form action = "login_action.php" method = "POST">
<p>
Email Address: <input type = "text" name = "email">
</p><p>
Password: <input type = "password" name = "pass">
</p><p>
<input type = "submit" value = "Login">
</p>
</form>
<p>Or Register <a href = "register.php">here</a></p>

 <!-- <?php include ('includes/footer.html'); ?> -->