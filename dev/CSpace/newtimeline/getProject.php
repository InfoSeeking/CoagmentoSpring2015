
<?php
$q=$_GET["q"];

$con = mysql_connect('localhost', 'shahonli_ic', 'collab2010!');
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("shahonli_coagmento", $con);

// Original Query
// $sql="SELECT * FROM pages WHERE userID=2 AND projectID = '".$q."'";
// $result = mysql_query($sql);

// Thumbnail Query
$sql_thumb="SELECT * FROM pages, thumbnails WHERE pages.thumbnailID = thumbnails.thumbnailID AND userID=2 AND projectID=".$q." order by date desc";
$result_thumb = mysql_query($sql_thumb) or die(" ". mysql_error());

// Project Name Query
$sql_name ="SELECT title FROM projects WHERE projectID = '".$q."'";
$result_name = mysql_query($sql_name);
while($row = mysql_fetch_array($result_name)) { echo '<h2>Project: '; echo $row['title']; echo '</h2>'; };

// Declaring Months
$jan = 01; $feb = 02; $mar = 03; $apr = 04; 
$may = 05; $jun = 06; $jul = 07; $aug = 08;
$sept = 09; $oct = 10; $nov = 11; $dec = 12;
$lemonth = '';

$setUp = false;
$currYear = '';
$currMonth = '';
$currDate = '';
$hasHeader1 = false;
$hasHeader2 = false;
$hasHeader3 = false;
$hasHeader4 = false;
$entered = false;

while ($row = mysql_fetch_array($result_thumb, MYSQL_ASSOC)) {
	$title = $row['title'];
	$url = $row['url'];
	$date = $row['date'];
	$month = date("m",strtotime($date));
	$year = date("Y",strtotime($date));
	$thumb = $row['fileName'];
	
	if($month == 01) { $lemonth = "January"; }
	else if($month == 02) { $lemonth = "February"; }
	else if($month == 03) { $lemonth = "March"; }
	else if($month == 04) { $lemonth = "April"; }
	else if($month == 05) { $lemonth = "May"; }
	else if($month == 06) { $lemonth = "June"; }
	else if($month == 07) { $lemonth = "July"; }
	else if($month == 08) { $lemonth = "August"; }
	else if($month == 09) { $lemonth = "September"; }
	else if($month == 10) { $lemonth = "October"; }
	else if($month == 11) { $lemonth = "November"; }
	else if($month == 12) { $lemonth = "December"; }
	
	// Set a year and month to compare to
	if($setUp == false) {
		$currYear = $year;
		$currMonth = $month;
		$currDate = $date;
		$setUp = true;
	}
	
	// Does the year match?
	if($year == $currYear) {
		
		// Does the month match?
		if($month == $currMonth) {
			if($hasHeader1 == false) {
				echo "<table><tr><td class='monthyear'><h3><a name=".$month.">".$lemonth."</a> <a name=".$year.">".$year."</a></h3></td><td class='popular'>POPULAR SEARCHES GO HERE</td><td class='noresults'>NUMBER OF RESULTS GO HERE</td>";
				$hasHeader1 = true;
				$entered = true;
			}
		}
		// If not, reset the month
		else {
			$currMonth = $month;
			if($hasHeader2 == false) {
				echo '</tr></table>';
				$hasHeader1 = false; $hasHeader3 = false; $hasHeader4 = false;
				echo "<table><tr><td class='monthyear'><h3><a name=".$month.">".$lemonth."</a> <a name=".$year.">".$year."</a></h3></td><td class='popular'>POPULAR SEARCHES GO HERE</td><td class='noresults'>NUMBER OF RESULTS GO HERE</td>";
				$hasHeader2 = true;
				$entered = true;
			}
			
		}
	
	}
	// If the year doesn't match
	else {
		
		// Reset the year
		$currYear = $year;
		$currMonth = $month;
		echo '</tr></table>';
		echo "<table><tr><td class='monthyear'><h3><a name=".$month.">".$lemonth."</a> <a name=".$year.">".$year."</a></h3></td><td class='popular'>POPULAR SEARCHES GO HERE</td><td class='noresults'>NUMBER OF RESULTS GO HERE</td>";

	}
		
}

if(!$entered) {
	echo 'No results found';
}











/*
// Original Table
echo "<table border='1'>
<tr>
<th>Webpage</th>
<th>Source</th>
<th>Query</th>
<th>Time</th>
</tr>";

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['title'] . "</td>";
  echo "<td>" . $row['source'] . "</td>";
  echo "<td>" . $row['query'] . "</td>";
  echo "<td><a name=".$row[date].">" . $row['date'] . "</a></td>";
  echo "</tr>";
  }
echo "</table>";*/

mysql_close($con);
?>