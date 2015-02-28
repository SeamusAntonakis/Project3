<form action="creator.php" method = "POST">
	<p> Name your Database: 
	<input type = "text" name = "db_name"
	value = "<?php if (isset($_POST['db_name'])) echo $_POST['db_name'];?>">
	<input type = "submit" value = "Create"></p>
</form>