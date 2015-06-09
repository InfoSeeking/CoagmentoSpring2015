<?php
//    Modification on 8/18/14: to accommodate for new connection
//	require_once("../connect.php");
//    
//	session_start();
//	date_default_timezone_set('America/New_York');
//	$timestamp = time();
//	$datetime = getdate();
//    	$date = date('Y-m-d', $datetime[0]);
//	$time = date('H:i:s', $datetime[0]);
//	$projectID = $_SESSION['CSpace_projectID'];
//	$userID = $_SESSION['CSpace_userID'];
//        $ip=$_SERVER['REMOTE_ADDR'];
//	$action = $_POST['action'];
// 	$value = $_POST['value'];
//	$query = "INSERT INTO actions (userID, projectID, timestamp, date, time, action, value, ip) VALUES ('$userID', '$projectID', '$timestamp', '$date', '$time', '$action', '$value','$ip')";
//	$results = mysql_query($query) or die(" ". mysql_error());
    
    session_start();
    require_once('../../core/Connection.class.php');
	require_once('../../core/Base.class.php');
	require_once('../../core/Action.class.php');
	require_once('../../core/Util.class.php');
    if (Base::getInstance()->isSessionActive())
    {
        $base = new Base();
        
        $actionVal = $_POST['action'];
        $value = $_POST['value'];
        
        $action = new Action($actionVal,$value); //add later the ID of the tab
        $action->setBase($base);
        $action->save();
        
    }
?>