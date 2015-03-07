<?php
	require_once("connect.php"); // Include the file for database connection details

	// Each user has a unique ID in the system.
	$userID = 2;
	
	// Get info about the user
	$query = "SELECT * FROM users WHERE userID=$userID";
	$results = mysql_query($query) or die(" ". mysql_error());
	$line = mysql_fetch_array($results, MYSQL_ASSOC);
	$firstName = $line['firstName']; // Here, $firstName is a PHP variable, and 'firstName' is the name of a column in MySQL database
	$lastName = $line['lastName'];
	
	echo "Records for user: <strong>$firstName $lastName</strong><br/><br/>\n";
	
	$test="2009-04-26";
	
	$query = "SELECT * FROM pages WHERE date=$test ORDER BY date,time LIMIT 100"; // To get the first 100 records
//	$query = "SELECT * FROM pages WHERE userID=$userID ORDER BY date,time"; // To get all the records
	$results = mysql_query($query) or die(" ". mysql_error());
	while ($line = mysql_fetch_array($results, MYSQL_ASSOC)) {	
		$title = $line['title'];
		$url = $line['url'];
		$date = $line['date'];
		$time = $line['time'];
		echo "<a href=\"$url\">$title</a>, $date $time<br/>\n";
	}
	
	
	
	/* $query = "SELECT * FROM pages WHERE userID=$userID ORDER BY date,time LIMIT 100"; // To get the first 100 records
//	$query = "SELECT * FROM pages WHERE userID=$userID ORDER BY date,time"; // To get all the records
	$results = mysql_query($query) or die(" ". mysql_error());
	while ($line = mysql_fetch_array($results, MYSQL_ASSOC)) {	
		$title = $line['title'];
		$url = $line['url'];
		$date = $line['date'];
		$time = $line['time'];
		echo "<a href=\"$url\">$title</a>, $date $time<br/>\n";
	}	*/
?>
