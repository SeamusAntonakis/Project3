
<?php
$page_title = 'DataCast - Register';
include('includes/header.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	require('../connect_db.php');
	$error = array();

# If there is no value for $_POST['first_name'], add to array $errors a value

	if(empty(trim($_POST['first_name']))){
		$errors[] = 'Enter your first name.';
	} else{
		$fn = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
	}

	if(empty(trim($_POST['last_name']))){
		$errors[] = 'Enter your last name.';
	} else{
		$ln = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
	}

	if(trim(empty($_POST['email']))){
		$errors[] = 'Enter your email address.';
	}

	else{

		$email = $_POST['email'];
# use regular expression to determine validity of email
		$pattern = '/\b[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}\b/';

		if(!preg_match($pattern,$email)){
			$errors[] = 'That is not a valid email address!';
		} else{
			$e = mysqli_real_escape_string($dbc, trim($_POST['email']));
		}
	}

	if(!empty(trim($_POST['pass1']))){
		if($_POST['pass1'] != $_POST['pass2']){
			$errors[] = 'Passwords do not match';
		} else{
			$p = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
		}
	} else{
		$errors[] = 'Enter your password';
	}

# Given that there is something in the $errors array one of the values for registration had 
# not been entered. So do not interact with the database.
	
# Check to see if the email address has already been used before, and add an error message 
# for that in the $errors array.

	if(empty($errors)){
		$q = "SELECT user_id FROM users WHERE email = '$e'";
		$r = mysqli_query($dbc,$q);
		if(mysqli_num_rows($r) != 0){
			$errors[] = 'Email address already registered.
							<a href = "signin.php">Login</a>';
		}
	}

	if(empty($errors)){
		$q = "INSERT INTO users (first_name, last_name, email, pass, reg_date)
				VALUES ('$fn','$ln','$e',SHA1('$p'),NOW())";
		$r = mysqli_query($dbc,$q);

		if($r){
			echo '<h1>Registered!</h1>
					<p>You are now registered.</p>
					<p><a href="signin.php">Login</a></p>';
		}

		mysqli_close($dbc);
		include('includes/footer.html');
		exit();
	} 
	
# Instead of interacting with the database, display messages contained in $errors array.
	
	else{
		echo '
	<div class = "centerbox">
		<h1>Error!</h1>
		<p id = "err_msg">The following error(s) occured:<br>';
		foreach($errors as $msg){
			echo " - $msg<br>";
		}
		echo 'Please try again.</p>';
		mysqli_close($dbc);
	}
}
?>

<div class = "centerbox">
	<div class = "centered">
		<h1>Register</h1>
	
<!--
	When the user hits submit, load signup.php with method POST
-->

		<form action="signup.php" method = "POST">

<!--
	Given that there is a value for $_POST['first_name'], write that value in the field
	This occurs when the user has previously pressed the submit button, values entered are 
	retained
-->

		<p>
		<input class = "cred fsname" type = "text" name = "first_name" placeholder ="First Name"
		value = "<?php if (isset($_POST['first_name'])) echo $_POST['first_name'];?>">
		<input class = "cred fsname" type = "text" name = "last_name" placeholder ="Last Name"
		value = "<?php if (isset($_POST['last_name'])) echo $_POST['last_name'];?>">
		</p><p>
		<input class = "cred" type = "text" name = "email" placeholder ="Email"
		value = "<?php if (isset($_POST['email'])) echo $_POST['email'];?>">
		</p><p>
		<input class = "cred" type = "password" name = "pass1" placeholder ="Password"
		value = "<?php if (isset($_POST['pass1'])) echo $_POST['pass1'];?>">
		</p><p>
		<input class = "cred" type = "password" name = "pass2" placeholder ="Re-enter Password"
		value = "<?php if (isset($_POST['pass2'])) echo $_POST['pass2'];?>">
		</p><p>
		<input class = "credbutton" type = "submit" value = "Register"></p>
		</form>
	</div>
</div>
 <!-- <?php include ('includes/footer.html'); ?> -->

 