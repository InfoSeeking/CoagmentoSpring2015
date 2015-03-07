<?php
	session_start();
	require_once("connect.php");
	require_once("header1.php");
	$pageName = "CSpace/profile.php";
	require_once("../counter.php");
?>

<?php
	if (isset($_SESSION['userID'])) {
		$userID = $_SESSION['userID'];

		if (isset($_POST['update'])) {
			$userName = $_POST['username'];
			$pass = $_POST['password'];
			$cpass = $_POST['cpassword'];
			$password = sha1($_POST['password']);
			$fname = $_POST['fname'];
			$lname = $_POST['lname'];
			$organization = $_POST['organization'];
			$email = $_POST['email'];
			$website = $_POST['website'];
			if ($pass != $cpass) {
				echo "<br/><br/><font color=\"red\">Password and confirm password didn't match. Please try again.</font>\n";
			}
			else {
				if ($pass)
					$query = "UPDATE users SET password='$password', firstName='$fname',lastName='$lname',organization='$organization',email='$email',website='$website' WHERE username='$userName'";
				else
					$query = "UPDATE users SET firstName='$fname',lastName='$lname',organization='$organization',email='$email',website='$website' WHERE username='$userName'";
				$result = mysql_query($query) or die(" ". mysql_error());
			}
		}
		
		if (isset($_FILES['uploaded']['name'])) {
			$target = "../img/";
			$fileName = $userID . '_'. basename($_FILES['uploaded']['name']);
			$target = $target . $fileName;
			$ok=1;
			if(move_uploaded_file($_FILES['uploaded']['tmp_name'], $target)) {
				echo "Your profile photo ". basename( $_FILES['uploadedfile']['name']). " has been updated.";
				$query1 = "UPDATE users SET avatar='$fileName' WHERE userID='$userID'";
				$results1 = mysql_query($query1) or die(" ". mysql_error());
			}
			else {
				echo "<br/><br/><font color=\"red\">Sorry, there was a problem uploading your file. Please try again.</font>\n";
			}
		}

		$query1 = "SELECT * FROM users WHERE userID='$userID'";
		$results1 = mysql_query($query1) or die(" ". mysql_error());
		$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
		$userName = $line1['username'];
		$firstName = $line1['firstName'];
		$lastName = $line1['lastName'];
		$email = $line1['email'];
		$website = $line1['website'];
		$organization = $line1['organization'];
		$avatar = $line1['avatar'];
		
		echo "<br/><br/>\n<table><tr><td>";
		echo "<form action=\"profile.php\" method=\"POST\">\n";
		echo "<table class=\"table\">\n";
	    echo "<tr><td>Username</td><td>$userName<input type=\"hidden\" name=\"username\" value=\"$userName\"/></td></tr>\n";
        echo "<tr><td>Password*</td><td><input name=\"password\" type=\"password\" size=30 /></td></tr>\n";
        echo "<tr><td>Confirm Password*</td><td><input name=\"cpassword\" type=\"password\" size=30 /></td></tr>\n";
        echo "<tr><td>First Name</td><td><input type=\"text\" name=\"fname\" size=30 value=\"$firstName\"/></td></tr>\n";
        echo "<tr><td>Last Name</td><td><input type=\"text\" name=\"lname\"  size=30 value=\"$lastName\"/></td></tr>\n";
        echo "<tr><td>Organization</td><td><input type=\"text\" name=\"organization\" size=30 value=\"$organization\"/></td></tr>\n";
        echo "<tr><td>Email</td><td><input type=\"text\" size=30 name=\"email\" value=\"$email\"/></td></tr>\n";
        echo "<tr><td>Website</td><td><input type=\"text\" size=30 name=\"website\" value=\"$website\"/></td></tr>\n";
        echo "<tr><td colspan=2>*Only if you want to change your existing password.</td></tr>\n";
        echo "<tr><td colspan=2 align=\"center\"><input type=\"submit\" value=\"Update\" />";
        echo "<input type=\"hidden\" name=\"update\" value=\"true\"/></td></tr>\n";	
        echo "</form>\n</table>\n";
        echo "</td><td valign=top><form action=\"profile.php\" enctype=\"multipart/form-data\" method=\"POST\"><table>";
        echo "<tr><td><img src=\"../img/$avatar\" height=100 width=100><br/><br/>Upload a new picture: <input name=\"uploaded\" type=\"file\"/></td></tr>\n";
        echo "<tr><td align=center><input type=\"submit\" value=\"Upload\"/></form></td></tr>\n";
        echo "</table></form></td></tr></table>\n<br/><br/><br/><br/>\n";
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
