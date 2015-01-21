<?php
	session_start();
	require_once('../core/Base.class.php');
	require_once('../core/Connection.class.php');
	require_once('../core/Util.class.php');	

    //$base = new Base();
    $base = Base::getInstance();
	
	if (!($base->isSessionActive())) // If not logged in
	{
?>
			<html>
    		<head>
				<title>Home: Not Logged In</title>
   			 </head>
	
			<body>
			<center>
				<br/>
					<table class="body" >
						<tr><td align="center"><br/>You are currently not logged into our system.<td/></tr>
						<tr><td align="center"><br/>If you wish to log in, please click <a href="../index.php">here</a>.<td/></tr>
					</table>
			</center> 
			</body>
			</html>
<?php
			
			
	}// if not logged in end
  
	else //Currently logged in
	{
	// Save "Get Home" action in db
	// Current stage:
	// Description:
	// Lost your page?  Click here to redirect. (index.php)
	
	$userID = $base->getUserID();
	$stageID = $base->getStageID();
	
	// Save action in Database
        
//    If you want to save the local timestamp.  Just remember to change the GET parameters in the getHome.php call of coagmento.js
//    $localTime = $_GET['localTime'];
//    $localDate = $_GET['localDate'];
//    $localTimestamp = $_GET['localTimestamp'];
//        
//        
//    $action = new Action("Clicked Get Home",$stageID);
//    $action->setBase($base);
//    $action->setLocalTimestamp($localTimestamp);
//    $action->setLocalTime($localTime);
//    $action->setLocalDate($localDate);
//    $action->save();
//        
	Util::getInstance()->saveAction("Clicked Get Home",$stageID, $base);
	
	$qStage = "SELECT description, stageDescription 
				FROM session_stages
				WHERE stageID=".$stageID;
	$connection = Connection::getInstance();
	$rStage = $connection->commit($qStage);
	$sLine = mysql_fetch_array($rStage, MYSQL_ASSOC);
	$description = $sLine['description'];
	$stageDescription = $sLine['stageDescription'];
?>
			<html>
    		<head>
				<title>Home: Current Progress</title>
   			 </head>
	
			<body>
				<center>
				<br/>
					<table class="body" >
						<tr><td align="center"><br/>You are already logged in to the system.<td/></tr>
						<tr><td align="center"><br/><strong><u>Your current stage:</u></strong> <?php echo $description;?><td/></tr>
						<!--<tr><td align="center"><br/><strong><u>Current stage description:</u></strong>--> 
						<?php 
// 						echo $stageDescription;
						?>
						<!--<td/></tr>-->
						<tr><td align="center"><br/><strong>Did you accidentally close the browser window? If so, please click <a href="../index.php">here</a> to continue from where you left off</strong>.<td/></tr>
					</table>
				</center>               
			</body>
			</html>
<?php
	}      
?>      
        
  