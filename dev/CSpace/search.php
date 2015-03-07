<?php
	session_start();
	ob_start();
	require_once("header1.php");
	require_once("connect.php");
	$pageName = "CSpace/search.php";
	require_once("../counter.php");
	
	if (isset($_SESSION['userID'])) {
		$userID = $_SESSION['userID'];
		$query1 = "SELECT * FROM users WHERE userID='$userID'";
		$results1 = mysql_query($query1) or die(" ". mysql_error());
		$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
		$firstName = $line1['firstName'];
		$lastName = $line1['lastName'];
		$searchString = $_GET['searchString'];

		// Get the date, time, and timestamp
		$timestamp = time();
		$datetime = getdate();
		$date = date('Y-m-d', $datetime[0]);
		$time = date('H:i:s', $datetime[0]);
			
		// If a project isn't set, assume it's Untitled
		if (isset($_SESSION['projectID']))
			$projectID = $_SESSION['projectID'];
		else {	
			$query = "SELECT projects.projectID FROM projects,memberships WHERE memberships.userID='$userID' AND projects.title='Untitled' AND memberships.projectID=projects.projectID";
			$results = mysql_query($query) or die(" ". mysql_error());
			$line = mysql_fetch_array($results, MYSQL_ASSOC);
			$projectID = $line['projectID'];
		}
		$ip=$_SERVER['REMOTE_ADDR'];
		$aQuery = "INSERT INTO actions VALUES('','$userID','$projectID','$timestamp','$date','$time','search','$searchString','$ip')";
		$aResults = mysql_query($aQuery) or die(" ". mysql_error());
?>
	<form action="search.php" method=get>
	<table class="table">
		<tr><td><input type="text" size=55 name="searchString" value="<?php echo $searchString;?>" /> <input type="submit" value="Search" /></td></tr>
	</table>
	</form>
	<br/>
	<table class="table">
		<tr><th colspan=5>Saved webpages matching "<em><?php echo $searchString; ?></em>"</th></tr>
		
	<?php
		$query = "SELECT * from pages where title like '%$searchString%' AND result=1 and userID='$userID'";
		$results = mysql_query($query) or die(" ". mysql_error());
		while ($line = mysql_fetch_array($results, MYSQL_ASSOC)) {
			$userID = $line['userID'];
			$url = $line['url'];
			$snippet = stripslashes($line['snippet']);
			$title = stripslashes($line['title']);
			$query1 = "SELECT * FROM users WHERE userID='$userID'";
			$results1 = mysql_query($query1) or die(" ". mysql_error());
			$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
			$userName = $line1['username'];
			$avatar = $line1['avatar'];
			
			$displayDate = $line['date'];
			$displayTime = $line['time'];
			
			echo "<tr><td align=center><img src=\"../img/$avatar\" height=60 width=60 /><br/>$userName</td><td>&nbsp;&nbsp;</td><td><a href=\"$url\">$title</a></td><td>&nbsp;&nbsp;</td><td>Saved on: $displayDate, $displayTime</td></tr>\n";
		}
	?>
	</table>
	<br/>
	<br/>
	<table class="table">
		<tr><th colspan=5>Snippets matching "<em><?php echo $searchString; ?></em>"</th></tr>
		
	<?php
		$query = "SELECT * from snippets where match(snippet) against('$searchString') and userID='$userID'";
		$results = mysql_query($query) or die(" ". mysql_error());
		while ($line = mysql_fetch_array($results, MYSQL_ASSOC)) {
			$userID = $line['userID'];
			$url = $line['url'];
			$snippet = stripslashes($line['snippet']);
			$note = stripslashes($line['note']);
			$query1 = "SELECT title FROM pages WHERE url='$url'";
			$results1 = mysql_query($query1) or die(" ". mysql_error());
			$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
			$title = stripslashes($line1['title']);
			$query1 = "SELECT * FROM users WHERE userID='$userID'";
			$results1 = mysql_query($query1) or die(" ". mysql_error());
			$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
			$userName = $line1['username'];
			$avatar = $line1['avatar'];
			
			$displayDate = $line['date'];
			$displayTime = $line['time'];
			
			echo "<tr><td align=center><img src=\"../img/$avatar\" height=60 width=60 /><br/>$userName</td><td>&nbsp;&nbsp;</td><td><a href=\"$url\">$title</a><br/><em>$snippet</em><br/><font color=\"gray\">$note</font></td><td>&nbsp;&nbsp;</td><td>Saved on: $displayDate, $displayTime</td></tr>\n";
		}
	?>
	</table>
	<br/>
	<br/>
	<table class="table">
		<tr><th colspan=5>Annotations matching "<em><?php echo $searchString; ?></em>"</th></tr>
		
	<?php
		$query = "SELECT * from annotations where match(note) against('$searchString') and userID='$userID'";
		$results = mysql_query($query) or die(" ". mysql_error());
		while ($line = mysql_fetch_array($results, MYSQL_ASSOC)) {
			$userID = $line['userID'];
			$url = $line['url'];
			$note = stripslashes($line['note']);
			$query1 = "SELECT title FROM pages WHERE url='$url'";
			$results1 = mysql_query($query1) or die(" ". mysql_error());
			$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
			$title = stripslashes($line1['title']);
			$query1 = "SELECT * FROM users WHERE userID='$userID'";
			$results1 = mysql_query($query1) or die(" ". mysql_error());
			$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
			$userName = $line1['username'];
			$avatar = $line1['avatar'];
			
			$displayDate = $line['date'];
			$displayTime = $line['time'];
			
			echo "<tr><td align=center><img src=\"../img/$avatar\" height=60 width=60 /><br/>$userName</td><td>&nbsp;&nbsp;</td><td><a href=\"$url\">$title</a><br/><em>$note</em></td><td>&nbsp;&nbsp;</td><td>Saved on: $displayDate, $displayTime</td></tr>\n";
		}
	?>
	</table>
	<br/>
	<br/>	
<?php
	} // if (isset($_SESSION['userID']))
	else {
		echo "<br/><br/><center>\n<table class=\"body\">\n";
		echo "<tr><td>Sorry. Looks like we had trouble knowing who you are!<br/>Please try <a href=\"index.php\">logging in</a> again.</td></tr>\n";
		echo "</table>\n</center>\n<br/><br/><br/><br/>\n";
	} 		
	require_once("footer.php");
?>
  <!-- end #footer --></div>
<!-- end #container --></div>


</body>
</html>