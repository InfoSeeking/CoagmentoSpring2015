<?php
	session_start();
	ob_start();
	require_once("header.php");
	require_once("connect.php");
	$pageName = "CSpace/collaborators.php";
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
		if (isset($_GET['targetUserID'])) {
			$targetUserID = $_GET['targetUserID'];
			$projectID = $_GET['projectID'];
			$query1 = "SELECT * FROM users WHERE userID='$targetUserID'";
			$results1 = mysql_query($query1) or die(" ". mysql_error());
			$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
			$targetUserName = $line1['username'];
			$targetFirstName = $line1['firstName'];
			$targetLastName = $line1['lastName'];
			$targetEmail = $line1['email'];
			$query1 = "SELECT * FROM projects WHERE projectID='$projectID'";
			$results1 = mysql_query($query1) or die(" ". mysql_error());
			$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
			$title = $line1['title'];
			$query = "INSERT INTO memberships VALUES('','$projectID','$targetUserID')";
			$results = mysql_query($query) or die(" ". mysql_error());
			
			// Create an email
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: Coagmento <noreply@Coagmento.org>' . "\r\n";
	
			$subject = 'You have been added as a collaborator';
			$message = "Hello, $targetFirstName $targetLastName,<br/><br/>This is to inform you that <strong>$firstName $lastName</strong> has just added you to their project <strong>$title</strong> as a collaborator.<br/><br/>Do not reply to this email. Visit your <a href=\"http://".$_SERVER['HTTP_HOST']."/CSpace\">CSpace</a> to access your projects. Your username is <strong>$targetUserName</strong>.<br/><br/><strong>The Coagmento Team</strong><br/><font color=\"gray\">'cause two (or more) heads are better than one!</font><br/><a href=\"http://www.coagmento.org\">www.Coagmento.org</a><br/>\n";
			mail ($targetEmail, $subject, $message, $headers);
			
			echo "<tr><td colspan=2><font color=\"green\"><strong>$targetFirstName $targetLastName</strong> has been added as a collaborator for project <strong>$title</strong>.<br/>An email has been sent to him/her informing about this new collaboration.</font></td></tr>";
		}
		echo "<tr><td valign=top><form action=\"inviteCollaborator.php\" method=GET>";
		echo "<table class=\"table\"><tr><td colspan=2>Invite a user to collaborate:</td></tr>";
		echo "<tr><td>Username</td><td><input name=\"username\" type=\"text\" size=15\></td></tr>\n";
		echo "<tr><td>Project</td><td>\n<select name=\"project\">\n";
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
			echo "<option value=\"$projectID\">$title</option>\n";
		}
		echo "</select>\n</td></tr>\n";
		echo "<tr><td colspan=2 align=center><input type=submit value=\"Invite\"/></td></tr>\n";
		echo "</table>\n</form></td><td valign=top>";
		echo "<table class=\"table\"><tr><td>Your current collaborators:</td></tr>";
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
			$query1 = "SELECT * FROM memberships WHERE projectID='$projectID'";
			$results1 = mysql_query($query1) or die(" ". mysql_error());
			$collabList = "";
			while($line1 = mysql_fetch_array($results1, MYSQL_ASSOC)) {
				$collabID = $line1['userID'];
				$query2 = "SELECT * FROM users WHERE userID='$collabID'";
				$results2 = mysql_query($query2) or die(" ". mysql_error());
				$line2 = mysql_fetch_array($results2, MYSQL_ASSOC);
				$collabList = $collabList . '<font color="#' . $line2['color'] . '">'. $line2['username'] . "</font> ";
			}
			echo "<li><a href=\"selectProject.php?projectID=$projectID\">$title</a>: $collabList</li>";
		} 
		echo "</ul></td></tr>\n";
		echo "</table></td></tr>\n";
		echo "</table>\n</center>\n<br/><br/><br/><br/>\n";
	} // if (isset($_GET['title']))
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
