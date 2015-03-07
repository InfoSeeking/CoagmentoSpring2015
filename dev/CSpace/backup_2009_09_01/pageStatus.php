<?php
	session_name('XULSession'); // Set session name
	session_start();
	require_once("connect.php");
	
//	$fout = fopen('status.tmp', 'a');
	$userID = $_GET['userID'];
	$projectID = $_GET['projectID'];
	if ($projectID == 0) {
		$query = "SELECT projects.projectID FROM projects,memberships WHERE memberships.userID='$userID' AND projects.description LIKE '%Untitled project%' AND projects.projectID=memberships.projectID";
//		fwrite($fout, "$query\n");
		$results = mysql_query($query) or die(" ". mysql_error());
		$line = mysql_fetch_array($results, MYSQL_ASSOC);
		$projectID = $line['projectID'];
	}

	$originalURL = $_GET['URL'];
	$url = $originalURL;

	if (isset($_GET['userID']) && ($projectID!=0)) {		
		$query = "SELECT count(*) as num FROM pages WHERE userID='$userID' AND projectID='$projectID' AND url='$url' AND result=1";
	//	fwrite($fout, $query."\n");
		$results = mysql_query($query) or die(" ". mysql_error());
		$line = mysql_fetch_array($results, MYSQL_ASSOC);
		$num = $line['num'];
		if ($num == 0)
			$saved = 0;
		else
			$saved = 1;
		echo "$saved;";
		$query = "SELECT count(*) as num FROM pages WHERE projectID='$projectID' AND userID='$userID' AND url='$url'";
	//	fwrite($fout, "$query\n");
		$results = mysql_query($query) or die(" ". mysql_error());
		$line = mysql_fetch_array($results, MYSQL_ASSOC);
		$num = 0;
		$num = $line['num'];
		echo "Views: $num;";
		$query = "SELECT count(*) as num FROM snippets WHERE projectID='$projectID' AND userID='$userID' AND url='$url'";
	//	fwrite($fout, "$query\n");
		$results = mysql_query($query) or die(" ". mysql_error());
		$line = mysql_fetch_array($results, MYSQL_ASSOC);
		$num = 0;
		$num = $line['num'];
		echo "Snippets: $num;";
		
		$query = "SELECT count(*) as num FROM annotations WHERE projectID='$projectID' AND userID='$userID' AND url='$url'";
	//	fwrite($fout, "$query\n");
		$results = mysql_query($query) or die(" ". mysql_error());
		$line = mysql_fetch_array($results, MYSQL_ASSOC);
		$num = 0;
		$num = $line['num'];
		echo "Annotations: $num;";
		
		$query = "SELECT title FROM projects WHERE projectID='$projectID'";
	//	fwrite($fout, "$query\n");
		$results = mysql_query($query) or die(" ". mysql_error());
		$line = mysql_fetch_array($results, MYSQL_ASSOC);
		$title = $line['title'];
		echo "Project: $title - ";
	
		$query = "SELECT count(distinct url) as num FROM pages WHERE projectID='$projectID'";
	//	fwrite($fout, "$query\n");
		$results = mysql_query($query) or die(" ". mysql_error());
		$line = mysql_fetch_array($results, MYSQL_ASSOC);
		$num = $line['num'];
		echo "Viewed: $num, ";
	
		$query = "SELECT count(distinct url) as num FROM pages WHERE projectID='$projectID' AND result=1";
	//	fwrite($fout, "$query\n");
		$results = mysql_query($query) or die(" ". mysql_error());
		$line = mysql_fetch_array($results, MYSQL_ASSOC);
		$num = $line['num'];
		echo "Saved: $num, ";
	
		$query = "SELECT count(distinct url) as num FROM queries WHERE projectID='$projectID'";
	//	fwrite($fout, "$query\n");
		$results = mysql_query($query) or die(" ". mysql_error());
		$line = mysql_fetch_array($results, MYSQL_ASSOC);
		$num = $line['num'];
		echo "Queries: $num, ";
		
		$query = "SELECT count(*) as num FROM snippets WHERE projectID='$projectID'";
	//	fwrite($fout, "$query\n\n");
		$results = mysql_query($query) or die(" ". mysql_error());
		$line = mysql_fetch_array($results, MYSQL_ASSOC);
		$num = $line['num'];
		echo "Snippets: $num";
	}
	else
		echo "0; View count: N/A; Snippets: N/A; Annotations: N/A; Project: N/A";
		
//	fclose($fout);
?>
