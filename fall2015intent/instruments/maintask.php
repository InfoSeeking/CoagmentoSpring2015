<?php
	session_start();
	require_once('../core/Base.class.php');
	require_once('../core/Util.class.php');
	require_once('../core/Connection.class.php');

	Util::getInstance()->checkSession();

	if (Util::getInstance()->checkCurrentPage(basename( __FILE__ )))
	{
		$collaborativeStudy = Base::getInstance()->getStudyID();

		if (isset($_POST['maintask']))
		{
      $localTime = $_POST['localTime'];
			$localDate = $_POST['localDate'];
			$localTimestamp =  $_POST['localTimestamp'];

			$base = new Base();
			$stageID = $base->getStageID();
			Util::getInstance()->saveActionWithLocalTime(basename( __FILE__ ),$stageID,$base,$localTime,$localDate,$localTimestamp);
			Util::getInstance()->moveToNextStage();
		}
		else if(isset($_GET['answer'])){
			$base = new Base();
			$stageID = $base->getStageID();
			Util::getInstance()->saveActionWithLocalTime(basename( __FILE__ ),$stageID,$base);
			Util::getInstance()->moveToNextStage();
		}
		else
		{

			$_SESSION['refreshQuestionSidebar'] = 1;
			$base = new Base();
			$userID = $base->getUserID();
			$stageID = $base->getStageID();
			$projectID = $base->getProjectID();





			$part_text = "";
			if($stageID > 35){
				$part_text = "Part 2 - ";
			}
            ?>
<html>
<head>
<title>Research Study</title>

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
	<div style="width:90%; margin: 0 auto">
		<center><h2><?php echo $part_text;?>Search Task</h2></center>
<form action="maintask.php" method="post" onsubmit="return validate(this)">


<p>Below is the same task that you were shown before.  If you have not done so, please read it carefully.  You can also review this by clicking the "Assignment" button in your toolbar.</p>

<strong><p>You have approximately 20 minutes to search.  You may open new tabs when searching, but please do not open new browser windows.</p></strong>




	<div class="grayrect">
		<span>
			<?php

			$base = Base::getInstance();
			$userID = $base->getUserID();
			$connection = Connection::getInstance();

			$topicAreaID = $base->getTopicAreaID();

			$questionID = $topicAreaID+1;
			if($base->getStageID() == 15){
				$questionID = $topicAreaID+1;
			}else if($base->getStageID() == 45){
				$questionID = $topicAreaID+4+1;
			}


			$query = "SELECT Q.question as question,Q.questionID as questionID FROM questions_study Q WHERE Q.questionID=$questionID";
			$results = $connection->commit($query);
			$question1 = '';
			$line = mysql_fetch_array($results,MYSQL_ASSOC);
			$question1 = $line['question'];

			$base->setQuestionID($questionID);
			$base->setQuestion($question1);
			$base->setQuestionStartTimestamp($base->getTimestamp());


			$qQuery = "SELECT question, answer, altAnswer
			FROM questions_study
			WHERE questionID = '$questionID'
			AND topicAreaID = $topicAreaID"; //Added topic area ID

			$connection = Connection::getInstance();
			$results = $connection->commit($qQuery);
			$line = mysql_fetch_array($results, MYSQL_ASSOC);
			$question = $line['question'];
			$answer = $line['answer'];
			$altAnswer = $line['altAnswer'];




			echo $question1;


			?>
		</span>
	</div>


<p>
	 <strong>DO NOT CLICK 'FINISH' UNTIL INSTRUCTED</strong>.  If you delete this tab, you may find revisit it by clicking the 'Home' button.
</p>


<center>
<table>
<tr><td align=center>
<input type="hidden" name="maintask" value="true"/>
<input type="hidden" name="localTime" value=""/>
<input type="hidden" name="localDate" value=""/>
<input type="hidden" name="localTimestamp" value=""/>
<button type="submit" id="continue_button" class="pure-button pure-button-primary" style="background: rgb(202, 60, 60);">Finish</button></td></tr>
</table>
</center>
</form>
</div>
</body>
</html>
<?php
    }
	}
	else {
		echo "Something went wrong. Please <a href=\"../index.php\">try again </a>.\n";
	}

    ?>
