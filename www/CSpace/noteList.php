<?php
	session_start();
	require_once("connect.php");
	if ((isset($_SESSION['CSpace_userID']))) {
		$userID = $_SESSION['CSpace_userID'];
		if (isset($_SESSION['CSpace_projectID']))
			$projectID = $_SESSION['CSpace_projectID'];
		else {
			$query = "SELECT projects.projectID FROM projects,memberships WHERE memberships.userID='$userID' AND projects.description LIKE '%Untitled project%' AND projects.projectID=memberships.projectID";
			$results = mysql_query($query) or die(" ". mysql_error());
			$line = mysql_fetch_array($results, MYSQL_ASSOC);
			$projectID = $line['projectID'];
		}
		if (isset($_SESSION['CSpace_noteShared']))
			$shared = $_SESSION['CSpace_noteShared'];
		else
			$shared = 0;
		if (isset($_GET['note'])) {
			$note = $_GET['note'];
			if (isset($_GET['noteID'])) {
				$noteID = $_GET['noteID'];
				$query = "UPDATE notes SET note='$note' WHERE noteID='$noteID'";
				$results = mysql_query($query) or die(" ". mysql_error());
			}
			else {
				date_default_timezone_set('America/New_York');
				$timestamp = time();
				$datetime = getdate();
			    $date = date('Y-m-d', $datetime[0]);
				$time = date('H:i:s', $datetime[0]);
				$query = "INSERT INTO notes VALUES('','$userID','$projectID','$note','$timestamp','$date','$time','$shared','1')";
				$results = mysql_query($query) or die(" ". mysql_error());
				
				// Get the date, time, and timestamp
				date_default_timezone_set('America/New_York');
				$timestamp = time();
				$datetime = getdate();
				$date = date('Y-m-d', $datetime[0]);
				$time = date('H:i:s', $datetime[0]);
					
				// Record the action and update the points
				$aQuery = "SELECT max(noteID) as num FROM notes WHERE userID='$userID'";
				$aResults = mysql_query($aQuery) or die(" ". mysql_error());
				$aLine = mysql_fetch_array($aResults, MYSQL_ASSOC);
				$rID = $aLine['num'];
				
				$ip=$_SERVER['REMOTE_ADDR'];
				$aQuery = "INSERT INTO actions VALUES('','$userID','$projectID','$timestamp','$date','$time','create-note','$rID','$ip')";
				$aResults = mysql_query($aQuery) or die(" ". mysql_error());
				
				$pQuery = "SELECT points FROM users WHERE userID='$userID'";
				$pResults = mysql_query($pQuery) or die(" ". mysql_error());
				$pLine = mysql_fetch_array($pResults, MYSQL_ASSOC);
				$totalPoints = $pLine['points'];
				$newPoints = $totalPoints+20;
				$pQuery = "UPDATE users SET points=$newPoints WHERE userID='$userID'";
				$pResults = mysql_query($pQuery) or die(" ". mysql_error());					
			}
		}
		if (isset($_GET['delete'])) {
			$noteID = $_GET['noteID'];
			$query = "DELETE FROM notes WHERE noteID='$noteID'";
			echo "$query<br/>\n";
			$results = mysql_query($query) or die(" ". mysql_error());
		}
		
		$maxPerPage = 3;
		$pageToGo = 'noteList.php';
		$container = 'noteList';
		if (!isset($_GET['page']))
			$pageNum = 1;
		else
			$pageNum = $_GET['page'];

		$min = $pageNum*3-3;
//		$max = $pageNum*3;

		if ($pageNum==1)
			$query = "SELECT * FROM notes WHERE projectID='$projectID' AND shared='$shared' ORDER BY timestamp LIMIT $min,$maxPerPage";
		else {
/*			$prevMin = ($pageNum-1)*3;
			$prevMax = ($pageNum-1)*3+1;
			$query = "SELECT noteID FROM notes WHERE projectID='$projectID' AND shared='$shared' ORDER BY timestamp LIMIT $prevMin,$prevMax";	
			$results = mysql_query($query) or die(" ". mysql_error());		
			$line = mysql_fetch_array($results, MYSQL_ASSOC);
			$minID = $line['noteID'];
*/
			$query = "SELECT * FROM notes WHERE projectID='$projectID' AND shared='$shared' ORDER BY timestamp LIMIT $min,$maxPerPage";
		}
//		echo "$query";
			
		$query1 = "SELECT * FROM notes WHERE projectID='$projectID' AND shared='$shared'";		
		$results = mysql_query($query) or die(" ". mysql_error());
		echo "<table>\n";
		while ($line = mysql_fetch_array($results, MYSQL_ASSOC)) {
			$noteID = $line['noteID'];
			$note = stripslashes($line['note']);
			$noteSnippet = substr($line['note'], 0, 20);
			$date = $line['date'];
			$dispNote = addslashes($note);
			echo "<tr><td><span style=\"color:blue;text-decoration:underline;cursor:pointer;font-size:11px;\" onClick=\"showNote($shared, $noteID,'$dispNote');\">$noteSnippet..</span></td><td align=right><span style=\"color:green;font-size:9px;\">$date</span> <span style=\"color:red;text-decoration:underline;cursor:pointer;\" onClick=\"deleteNote($shared, $noteID);\">X</span></font></td></tr>\n";
		}
		echo "<tr><td colspan=2><hr/></td></tr>\n";
		echo "<tr><td colspan=2 align=center>";
		require_once("sidebarPaging.php");
		echo "</td></tr>\n";
		echo "</table>\n";
	}
	else {
		echo "Your session has expired. Please <a href=\"http://www.coagmento.org/CSpace/\" target=_content><span style=\"color:blue;text-decoration:underline;cursor:pointer;\">login</span> again.\n";
	}
?>
