<?php

    session_start();
    require_once('../../core/Connection.class.php');
	require_once('../../core/Base.class.php');
	require_once('../../core/Action.class.php');
	require_once('../../core/Util.class.php');
    if (Base::getInstance()->isSessionActive())
    {
        
        $message = addslashes($_POST['message']);
        $base = Base::getInstance();
        $timestamp = $base->getTimestamp();
        $date = $base->getDate();
        $time = $base->getTime();
        $userID = $base->getUserID();
        $projectID = $base->getProjectID();
        $username = $base->getUserName();
        $questionID = $base->getQuestionID();
        $stageID = $base->getStageID();

        
        $query = "INSERT INTO chat (userID, projectID, message, timestamp, date, time) VALUES ('$userID', '$projectID', '$message','$timestamp','$date','$time')";
        $connection = Connection::getInstance();
        $results = $connection->commit($query);
        $lastID = $connection->getLastID();
        $base = new Base();
        
        $actionVal = $_POST['action'];
        
        $action = new Action($actionVal,$lastID); //add later the ID of the tab
        $action->setBase($base);
        $action->save();
        
    }
?>