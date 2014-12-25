<?php
session_start();
require_once('connect.php');
echo "hello: ".$_SESSION['CSpace_userID'];

$query = "select * from tips";
$results = mysql_query($query) or die(" ". mysql_error());
$line = mysql_fetch_array($results, MYSQL_ASSOC);
$record = $line['num'];

?>
<html>
<head>
<title>Test</title>
</head>
<body>
	<p><?php echo "Rows: ".$records;?></p>
</body>
</html>