<?php
$q=$_GET["q"];

//get content of textfile
$filename = "poll_result.txt";
$content = file($filename);

//put content in array
$array = explode("||", $content[0]);
$doc1 = $array[0];
$doc2 = $array[1];
$doc3 = $array[2];

require_once('connect.php');

// Page
$page="SELECT * FROM pages WHERE pageID=".$q."";
$result = mysql_query($page) or die(" ". mysql_error());

echo '<div id="results">';
while($row = mysql_fetch_array($result))
	{
	$hasThumb = $row['thumbnailID'];
	$projectID = $row['projectID'];
	
	// Get project name
	$getProjectName="SELECT * FROM projects WHERE projectID=".$projectID."";
	$projectNameResult = mysql_query($getProjectName) or die(" ". mysql_error());		

	while($line = mysql_fetch_array($projectNameResult)) {
		$projectName = $line['title'];
		// echo "".$row['title']."";
	}

	// Get thumbnail
	$getPage="SELECT * FROM pages,thumbnails WHERE thumbnails.thumbnailID=pages.thumbnailID AND pages.pageID=".$q."";
	$pageResult = mysql_query($getPage) or die(" ". mysql_error());
	
	while($line = mysql_fetch_array($pageResult)) {
		$value = $line['pageID'];
		$thumb = $line['fileName'];

	  	if ($value == $q) {
		    echo "<img src='http://coagmento.org/CSpace/thumbnails/".$thumb."' width='20%' />";			  		
		    echo "".$row['title']."";
		}
		// If it doesn't match
		else {
			echo "".$row['title']."";
		}
	}
}

echo '</div>';

mysql_close($con);
?>