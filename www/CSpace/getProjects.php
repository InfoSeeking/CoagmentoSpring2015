<?php
	session_name('XULSession'); // Set session name
	session_start();
	require_once("connect.php");
	$userID = $_GET['userID'];
	
	// Get the projects for the given user
	$query = "SELECT * FROM participants WHERE userID='$userID'";
	$results = mysql_query($query) or die(" ". mysql_error());
	$responseText = "";
	while ($line = mysql_fetch_array($results, MYSQL_ASSOC)) {
		$projectID = $line['projectID'];
		$query2 = "SELECT * FROM projects WHERE projectID='$projectID'";
		$results2 = mysql_query($query2) or die(" ". mysql_error());
		while ($line2 = mysql_fetch_array($results2, MYSQL_ASSOC)) {
			$name = $line2['name'];
			$responseText = $responseText . $projectID . ";,;" . $name . ",;,";
		}
	}
	echo $responseText;
?>
