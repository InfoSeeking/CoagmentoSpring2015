<?php
	session_start();
	require_once('core/Base.class.php');
	require_once('core/Connection.class.php');
	require_once('core/Util.class.php');
	require_once('sidebar/pubnub-lib/autoloader.php');
	use Pubnub\Pubnub;

	if (Base::getInstance()->isSessionActive())
	{
		$pubnub = new Pubnub(array('publish_key'=>'pub-c-c65f91dd-c2b5-42c5-be54-2107495df5fa','subscribe_key'=>'sub-c-36a53ccc-5ae9-11e4-92e9-02ee2ddab7fe'));
		$base = Base::getInstance();
		$userID = $base->getUserID();
		$query = "SELECT userID from users WHERE projectID='$userID'";
		$connection = Connection::getInstance();
		$results = $connection->commit($query);
		$lineBroadcast = mysql_fetch_array($results,MYSQL_ASSOC);
		$userIDBroadcast = $lineBroadcast['userID'];
		$message = array('message'=>'3');
		$res=$pubnub->publish("spr15-".$base->getStageID()."-".$base->getProjectID()."-checkStage".$userIDBroadcast,$message);
			session_destroy();
			//Save action
			$base = new Base();
			$base->setAllowCommunication(0);
			$base->setAllowBrowsing(0);
			Util::getInstance()->saveAction('logout',0,$base);
			// pubnub 3
			echo "1";
	}


?>
