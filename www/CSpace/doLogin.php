<?php
	session_name('XULSession'); // Set session name
	session_start();
	require_once("connect.php");
		
	$userName = $_GET['userName'];
	$password = sha1($_GET['password']);
	
	// Get the results for the given user and the project
	$query = "SELECT * FROM users WHERE userName='$userName' AND password='$password'";
	$results = mysql_query($query) or die(" ". mysql_error());
	$numOfResults = mysql_num_rows($results);
	if ($numOfResults==1)
		$responseText = "Login successful!";
	else
		$responseText = "Login failed.";
	echo $responseText;
?>
