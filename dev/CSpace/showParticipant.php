<?php
	require_once("header.php");
	require_once("connect.php");
?>
<center>
<table class="body">
<?php
	$userID = $_GET['userID'];
	
	// Get the results for the given user and the project
	$query = "SELECT * FROM users WHERE userID='$userID'";
	$results = mysql_query($query) or die(" ". mysql_error());
	while ($line = mysql_fetch_array($results, MYSQL_ASSOC)) {
		$name = $line['firstName'] . " " . $line['lastName'];
		echo "<tr><td>$name</td></tr>\n";
	}
?>
</table>
</center>
<?php
	require_once("footer.php");
?>