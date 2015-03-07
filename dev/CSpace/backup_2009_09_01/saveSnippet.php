<?php
	session_name('XULSession'); // Set session name
	session_start();
	require_once("connect.php");
	$pageName = "CSpace/saveSnippet.php";
	require_once("../counter.php");
?>
<html>
<head>
	<title>Snippet</title>
	<link href="css/styles.css" rel="stylesheet" type="text/css" />
</head>
<?php	
	$userID = $_GET['userID'];
	$projectID = $_GET['projectID'];
	if ($projectID == 0) {
		$query = "SELECT projects.projectID FROM projects,memberships WHERE memberships.userID='$userID' AND projects.description LIKE '%Untitled project%' AND projects.projectID=memberships.projectID";
		$results = mysql_query($query) or die(" ". mysql_error());
		$line = mysql_fetch_array($results, MYSQL_ASSOC);
		$projectID = $line['projectID'];
	}

	$title = $_GET['title'];
	$url = $_GET['URL'];
	$snippet = addslashes($_GET['snippet']);
	
	if (isset($_GET['annotation'])) {
		// Get the date, time, and timestamp
		$timestamp = time();
		$datetime = getdate();
	    $date = date('Y-m-d', $datetime[0]);
		$time = date('H:i:s', $datetime[0]);
		$annotation = addslashes($_GET['annotation']);
				
		$snippet = stripslashes($snippet);
//		echo "$snippet<br/>\n";
	//	$fout = fopen("snip.tmp", 'w');
		$query = "INSERT INTO snippets VALUES('','$url','$userID','$projectID','$timestamp','$date','$time','$snippet','$annotation')";
//		echo "$query\n";
	//	fwrite($fout, "$query\n");
	//	fclose($fout);
		echo "<body class=\"body\" onload=\"window.close();\">\n";
		echo "<center>\n";
		echo "<table class=\"style1\" width=90%>";
		$results = mysql_query($query) or die(" ". mysql_error());		
		echo "<tr><td>The snippet was saved. You can close this window now.</td></tr>";
	}
	else {
		echo "<body class=\"body\" onload=\"document.f.annotation.focus();\">\n";
		echo "<br/><center>\n";
		echo "<table class=\"style1\" width=90%>";
		echo "<tr><th>Collecting a snippet from page: <a href=\"$url\">$title</a><br/><br/></th></tr>\n";
		echo "<form name=\"f\" action=\"saveSnippet.php\" method=GET>\n";
		$snippet = stripslashes($snippet);
		$snippet = stripslashes($snippet);
//		$snippetValue = str_replace("'","\'",$snippet);
		echo "<tr bgcolor=#CCFFAA><td><textarea cols=70 rows=12 name=\"snippet\">$snippet</textarea></td></tr>\n";
		echo "<tr><td><em>Add notes to this snippet (optional)</em><br/><textarea cols=70 rows=6 name=\"annotation\"></textarea><input type=\"hidden\" name=\"userID\" value=\"$userID\"/><input type=\"hidden\" name=\"projectID\" value=\"$projectID\"/><input type=\"hidden\" name=\"URL\" value=\"$url\"/></td></tr>\n";
		echo "<tr><td align=center><input type=\"submit\" value=\"Save\" /> <input type=\"button\" value=\"Cancel\" onclick=\"window.close();\" /></td></tr>\n";
		echo "</form>\n";
	}
?>
</table>
</body>
</html>
