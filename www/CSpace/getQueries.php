<?php
	session_name('XULSession'); // Set session name
	session_start();
	require_once("connect.php");
		
	$projectID = $_GET['projectID'];
	
	// Get the results for the given user and the project
	$query = "SELECT * FROM queries WHERE projectID='$projectID'";
	$results = mysql_query($query) or die(" ". mysql_error());
	$responseText = "";
	while ($line = mysql_fetch_array($results, MYSQL_ASSOC)) {
		$text = $line['query'];
		$source = $line['source'];
		switch ($source) {
			case "google":
				$symbol = "G";
				break;
			case "yahoo":
				$symbol = "Y";
				break;
			case "live":
				$symbol = "L";
				break;
			case "cnn":
				$symbol = "C";
				break;
			default:
				$symbol = $source;
				break;
		}
		$url = $line['url'];
		$responseText = $responseText . $symbol . ": " . $text . ";,;". $url . ",;,";
	}
	echo $responseText;
?>
