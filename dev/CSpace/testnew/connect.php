<?php
$host = "localhost";
$username = "shahonli_ic";
$password = "collab2010!";
$database = "shahonli_coagmento";
$dbh = mysql_connect($host,$username,$password) or die("Cannot connect to the database: ". mysql_error());
$db_selected = mysql_select_db($database) or die ('Cannot connect to the database: ' . mysql_error());
?>
