<?php
	session_start();
	ob_start();
	require_once("header.php");
	require_once("connect.php");
	$pageName = "CSpace/inviteCollaborator.php";
	require_once("../counter.php");
		
	if (isset($_SESSION['userID'])) {
		$userID = $_SESSION['userID'];
		echo "<br/><br/><center>\n<table class=\"body\">\n";
		if (isset($_GET['username'])) {
			$userName = $_GET['username'];
			$projectID = $_GET['project'];
			$query1 = "SELECT * FROM projects WHERE projectID='$projectID'";
			$results1 = mysql_query($query1) or die(" ". mysql_error());
			$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
			$title = $line1['title'];
			$query = "SELECT * FROM users WHERE username='$userName'";
			$results = mysql_query($query) or die(" ". mysql_error());
			if (mysql_num_rows($results)==0) {
				echo "<tr><td>This user does not exist in our system. Please <a href=\"collaborators.php\">try again</a>.</td></tr>\n";
			} // if (mysql_num_rows($results)==0)
			else {
				$line = mysql_fetch_array($results, MYSQL_ASSOC);
				$targetUserID = $line['userID'];
//				if ($userID == $targetUserID)
//					echo "<tr><td>You can't invite yourself to a collaboration. C'mon, that's given!<br/><a href=\"collaborators.php\">Try again</a> with a different user.</td></tr>\n";
//				else {
					$firstName = $line['firstName'];
					$lastName = $line['lastName'];
					echo "<tr><td><form action=\"collaborators.php\" method=GET></td></tr>\n";
					echo "<tr><td>Are you sure you want to invite <strong>$firstName $lastName</strong> to collaborate on <strong>$title</strong> project?<br/><br/></td></tr>\n";
					echo "<tr><td align=center><input type=\"submit\" value=\"Invite\"/>&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"collaborators.php\">Cancel</a></td></tr>\n";
					echo "<tr><td><input type=\"hidden\" name=\"targetUserID\" value=$targetUserID/><input type=\"hidden\" name=\"projectID\" value=$projectID/></form></td></tr>\n";
//				}
			}
		} // if (isset($_GET['username']))
		else {
			echo "<tr><td>Did you forget to provide a name for a collaborator or did we just mess up?!</td></tr>\n";
			echo "<tr><td>Please <a href=\"collaborators.php\">try again</a>.</td></tr>\n";
		}
		echo "</table>\n</center>\n<br/><br/><br/><br/>\n";
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
