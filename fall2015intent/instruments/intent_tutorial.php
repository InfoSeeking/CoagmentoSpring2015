<?php
	session_start();
	require_once('../core/Base.class.php');
	require_once('../core/Util.class.php');

	Util::getInstance()->checkSession();

	if (Util::getInstance()->checkCurrentPage(basename( __FILE__ )))
	{
		$collaborativeStudy = Base::getInstance()->getStudyID();

		if (isset($_POST['intent_tutorial']))
		{
			$base = new Base();
			$stageID = $base->getStageID();
            $localTime = $_POST['localTime'];
            $localDate = $_POST['localDate'];
            $localTimestamp = $_POST['localTimestamp'];

            Util::getInstance()->saveActionWithLocalTime(basename( __FILE__ ),$stageID,$base,$localTime,$localDate,$localTimestamp);
			Util::getInstance()->moveToNextStage();
		}
		else
		{
?>
<html>
<head>
<title>Intention Annotation Tutorial
</title>

</head>
<link rel="stylesheet" href="../study_styles/pure-release-0.5.0/buttons.css">
<link rel="stylesheet" href="../study_styles/pure-release-0.5.0/forms.css">
<link rel="stylesheet" href="../study_styles/custom/text.css">

<script type="text/javascript">
	function validate(form)
	{
		if (!form.confirmReadInstructions.checked)
		{
			document.getElementById("alert").style.display = "block";
			return false;
		}
		else{
            var currentTime = new Date();
            var month = currentTime.getMonth() + 1;
            var day = currentTime.getDate();
            var year = currentTime.getFullYear();
            var localDate = year + "/" + month + "/" + day;
            var hours = currentTime.getHours();
            var minutes = currentTime.getMinutes();
            var seconds = currentTime.getSeconds();
            var localTime = hours + ":" + minutes + ":" + seconds;
            var localTimestamp = currentTime.getTime();

            document.getElementById("localTimestamp").value = localTimestamp;
            document.getElementById("localDate").value = localDate;
            document.getElementById("localTime").value = localTime;
			return true;
        }
	}

	function complete(check)
	{
		if (check.checked)
		{
			document.getElementById("complete").style.display = "block";
			document.getElementById("alert").style.display = "none";
		}
		else
		{
			document.getElementById("complete").style.display = "none";
			document.getElementById("alert").style.display = "block";
		}
	}
</script>
<body class="body">
<center>
	<br/>
	<form class="pure-form" action="intent_tutorial.php" method="post" onsubmit="return validate(this)">
		<table class="body" width="90%">
		<tr><th><h2>Intention Annotation Tutorial</h2></th></tr>
		<tr><td><hr/></td></tr>
		<tr>
			<td>

				<?php
				if(Base::getInstance()->getStageID()<30)
				{
				?>
				You are about to annotate the task you just completed.  Please watch the video below and listen to the instructions carefully.
				<?php
				}
				else
				{
				?>
				Below is the video that you saw before for intention annotation.  You may review this video again if you wish.  Otherwise, please click the checkbox below and press 'Continue'.
				<?php
				}
				?>


				<center>
					<video id='session_video' width='100%' controls>
						<source id='mp4source' type='video/mp4' src='../tutorial/intent_tutorial.mp4' >
					</video>
			</center>
				<center>
					<p>
						<strong>After you have watched this video, please check the option below and press "Continue." Have fun!</strong>
					</p>
				</center>
			</td>
		</tr>
		<tr><td><hr/></td></tr>
		<tr><td><div style="display: none; background: Red; text-align:center;" id="alert"><strong>Before you continue, you must watch the above video. Once you have watched and understood the video, click on the box below and then continue.</strong></div></td></tr>
		<tr><td><div style="display: none; background: LightGreen; text-align:center;" id="complete"><strong>Good! Click on Continue</strong></div></td></tr>
		<tr><td align=center><input type="checkbox" name="confirmReadInstructions" value="true" onclick="complete(this)"/>I have watched and understood the above video</td></tr>
		<tr><td><br/><input type="hidden" id="localTimestamp" name="localTimestamp" value=""/><input type="hidden" id="localTime" name="localTime" value=""/><input type="hidden" id="localDate" name="localDate" value=""/></td></tr>
		<tr><td align=center><input type="hidden" name="intent_tutorial" value="true"/><button type="submit" class="pure-button pure-button-primary" >Continue</button></td></tr>
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
		echo "Something went wrong. Please <a href=\"../index.php\">try again </a>.\n";
	}

?>
