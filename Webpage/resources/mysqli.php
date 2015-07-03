<?php
	//MYSQL DATEN
	$dbserver = "localhost";
	$db = "streaming";
	$dbuser = "streaming";
	$dbpw = "FvEQkzgmeGY4rfmu";
	
	try{
		$mysqli = new mysqli("$dbserver", "$dbuser", "$dbpw", "$db");
		if ($mysqli->connect_errno) {	
			echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		
		}
	} catch (Exception $e)
	{
	
	
	}
?>