<?php

# session_start creates a session or resumes the current
# one based on the session identifier passed by GET or POST
# in this way variables are available from other pages of the 
# site with the superglobal $_SESSION. Commonly user data.

session_start();

$page_title = 'AppCast - Home';

# Include header placed in the includes folder.

include('includes/header.html');


# We can tell from $_SESSION[] whether or not a user
# is logged in, if s(he) is then display a different 
# than that viewed by an anonymous user.

if(isset($_SESSION['user_id'])){
	echo "<h1>HOME</h1>
		<p>You are now logged in,
		{$_SESSION['first_name']} {$_SESSION['last_name']}
		</p>";
}

# Anonymous user view.

else echo '<h1>HOME</h1>
		<p>Welcome to Datacast.
		</p>';
		
# Display login or Signup links for anonymous users, otherwise 
# display a logout link.		

if(!isset($_SESSION['user_id'])){
	echo '<p><a href = "login.php">Login</a> | <a href = "register.php">Signup</a></p>';
}
else echo '<p><a href = "goodbye.php">Logout</a></p>';

# Include the footer placed in the includes folder.
include('includes/footer.html');

?>