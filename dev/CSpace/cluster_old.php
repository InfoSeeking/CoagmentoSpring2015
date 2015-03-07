<?php
$cpages = $_GET["cpages"];
$n = $_GET["n"];

/* create a dom document with encoding utf8 */
$xml = new DOMDocument('1.0', 'UTF-8');
$xml->formatOutput = true;

/* create the root element of the xml tree */
$parameters = $xml->createElement("parameters");
/* append it to the document created */
$parameters = $xml->appendChild($parameters);

$reqType = $xml->createElement("requestType");
$reqType = $parameters->appendChild($reqType);
$cluster = $xml->createTextNode('cluster');
$cluster = $reqType->appendChild($cluster);

$numClusters = $xml->createElement("numClusters");
$numClusters = $parameters->appendChild($numClusters);
$three = $xml->createTextNode($n);
$three = $numClusters->appendChild($three); 

$docList = $xml->createElement("docList");
$docList = $parameters->appendChild($docList);

foreach ($cpages as $checked) {
	$doc = $xml->createElement("doc");
	$doc = $docList->appendChild($doc);
	$docID = $xml->createElement("docID");
	$docID = $doc->appendChild($docID);
	$cvalue = $xml->createTextNode($checked);
	$cvalue = $docID->appendChild($cvalue);
}

    /* get the xml printed */
    echo $xml->saveXML();
    $xml->save('clusteringInput.xml');
?> 


<?php

// //check if clusterOutput.xml has been generated,
// if (file_exists('cluster.xml')) {
//     $xml = simplexml_load_file('cluster.xml');

//     $cluster = $xml->clusterList->cluster;
//     //for each cluster, get clusterID
//     for ($i=0; $i < count($cluster); $i++) { 
//     	$clusterID = $cluster[$i]->clusterID;
//     	echo "<div class='cf'> <div class='cluster'>Cluster: ".$clusterID." </div>";

//     	$docList = $cluster[$i]->docList;
//     	// for each docList in $cluster, get the $docs of each docList
//     	for ($j = 0; $j < count($docList); $j++) {
//     		$doc = $docList[$j]->doc;
//     		//for each doc, get docID, url
//     		for ($k = 0; $k < count($doc); $k++) {
//     			$docID = $doc[$k]->docID;
//     			//$url = $doc[$k]->url;
//     			//echo $docID;

// 			//connect to DB
// 				$con = mysql_connect('localhost', 'shahonli_ic', 'collab2010!');
// 				if (!$con)
// 				{
// 				  die('Could not connect: ' . mysql_error());
// 				}

// 				mysql_select_db("shahonli_coagmento", $con);

//     			$page="SELECT * FROM pages WHERE pageID=".$docID."";
// 				$result = mysql_query($page) or die(" ". mysql_error());

// 				while($row = mysql_fetch_array($result))
// 					{
// 					$hasThumb = $row['thumbnailID'];
// 					$projectID = $row['projectID'];
					
// 					// Get project name
// 					$getProjectName="SELECT * FROM projects WHERE projectID=".$projectID."";
// 					$projectNameResult = mysql_query($getProjectName) or die(" ". mysql_error());		

// 					while($line = mysql_fetch_array($projectNameResult)) {
// 						$projectName = $line['title'];
// 					}

// 					// Get thumbnail
// 					$getPage="SELECT * FROM pages,thumbnails WHERE thumbnails.thumbnailID=pages.thumbnailID AND pages.pageID=".$docID."";
// 					$pageResult = mysql_query($getPage) or die(" ". mysql_error());
					
// 					while($line = mysql_fetch_array($pageResult)) {
// 						$value = $line['pageID'];
// 						$thumb = $line['fileName'];

// 					  	if ($value == $docID) {
// 					  		//echo "<div class='wrapper'><a href=".$row['url']." target='new'>".$row['title']."</a>";		  		
// 				    		echo "<div class='wrapper'><a href=".$row['url']." target='new'><img width='100px' height='100px' src='http://".$_SERVER['HTTP_HOST']."/CSpace/thumbnails/small/".$thumb."' /></a></div>";	
// 						}
// 					}
// 				} 
//     		}
//     	}
//     	echo "</div>";
//     }

// } // end access XML file

// else {
//     exit('Failed to open cluster.xml.');
// }


// mysql_close($con);

?>
