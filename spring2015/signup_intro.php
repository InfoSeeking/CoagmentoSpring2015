<?php
require_once('core/Connection.class.php');

$query = "SELECT COUNT(*) AS num_recruits FROM recruits";
$connection = Connection::getInstance();			
$results = $connection->commit($query);
$line = mysql_fetch_array($results, MYSQL_ASSOC);
$num_recruits = $line['num_recruits'];
    $recruit_limit =72; // Current Recruitment Limit as of 10/6/2014
    
$closed=true;

    
$query = "SELECT a.ct as k, COUNT(a.ct) as v from (SELECT projectID, COUNT(projectID) as ct FROM recruits GROUP BY projectID) a GROUP BY a.ct";
$connection = Connection::getInstance();
$results = $connection->commit($query);
    
    $ct_array = array();

    while($line = mysql_fetch_array($results, MYSQL_ASSOC)){
        if($line['k'] == 1 && $line['v'] < 21){
            $closed = false;
        }
        else if($line['k'] == 2 && $line['v'] < 14){
            $closed = false;
        }
        $ct_array[$line['k']] = $line['v'];
    }
    
    $closed = true;
    
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
		form.action = "signup.php";
        
        var radios = document.getElementsByName('num_users');
        if (radios.length >=2){
            isValid &= isRadioSelected(form.num_users);
        }else{
            isValid &= radios[0].checked;
        }
        
        
        if (isValid==1)
		{
			document.getElementById("alertForm").style.display = "none";
			return true;
		}
		else
		{
			document.getElementById("alertForm").style.display = "block";
			return false;
		}
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
	<h3>Interactive Search Study: Introduction</h3>
	<form method="post" onsubmit="return validateForm(this)">
		<table class="style1" width=90%>
			<tr>
			  <td colspan=2>
				<ul>
				<li>This is a sign-up form for participating in a research study. By filling in this form, you are submitting a request to participate.</li>
				<li>By participating in this study you will perform online research using an experimental browser plug-in, answer some questionnaires, and be interviewed briefly.</li>
				<li>The study will take place in Room 413 of Alexander Library.</li>
				<li>The study consists of one hour-long session.</li>
				<li>You will receive <strong>$15 cash</strong> for participating in the session, if you sign up individually.</li>
                <li>If you sign up as a pair, each member will receive <strong>$20 cash</strong> for participating in the session.</li>
                <li>You are eligible for a cash <strong>$20 first prize</strong> and <strong>$10 second prize</strong> for best performers, both individuals and pairs (two prizes for individuals and two prizes for pairs).</li>
				<li>Note that you will be eligible for compensation only if you complete the session and follow all guidelines.</li>
				<li>You can participate <strong>only once</strong> in this study.</li>
				<li>Please note that you cannot participate in this study if you already participated in the Coagmento Lab Search Study in <a href="http://coagmento.rutgers.edu/summer2012/studyInfo.php">2012</a>, <a href="http://coagmento.rutgers.edu/studyRecruitment/signup.php">2013</a>, or <a href="http://userstudy2014.coagmento.rutgers.edu/userstudy2014/signup_intro.php">Summer 2014</a>.</li>
				<li>You <strong>must be an undergraduate student</strong> to be eligible to participate in this study.</li>
				<li>Proficiency in English is required.</li>
				<li>Intermediate typing and online search skills are required.</li>
                <li><strong>You must currently be enrolled in 04:192:201 Communication in Relationships.</strong></li>
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
                                                                                                                                                                                                                                                                                                                <td align="center" colspan=2>To continue with the participation registration, please select the number of registrants (individual or pair), then click on the continue button.</td></tr>
						
                                                                                                                                                                                                                                                                                                                <tr>
                                                                                                                                                       
                                                                                                                                                                                                                                                                                                                </table>
                                                                                                                                                                                                                                                                                                                <table>
<?php
                                                                                                                                                                                                                                                                                                                if($ct_array[1]<21){                                                                                                                                                                                                                                             ?><td align="center">
                                                                                                                                                                                                                                                                                                                <input type="radio" name="num_users" value="1" style="width:100px; height:40px;" /></td><td>Individual (1 Registrant)
                                                                                                                                                                                                                                                                                                                </td><?php
                                                                                                                                                                                                                                                                                                                }else{
                                                                                                                                                                                                                                                                                                                
                                                                                                                                                                                                                                                                                                                ?><td align="center">
                                                                                                                                                                                                                                                                                                                </td><td><strong>(Registration for single registrants is closed.)</strong>
                                                                                                                                                                                                                                                                                                                </td><?php                                                                                                                                                                     }
                                                                                                                                                                                                                                                                                                                ?>
                                                                                                                                                                                                                                                                                                                </tr>
                                                                                                                                               
                                                                                                                                                                                                                                                                                                                <tr>
                                                                                                                                                                                                                                                                                                                
                                                                                                                                                                                                                                                                                                                <?php
                                                                                                                                                                                                                                                                                                                if($ct_array[2]<14){                                                                                                                                                                                                                                             ?>                                                                                                                                                                                                                                          <td align="center">
                                                                                                                                                                                                                                                                                                                <input type="radio" name="num_users" value="2" style="width:100px; height:40px;" /></td><td>Pair (2 Registrants)
                                                                                                                                                                                                                                                                                                                </td>
                                                                                                                                                                                                                                                                                                                <?php
                                                                                                                                                                                                                                                                                                                }else{
                                                                                                                                                                                                                                                                                                                ?><td align="center">
                                                                                                                                                                                                                                                                                                                </td><td><strong>(Registration for pairs is closed.)</strong>
                                                                                                                                                                                                                                                                                                                </td><?php
                                                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                                                ?>
                                                                                                                                                                                                                                                                                                                </tr>
                                                                                                                                                                                                                                                                                                                
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


