<?php

// Connect to the database and return the MySQLi object
function ConnectToDatabase() {
	// Used to connect to the database
	$db_username = 'dpoppe';
	$db_password = 'H01679809';
	$db_database = 'dpoppe';

	// Your database name is the same as your username
	$mysqli = new mysqli("localhost", $db_username, $db_password, $db_database);
 
	// Output error info if there was a connection problem
	if ($mysqli->connect_errno)
		die("Failed to connect to MySQL: ($mysqli->connect_errno) $mysqli->connect_error");
		
	return $mysqli;
}

?>	