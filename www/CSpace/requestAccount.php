<?php
	require_once("header.php");
	require_once("connect.php");
	$pageName = "CSpace/requestAccount.php";
	require_once("../counter.php");
		
	if (isset($_POST['email'])) {
		if (!($_POST['email']) || !($_POST['firstName']) || !($_POST['lastName']) || !($_POST['username'])) {
			echo "<br/><br/><font color=red>Oops.. you forgot to enter something! Please try again.</font>\n";
		}
		else {
			$firstName = $_POST['firstName'];
			$lastName = $_POST['lastName'];
			$email = $_POST['email'];
			$userName = $_POST['username'];
			$passwordPlain = $userName . "123";
			$password = sha1($passwordPlain);
			$datetime = getdate();
    		$date = date('Y-m-d', $datetime[0]);
	
			$query = "SELECT * FROM colors WHERE used=0";
			$results = mysql_query($query) or die(" ". mysql_error());
			$line = mysql_fetch_array($results, MYSQL_ASSOC);
			$color = $line['color'];
			$colorID = $line['colorID'];
			$query = "INSERT INTO users VALUES('','$userName','$password','$firstName','$lastName','','$email','','','1','$date','0','male1.gif','$color','0')";
			$results = mysql_query($query) or die(" ". mysql_error());
			$query = "UPDATE colors SET used=1 WHERE colorID='$colorID'";
			$results = mysql_query($query) or die(" ". mysql_error());
			
			// Create an email
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: Coagmento <support@coagmento.org>' . "\r\n";
	
			$subject = 'Coagmento account request';
			$message = "$firstName $lastName<br/>$userName<br/>$email<br/>\n";
			mail ('chirags@rutgers.edu', $subject, $message, $headers);
		
			echo "<br/><br/><font color=green>Thank you. A team of highly trained monkeys has been dispatched to work on your request!<br/>You will soon receive an email with your account information. Return to <a href=\"http://www.coagmento.org\">Coagmento Home</a>.</font>\n";
		}
	}
?>
	<br/><br/>
	<form action="requestAccount.php" method=post>
	<table class="table" border=0>
		<tr><th colspan=2>Request a <em>Coagmento</em> account</th></tr>
		<tr><td colspan=2>All the information is required.</td></tr>
		<tr><td>First name</td><td><input type="text" name="firstName" size=25 /></td></tr>
		<tr><td>Last name</td><td><input type="text" name="lastName" size=25 /></td></tr>
		<tr><td>Expected username</td><td><input type="text" name="username" size=25 /></td></tr>
		<tr><td>Email</td><td><input type="text" name="email" size=25 /></td></tr>
		<tr><td colspan=2 align=center><input type="submit" value="Submit" /></td></tr>
	</table>
	</form>
	<br/>
	<table class="table" border=0>
		<tr><td><font size=1>Read our privacy policy and terms of use. (coming soon)</font></td></tr>
	</table>
	<br/><br/>
<?php
	require_once("footer.php");
?>
