<?php
	session_start();
	require_once('../core/Base.class.php');
	require_once('../core/Connection.class.php');
	require_once('../core/Util.class.php');	

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
			
			
	}
    // if not logged in end
  
	else //Currently logged in
	{
	$stageID = $base->getStageID();
	// Save action in Database
    //    If you want to save the local timestamp.  Just remember to change the GET parameters in the getHome.php call of coagmento.js
	Util::getInstance()->saveAction("Clicked Get Home",0, $base);
	
?>
			<html>
    		<head>
				<title>Home: Logged In</title>
   			 </head>
	
			<body>
				<center>
				<br/>
					<table class="body" >
						<tr><td align="center"><br/>You are already logged in to the system.  This is a placeholder for the home page.<td/></tr>
                        <tr><td align="center"><br/>This will redirect to CSpace.<td/></tr>
						<tr><td align="center"><br/><strong>For now, click <a href="../index.php">here</a> to go to index.php</strong>.<td/></tr>
					</table>
				</center>               
			</body>
			</html>
<?php
	}      
?>      
        
  