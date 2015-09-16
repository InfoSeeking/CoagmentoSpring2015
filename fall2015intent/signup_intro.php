<?php
require_once('core/Connection.class.php');


$num_recruits = 0;
    $recruit_limit =60; // Current Recruitment Limit as of 10/6/2014

$closed=true;


function availableDates(){
  $cxn = Connection::getInstance();
  $query = "SELECT * FROM questionnaire_questions WHERE `key`='date_firstchoice' AND questionID=1038 AND question_cat='fall2015intent'";
  $results = $cxn->commit($query);
  $line = mysql_fetch_array($results, MYSQL_ASSOC);
  $js = json_decode($line['question_data']);
  $dates_available = array();
  foreach($js->{'options'} as $key=>$val){
    array_push($dates_available,$val);
  }





  $query = "SELECT * FROM recruits WHERE firstpreference != ''";
  $results = $cxn->commit($query);
  $dates_taken = array();
  while($line = mysql_fetch_array($results, MYSQL_ASSOC)){
    array_push($dates_taken,$line['firstpreference']);
  }


  return array_diff($dates_available,$dates_taken);

}


function allSlotsTaken(){
  return count(availableDates()) <= 0;
}
    $closed = false;

if($num_recruits<=$recruit_limit && !allSlotsTaken() &&!$closed)
{

?>
<html>
<head>
	<title>
    Research Study Registration: Introduction
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
	<h3>Research Study Registration</h3>
	<form method="post" onsubmit="return validateForm(this)">
		<table class="style1" width=90%>
			<tr>
			  <td colspan=2>

          <p>Welcome! This is the sign-up form to register for the paid research study.</p>
          <p>The research project, <em>Information Seeking Intentions</em>, seeks Journalism/Media Studies students as participants in a study of information seeking.  Participants will conduct searches in an experimental setting for information relating to several different kinds of search tasks related to journalism tasks.
          Each experimental session will last <strong>about two and a half hours</strong>, and will be held in the Communication and Interaction Laboratory in the SCI building.  Participants will be asked to complete the background questionnaire about their expectations for each task and then conduct a search.
          After the search session participants will be asked to evaluate the information that they found and explain their search intentions at selected points.  Various aspects of their searching behaviros will be recorded for subsequent analysis.</p>

          <p>All volunteers for this study will receive a <strong>$30 Amazon gift card</strong> for their participation, and those judged to have performed the best searches will receive <strong>an additional $10</strong>. Taking part in this study will help to advance the understanding of the search process and contribute towards development of search systems taht can automatically adapt to a user's specific search goals.</p>

          <p>Requirements:
            <ul>
              <li>You must be at least 18 years old to participate.</li>
              <li>Proficiency in English is required.</li>
              <li>Intermediate typing and online search skills are required.</li>
              <li>Normal to corrected vision is required.</li>
              <li>You must have <em>already completed</em>either 04:567:200 (Writing for Media) or 04:567:324 (News Reporting and Writing).</li>
            </ul>
          </p>

          <!-- <p>During this study you will perform online research using an eye tracker and experimental browser plug-in and answer questionnaires.</p>
          <p>The study will last approximately 150 minutes and take place in the School of Communication and Information building.</p>
          <p>You will receive <strong>$40 cash</strong> for participating in the study.</p> -->


          <!-- <p>Requirements:
            <ul>
              <li>You must be at least 18 years old to participate.</li>
              <li>Proficiency in English is required.</li>
              <li>Intermediate typing and online search skills are required.</li>
              <li>Normal to corrected vision is required.</li>

            </ul>
          </p> -->



          <p>Choosing or declining to participate in this study will not affect your class standing or grades at Rutgers.
            You will not be offered or receive any special consideration if you take part in this research; it is purely voluntary.
            This study has been approved by the Rutgers Institutional Review Board (IRB Study #E14-136),
            and will be supervised by Dr. Nicholas Belkin (belkin@rutgers.edu) and Dr. Chirag Shah (chirags@rutgers.edu)
            at the School of Communication and Information.</p>
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
