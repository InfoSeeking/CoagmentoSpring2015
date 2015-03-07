<?php
	session_start();
	ob_start();
	require_once("header.php");
	require_once("connect.php");
	$pageName = "CSpace/index.php";
	require_once("../counter.php");
	
	if (isset($_GET['logout'])) {
		if ($_GET['logout']=='true') {
			$userID = $_SESSION['CSpace_userID'];
			$query1 = "UPDATE users SET status=1 WHERE userID='$userID'";
			$results1 = mysql_query($query1) or die(" ". mysql_error());
			setcookie('CSpace_userID');
			setcookie('CSpace_projectID');
			session_destroy();
	?>
			<br/>
			<br/>
			<form action="index.php" method="POST">
			<table class="body">
				<tr><td colspan=2><font color="green">You have been successfully logged out of your CSpace.</font><br/><br/><br/></td></tr>
				<tr><th colspan=2>Login to your CSpace</th></tr>
				<tr><td>Username</td><td> <input type="text" size=15 name="userName" /></td></tr>
				<tr><td>Password</td><td> <input type="password" size=15 name="password" /></td></tr>
				<tr><td colspan=2><br/></td></tr>
				<tr><td align="center" colspan=2><input type="submit" value="Login" /></td></tr>	
			</table>
			</form>
			<br/>
			<br/>
	<?php
		}
	}
	else {
		// If the user tried to login	
		if (isset($_POST['userName'])) {
			$userName = $_POST['userName'];
			$password = sha1($_POST['password']);
			$query = "SELECT * FROM users WHERE username='$userName' AND password='$password'";
			$results = mysql_query($query) or die(" ". mysql_error());
			$line = mysql_fetch_array($results, MYSQL_ASSOC);
			$userID = $line['userID'];
			
			// If the login information was incorrect
			if (mysql_num_rows($results)==0) {
				echo "<br/>The login information you entered does not match our records. Please try again.\n";
	?>
			<br/>
			<br/>
			<form action="index.php" method="POST">
			<table class="body">
				<tr><th colspan=2>Login to your CSpace</th></tr>
				<tr><td>Username</td><td> <input type="text" size=15 name="userName" /></td></tr>
				<tr><td>Password</td><td> <input type="password" size=15 name="password" /></td></tr>
				<tr><td colspan=2><br/></td></tr>
				<tr><td align="center" colspan=2><input type="submit" value="Login" /></td></tr>	
			</table>
			</form>
			<br/>
			<br/>
	<?php
			} // if (mysql_num_rows($results)==0)
			
			// Login information was correct, so ask to select a project
			else {
				$query1 = "UPDATE users SET status=1 WHERE userID='$userID'";
				$results1 = mysql_query($query1) or die(" ". mysql_error());
				echo "<br/><br/><center>\n<table class=\"body\">\n";
				$query1 = "SELECT * FROM users WHERE userID='$userID'";
				$results1 = mysql_query($query1) or die(" ". mysql_error());
				$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
				$loginCount = $line1['loginCount']+1;
				
				if ($loginCount==1)
					echo "<tr><td colspan=2><font color=\"green\">First timer? Read the <a href=\"documentation.php\">documentation</a> for downloading, installing, and using Coagmento.</font></td></tr>\n";
				
				$query2 = "UPDATE users SET loginCount='$loginCount' WHERE userID='$userID'";
				$results2 = mysql_query($query2) or die(" ". mysql_error());
				
				$firstName = $line1['firstName'];
				$lastName = $line1['lastName'];
				echo "<tr bgcolor=#DDDDDD><td colspan=2>Welcome back, <strong>$firstName $lastName</strong>.";
				if (isset($_SESSION['projectID'])) {
					$projectID = $_SESSION['projectID'];
					$query = "SELECT * FROM projects WHERE projectID='$projectID'";
					$results = mysql_query($query) or die(" ". mysql_error());
					$line = mysql_fetch_array($results, MYSQL_ASSOC);
					$title = $line['title'];
					echo "<br/>Your active project: <strong>$title</strong>.</td></tr>\n";
				}
				else {
					echo " Select a project to work with.</td></tr>\n";
				}
				echo "<tr><td valign=top align=center><table class=\"body\">\n";
				echo "<tr bgcolor=#DDDDDD><td><strong>My CSpace</strong></td></tr>\n";
				echo "<tr><td><a href=\"profile.php\">My profile</a></td></tr>\n";
				echo "<tr><td><a href=\"log.php\">My log</a></td></tr>\n";
				echo "<tr><td><a href=\"report.php\">Generate report</a></td></tr>\n";
				echo "<tr><td><a href=\"index.php?logout=true\">Logout</a></td></tr>\n";
				echo "</table>\n</td>";
				echo "<td valign=top align=center><table class=\"body\">\n";
				echo "<tr bgcolor=#DDDDDD><td><strong>Collaborators & Projects</strong></td></tr>\n";
				echo "<tr><td><a href=\"collaborators.php\">Collaborators</a></td></tr>\n";
				echo "<tr><td><a href=\"projects.php\">Create a new project</a></td></tr>\n";
				echo "<tr><td>Select a project:<ul>";
				$_SESSION['userID'] = $userID;
				setcookie("CSpace_userID", $userID);
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
				echo "</table>\n</td></tr>\n";
				echo "<tr><td colspan=2><br/></td></tr>\n";
				echo "<tr><td colspan=2 align=center>[ <a href=\"http://www.coagmento.org\">Coagmento Home</a> ] [ <a href=\"documentation.php\">Documentation</a> ] [ <a href=\"updates.php\">Updates</a> ] [ <a href=\"&#109;&#97;&#105;&#108;&#116;&#111;:&#99;&#104;&#105;&#114;&#97;&#103;&#64;&#117;&#110;&#99;&#46;&#101;&#100;&#117;\">Feedback</a> ]</td></tr>\n";
				echo "</table></center>\n<br/><br/><br/><br/>\n";
	?>
	<?php			
			} // else with if ($num!=0)
		} // if (isset($_POST['userName']))
		
		// Login information was not entered
		else {
			// If the user was already logged in
			if (isset($_SESSION['userID'])) {
				$userID = $_SESSION['userID'];
				setcookie("CSpace_userID", $userID);
				$query1 = "SELECT * FROM users WHERE userID='$userID'";
				$results1 = mysql_query($query1) or die(" ". mysql_error());
				$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
				$firstName = $line1['firstName'];
				$lastName = $line1['lastName'];
				echo "<br/><br/><center>\n<table class=\"body\">\n";
				echo "<tr bgcolor=#DDDDDD><td colspan=2>Welcome back, <strong>$firstName $lastName</strong>.";
				
				// If an active project was already selected
				if (isset($_SESSION['projectID'])) {
					$projectID = $_SESSION['projectID'];
					$query = "SELECT * FROM projects WHERE projectID='$projectID'";
					$results = mysql_query($query) or die(" ". mysql_error());
					$line = mysql_fetch_array($results, MYSQL_ASSOC);
					$title = $line['title'];
					echo "<br/>Your active project: <strong>$title</strong>.</td></tr>\n";
				}
				else {
					echo " Select a project to work with.</td></tr>\n";
				}
				echo "<tr><td valign=top align=center><table class=\"body\">\n";
				echo "<tr bgcolor=#DDDDDD><td><strong>My CSpace</strong></td></tr>\n";
				echo "<tr><td><a href=\"profile.php\">My profile</a></td></tr>\n";
				echo "<tr><td><a href=\"log.php\">My log</a></td></tr>\n";
				echo "<tr><td><a href=\"report.php\">Generate report</a></td></tr>\n";
				echo "<tr><td><a href=\"index.php?logout=true\">Logout</a></td></tr>\n";
				echo "</table>\n</td>";
				echo "<td valign=top align=center><table class=\"body\">\n";
				echo "<tr bgcolor=#DDDDDD><td><strong>Projects</strong></td></tr>\n";
//				echo "<tr><td><a href=\"collaborators.php\">Collaborators</a></td></tr>\n";
				echo "<tr><td><a href=\"projects.php\">Create a new project</a></td></tr>\n";
				echo "<tr><td>Select a project:<ul>";
				$_SESSION['userID'] = $userID;
				setcookie("CSpace_userID", $userID);
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
					echo "<li><a href=\"selectProject.php?projectID=$projectID\">$title</a></li>\n";
				}
				echo "</ul></td></tr>\n";
				echo "</table>\n</td></tr>\n";
				echo "<tr><td colspan=2><br/></td></tr>\n";
				echo "<tr><td colspan=2 align=center>[ <a href=\"http://www.coagmento.org\">Coagmento Home</a> ] [ <a href=\"documentation.php\">Documentation</a> ] [ <a href=\"updates.php\">Updates</a> ] [ <a href=\"&#109;&#97;&#105;&#108;&#116;&#111;:&#99;&#104;&#105;&#114;&#97;&#103;&#64;&#117;&#110;&#99;&#46;&#101;&#100;&#117;\">Feedback</a> ]</td></tr>\n";
				echo "</table></center>\n<br/><br/><br/><br/>\n";		
			}
			// User was not logged in and no login information was sent.
			else {
	?>
			<br/>
			<br/>
			<form action="index.php" method="POST">
			<table class="body">
				<tr><th colspan=2>Login to your CSpace</th></tr>
				<tr><td>Username</td><td> <input type="text" size=15 name="userName" /></td></tr>
				<tr><td>Password</td><td> <input type="password" size=15 name="password" /></td></tr>
				<tr><td colspan=2><br/></td></tr>
				<tr><td align="center" colspan=2><input type="submit" value="Login" /></td></tr>	
			</table>
			</form>
			<br/>
			<br/>
<?php	
			}
		}
	}
	require_once("footer.php");
?>
  <!-- end #footer --></div>
<!-- end #container --></div>


</body>
</html>
