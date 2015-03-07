<?php
	session_start();
	require_once("connect.php");
	$pageName = "CSpace/views.php";
	require_once("../counter.php");
	$userID = $_SESSION['CSpace_userID'];
	$projectID = $_SESSION['CSpace_projectID'];
	if ($projectID == 0) {
		$query = "SELECT projects.projectID FROM projects,memberships WHERE memberships.userID='$userID' AND projects.description LIKE '%Untitled project%' AND projects.projectID=memberships.projectID";
		$results = mysql_query($query) or die(" ". mysql_error());
		$line = mysql_fetch_array($results, MYSQL_ASSOC);
		$projectID = $line['projectID'];
	}
?>
<html>
<head>
	<title>Views</title>
	<link href="css/styles.css" rel="stylesheet" type="text/css" />
</head>
<body class="body">
<center>
<table border=1 cellpadding=2 cellspacing=0 class="style3">
<?php		
	if ($userID>0) {
		$url = $_GET['page'];	
//		$title = $_GET['title'];
		echo "<strong>Views for page: <a href=\"$url\">$url</a></strong><br/><br/>\n";
		echo "<tr bgcolor=#DDDDDD><th>#</th><th>User</th><th>Time</th></tr>\n";
		// Get the date, time, and timestamp
		$timestamp = time();
		$datetime = getdate();
	    $date = date('Y-m-d', $datetime[0]);
		$time = date('H:i:s', $datetime[0]);
	
		// Get the results for the given user and the project
		$query = "SELECT * FROM pages WHERE projectID='$projectID' AND url='$url' ORDER BY timestamp";
		$results = mysql_query($query) or die(" ". mysql_error());
		$count = 1;
		while ($line = mysql_fetch_array($results, MYSQL_ASSOC)) {
			$user = $line['userID'];
			$query1 = "SELECT * FROM users WHERE userID='$user'";
			$results1 = mysql_query($query1) or die(" ". mysql_error());
			$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
			$userName = $line1['username'];
			$avatar = $line1['avatar'];
			
			$displayDate = $line['date'];
			$displayTime = $line['time'];
			echo "<tr><td>$count</td><td align=center><img src=\"../img/$avatar\" height=60 width=60 /><br/>$userName</td><td align=center>$displayDate<br/>$displayTime</td></tr>\n";
			$count++;
		}
	}
	else {
		echo "<tr><td>Your session is expired. Please login again.</td></tr>\n";
	}
?>
</table>
</center>
</body>
</html>
