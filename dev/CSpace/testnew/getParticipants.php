<?php
	session_name('XULSession'); // Set session name
	session_start();
	require_once("connect.php");
	$projectID = $_GET['projectID'];
	
	// Get the results for the given user and the project
	$query = "SELECT * FROM participants WHERE projectID='$projectID'";
	$results = mysql_query($query) or die(" ". mysql_error());
	$responseText = "";
	while ($line = mysql_fetch_array($results, MYSQL_ASSOC)) {
		$userID = $line['userID'];
		$query2 = "SELECT * FROM users WHERE userID='$userID'";
		$results2 = mysql_query($query2) or die(" ". mysql_error());
		while ($line2 = mysql_fetch_array($results2, MYSQL_ASSOC)) {
			$firstName = $line2['firstName'];
			$lastName = $line2['lastName'];
			$name = $firstName . " " . $lastName;
			$responseText = $responseText . $userID . ";,;" . $name . ",;,";
		}
	}
	echo $responseText;
?>
