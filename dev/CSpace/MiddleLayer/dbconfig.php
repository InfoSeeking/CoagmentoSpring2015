<?php
$dbhost = "localhost";
$user = "root";
$pass = "102533";
$db = "coagmento";

if($HOST == "live"){
	$dbhost = "localhost";
	$user = "shahonli_ctest";
	$pass = "coag2012!";
	$db = "shahonli_coagmento";
}
$cxn = mysqli_connect($dbhost, $user, $pass, $db) or die("Could not connect to database");