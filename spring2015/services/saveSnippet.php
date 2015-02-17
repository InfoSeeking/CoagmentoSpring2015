
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

	$query = "INSERT INTO snippets (userID, projectID, stageID, questionID, url, title, snippet, timestamp, date, time, `localTimestamp`, `localDate`, `localTime`, type)
	 		                VALUES('$userID','$projectID','$stageID', '$questionID','$url','$title','$snippet','$timestamp','$date','$time','$localTimestamp','$localDate','$localTime','text')";

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
