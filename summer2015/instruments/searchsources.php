<?php
	session_start();
	require_once('../core/Base.class.php');
	require_once('../core/Util.class.php');
	require_once('../core/Connection.class.php');

	Util::getInstance()->checkSession();

	if (Util::getInstance()->checkCurrentPage(basename( __FILE__ )))
	{
		$collaborativeStudy = Base::getInstance()->getStudyID();

		if (isset($_POST['searchsources']))
		{
      $localTime = $_POST['localTime'];
			$localDate = $_POST['localDate'];
			$localTimestamp =  $_POST['localTimestamp'];

			$base = new Base();
			$stageID = $base->getStageID();
			Util::getInstance()->saveActionWithLocalTime(basename( __FILE__ ),$stageID,$base,$localTime,$localDate,$localTimestamp);
			Util::getInstance()->moveToNextStage();
		}
		else
		{
            ?>
<html>
<head>
<title>Search Sources</title>

</head>

<link rel="stylesheet" href="../study_styles/pure-release-0.5.0/buttons.css">
<link rel="stylesheet" href="../study_styles/pure-release-0.5.0/forms.css">
<link rel="stylesheet" href="../study_styles/custom/text.css">
<link rel="stylesheet" href="../study_styles/custom/background.css">
<script type="text/javascript" src="js/util.js"></script>
<script type="text/javascript">


function validate(form)
{
    return confirm("Are you sure you want to proceed?  If you do, you'll be unable to complete the task.");
}


</script>
<body class="body">
<form action="searchsources.php" method="post" onsubmit="return validate(this)">


<p>Now, please search online for relevant sources that are not already saved by your group, and Bookmark them using the toolbar.
Also collect relevant snippets from those sources that help you address what is needed for this task.
Try to find sources and snippets that are good quality for use in the group report.</p>

<p>Below is the task description once more.  You can review the assignment description by clicking the Assignment button.</p>

<p>You can open new tabs for searching. Do not open a new window.</p>




	<div class="grayrect">
		<span>
			<?php

			$base = Base::getInstance();
			$userID = $base->getUserID();
			$connection = Connection::getInstance();
			$query = "SELECT userID, topicAreaID
						FROM users
						WHERE userID='$userID'";
			$results = $connection->commit($query);
			$line = mysql_fetch_array($results,MYSQL_ASSOC);
			$topicAreaID = $line['topicAreaID'];


			$query = "SELECT Q.question as question FROM questions_study Q WHERE Q.questionID=$topicAreaID+1";
			$results = $connection->commit($query);
			$question1 = '';
			$line = mysql_fetch_array($results,MYSQL_ASSOC);
			$question1 = $line['question'];


			echo $question1;


			?>
		</span>
	</div>

<p>
	Click 'Finish' <strong>only when you have completed your search<strong>.  If you delete this tab, you may find revisit it by clicking the 'Home' button.
</p>


<center>
<table>
<tr><td align=center>
<input type="hidden" name="searchsources" value="true"/>
<input type="hidden" name="localTime" value=""/>
<input type="hidden" name="localDate" value=""/>
<input type="hidden" name="localTimestamp" value=""/>
<button type="submit" id="continue_button" class="pure-button pure-button-primary">Finish</button></td></tr>
</table>
</center>
</form>
</body>
</html>
<?php
    }
	}
	else {
		echo "Something went wrong. Please <a href=\"../index.php\">try again </a>.\n";
	}

    ?>
