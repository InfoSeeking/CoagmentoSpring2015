<?php
	session_start();
	require_once('../core/Base.class.php');
	require_once('../core/Util.class.php');


	$base = Base::getInstance();

	if ($base->isSessionActive())
	{
		$base = new Base();
		$stageID = $base->getStageID();
?>
<html>
<head>
<title>Intention Annotation Tutorial
</title>

</head>
<link rel="stylesheet" href="../study_styles/pure-release-0.5.0/buttons.css">
<link rel="stylesheet" href="../study_styles/pure-release-0.5.0/forms.css">
<link rel="stylesheet" href="../study_styles/custom/text.css">


<body class="body">
<center>
	<br/>

		<table class="body" width="90%">
		<tr><th><h2>Intention Annotation Tutorial</h2></th></tr>
		<tr><td><hr/></td></tr>
		<tr>
			<td>

				Below is the video that was just shown to you.  You may review this video again if you wish.  Otherwise, please click the checkbox below and press 'Continue'.
				<?php
				if($stageID<25 || ($stageID>35 && $stageID<51))
				{
				?>
				<center>
					<video id='session_video' width='100%' controls>
						<source id='mp4source' type='video/mp4' src='../tutorial/system_tutorial.mp4' >
					</video>
				</center>
				<?php
				}
				else
				{
				?>
				<center>
					<video id='session_video' width='100%' controls>
						<source id='mp4source' type='video/mp4' src='../tutorial/intent_tutorial.mp4' >
					</video>
				</center>
				<?php
				}
				?>



			</td>
		</tr>
	  </table>

<br/>
</center>
</body>
</html>
<?php

	}
	else {
		echo "Something went wrong. Please <a href=\"../index.php\">try again </a>.\n";
	}

?>
