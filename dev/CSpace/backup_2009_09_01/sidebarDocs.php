<?php
	session_start();
?>
<div id="docsBox" style="height:200px;overflow:auto;">
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
		$query = "SELECT * FROM pages WHERE projectID='$projectID' AND result=1 GROUP BY url ORDER BY timestamp";
		$results = mysql_query($query) or die(" ". mysql_error());
		while ($line = mysql_fetch_array($results, MYSQL_ASSOC)) {
			$qUserID = $line['userID'];
			$query1 = "SELECT * FROM users WHERE userID='$qUserID'";
			$results1 = mysql_query($query1) or die(" ". mysql_error());
			$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
			$userName = $line1['username'];
			$color = $line1['color'];
			$title = $line['title'];
			$url = $line['url'];
			if (!$title)
				$title = $url;
			$originalTitle = $title;
			$title = substr($title, 0, 25);
			if (strlen($originalTitle)>25)
				$title = $title . '...';
			echo "<strong><font color=\"#$color\">$userName</font></strong>: <font color=blue><a href=\"$url\" target=_content>$title</a></font><br/>\n";
		}
		echo "</div>\n";
	}
	else {
		echo "You are not logged in. Visit your <a href=\"http://".$_SERVER['HTTP_HOST']."/CSpace/\" target=_content><font color=blue>CSpace</font></a> to do so.\n";
	}
?>