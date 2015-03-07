<?php
	session_name('XULSession'); // Set session name
	session_start();
	require_once("connect.php");
	$pageName = "CSpace/annotations.php";
	require_once("../counter.php");?>
<html>
<head>
	<title>Annotations</title>
	<link href="css/styles.css" rel="stylesheet" type="text/css" />
</head>
<body class="body" onload="document.f.note.focus();">
<center>
<form name="f" action="annotations.php" method="get">
<?php		
	$url = $_GET['page'];
	$title = $_GET['title'];
	echo "<tr><th>Annotations for page: <a href=\"$url\">$title</a><br/><br/></th></tr>\n";
	echo "<table border=1 cellspacing=2 cellpadding=2 class=\"style1\">\n";
	$userID = $_GET['userID'];
	if (isset($_GET['userID']) && ($userID>0)) {
		$userID = $_GET['userID'];
		$projectID = $_GET['projectID'];

		// If this was the default (Untitled) project
		if ($projectID == 0) {
			$query = "SELECT projects.projectID FROM projects,memberships WHERE memberships.userID='$userID' AND projects.description LIKE '%Untitled project%' AND projects.projectID=memberships.projectID";
			$results = mysql_query($query) or die(" ". mysql_error());
			$line = mysql_fetch_array($results, MYSQL_ASSOC);
			$projectID = $line['projectID'];
		} // if ($projectID == 0)	

		// Get the date, time, and timestamp
		$timestamp = time();
		$datetime = getdate();
		$date = date('Y-m-d', $datetime[0]);
		$time = date('H:i:s', $datetime[0]);
	
		// If the annotation was submitted, get it and save it.
		if (isset($_GET['note'])) {
			$note = $_GET['note'];
			$query = "INSERT INTO annotations VALUES('','$url','$userID','$projectID','$timestamp','$date','$time','$note')";
			$results = mysql_query($query) or die(" ". mysql_error());
		}
		
		// Get the results for the given user and the project
		$query = "SELECT * FROM annotations WHERE projectID='$projectID' AND url='$url' ORDER BY timestamp";
		$results = mysql_query($query) or die(" ". mysql_error());
	//	$responseText = "";
		while ($line = mysql_fetch_array($results, MYSQL_ASSOC)) {
			$userID = $line['userID'];
			$query1 = "SELECT * FROM users WHERE userID='$userID'";
			$results1 = mysql_query($query1) or die(" ". mysql_error());
			$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
			$userName = $line1['username'];
			$avatar = $line1['avatar'];
			$note = $line['note'];
			$displayDate = $line['date'];
			$displayTime = $line['time'];
			echo "<tr><td align=center><img src=\"../img/$avatar\" height=60 width=60 /><br/>$userName</td><td align=center>$displayDate<br/>$displayTime</td><td>$note</td></tr>\n";
	//		$responseText = $responseText . $user . ": " . $note . "\n";
		} // while ($line = mysql_fetch_array($results, MYSQL_ASSOC))
	//	echo "<textarea cols=46 rows=12 disabled>$responseText</textarea><br/>\n";
	echo "<input type=\"hidden\" name=\"userID\" value=\"$userID\" />\n";
	echo "<input type=\"hidden\" name=\"projectID\" value=\"$projectID\" />\n";
	echo "<input type=\"hidden\" name=\"page\" value=\"$url\" />\n";
?>
</table>
<br/>
<textarea cols=70 rows=6 name="note"></textarea><br/>
<input type="submit" value="Save" />
</form>
<?php
	}
	else {
		echo "<tr><td>You are not logged in. Visit your CSpace to do so.</td></tr>\n</table>\n";
	}
?>
</center>
</body>
</html>
