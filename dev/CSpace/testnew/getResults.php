<?php
	session_name('XULSession'); // Set session name
	session_start();
	require_once("connect.php");
		
	$projectID = $_GET['projectID'];
	
	// Get the results for the given user and the project
	$query = "SELECT * FROM results WHERE projectID='$projectID'";
	$results = mysql_query($query) or die(" ". mysql_error());
	$responseText = "";
	while ($line = mysql_fetch_array($results, MYSQL_ASSOC))
	{
		$title = $line['title'];
		$url = $line['url'];
		if ($title=="")
			$title = $url;
		$responseText = $responseText . $title . ";,;" . $url . ",;,";
	}
//	$responseText = $responseText . "\n";
	echo $responseText;
?>
