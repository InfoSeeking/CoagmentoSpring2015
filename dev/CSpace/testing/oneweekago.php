<?php

/* function first_image_from_website($url){
    preg_match("/^(http:\/\/)?([^\/]+)/i", $url, $matches);
    $host = $matches[2];
    preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);
    $contents=file_get_contents($url);
    preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $contents, $images);
    return 'http://'.$matches[0].$images[1][0];
} */

	echo '<link href="css/style.css" rel="stylesheet" type="text/css" />';
	
	require_once("../connect.php"); // Include the file for database connection details

	// Each user has a unique ID in the system.
	$userID = 2;
	$title = "Coagmento";
	$test = "2009-04-26";
	$yesterday = "2009-04-25";
	$twodaysago = "2009-04-24";
	$oneweekago = "2009-04-19";
	
	// Get info about the user
	$query = "SELECT * FROM users WHERE userID=$userID";
	$results = mysql_query($query) or die(" ". mysql_error());
	$line = mysql_fetch_array($results, MYSQL_ASSOC);
	$firstName = $line['firstName'];
	$lastName = $line['lastName'];
	
	/* $today = date("Y-m-d", time());
	 print $today;
	 echo "<br>";
	 $tomorrow  = mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
	 print date("Y-m-d",$tomorrow) . "<br>";
	 $lastmonth = mktime(0, 0, 0, date("m")-5, date("d"),   date("Y"));
	 print date("Y-m-d",$lastmonth) . "<br><br>";
	 
	 if($today < $date == false) {
		 print "true";
		 echo "today $today yesterday $date<br><br>";
	 }*/
	
	echo "Records for user: <strong>$firstName $lastName</strong><br/><br/>\n";
	
	$query = "SELECT * FROM pages ORDER BY date,time LIMIT 100";
	$results = mysql_query($query) or die(" ". mysql_error());
	$count = 1;
	$records = 0;
	
	echo "Search results for <font color=ff0000>$oneweekago</font><br/><br/>";
	
	echo "<table><tr>";
	while ($line = mysql_fetch_array($results, MYSQL_ASSOC)) {
		$title = $line['title'];
		$url = $line['url'];
		$date = $line['date'];
		$time = $line['time'];
		
		if(($records % 3) == 0) {
				echo "</tr><tr>\n";
		}
		
		if($date == $oneweekago) {
		echo "<td class='count'>$count</td>";
		/* echo '<img src="';
		echo first_image_from_website($url);
		echo '">'; */

		echo "<td><a href=\"$url\">$title</a> <br /> $date $time<br/>\n</td>";
		$records++;
		$count++;
		}
		
	}
	echo "</tr></table><br/><br/>";
	
	echo "$count records found";
	
	
	/* $query = "SELECT * FROM pages WHERE userID=$userID ORDER BY date,time LIMIT 100"; // To get the first 100 records
//	$query = "SELECT * FROM pages WHERE userID=$userID ORDER BY date,time"; // To get all the records
	$results = mysql_query($query) or die(" ". mysql_error());
	while ($line = mysql_fetch_array($results, MYSQL_ASSOC)) {	
		$title = $line['title'];
		$url = $line['url'];
		$date = $line['date'];
		$time = $line['time'];
		echo "<a href=\"$url\">$title</a>, $date $time<br/>\n";
	}	*/
?>
