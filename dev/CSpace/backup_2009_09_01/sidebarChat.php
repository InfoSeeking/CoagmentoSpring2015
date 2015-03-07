<?php
	session_start();
?>

<?php
	require_once("connect.php");
	if ((isset($_SESSION['userID']))) {
		$userID = $_SESSION['userID'];
		if (isset($_SESSION['projectID']))
			$projectID = $_SESSION['projectID'];
		else {
			$query = "SELECT projects.projectID FROM projects,memberships WHERE memberships.userID='$userID' AND projects.description LIKE '%Untitled project%' AND projects.projectID=memberships.projectID";
			$results = mysql_query($query) or die(" ". mysql_error());
			$line = mysql_fetch_array($results, MYSQL_ASSOC);
			$projectID = $line['projectID'];
		}
		
		$query = "SELECT * FROM chat WHERE projectID='$projectID' ORDER BY timestamp";
		$results = mysql_query($query) or die(" ". mysql_error());
		while($line = mysql_fetch_array($results, MYSQL_ASSOC)) {
			$userName = $line['username'];
			$color = $line['color'];
			$message = stripslashes($line['message']);
			echo "<strong><font color=\"#$color\">$userName</font></strong>: $message<br/>\n";
		}
/*
	$num = rand(1, 100);
	echo "$num<br/>";
*/
//		unset($_POST['message']);
?>

<?php
	}
	else {
		echo "You are not logged in. Visit your <a href=\"http://".$_SERVER['HTTP_HOST']."/CSpace/\" target=_content><font color=blue>CSpace</font></a> to do so.\n";
	}
?>
