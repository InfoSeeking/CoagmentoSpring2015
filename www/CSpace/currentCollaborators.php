<?php
	session_start();
	$userID = $_SESSION['CSpace_userID'];
	$projectID = $_SESSION['CSpace_projectID'];
	require_once("connect.php");
?>
<table>
	<?php
		$query = "SELECT * FROM memberships WHERE userID='$userID' AND projectID='$projectID' GROUP BY projectID";
		$results = mysql_query($query) or die(" ". mysql_error());
		while($line = mysql_fetch_array($results, MYSQL_ASSOC)) {
			$projectID = $line['projectID'];
			$query1 = "SELECT * FROM memberships WHERE projectID='$projectID' AND userID!='$userID' GROUP BY userID";
			$results1 = mysql_query($query1) or die(" ". mysql_error());
			while($line1 = mysql_fetch_array($results1, MYSQL_ASSOC)) {
				$cUserID = $line1['userID'];
				$access = $line1['access'];
				$query2 = "SELECT * FROM users WHERE userID='$cUserID'";
				$results2 = mysql_query($query2) or die(" ". mysql_error());
				$line2 = mysql_fetch_array($results2, MYSQL_ASSOC);
				$userName = $line2['firstName'] . " " . $line2['lastName'];
				$avatar = $line2['avatar'];
				echo "<tr><td><img src=\"../img/$avatar\" width=20 height=20 /></td><td><span style=\"color:blue;text-decoration:underline;cursor:pointer;\" onClick=\"ajaxpage('showCollaborator.php?userID=$cUserID','content');\">$userName</span></td><td>";
				if ($access!=1)
					echo "<span style=\"color:red;text-decoration:underline;cursor:pointer;\" onClick=\"ajaxpage('collaborators.php?remove=$cUserID&projID=$projectID','content');\">X</span>";
				echo "</td></tr>";
			}
		}
		echo "<tr><td colspan=4><span style=\"color:blue;text-decoration:underline;cursor:pointer;\" onClick=\"ajaxpage('collaborators.php','content');\">See all your collaborators</span></td></tr>\n";
	?>
</table>