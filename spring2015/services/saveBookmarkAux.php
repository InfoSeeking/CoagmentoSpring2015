<?php

	session_start();
    require_once('../core/Connection.class.php');
    require_once('../core/Base.class.php');
    require_once('../core/Util.class.php');
    require_once('../core/Tags.class.php');


    if (Base::getInstance()->isSessionActive())
    {

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


    $title = addslashes($_POST['title']);
    $source = addslashes($_POST['source']);
//    $site = $_POST['site'];

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

    $timestamp = $base->getTimestamp();
    $date = $base->getDate();
    $time = $base->getTime();
    $lastID = $connection->getLastID();

    Util::getInstance()->saveAction("Save Bookmark - Rating: $rating",$lastID,$base);

    $query = "INSERT INTO bookmarks (userID,projectID,stageID,questionID,url,title,source,query,timestamp,date,time,`localDate`,`localTime`,`localTimestamp`,note,rating,status) VALUES('$userID','$projectID','$stageID','$questionID','$originalURL','$title','$source','$queryString','$timestamp','$date','$time','$localDate','$localTime','$localTimestamp','$note','$rating','1')";
    $results = $connection->commit($query);

    $bookmarkID = $connection->getLastID();
    $tags = new Tags();
    $tags->assignTagsToBookmark($bookmarkID, $_POST["tags"]);
    echo "<script>window.close()</script>";


    //TODO: Save bookmark action!!!!

//    $lastID = mysql_insert_id();
    //TODO: Insert into actions!
//            $aQuery = "INSERT INTO actions VALUES('','$userID','$projectID','$timestamp','$date','$time','save-page','$lastID','$ip')";
//            $aResults = mysql_query($aQuery) or die(" ". mysql_error());

    }

?>
