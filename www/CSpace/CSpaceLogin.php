<?php
	ob_start();
	require_once("header.php");
	require_once("connect.php");
	
	if (isset($_GET['userName'])) {
		$userName = $_GET['userName'];
		$groupID = $_GET['groupID'];
		$avatar = $_GET['avatar'];
		$query = "SELECT count(*) as num FROM users WHERE userName='$userName'";
		$results = mysql_query($query) or die(" ". mysql_error());
		$line = mysql_fetch_array($results, MYSQL_ASSOC);
		$num = $line['num'];
		
		if ($num!=0) {
			echo "<br/>Sorry. This user name is already taken. Please try again.\n";
/*
	if (isset($_POST['userName']) || isset($_POST['password'])) {
		$userName = $_POST['userName'];
		$password = sha1($_POST['password']);

		$query = "SELECT * FROM users WHERE userName='$userName' AND password='$password'";
		$results = mysql_query($query) or die(" ". mysql_error());
		$numOfResults = mysql_num_rows($results);
		if ($numOfResults == 1) {
			$line = mysql_fetch_array($results, MYSQL_ASSOC);
			$userID = $line['userID'];
			echo "<br/><br/>You are successfully logged in.<br/>Click <a href=\"CSpaceWeb.html\">here</a> to login to your CSpace Browser.<br/><br/>";
			setcookie("CSpace_login", $userID);
		}
		else {
			echo "<br/><br/>Incorrect username/password.<br/><br/>";
		}		
	}
	else {
*/
?>
		<br/>
		<br/>
		<form action="CSpaceLogin.php" method="GET">
		<table class="body">
			<tr><td>Select your name</td><td> <input type="text" size=15 name="userName" /></td></tr>
			<tr><td>Select your group</td><td> <input type="text" size=15 name="groupID" /></td></tr>
			<tr><td colspan=2 align=center><br/>Select your avatar<br/></td></tr>
			<tr><td align=center><input type="radio" name="avatar" value="male1" /><img src="../img/male1.gif" height=60 width=65 /></td><td align=center><input type="radio" name="avatar" value="female1" /><img src="../img/female1.gif" height=60 width=65 /></td></tr>
			<tr><td align=center><input type="radio" name="avatar" value="male2" /><img src="../img/male2.gif" height=60 width=65 /></td><td align=center><input type="radio" name="avatar" value="female2" /><img src="../img/female2.gif" height=60 width=65 /></td></tr>
		<!--	<tr><td>Password</td><td><input type="password" size=15 name="password" /></td></tr> -->
			<tr><td colspan=2><br/></td></tr>
			<tr><td align="center" colspan=2><input type="submit" value="Login" /></td></tr>	
		</table>
		</form>
		<br/>
		<br/>
<?php
			}
		else {
			$query = "INSERT INTO users VALUES('','$userName','$groupID','$avatar')";
			$results = mysql_query($query) or die(" ". mysql_error());
			$query = "SELECT userID FROM users WHERE userName='$userName'";
			$results = mysql_query($query) or die(" ". mysql_error());
			$line = mysql_fetch_array($results, MYSQL_ASSOC);
			$userID = $line['userID'];
			echo "<br/><br/><table class=\"body\">\n<tr><td><img src=\"../img/$avatar.gif\" heigh=60 width=65 /></td><td>Welcome, <strong>$userName</strong>.<br/> You are ready to start using your <em>Coagmento</em> toolbar.</td></tr>\n</table>\n<br/><br/>";
			setcookie("CSpace_login", $userID);
			setcookie("CSpace_avatar", $avatar);
			setcookie("CSpace_groupID", $groupID);
		}
	}
	else {
?>
		<br/>
		<br/>
		<form action="CSpaceLogin.php" method="GET">
		<table class="body">
			<tr><td>Select your name</td><td> <input type="text" size=15 name="userName" /></td></tr>
			<tr><td>Select your group</td><td> <input type="text" size=15 name="groupID" /></td></tr>
			<tr><td colspan=2 align=center><br/>Select your avatar<br/></td></tr>
			<tr><td align=center><input type="radio" name="avatar" value="male1" /><img src="../img/male1.gif" height=60 width=65 /></td><td align=center><input type="radio" name="avatar" value="female1" /><img src="../img/female1.gif" height=60 width=65 /></td></tr>
			<tr><td align=center><input type="radio" name="avatar" value="male2" /><img src="../img/male2.gif" height=60 width=65 /></td><td align=center><input type="radio" name="avatar" value="female2" /><img src="../img/female2.gif" height=60 width=65 /></td></tr>
		<!--	<tr><td>Password</td><td><input type="password" size=15 name="password" /></td></tr> -->
			<tr><td colspan=2><br/></td></tr>
			<tr><td align="center" colspan=2><input type="submit" value="Login" /></td></tr>	
		</table>
		</form>
		<br/>
		<br/>
<?php	
	}
	require_once("footer.php");
?>