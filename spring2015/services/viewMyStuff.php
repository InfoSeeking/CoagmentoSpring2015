<?php
	session_start();
	require_once('../core/Base.class.php');
	require_once('../core/Connection.class.php');
	require_once('../core/Util.class.php');

    $base = new Base();

	if ($base->isSessionActive())
	{
		$userID = $base->getUserID();
		$projectID=$base->getProjectID();
//			$localTime = $_GET['localTime'];
//			$localDate = $_GET['localDate'];
//			$localTimestamp = $_GET['localTimestamp'];

      //   $userID = $base->getUserID();
      //   $query = "SELECT numUsers from users WHERE userID='$userID'";
      //   $connection = Connection::getInstance();
      //   $results = $connection->commit($query);
      //   $line = mysql_fetch_array($results,MYSQL_ASSOC);
      //   $num_users = $line['numUsers'];
			//
      //   	$stageID = $base->getStageID();
			// $userID=$base->getUserID();
      //       $projectID=$base->getProjectID();
			// $qIDQuery = "SELECT questionID
			// 			FROM questions_progress
			// 			WHERE projectID=$projectID AND stageID=$stageID AND responses=0";
			//
			//
			// $connection = Connection::getInstance();
			// $qIDresults = $connection->commit($qIDQuery);
			// $numRows = mysql_num_rows($qIDresults);
			// $qIDline = mysql_fetch_array($qIDresults, MYSQL_ASSOC);
			// $questionID = $qIDline['questionID'];



//        	Util::getInstance()->saveActionWithLocalTime("View My Task",$questionID,$base,$localTime,$localDate,$localTimestamp);

      //  	 	$query = "SELECT question
      //  	 				FROM questions_study
      //  	 				WHERE questionID = $questionID";
			//
 		// 	$results = $connection->commit($query);
			// $numRows = mysql_num_rows($results);
			//
			// if ($numRows>0)
			// {
        		$base = Base::getInstance();
                $connection = Connection::getInstance();
                $userID = $base->getUserID();
                $userID = $base->getProjectID();
                $query = "SELECT Q.question as question,Q.questionID as questionID FROM recruits R,questions_study Q WHERE  R.instructorID+1=Q.questionID ORDER BY recruitsID ASC";
                $results = $connection->commit($query);
                $question1 = '';
                $line = mysql_fetch_array($results,MYSQL_ASSOC);
								$question1 = $line['question'];
								$questionID = $line['questionID'];
								Util::getInstance()->saveAction("View My Task",$questionID, $base);


?>

<html>
    <head>
		<title>View My Task</title>
<link rel="stylesheet" href="../study_styles/custom/background.css">
    </head>
	<!--<script type="text/javascript" src="js/utilities.js"></script>-->
<body>
			<div class="grayrect">
<span>
<?php
    echo $question1;
    ?>
</span>
</div>
</body>
</html>

<?php

			// }


	}
?>
