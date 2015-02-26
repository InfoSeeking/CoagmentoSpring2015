<?php
require_once('core/Connection.class.php');

//$query = "SELECT COUNT(*) AS num_recruits FROM recruits";
//$connection = Connection::getInstance();			
//$results = $connection->commit($query);
//$line = mysql_fetch_array($results, MYSQL_ASSOC);
$num_recruits = 0;
    $recruit_limit =100; // Current Recruitment Limit as of 10/6/2014
    
$closed=true;

    
//$query = "SELECT a.ct as k, COUNT(a.ct) as v from (SELECT projectID, COUNT(projectID) as ct FROM recruits GROUP BY projectID) a GROUP BY a.ct";
//$connection = Connection::getInstance();
//$results = $connection->commit($query);
//    
//    $ct_array = array();
//
//    while($line = mysql_fetch_array($results, MYSQL_ASSOC)){
//        if($line['k'] == 1 && $line['v'] < 21){
//            $closed = false;
//        }
//        else if($line['k'] == 2 && $line['v'] < 14){
//            $closed = false;
//        }
//        $ct_array[$line['k']] = $line['v'];
//    }
    
    $closed = false;
    
if($num_recruits<=$recruit_limit && !$closed)
{

?>
<html>
<head>
	<title>
    	Collaborative Search Study: Introduction
    </title>
    <link rel="stylesheet" type="text/css" href="styles.css" />
<script type="text/javascript">
	
	var alertColor = "Red";
	var okColor = "White";
	

	function validateForm(form)
	{
		var isValid = 1;
		form.action = "signup.php";
        return true;
        
//        var radios = document.getElementsByName('num_users');
//        if (radios.length >=2){
//            isValid &= isRadioSelected(form.num_users);
//        }else{
//            isValid &= radios[0].checked;
//        }
//        
//        
//        if (isValid==1)
//		{
//			document.getElementById("alertForm").style.display = "none";
//			return true;
//		}
//		else
//		{
//			document.getElementById("alertForm").style.display = "block";
//			return false;
//		}
	}

function isRadioSelected(radioButtons, obj)
{
    for (i=radioButtons.length-1; i > -1; i--)
        if (radioButtons[i].checked)
        {
            return true;
        }
    
    return false;
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
	<h3>Collaborative Search Study: Introduction</h3>
	<form method="post" onsubmit="return validateForm(this)">
		<table class="style1" width=90%>
			<tr>
			  <td colspan=2>
				<ul>
				<li>Welcome! This is a sign-up form for participating in a research study. By filling in this form, you are submitting a request to participate.</li>
				<li>By participating in this study you will perform online research using an experimental browser plug-in, answer some questionnaires, and be interviewed briefly.</li>
				<li>You will use the Coagmento collaborative search system while you work on your group project on IT Market Sector Analysis report.</li>
				<li>You will receive <strong>$40 cash</strong> for participating in the study.</li>
                <li>Your group is also eligible for an additional <strong>$20 cash prize per person</strong> for best performance, measured by amount of activity using the Coagmento tool.</li>
				<li>Note that you will be eligible for compensation only if you complete the study and follow all guidelines.</li>
                <li><strong>You must currently be enrolled in 04:547:220 Retrieving and Evaluating Electronic Information.</strong></li>
                <!--<li>Please note that you cannot participate in this study if you already participated in the Coagmento Lab Search Study in <a href="http://coagmento.rutgers.edu/summer2012/studyInfo.php">2012</a>, <a href="http://coagmento.rutgers.edu/studyRecruitment/signup.php">2013</a>, or <a href="http://userstudy2014.coagmento.rutgers.edu/userstudy2014/signup_intro.php">Summer 2014</a>.</li>
				<li>You <strong>must be an undergraduate student</strong> to be eligible to participate in this study.</li>-->
				<li>You must be at least 18 years old to participate.</li>
				<li>Proficiency in English is required.</li>
				<li>Intermediate typing and online search skills are required.</li>
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
                                                                                                                                                       
                                                                                                                                                                                                                                                                                                                </table>
                                                                                                                                                                                                                                                                                                
                                                                                                                                                                                                                                                                                                                <table class="style1" width=90%>
                                                                                                                                                                                                                                                                                                                <tr>
                                                                                                                                                                                                                                                                                                                <td align="center" colspan=2>
                                                                                                                                                                                                                                                                                                                <div style="display: none; background: Red; text-align:center;" id="alertForm"><strong>Please Complete Select the Number of Participants and Try Again</strong></div>
                                                                                                                                                                                                                                                                                                                </td>
                                                                                                                                                                                                                                                                                                                </tr>
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
echo "<title>Collaborative Search Study: Currently Closed</title>\n";
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


