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
        	$sourceName = urldecode($_GET['value']);

        	Util::getInstance()->saveAction("View Source",$sourceName, $base);

          $query = "SELECT * FROM
          (SELECT 'bookmark' as type,url,userID,projectID,`date`,`time`,`timestamp`,host,status,'' as snippet FROM bookmarks
            UNION ALL
            SELECT 'snippet' as type,url,userID,projectID,`date`,`time`,`timestamp`,host,status,snippet as snippet from snippets) a
            WHERE projectID='$projectID' AND status=1 AND host='$sourceName' ORDER BY type ASC";

 			$connection = Connection::getInstance();
			$results = $connection->commit($query);
			$numRows = mysql_num_rows($results);

			if ($numRows>0)
			{
        // $line = mysql_fetch_array($results, MYSQL_ASSOC);
				// $url = $line['url'];
				// $title = stripslashes($line['title']);
				// $snippet = stripslashes($line['snippet']);
				// $username = $line['username'];
				// $time = $line['time'];
				// $userID = $line['userID'];
        //
				// $user = "";
				// if ($base->getUserID()==$userID)
				// 	$user = "You";
				// else
				// 	$user = $username;
?>

<html>
    <head>
		<title>Source View</title>
    </head>
	<script type="text/javascript" src="js/utilities.js"></script>
<body>

			<div>
        <h3>Source: <?php echo $sourceName;?></h3>
        <hr>

			<?php
				if ($base->getAllowBrowsing())
				{

          $query = "SELECT *,(SELECT username from users b where bookmarks.userID = b.userID) from bookmarks WHERE projectID='$projectID' AND status=1 AND host='$sourceName'";


            $connection = Connection::getInstance();
     			  $results = $connection->commit($query);
     			  $numRows = mysql_num_rows($results);
            if($numRows>0){
              $count = 1;
              while($line = mysql_fetch_array($results, MYSQL_ASSOC)){
                echo "<h4>Bookmark $count</h4>";
                $userID = $line['userID'];
                $username = $line['username'];
                $rating = $line['rating'];
                $notes = stripslashes($line['notes']);
                if ($base->getUserID()==$userID){
                  $user = "You";
                }
                else {
                  $user = $username;
                }
                $time = $line['time'];

                  // Saved by
                  echo "<p>Saved By: $user</p>";
                  // Saved by
                  echo "<p>Time: $time</p>";
                  // Rating
                  echo "<p>Rating: $rating</p>";
                  // Notes
                  echo "<p>Notes: $notes</p>";
                  // Tags
                  echo "<p>Tags:";
                  $used_tags = Tags::retrieveFromBookmark($bookmarkID);
                  foreach ($used_tags as $t){
                    echo "$t; ";
                  }
                  echo "</p>";
                $count += 1;
              }
            }
            echo "<hr>";

            $query = "SELECT *,(SELECT username from users b where snippets.userID = b.userID) from snippets WHERE projectID='$projectID' AND status=1 AND host='$sourceName'";

              $connection = Connection::getInstance();
       			  $results = $connection->commit($query);
       			  $numRows = mysql_num_rows($results);
               if($numRows>0){
                 $count = 1;
                 while($line = mysql_fetch_array($results, MYSQL_ASSOC)){
                   echo "<h4>Snippet $count</h4>";
                   $userID = $line['userID'];
                   $username = $line['username'];
                   if ($base->getUserID()==$userID){
                   	$user = "You";
                   }
                   else {
                   	$user = $username;
                   }
                   $time = $line['time'];
                     // Saved by
                     echo "<p>Saved By: $user</p>";
                     // Saved by
                     echo "<p>Time: $time</p>";
                     // Snippet
                     echo "<p>Snippet: $snippet</p>";
                     $count += 1;
                 }
               }
			?>


			<!-- <h3><a href="<?php echo $url; ?>" target="_new"><?php echo $title; ?></a></h3> -->
			 		<!-- from this <strong><a onclick="javascript:addAction('Revisit Page From Snippet','<?php echo $snippetID;?>')" href="<?php echo $url; ?>" target="_new">link</a></strong></div> -->
			<?php
				}
			?>
			<!-- <h4>Saved by <strong><?php echo $user;?></strong> at <strong><?php echo $time;?></strong></h4> -->
			</div>
			<hr />
			<!-- <div><p><strong>Snippet:</strong> <?php echo $snippet;?></p></div> -->
</body>
</html>

<?php

			}

        }
	}
?>
