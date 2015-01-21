<?php
require_once('core/Connection.class.php');

$query = "SELECT COUNT(*) AS num_recruits FROM recruits";
$connection = Connection::getInstance();			
$results = $connection->commit($query);
$line = mysql_fetch_array($results, MYSQL_ASSOC);
$num_recruits = $line['num_recruits'];
    $recruit_limit =72; // Current Recruitment Limit as of 10/6/2014
    
$closed=false;


if($num_recruits<=$recruit_limit && !$closed)
{

?>
<html>
<head>
	<title>
    	Interactive Search Study: Introduction
    </title>
    <link rel="stylesheet" type="text/css" href="styles.css" />
<script type="text/javascript">
	
	var alertColor = "Red";
	var okColor = "White";
	

	function validateForm(form)
	{
		var isValid = 1;
		form.action = "consent.php";
	}



</script>
<style type="text/css">
		.cursorType{
		cursor:pointer;
		cursor:hand;
		}
</style>
</head>
<body class="style1">
<br/>
<div id="signupIntro" align="center">
	<h3>Interactive Search Study: Introduction</h3>
	<form method="post" onsubmit="return validateForm(this)">
		<table class="style1" width=90%>
			<tr>
			  <td colspan=2>
				<ul>
				<li>By participating in this study you will perform online research using an experimental browser plug-in, answer some questionnaires, and be interviewed briefly.</li>
				<li>The study will take place in Room 413 of Alexander Library.</li>
				<li>The study consists of one hour-long session.</li>
				<li>You will receive <strong>$10 cash</strong> for participating in the session.</li>
				<li>Note that you will be eligible for compensation only if you complete the session and follow all guidelines.</li>
				<li>You can participate <strong>only once</strong> in this study.</li>
				<li>Please note that you cannot participate in this study if you already participated in the Coagmento Lab Search Study in <a href="http://coagmento.rutgers.edu/summer2012/studyInfo.php">2012</a>, <a href="http://coagmento.rutgers.edu/studyRecruitment/signup.php">2013</a>, or <a href="http://userstudy2014.coagmento.rutgers.edu/userstudy2014/signup_intro.php">Summer 2014</a>.</li>
				<li>You <strong>must be an undergraduate student</strong> to be eligible to participate in this study.</li>
				<li>Proficiency in English is required.</li>
				<li>Intermediate typing and online search skills are required.</li>
                <li><strong>You must currently be enrolled in 01:355:201 Research in the Disciplines.</strong></li>
                <li>No identifying information about you will be shared.</li>

				</ul>
<p>Choosing or declining to participate in this study will not affect your class standing or grades at Rutgers. You will not be offered or receive any special consideration if you take part in this research; it is purely voluntary. This study has been approved by the Rutgers Institutional Review Board (IRB Study #E13-046), and will be supervised by Dr. Chirag Shah (chirags@rutgers.edu) at the School of Communication and Information.</p>
				</td>
			</tr>
<!-- 
Registration
-->
                  
                                                                                                                                                                                                                                                                                                                </table>
                                                                                                                                                                                                                                                                                                                <hr>
                                                                                                                                                                                                                                                                                                                <table>
			<tr>
				<td>
                                                                                                                                                                                                                                                                                                                <tr>
                                                                                                                                                                                                                                                                                                                <td align="center" colspan=2>To continue with the participation registration, please click on the continue button.</td></tr>
						
				<tr>
                    
					<td align="center" colspan=2>
						<input type="submit" value="Continue" style="width:100px; height:40px;" />
					</td>
				</tr>	
				</td>
			</tr>
		</table>
    </form>
</div>
</body>
</html>
<?php
}

else if (!$closed)
{
echo "<html>\n";
echo "<head>\n";
echo "<title>Interactive Search Study: Currently Closed</title>\n";
echo "</head>\n";
echo "<body>\n";
echo "<p style='background-color:red;'>Sorry! The user study registration is currently closed.</p>\n";
echo "<br/><br/>\n";
echo "<hr/>\n";
echo "<p>The number of participants required has been reached at this point.</p>\n";
echo "<p>If more user participation is required, we will reopen the study registration and send another round of recruitment emails.</p>\n";
echo "<hr/>\n";
echo "</body>";
echo "</html>";
                                                                                                                                                                                                                                                                                                                                         }else{
                                                                                                                                                                                                                                                                                                                                         echo "<html>\n";
                                                                                                                                                                                                                                                                                                                                         echo "<head>\n";
                                                                                                                                                                                                                                                                                                                                         echo "<title>Interactive Search Study: Currently Closed</title>\n";
                                                                                                                                                                                                                                                                                                                                         echo "</head>\n";
                                                                                                                                                                                                                                                                                                                                         echo "<body class=\"body\">\n<center>\n<br/><br/>\n";
                                                                                                                                                                                                                                                                                                                                         echo "<table class=body align=center>\n";
                                                                                                                                                                                                                                                                                                                                         echo "<tr><td align=center>Our study is currently closed at this time, and we are currently not accepting new recruits.  We apologize for any inconvenience.</td></tr>\n";
                                                                                                                                                                                                                                                                                                                                         echo "</table></body>\n";
                                                                                                                                                                                                                                                                                                                                         echo "</html>";
                                                                                                                                                                                                                                                                                                                 
                                                                                                                                                                                                                                                                                                                 }

?>


