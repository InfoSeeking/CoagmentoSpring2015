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
        	$bookmarkID = $_GET['value'];
        	
        	Util::getInstance()->saveAction("View Bookmark",$bookmarkID, $base);
        	

            $query = "SELECT bookmarkID, userID, (SELECT username from users b where a.userID = b.userID) username, url, title, time, rating, note
            FROM bookmarks a
            WHERE bookmarkID = $bookmarkID";

 			$connection = Connection::getInstance();
			$results = $connection->commit($query);
			$numRows = mysql_num_rows($results);
			
			if ($numRows>0)
			{
        		$line = mysql_fetch_array($results, MYSQL_ASSOC);
				$url = $line['url'];
				$title = stripslashes($line['title']);
				$username = $line['username'];
				$time = $line['time'];
				$userID = $line['userID'];
                $rating = $line['rating'];
                $note = $line['note'];
                
				
				$user = "";
				if ($base->getUserID()==$userID)
					$user = "You";
				else
					$user = $username;
                
                //print page, note, rating
?>

<html>
    <head>
		<title>Bookmark View</title>
    </head>
	<script type="text/javascript" src="js/utilities.js"></script>
<body>
	<center>
			<br />

			<div>The following bookmark was collected by <strong><?php echo $user;?></strong> at <strong><?php echo $time;?></strong>
			<?php 
				if ($base->getAllowBrowsing())
				{
			?>			
			 		from this <strong><a onclick="javascript:addAction('Revisit Page From Snippet','<?php echo $bookmarkID;?>')" href="<?php echo $url; ?>" target="_new">link</a></strong></div>
			<?php 
				}
			?> 
			</div>
			<br />
			<hr />
			<div>
<?php
    echo "Page Title: ".$title."<br><br>";
    if($rating > 0){
        echo "Rating: ".strval($rating)."<br><br>";
    }else{
        echo "Rating: None<br><br>";
    }
    
    if(!is_null($note) && $note != ""){
        echo "Note: ".$note."<br><br>";
    }
    ?>

</div>
	</center>                
</body>
</html>

<?php				
				
			}
        
        }
	}        
?>      
        
  