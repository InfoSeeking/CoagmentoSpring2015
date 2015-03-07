<?php
	session_start();
	require_once("connect.php");
	if (isset($_SESSION['CSpace_userID'])) {
		$userID = $_SESSION['CSpace_userID'];
		if (isset($_SESSION['CSpace_projectID']))
			$projectID = $_SESSION['CSpace_projectID'];
		else {
			$query = "SELECT projects.projectID FROM projects,memberships WHERE memberships.userID='$userID' AND projects.description LIKE '%Untitled project%' AND projects.projectID=memberships.projectID";
			$results = mysql_query($query) or die(" ". mysql_error());
			$line = mysql_fetch_array($results, MYSQL_ASSOC);
			$projectID = $line['projectID'];
		}
		$query = "SELECT * FROM requests WHERE userID='$userID' AND type='reported-project'";
		$results = mysql_query($query) or die(" ". mysql_error());
		if (mysql_num_rows($results)==0) {
			$query1 = "INSERT INTO requests VALUES('','$userID','-1','reported-project','$projectID')";
			$results1 = mysql_query($query1) or die(" ". mysql_error());
		}
		else {
			$line = mysql_fetch_array($results, MYSQL_ASSOC);
			$reportedProjectID = $line['value'];
//			$query1 = "UPDATE requests SET value='$projectID' WHERE userID='$userID' AND type='reported-project'";
//			$results1 = mysql_query($query1) or die(" ". mysql_error());
		}	
		$version = $_GET['version'];
		if ($version<200)
			echo "-1:Incompatible version. Please download the latest version of Coagmento plug-in.";
		else
			echo $userID.":".$reportedProjectID;
	}
	else
		echo "0:Your session has expired. Please login again.";
?>