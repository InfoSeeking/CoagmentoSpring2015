<?php
	session_start();
	require_once("connect.php");
	if (isset($_COOKIE['CSpace_noteID'])) {
		$noteID = $_COOKIE['CSpace_noteID'];
		$note = "";
		if ($noteID!=0) {
			$query = "SELECT * FROM notes WHERE noteID=$noteID";
			$results = mysql_query($query) or die(" ". mysql_error());
			$line = mysql_fetch_array($results, MYSQL_ASSOC);
			$note = stripslashes($line['note']);
		}
	}
	else
		$noteID = 0;
?>
<div id="notesBox" style="height:380px;overflow:auto;">
<form action="sidebar.php" method=post>
<input type="hidden" name="noteID" value="<?php echo $noteID;?>" />
<textarea name="note" rows=6 cols=32><?php echo $note;?></textarea><br/>
<input type="submit" value="Save Note"/>&nbsp;&nbsp;&nbsp;&nbsp; <font color=blue style="text-decoration: underline;"><a href="sidebar.php">New Note</a></font>
</form>
<?php
	if ((isset($_SESSION['userID']))) {
		$userID = $_SESSION['userID'];
		if (isset($_SESSION['projectID']))
			$projectID = $_SESSION['projectID'];
		else {
			$query = "SELECT projects.projectID FROM projects,memberships WHERE memberships.userID='$userID' AND projects.description LIKE '%Untitled project%' AND projects.projectID=memberships.projectID";
			$results = mysql_query($query) or die(" ". mysql_error());
			$line = mysql_fetch_array($results, MYSQL_ASSOC);
			$projectID = $line['projectID'];
		}
		$query = "SELECT * FROM notes WHERE projectID='$projectID' ORDER BY timestamp";
		$results = mysql_query($query) or die(" ". mysql_error());
		echo "<table>\n";
		while ($line = mysql_fetch_array($results, MYSQL_ASSOC)) {
			$noteID = $line['noteID'];
			$note = stripslashes($line['note']);
			$noteSnippet = substr($line['note'], 0, 25);
			$date = $line['date'];
			echo "<tr><td><font color=blue><a href=\"sidebar.php?noteID=$noteID\">$noteSnippet ...</a></font></td><td align=right><font color=green>$date</font></td></tr>\n";
		}
		echo "</table>\n</div>\n";
	}
	else {
		echo "You are not logged in. Visit your <a href=\"http://www.coagmento.org/CSpace/\" target=_content><font color=blue>CSpace</font></a> to do so.\n";
	}
?>