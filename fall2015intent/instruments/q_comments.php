<?php
	session_start();
	require_once('../core/Connection.class.php');
	require_once('../core/Base.class.php');
	require_once('../core/Action.class.php');
	require_once('../core/Util.class.php');

	Util::getInstance()->checkSession();

	if (Util::getInstance()->checkCurrentPage(basename( __FILE__ )))
	{
		if (isset($_POST['comments']))
		   {

			$base = new Base();

			$taskComments = addslashes($_POST['taskComments']);
			$searchExpComments = addslashes($_POST['searchExpComments']);
			$systemComments = addslashes($_POST['systemComments']);
			$issuesComments = addslashes($_POST['issuesComments']);
			$generalComments = addslashes($_POST['generalComments']);

			$localTime = $_POST['localTime'];
			$localDate = $_POST['localDate'];
			$localTimestamp =  $_POST['localTimestamp'];

			$projectID = $base->getProjectID();
			$userID = $base->getUserID();
			$time = $base->getTime();
			$date = $base->getDate();
			$timestamp = $base->getTimestamp();
			$stageID = $base->getStageID();

			$query = "INSERT INTO questionnaire_postcomments (projectID, userID, stageID,taskComments, systemComments, searchExpComments, issuesComments,generalComments,date, time, timestamp)
									VALUES('$projectID','$userID','$stageID','$taskComments','$systemComments','$searchExpComments','$issuesComments','$generalComments','$date','$time','$timestamp')";

			$connection = Connection::getInstance();
			$results = $connection->commit($query);
			$lastID = $connection->getLastID();

			//Save action
			//Util::getInstance()->saveAction(basename( __FILE__ ),$stageID,$base);
			Util::getInstance()->saveActionWithLocalTime(basename( __FILE__ ),$lastID,$base,$localTime,$localDate,$localTimestamp);

			//Next stage
			Util::getInstance()->moveToNextStage();
		}
		else {
?>
<html>
<head>
<title>Questionnaire: Comments
</title>

<link rel="stylesheet" href="../study_styles/pure-release-0.5.0/buttons.css">
<link rel="stylesheet" href="../study_styles/pure-release-0.5.0/forms.css">
<link rel="stylesheet" href="../study_styles/custom/text.css">

<script type="text/javascript" src="js/util.js"></script>
</head>
<body class="body">
	<center><h2>Comments</h2></center>

<center>
	<br/>
	<form action="q_comments.php" method="post" onsubmit="return validate(this)">
      <table class="body" width=85%>
		<tr><td colspan=3>You're almost done!  Please provide any remaining thoughts and comments.</td></tr>
		<tr><td><br/></td></tr>
		<tr>
			<td colspan=2 align=left>
			<br/>
			Comments on search task:
			<br/>
			<textarea name="taskComments" cols=55 rows=3></textarea>
			</td>
		</tr>
		<tr>
			<td colspan=2 align=left>
			<br/>
			Comments on search experience:
			<br/>
			<textarea name="searchExpComments" cols=55 rows=3></textarea>
			</td>
		</tr>
		<tr>
			<td colspan=2 align=left>
			<br/>
			Comments on system (search, editor, toolbar, sidebar, snippets):
			<br/>
			<textarea name="systemComments" cols=55 rows=3></textarea>
			</td>
		</tr>
		<tr>
			<td colspan=2 align=left>
			<br/>
			Any issues encountered:
			<br/>
			<textarea name="issuesComments" cols=55 rows=3></textarea>
			</td>
		</tr>
		<tr>
			<td colspan=2 align=left>
			<br/>
			General comments:
			<br/>
			<textarea name="generalComments" cols=55 rows=3></textarea>
			</td>
		</tr>
		<tr><td colspan=3><br/></td></tr>
		<tr><td colspan=3 align=center><br/><input type="hidden" name="comments" value="true"/>
			<input type="hidden" name="localTime" value=""/>
			<input type="hidden" name="localDate" value=""/>
			<input type="hidden" name="localTimestamp" value=""/>
<button type="submit" class="pure-button pure-button-primary">Submit</button>

		</td></tr>
 	  </table>
	</form>
	<br/>
</center>
</body>
</html>
<?php
		}
	}
	else {
		echo "<tr><td>Something went wrong. Please <a href=\"../index.php\">try again</a>.</td></tr>\n";
	}

?>
