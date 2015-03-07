<?php
	session_name('XULSession'); // Set session name
	session_start();
	require_once("connect.php");
	$pageName = "CSpace/saveResult.php";
	require_once("../counter.php");
			
	$userID = $_GET['userID'];
	$projectID = $_GET['projectID'];
	if ($projectID == 0) {
		$query = "SELECT projects.projectID FROM projects,memberships WHERE memberships.userID='$userID' AND projects.description LIKE '%Untitled project%' AND projects.projectID=memberships.projectID";
		$results = mysql_query($query) or die(" ". mysql_error());
		$line = mysql_fetch_array($results, MYSQL_ASSOC);
		$projectID = $line['projectID'];
	}

	$originalURL = $_GET['URL'];
	$title = $_GET['title'];
	$url = $originalURL;
	$save = $_GET['save'];
/*
	$query = "SELECT max(pageID) as id FROM pages WHERE userID='1' AND projectID='1' AND url='$url'";
	$results = mysql_query($query) or die(" ". mysql_error());
	$line = mysql_fetch_array($results, MYSQL_ASSOC);
	$pageID = $line['id'];
*/
	
	if ($save) {
		$query = "SELECT * FROM pages WHERE projectID='$projectID' AND url='$originalURL'";
		$results = mysql_query($query) or die(" ". mysql_error());
		if (mysql_num_rows($results)==0) {	
			require_once("utilityFunctions.php");

			// Parse the URL to extract the source
			$url = str_replace("http://", "", $url); // Remove 'http://' from the reference
			$url = str_replace("com/", "com.", $url);
			$url = str_replace("org/", "org.", $url);
			$url = str_replace("edu/", "edu.", $url);
			$url = str_replace("gov/", "gov.", $url);
			$url = str_replace("us/", "us.", $url);
			$url = str_replace("ca/", "ca.", $url);
			$url = str_replace("uk/", "uk", $url);
			$url = str_replace("es/", "es.", $url);
			$url = str_replace("net/", "net.", $url);
			$entry = explode(".", $url);
			$i = 0;
			$isWebsite = 0;
			while (($entry[$i]) && ($isWebsite == 0)) {
				$entry[$i] = strtolower($entry[$i]);
				if (($entry[$i] == "com") || ($entry[$i] == "edu") || ($entry[$i] == "org") || ($entry[$i] == "gov") || ($entry[$i] == "info") || ($entry[$i] == "us") || ($entry[$i] == "ca") || ($entry[$i] == "es") || ($entry[$i] == "uk") || ($entry[$i] == "net")) {
					$isWebsite = 1;
					$site = $entry[$i-1];
					$domain = $entry[$i];
				}
				$i++;
			} // while (($entry[$i]) && ($isWebsite == 0))
		
			// Extract the query if there is any
			$queryString = extractQuery($originalURL);
				
			// Get the date, time, and timestamp
			$timestamp = time();
			$datetime = getdate();
		    $date = date('Y-m-d', $datetime[0]);
			$time = date('H:i:s', $datetime[0]);
			$query = "INSERT INTO pages VALUES('','$userID','$projectID','$originalURL','$title','$site','$queryString','$timestamp','$date','$time','1')";
		} // if (mysql_num_rows($results)==0)
		else
			$query = "UPDATE pages SET result=1 WHERE projectID='$projectID' AND url='$originalURL'";
	} // if ($save)
	else
		$query = "UPDATE pages SET result=0 WHERE projectID='$projectID' AND url='$originalURL'";
	$results = mysql_query($query) or die(" ". mysql_error());
//	fwrite($fout, $userID."\t".$projectID."\t".$originalURL."\n");
	
/*	// Get the date, time, and timestamp
	$timestamp = time();
	$datetime = getdate();
    $date = date('Y-m-d', $datetime[0]);
	$time = date('H:i:s', $datetime[0]);
	
	if ($save == 1) {
		// Parse the URL to extract the source
		$url = str_replace("http://", "", $url); // Remove 'http://' from the reference
		$url = str_replace("com/", "com.", $url);
		$url = str_replace("org/", "org.", $url);
		$url = str_replace("edu/", "edu.", $url);
		$url = str_replace("gov/", "gov.", $url);
		$url = str_replace("us/", "us.", $url);
		$url = str_replace("ca/", "ca.", $url);
		$url = str_replace("uk/", "uk", $url);
		$url = str_replace("es/", "es.", $url);
		$url = str_replace("net/", "net.", $url);
		$entry = explode(".", $url);
		$i = 0;
		$isWebsite = 0;
		while (($entry[$i]) && ($isWebsite == 0))
		{
			$entry[$i] = strtolower($entry[$i]);
			if (($entry[$i] == "com") || ($entry[$i] == "edu") || ($entry[$i] == "org") || ($entry[$i] == "gov") || ($entry[$i] == "info") || ($entry[$i] == "us") || ($entry[$i] == "ca") || ($entry[$i] == "es") || ($entry[$i] == "uk") || ($entry[$i] == "net"))
			{
				$isWebsite = 1;
				$site = $entry[$i-1];
				$domain = $entry[$i];
			}
			$i++;
		} // while (($entry[$i]) && ($isWebsite == 0))
		
		// Fetch the webpage
		$page = file_get_contents($originalURL);	
		$fout = fopen("temp",'w');
		fwrite($fout, $page);
		fclose($fout);
		

		// Calculate the file size (in bytes) and word count
		$fileSize = filesize("temp");
		if ($fileSize == 0)
		{
			$entry = explode("/", $originalURL);
			$i = 0;
			$fetchURL = "";
			while($entry[$i+1])
			{
				$fetchURL = $fetchURL . $entry[$i];
				$i++;
			}
			// Fetch the webpage
			$page = file_get_contents($fetchURL);	
			$fout = fopen("temp",'w');
			fwrite($fout, $page);
			fclose($fout);
	
			// Calculate the file size (in bytes) and word count
			$fileSize = filesize("temp");
		}
		$wordCount = str_word_count($page);

		
		// Extract the title of the webpage
		system("grep \"<title>\" temp > ttemp");
		$fTemp = fopen("ttemp", 'r');
		$tLine = fgets($fTemp);
		trim($tLine);
		if ($tLine=="") {
			system("grep \"<TITLE>\" temp > ttemp");
			$fTemp = fopen("ttemp", 'r');
			$tLine = fgets($fTemp);
			trim($tLine);
		}
		str_replace("TITLE>", "title>", $tLine);
		fclose($fTemp);
		list($temp1, $temp2) = explode("<title>", $tLine);
		list($title, $temp3) = explode("</title>", $temp2);
					
		$query = "INSERT INTO results1 VALUES('','$userID','$projectID','$originalURL','$site','$title','$fetchURL','','$timestamp','$date','$time','1','','$fileSize','$wordCount')";
		$results = mysql_query($query) or die(" ". mysql_error());
	}
	else {
		$query = "REMOVE FROM results WHERE userID='$userID' AND projectID='$projectID' AND url='$originalURL'";
		$results = mysql_query($query) or die(" ". mysql_error());
	}	
//	fclose($fout);
*/
?>
