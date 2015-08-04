<?php
	session_start();
	require_once('../core/Base.class.php');
	require_once('../core/Util.class.php');
	
	Util::getInstance()->checkSession();
	
	if (Util::getInstance()->checkCurrentPage(basename( __FILE__ )))
	{ 
		$collaborativeStudy = Base::getInstance()->getStudyID();
	
		if (isset($_POST['welcome'])) 
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
<title>Overview
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
	<form class="pure-form" action="welcome.php" method="post" onsubmit="return validate(this)">
		<table class="body" width="90%">
		<tr><th><h2>Library Research Study: Overview</h2></th></tr>
		<tr><td><hr/></td></tr>
		<tr>
			<td>
				<?php
				if(Base::getInstance()->getStageID()<120)
				{
				?>
				<ul>
				<li>Thank you for signing up for this study. We appreciate your participation!</li>					
				<li>The first step is to answer a few questions about your background experiences. For questionnaires, there are no right nor wrong answers, so simply respond as honestly as you can.</li>					
				<li>Next there will be a brief demo of how to use the <strong>Coagmento</strong> online research tool</li>				
				<li>Then you will have <strong>40 minutes</strong> to use the <strong>Coagmento</strong> tool to help you research. Use the library website to search for sources for your research paper</li>
				<li>At the end of 40 minutes, there will be another questionnaire, followed by a short group discussion about your experience.</li>
				<li>Once you complete the entire study session, you will be paid your cash incentive for participating.</li>
				<li>If you have any questions, please ask the researcher.</li>
				</ul>
				<?php
				}
				else
				{
				?>
				<ul>
				<li>This is the <strong>second session</strong>. </li>
				<li>During this study session, you will be asked to fill questionnaires at different moments. <strong>Please read the instructions of each questionnaire carefully</strong>.</li>					
				<li><strong>For questionnaires, there are no right nor wrong answers, so simply respond as honestly as you can</strong>.</li>					
				<li>You can watch the video tutorial, if you would like to be reminded of the usage of the system again.</li>				
				<li>In this session you will have to perform <strong>one</strong> search task for 1-2 hours and answer some pre and post questionnaires.</li>
				<li>After successful completion of this session, you would be entitled for $20 worth Amazon gift card, which would be emailed to you. </li>
				<li><strong>THE PRIZE:</strong> If you become one of the the best performing individuals YOU CAN WIN an additional $20 worth Amazon gift card. YOU CAN MAKE IT, DO YOUR BEST!</strong></li>
				</ul>
				<?php
				}
				?>
				<center>
					<p>
						<strong>If you have read these instructions, please check the option below and press "Continue." Have fun!</strong>
					</p>
				</center>
			</td>
		</tr>	
		<tr><td><hr/></td></tr>
		<tr><td><div style="display: none; background: Red; text-align:center;" id="alert"><strong>Before you continue, you must read all the above instructions. Once you have read them, click on the box below and then continue.</strong></div></td></tr>
		<tr><td><div style="display: none; background: LightGreen; text-align:center;" id="complete"><strong>Good! Click on Continue</strong></div></td></tr>	        	
		<tr><td align=center><input type="checkbox" name="confirmReadInstructions" value="true" onclick="complete(this)"/>I have read all the above instructions</td></tr>
		<tr><td><br/><input type="hidden" id="localTimestamp" name="localTimestamp" value=""/><input type="hidden" id="localTime" name="localTime" value=""/><input type="hidden" id="localDate" name="localDate" value=""/></td></tr>
		<tr><td align=center><input type="hidden" name="welcome" value="true"/><button type="submit" class="pure-button pure-button-primary" >Continue</button></td></tr>
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
