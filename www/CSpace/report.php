<?php
	session_start();
	ob_start();
	require_once("header1.php");
	require_once("connect.php");
	$pageName = "CSpace/report.php";
	require_once("../counter.php");
	
	if (isset($_SESSION['userID'])) {
		$userID = $_SESSION['userID'];
		$query1 = "SELECT * FROM users WHERE userID='$userID'";
		$results1 = mysql_query($query1) or die(" ". mysql_error());
		$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
		$firstName = $line1['firstName'];
		$lastName = $line1['lastName'];
?>
		<form action="report.php" method="GET">
		<table class="table" border=0>
		    <tr>
    		<td>
			<select name="projectID">
		      <option value="" selected="selected">Project:</option>
		      <?php
			  	$query = "SELECT * FROM memberships WHERE userID='$userID'";
				$results = mysql_query($query) or die(" ". mysql_error());
				while ($line = mysql_fetch_array($results, MYSQL_ASSOC)) {	
					$projectID = $line['projectID'];
					$query1 = "SELECT * FROM projects WHERE projectID='$projectID'";
					$results1 = mysql_query($query1) or die(" ". mysql_error());
					$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
					$title = $line1['title'];
					echo "<option value=\"$projectID\">$title</option>\n";
				}
		      ?>
		    </select>
		    </td>
    		<td>
			<select name="session">
		      <option value="" selected="selected">Session:</option>
		      <?php
			  	$query = "SELECT distinct date FROM pages WHERE userID='$userID' ORDER BY date desc";
				$results = mysql_query($query) or die(" ". mysql_error());
				while ($line = mysql_fetch_array($results, MYSQL_ASSOC)) {	
					$date = $line['date'];
					echo "<option value=\"$date\">$date</option>\n";
				}
		      ?>
		    </select>
		    </td>
			<td><input type="submit" value="Generate Report" /> </td>
			<td align="right">&nbsp;&nbsp;&nbsp;&nbsp;<?php // include("pagingnav.php");?></td>
    		</tr>
		</table>
		<table class="table" border=1>
<?php
	// Get the date, time, and timestamp
	$timestamp = time();
	$datetime = getdate();
	$date = date('Y-m-d', $datetime[0]);
	$time = date('H:i:s', $datetime[0]);
		
	if (isset($_SESSION['projectID']))
			$projectID = $_SESSION['projectID'];
	else
		$projectID = -1;
	$ip=$_SERVER['REMOTE_ADDR'];
	$aQuery = "INSERT INTO actions VALUES('','$userID','$projectID','$timestamp','$date','$time','report','','$ip')";
	$aResults = mysql_query($aQuery) or die(" ". mysql_error());
		
	$projectID = $_GET['projectID'];
	$session = $_GET['session'];

	if ($projectID) {
		$query1 = "SELECT * FROM projects WHERE projectID='$projectID'";
		$results1 = mysql_query($query1) or die(" ". mysql_error());
		$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
		$title = $line1['title'];
		if ($session) {
			$query = "SELECT * FROM pages WHERE projectID='$projectID' AND userID='$userID' AND date='$session' ORDER BY timestamp";
			echo "<tr><td colspan=7>Displaying <strong>documents</strong> from project <strong>$title</strong> for session <strong>$session</strong>.</td></tr>\n";
		}
		else {
			$query = "SELECT * FROM pages WHERE projectID='$projectID' AND userID='$userID' ORDER BY timestamp";
			echo "<tr><td colspan=7>Displaying <strong>documents</strong> from project <strong>$title</strong> for <strong>all</strong> the sessions.</td></tr>\n";
		}
	}
	else {
		if ($session) {
			$query = "SELECT * FROM pages WHERE date='$session' AND userID='$userID' ORDER BY timestamp";
			echo "<tr><td colspan=7>Displaying <strong>documents</strong> from <strong>all</strong> the projects for session <strong>$session</strong>.</td></tr>\n";
		}
		else {
			$query = "SELECT * FROM pages WHERE userID='$userID' ORDER BY timestamp";
			echo "<tr><td colspan=7>Displaying <strong>documents</strong> from <strong>all</strong> the projects for <strong>all</strong> the sessions.</td></tr>\n";
		}
	}
	echo "<tr><th>Participant</th><th>Project</th><th>Document</th><th>Query</th><th>Date/Time</th></tr>\n";
		
	$results = mysql_query($query) or die(" ". mysql_error());
	while ($line = mysql_fetch_array($results, MYSQL_ASSOC)) {	
		$userID = $line['userID'];
		$query1 = "SELECT * FROM users WHERE userID='$userID'";
		$results1 = mysql_query($query1) or die(" ". mysql_error());
		$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
		$userName = $line1['username'];
		$avatar = $line1['avatar'];
		$projectID = $line['projectID'];
		$query1 = "SELECT * FROM projects WHERE projectID='$projectID'";
		$results1 = mysql_query($query1) or die(" ". mysql_error());
		$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
		$title = $line1['title'];
		$url = $line['url'];
		if ($line['title'])
			$pageTitle = $line['title'];
		else
			$pageTitle = $url;
		$pageID = $line['pageID'];
		$saved = $line['result'];
		$source = $line['source'];
		$queryText = $line['query'];
		$date = $line['date'];
		$time = $line['time'];
		$subText = "";
		$query1 = "SELECT * FROM snippets WHERE url='$url' AND projectID='$projectID' AND userID='$userID'";
		$results1 = mysql_query($query1) or die(" ". mysql_error());
		if (mysql_num_rows($results1)!=0) {
			$subText = "<em>Snippets:</em><font color=\"gray\"><ul>";
			while ($line1 = mysql_fetch_array($results1, MYSQL_ASSOC)) {
				$subText = $subText . "<li>" . $line1['snippet'];
				if ($line1['note']) 
					$subText = $subText . " - <em>" . $line1['note']. "</em>";
				$subText = $subText . "</li>";
			}
			$subText = $subText . "</ul></font>";
		}
		$query1 = "SELECT note FROM annotations WHERE url='$url' AND projectID='$projectID' AND userID='$userID' ";
		$results1 = mysql_query($query1) or die(" ". mysql_error());
		if (mysql_num_rows($results1)!=0) {
			$subText = "<em>Annotations:</em><font color=\"gray\"><ul>";
			while ($line1 = mysql_fetch_array($results1, MYSQL_ASSOC)) {
				$subText = $subText . "<li>" . $line1['note'] . "</li>";
			}
			$subText = $subText . "</ul></font>";
		}
		echo "<tr><td align=center><img src=\"../img/$avatar\" height=60 width=60 /><br/>$userName</td><td>$title</td><td><a href=\"$url\">$pageTitle</a> [<a href=\"printRecord.php?userID=$userID&projectID=$projectID&pageID=$pageID\" onClick=\"return popup(this, 'Print record')\">Print this record</a>]";
		if ($saved)
			echo " <img src=\"../img/check.gif\" height=20/>";

		if ($subText)
			echo "<br/>$subText";
		echo "</td><td>$queryText</td><td>$date<br/>$time</td></tr>\n";
	}
?>
	</table>
	<br/><br/><br/><br/>
<?php
	}
	else {
		echo "<br/><br/><center>\n<table class=\"body\">\n";
		echo "<tr><td>Sorry. Looks like we had trouble knowing who you are!<br/>Please try <a href=\"index.php\">logging in</a> again.</td></tr>\n";
		echo "</table>\n</center>\n<br/><br/><br/><br/>\n";
	} 		
	require_once("footer.php");
?>

</body>
</html>

