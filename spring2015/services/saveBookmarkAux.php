<?php

	session_start();
    require_once('../core/Connection.class.php');
    require_once('../core/Base.class.php');
    require_once('../core/Util.class.php');
    require_once('../core/Tags.class.php');
		use Pubnub\Pubnub;

		require_once('../sidebar/pubnub-lib/autoloader.php');


    if (Base::getInstance()->isSessionActive())
    {





			$pubnub = new Pubnub(array('publish_key'=>'pub-c-0ee3d3d2-e144-4fab-bb9c-82d9be5c13f1','subscribe_key'=>'sub-c-ac9b4e84-b567-11e4-bdc7-02ee2ddab7fe'));
    $ip=$_SERVER['REMOTE_ADDR'];
    $connection = Connection::getInstance();
    $base = Base::getInstance();
    $userID = $base->getUserID();
    $projectID = $base->getProjectID();
    $stageID = $base->getStageID();
    $questionID = $base->getQuestionID();
    $localDate = $_POST['localDate'];
    $localTime = $_POST['localTime'];
    $localTimestamp = $_POST['localTimestamp'];


		$query = "SELECT instructorID from recruits WHERE userID='$userID'";
		$cxn = Connection::getInstance();
		$r = $cxn->commit($query);
		$l = mysql_fetch_array($r,MYSQL_ASSOC);
		$instructorID = $l['instructorID'];


    $title = addslashes($_POST['title']);
    $source = addslashes($_POST['source']);
		$site = addslashes($_POST['site']);
//    $site = $_POST['site'];
		$host = addslashes($_POST['host']);

    $queryString = '';
    if(isset($_POST['queryString'])){
        $queryString = addslashes($_POST['queryString']);
    }

    $queryString = $_POST['queryString'];
    $originalURL = $_POST['originalURL'];
    $rating = "NULL";
    if(isset($_POST['rating'])){
        $rating = $_POST['rating'];
    }
    $note = "NULL";
    if(isset($_POST['annotation'])){
        $note = addslashes($_POST['annotation']);
    }

		$useful_info = "NULL";
		if(isset($_POST['useful_info'])){
        $useful_info = addslashes($_POST['useful_info']);
    }

		$author_qualifications="NULL";
		if(isset($_POST['author_qualifications'])){
        $author_qualifications = addslashes($_POST['author_qualifications']);
    }





    $timestamp = $base->getTimestamp();
    $date = $base->getDate();
    $time = $base->getTime();
    // $lastID = $connection->getLastID();



		if($instructorID==1){
	    $query = "INSERT INTO bookmarks (userID,projectID,stageID,questionID,url,title,source,host,query,timestamp,date,time,`localDate`,`localTime`,`localTimestamp`,note,rating,status) VALUES('$userID','$projectID','$stageID','$questionID','$originalURL','$title','$site','$host','$queryString','$timestamp','$date','$time','$localDate','$localTime','$localTimestamp','$note','$rating','1')";
	    $results = $connection->commit($query);
		}else{
			$query = "INSERT INTO bookmarks (userID,projectID,stageID,questionID,url,title,source,host,query,timestamp,date,time,`localDate`,`localTime`,`localTimestamp`,useful_info,author_qualifications,rating,status) VALUES('$userID','$projectID','$stageID','$questionID','$originalURL','$title','$site','$host','$queryString','$timestamp','$date','$time','$localDate','$localTime','$localTimestamp','$useful_info','$author_qualifications','$rating','1')";
	    $results = $connection->commit($query);
		}


    $bookmarkID = $connection->getLastID();
		Util::getInstance()->saveActionWithLocalTime("Save Bookmark - Rating: $rating",$bookmarkID,$base,$localTime,$localDate,$localTimestamp);
    $tags = new Tags();
		$tag_input = array();
		if(isset($_POST["tags"])){
			$tag_input = $_POST["tags"];
		}
    $tags->assignTagsToBookmark($bookmarkID, $tag_input);


		$query = "SELECT userID as userID from users WHERE projectID='$projectID'";
		$results = $connection->commit($query);

		while($lineBroadcast = mysql_fetch_array($results,MYSQL_ASSOC)){
			$userIDBroadcast = $lineBroadcast['userID'];
			$message = array('message'=>'refresh-bookmarks');
			$res=$pubnub->publish("spr15-".$base->getStageID()."-".$base->getProjectID()."-".$userIDBroadcast,$message);
		}

    echo "<script>window.close()</script>";


    //TODO: Save bookmark action!!!!

//    $lastID = mysql_insert_id();
    //TODO: Insert into actions!
//            $aQuery = "INSERT INTO actions VALUES('','$userID','$projectID','$timestamp','$date','$time','save-page','$lastID','$ip')";
//            $aResults = mysql_query($aQuery) or die(" ". mysql_error());

    }

?>
