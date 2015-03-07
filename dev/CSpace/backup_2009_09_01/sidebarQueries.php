<?php
	session_start();
?>
<div id="queriesBox" style="height:200px;overflow:auto;">
<?php
	require_once("connect.php");
	if ((isset($_SESSION['userID']))) {
		$userID = $_SESSION['userID'];
		if (isset($_SESSION['projectID']))
			$projectID = $_SESSION['projectID'];
		else {
			$query = "SELECT projects.projectID FROM projects,memberships WHERE memberships.userID='$userID' AND projects.description LIKE '%Untitled project%' AND projects.projectID=memberships.projectID";
			$results = mysql_query($query) or die(" ". mysql_error());
			$line = mysql_fetch_array($results, MYSQL_ASSOC);
			$projectID = $line['projectID'];
		}
		$query = "SELECT * FROM queries WHERE projectID='$projectID' ORDER BY timestamp";
		$results = mysql_query($query) or die(" ". mysql_error());
		while ($line = mysql_fetch_array($results, MYSQL_ASSOC)) {
			$qUserID = $line['userID'];
			$query1 = "SELECT * FROM users WHERE userID='$qUserID'";
			$results1 = mysql_query($query1) or die(" ". mysql_error());
			$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
			$userName = $line1['username'];
			$color = $line1['color'];
			$source = $line['source'];
			$queryText = $line['query'];
			$url = $line['url'];
			echo "<strong><font color=\"#$color\">$userName</font></strong>: <font color=blue><a href=\"$url\" target=_content>$queryText</a></font> (<font color=green>$source</font>)<br/>\n";
		}
		echo "</div>\n";
	}
	else {
		echo "You are not logged in. Visit your <a href=\"http://".$_SERVER['HTTP_HOST']."/CSpace/\" target=_content><font color=blue>CSpace</font></a> to do so.\n";
	}
?>