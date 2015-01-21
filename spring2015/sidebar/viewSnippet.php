<?php
	session_start();
	require_once('../core/Base.class.php');
	require_once('../core/Connection.class.php');
	require_once('../core/Util.class.php');	

    $base = new Base();
	
	if ($base->isSessionActive())
	{
        if (isset($_GET['value']))
        {
        	$snippetID = $_GET['value'];
        	
        	Util::getInstance()->saveAction("View Snippet",$snippetID, $base);
        	
//       	 	$query = "SELECT snippetID, userID, SUBSTRING((SELECT username from users b where a.userID = b.userID),1,5) username, url, snippet, time
//					 FROM snippets a
//			 		 WHERE status=1 
//			  		 AND snippetID = $snippetID";
            $query = "SELECT snippetID, userID, (SELECT username from users b where a.userID = b.userID) username, url, snippet, time
            FROM snippets a
            WHERE status=1
            AND snippetID = $snippetID";

 			$connection = Connection::getInstance();
			$results = $connection->commit($query);
			$numRows = mysql_num_rows($results);
			
			if ($numRows>0)
			{
        		$line = mysql_fetch_array($results, MYSQL_ASSOC);
				$url = $line['url'];
				$snippet = stripslashes($line['snippet']);
				$username = $line['username'];
				$time = $line['time'];
				$userID = $line['userID'];
				
				$user = "";
				if ($base->getUserID()==$userID)
					$user = "You";
				else
					$user = $username;        	
?>

<html>
    <head>
		<title>Snippet View</title>
    </head>
	<script type="text/javascript" src="js/utilities.js"></script>
<body>
	<center>
			<br />
			<!--  <div>The following snippet was collected by <strong><?php echo $user;?></strong> at <strong><?php echo $time;?></strong> from this <strong><a onclick="javascript:ajaxpage('insertAction.php?action=Revisit Page From Snippet&value=<?php echo $snippetID;?>',null)" href="<?php echo $url; ?>" target="_new">link</a></strong></div> -->
			<div>The following snippet was collected by <strong><?php echo $user;?></strong> at <strong><?php echo $time;?></strong>
			<?php 
				if ($base->getAllowBrowsing())
				{
			?>			
			 		from this <strong><a onclick="javascript:addAction('Revisit Page From Snippet','<?php echo $snippetID;?>')" href="<?php echo $url; ?>" target="_new">link</a></strong></div>
			<?php 
				}
			?> 
			</div>
			<br />
			<hr />
			<div><?php echo $snippet;?></div>
	</center>                
</body>
</html>

<?php				
				
			}
        
        }
	}        
?>      
        
  