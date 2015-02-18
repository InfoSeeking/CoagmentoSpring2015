
<?php
	session_start();
	require_once('../sidebar/pubnub-lib/autoloader.php');
	require_once('../core/Connection.class.php');
	require_once('../core/Base.class.php');
	require_once('../core/Action.class.php');
	require_once('../core/Util.class.php');
	require_once("utilityFunctions.php");


	use Pubnub\Pubnub;

if (Base::getInstance()->isSessionActive())
{
	$pubnub = new Pubnub(array('publish_key'=>'pub-c-c65f91dd-c2b5-42c5-be54-2107495df5fa','subscribe_key'=>'sub-c-36a53ccc-5ae9-11e4-92e9-02ee2ddab7fe'));
	$localTime = $_GET['localTime'];
	$localDate = $_GET['localDate'];
	$localTimestamp = $_GET['localTimestamp'];

	$base = new Base();
	$base->registerActivity();

	$url = $_GET['URL'];


	$entry = explode(".", $url);
	$i = 0;
	$isWebsite = 0;
			$site = NULL;

	while (isset($entry[$i]) && ($isWebsite == 0))
	{
		$entry[$i] = strtolower($entry[$i]);
		if (($entry[$i] == "com") || ($entry[$i] == "edu") || ($entry[$i] == "org") || ($entry[$i] == "gov") || ($entry[$i] == "info") || ($entry[$i] == "us") || ($entry[$i] == "ca") || ($entry[$i] == "es") || ($entry[$i] == "uk") || ($entry[$i] == "net"))
		{
			$isWebsite = 1;
							if(($entry[$i] == "uk") && strpos($originalURL,'uk.yahoo.com') !== false){
									$domain = $entry[$i+2];
									$site = $entry[$i+1];
							}else if(($entry[$i] == "uk") && strpos($originalURL,'uk.search.yahoo.com') !== false){
									$domain = $entry[$i+3];
									$site = $entry[$i+2];
							}else if(($entry[$i] == "uk") && strpos($originalURL,'.co.uk') !== false){
									$domain = $entry[$i];
									$site = $entry[$i-2];
							}else{
									$domain = $entry[$i];
									$site = $entry[$i-1];
							}
		}
		$i++;
	}


	$host = "";
	$p = parse_url($url);
	if ($p){
		$host = $p['host'];
		$host = addslashes($host);
	}

	$title = addslashes(htmlspecialchars($_GET['title']));
	$snippet = addslashes($_GET['snippet']);
	$title = str_replace(" - Mozilla Firefox","",$title);

	$snippet = stripslashes($snippet);
	$snippet = stripslashes($snippet);
	$snippetValue = str_replace("\"","&quote;",$snippet);
	$snippet = str_replace("&quote;", "\"", $snippet);
	$snippet = str_replace("'", "\\'", $snippet);

	$projectID = $base->getProjectID();
	$userID = $base->getUserID();
	$time = $base->getTime();
	$date = $base->getDate();
	$timestamp = $base->getTimestamp();
	$stageID = $base->getStageID();
	$questionID = $base->getQuestionID();

	$query = "INSERT INTO snippets (userID, projectID, stageID, questionID, url, title,host, snippet, timestamp, date, time, `localTimestamp`, `localDate`, `localTime`, type)
	 		                VALUES('$userID','$projectID','$stageID', '$questionID','$url','$title','$host','$snippet','$timestamp','$date','$time','$localTimestamp','$localDate','$localTime','text')";

	$connection = Connection::getInstance();
	$results = $connection->commit($query);
	$snippetID = $connection->getLastID();

	$action = new Action('snippet',$snippetID);
	$action->setBase($base);
	$action->setLocalTimestamp($localTimestamp);
	$action->setLocalTime($localTime);
	$action->setLocalDate($localDate);
	$action->save();

	$query = "SELECT userID from users WHERE projectID='$projectID'";
	$results = $connection->commit($query);
	while($lineBroadcast = mysql_fetch_array($results,MYSQL_ASSOC)){
		$userIDBroadcast = $lineBroadcast['userID'];
		$message = array('message'=>'refresh-snippets');
		$res=$pubnub->publish("spr15-".$base->getStageID()."-".$base->getProjectID()."-".$userIDBroadcast,$message);
	}

}
?>
