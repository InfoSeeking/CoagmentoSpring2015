<?php
	session_start();
	ob_start();
	require_once("header.php");
	require_once("connect.php");
	$pageName = "CSpace/projects.php";
	require_once("../counter.php");
		
	if (isset($_SESSION['userID'])) {
		$userID = $_SESSION['userID'];
		$query1 = "SELECT * FROM users WHERE userID='$userID'";
		$results1 = mysql_query($query1) or die(" ". mysql_error());
		$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
		$firstName = $line1['firstName'];
		$lastName = $line1['lastName'];
		echo "<br/><br/><center>\n<table class=\"body\">\n";
		echo "<tr bgcolor=#CCFFAA><td colspan=2>Hello, <strong>$firstName $lastName</strong>.";
		
		// If new project information was sent
		if (isset($_GET['title'])) {
			$title = addslashes($_GET['title']);
			$query = "SELECT * FROM projects,memberships WHERE projects.title='$title' AND memberships.userID='$userID'";
			$results = mysql_query($query) or die(" ". mysql_error());
			$num = mysql_num_rows($results);
			if ($num!=0) {
				echo "<tr><td colspan=2><font color=\"red\">Project <strong>$title</strong> already exists. Please choose a different title for your project.</font></td></tr>";
			}
			else {
				$description = addslashes($_GET['description']);
				// Get the date, time, and timestamp
				$timestamp = time();
				$datetime = getdate();
			    $startDate = date('Y-m-d', $datetime[0]);
				$startTime = date('H:i:s', $datetime[0]);
				$query = "INSERT INTO projects VALUES('','$title','$description','$startDate','$startTime','','')";
				$results = mysql_query($query) or die(" ". mysql_error());
				$query = "SELECT max(projectID) as num FROM projects";
				$results = mysql_query($query) or die(" ". mysql_error());
				$line = mysql_fetch_array($results, MYSQL_ASSOC);
				$projectID = $line['num'];
				$query = "INSERT INTO memberships VALUES('','$projectID','$userID')";
				$results = mysql_query($query) or die(" ". mysql_error());
				echo "<tr><td colspan=2><font color=\"green\">Your new project <strong>$title</strong> has been created.</font></td></tr>";
			}
		}
		echo "<tr><td valign=top><form action=\"projects.php\" method=GET>";
		echo "<table class=\"table\"><tr><td colspan=2>You can create a new project:</td></tr>";
		echo "<tr><td>Title</td><td><input name=\"title\" type=\"text\" size=32\></td></tr>\n";
		echo "<tr><td>Description</td><td><textarea name=\"description\" cols=28 rows=4></textarea></td></tr>\n";
		echo "<tr><td colspan=2 align=center><input type=submit value=\"Create\"/></td></tr>\n";
		echo "</table>\n</form></td><td valign=top>";
		echo "<table class=\"table\"><tr><td>Or select from an existing project:</td></tr>";
		echo "<tr><td><ul>";
		$query = "SELECT projectID FROM memberships WHERE userID='$userID'";
		$results = mysql_query($query) or die(" ". mysql_error());
		while ($line = mysql_fetch_array($results, MYSQL_ASSOC)) {
			$projectID = $line['projectID'];
			$query1 = "SELECT * FROM projects WHERE projectID='$projectID'";
			$results1 = mysql_query($query1) or die(" ". mysql_error());
			$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
			$projectID = $line1['projectID'];
			$title = $line1['title'];
			$description = $line['description'];
			echo "<li><a href=\"selectProject.php?projectID=$projectID\">$title</a></li>";
		}
		echo "</ul></td></tr>\n";
		echo "</table></td></tr>\n";
		echo "</table>\n</center>\n<br/><br/><br/><br/>\n";
	}
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
