<?php
	session_start();
	$userID = $_SESSION['CSpace_userID'];
	$projectID = $_SESSION['CSpace_projectID'];
	require_once("connect.php");

	$query = "SELECT max(chatID) as num FROM chat WHERE projectID='$projectID'";
	$results = mysql_query($query) or die("1 ". mysql_error());
	$line = mysql_fetch_array($results, MYSQL_ASSOC);
	$maxChatID = $line['num'];
	echo "$maxChatID";
?>