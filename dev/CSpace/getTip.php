<?php
	require_once("connect.php");
	$query = "SELECT * FROM tips";
	$results = mysql_query($query) or die(" ". mysql_error());
	$numTips = mysql_num_rows($results);
	$randNum = rand(1,$numTips);

	$query = "SELECT * FROM tips WHERE id='$randNum'";
	$results = mysql_query($query) or die(" ". mysql_error());
	$line = mysql_fetch_array($results, MYSQL_ASSOC);
	$tip = $line['tip'];
	echo "$tip";
?>