<?php
	ob_start();
	require_once("header.php");
	require_once("connect.php");
?>
<table class="table" border=0>
<tr><td><a href="CSpaceData.php?display=pages">Pages</a></td><td><a href="CSpaceData.php?display=queries">Queries</a></td><td><a href="CSpaceData.php?display=snippets">Snippets</a></td><td><a href="CSpaceData.php?display=annotations">Annotations</a></td></tr>
</table>
<table class="table" border=1>
<?php	
	$display = $_GET['display'];
	if (!$display)
		$display = 'pages';
	switch ($display) {
		case 'pages':
			echo "<tr><td>User</td><td>Project</td><td>Page</td><td>Source</td><td>Query</td><td>Date</td><td>Time</td></tr>\n";

			$query = "SELECT * FROM pages ORDER BY timestamp";
			$results = mysql_query($query) or die(" ". mysql_error());
			while ($line = mysql_fetch_array($results, MYSQL_ASSOC)) {	
				$userID = $line['userID'];
				$query1 = "SELECT * FROM users WHERE userID='$userID'";
				$results1 = mysql_query($query1) or die(" ". mysql_error());
				$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
				$userName = $line1['userName'];
				$projectID = $line['projectID'];
				$url = $line['url'];
				$source = $line['source'];
				$queryText = $line['query'];
				$date = $line['date'];
				$time = $line['time'];
				echo "<tr><td>$userName</td><td>$projectID</td><td><a href=\"$url\">$url</a></td><td>$source</td><td>$queryText</td><td>$date</td><td>$time</td></tr>\n";
			}
			break;
		case 'queries':
			echo "<tr><td>User</td><td>Project</td><td>Source</td><td>Query</td><td>Date</td><td>Time</td></tr>\n";

			$query = "SELECT * FROM queries ORDER BY timestamp";
			$results = mysql_query($query) or die(" ". mysql_error());
			while ($line = mysql_fetch_array($results, MYSQL_ASSOC)) {	
				$userID = $line['userID'];
				$query1 = "SELECT * FROM users WHERE userID='$userID'";
				$results1 = mysql_query($query1) or die(" ". mysql_error());
				$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
				$userName = $line1['userName'];
				$projectID = $line['projectID'];
				$source = $line['source'];
				$queryText = $line['query'];
				$url = $line['url'];
				$date = $line['date'];
				$time = $line['time'];
				echo "<tr><td>$userName</td><td>$projectID</td><td>$source</td><td><a href=\"$url\">$queryText</a></td><td>$date</td><td>$time</td></tr>\n";
			}
			break;
		case 'snippets':
			echo "<tr><td>User</td><td>Project</td><td>Page</td><td>Snippet</td><td>Date</td><td>Time</td></tr>\n";

			$query = "SELECT * FROM snippets ORDER BY timestamp";
			$results = mysql_query($query) or die(" ". mysql_error());
			while ($line = mysql_fetch_array($results, MYSQL_ASSOC)) {	
				$userID = $line['userID'];
				$query1 = "SELECT * FROM users WHERE userID='$userID'";
				$results1 = mysql_query($query1) or die(" ". mysql_error());
				$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
				$userName = $line1['userName'];
				$projectID = $line['projectID'];
				$url = $line['url'];
				$snippet = stripslashes($line['snippet']);
				$date = $line['date'];
				$time = $line['time'];
				echo "<tr><td>$userName</td><td>$projectID</td><td><a href=\"$url\">$url</a></td><td>$snippet</td><td>$date</td><td>$time</td></tr>\n";
			}		
			break;
		case 'annotations':
			echo "<tr><td>User</td><td>Project</td><td>Page</td><td>Snippet</td><td>Date</td><td>Time</td></tr>\n";

			$query = "SELECT * FROM annotations ORDER BY timestamp";
			$results = mysql_query($query) or die(" ". mysql_error());
			while ($line = mysql_fetch_array($results, MYSQL_ASSOC)) {	
				$userID = $line['userID'];
				$query1 = "SELECT * FROM users WHERE userID='$userID'";
				$results1 = mysql_query($query1) or die(" ". mysql_error());
				$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
				$userName = $line1['userName'];
				$projectID = $line['projectID'];
				$url = $line['url'];
				$note = stripslashes($line['note']);
				$date = $line['date'];
				$time = $line['time'];
				echo "<tr><td>$userName</td><td>$projectID</td><td><a href=\"$url\">$url</a></td><td>$note</td><td>$date</td><td>$time</td></tr>\n";
			}				
			break;
	}
?>
</table>
<br/>
<?php
	require_once("footer.php");
?>