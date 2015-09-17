<?php
session_start();
require_once('core/Connection.class.php');
require_once('core/Questionnaires.class.php');

$num_recruits = 0;
$recruit_limit =60; // Current Recruitment Limit as of 07/15/2014
$section_closed = false;
$closed=true;
$closed = false;


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

  // print_r($dates_available);



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


if($num_recruits<=$recruit_limit && !allSlotsTaken() && !$closed && !$section_closed)
{
	if(1)
	{
        $NUM_USERS = 1;
        $questionnaire = Questionnaires::getInstance();
				$questionnaire->clearCache();
        $questionnaire->populateQuestionsFromDatabase("fall2015intent","questionID ASC");


	?>
<html>
<head>
  <link rel="stylesheet" href="study_styles/custom/text.css">
	<title>
			Research Study Registration
    </title>
    <link rel="stylesheet" type="text/css" href="styles.css" />

    <style>
    select {
      font-size:13px;
    }
    </style>
    <?php echo $questionnaire->printPreamble();?>


		<script type="text/javascript">
		$().ready(function(){
			$.validator.addMethod("notEqualTo", function (value, element, param)
			{
			    var target = $(param);
			    if (value) return value != target.val();
			    else return this.optional(element);
			}, "Does not match");
		});
		</script>
    <script>
    <?php

    $rules = "firstName_1: \"required\",
        lastName_1: \"required\",
				age_1: {
					required: true,
					number: true
				},
        email1_1: {
					required: true,
					email: true
				},
        reEmail_1: {
					required: true,
					email: true,
          equalTo: \"#email1_1\"
				},";
				// date_firstchoice_1: {
        //
				// 	notEqualTo: \"#date_secondchoice_1\"
				// },
				// date_secondchoice_1: {
        //
				// 	notEqualTo: \"#date_firstchoice_1\"
				// },

        $messages = "firstName_1: {required:\"<span style='color:red'>Please enter your first name.</span>\"},
            lastName_1: {required:\"<span style='color:red'>Please enter your last name.</span>\"},
						age_1: {
							required:\"<span style='color:red'>Please enter your age.</span>\",
							number:\"<span style='color:red'>Please enter a number.</span>\"
						},
            email1_1: {
    					required: \"<span style='color:red'>Please enter your e-mail address.</span>\",
    					email: \"<span style='color:red'>Please enter a valid e-mail address.</span>\"
    				},
            reEmail_1: {
    					required: \"<span style='color:red'>Please enter your e-mail address.</span>\",
    					email: \"<span style='color:red'>Please enter a valid e-mail address.</span>\",
              equalTo: \"<span style='color:red'>Please enter the same e-mail address again.</span>\",
    				},";
						// date_firstchoice_1: {
    				// 	required: \"<span style='color:red'>Please enter a date.</span>\",
						// 	notEqualTo: \"<span style='color:red'>Please enter two different dates.</span>\"
    				// },
						// date_secondchoice_1: {
						// 	required: \"<span style='color:red'>Please enter a date.</span>\",
						// 	notEqualTo: \"<span style='color:red'>Please enter two different dates.</span>\"
    				// },
    echo $questionnaire->printValidation("spr2015_regform",$rules,$messages);
    ?>


    </script>
<script type="text/javascript">
	function viewDetails(check)
	{
		if (check.checked)
			document.getElementById("singleStudyDetails").style.display = "block";
		else
			document.getElementById("singleStudyDetails").style.display = "none";
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
<div id="signupForm" align="center">
	<h3>Research Study Registration</h3>
		<table class="style1" width=90%>
			<tr>
			  <td colspan=2>
				<ul>
				<li>Use this form to register for the paid research study on <em>Information Seeking Intentions</em>.</li>
				<li>Please fill out the information below then click Submit.</li>
				<li>You will receive a confirmation email within 24-48 hours with details about time, date, and location of your session.</li>

				<li><a href="mailto:mmitsui@scarletmail.rutgers.edu?subject=Study inquiry">Contact us</a> if you have any questions.</li>
				</ul>
				</td>
			</tr>
<!--
Registration
-->
			<tr>
				<td>
					<p><strong>Check here to if you would like to read recruitment details again. </strong><input type="checkbox" name="viewInstructionsCheckSingle" id="viewInstructionsCheckSingle" onclick="viewDetails(this)" /></p>
					<br />
					<div style="display: none; background: #F2F2F2; text-align:center; border-style:solid; width:70%; border-color:blue; padding:25px;" id="singleStudyDetails">
	 					<table class="style1" width="100%">
							<tr>
								<td>


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
	  					</table>
					</div>


<form id="spr2015_regform" class="pure-form" method="post" action="signupGroup.php">
<?php
echo "<input type=\"hidden\" name=\"num_users\" value=\"$NUM_USERS\">";
for($x=1;$x<=$NUM_USERS;$x++){


  //Registration
  // echo "<table class=\"style1\" border=\"1\">";
  if($x==1 && $NUM_USERS==1){
  echo "<h3>Enter Participant details</h3>";
  // echo "<tr><th colspan=2 align=center bgcolor=\"#F2F2F2\">Enter Participant details</th></tr>";
  }else{
  echo "<h3>Participant $x</h3>";
  // echo "<tr><th colspan=2 align=center bgcolor=\"#F2F2F2\">Participant $x</th></tr>";

  }

  echo "<div class=\"pure-form-aligned\">";
  echo "<fieldset>";
  echo "<div class=\"pure-control-group\">";
  echo "<label for=\"firstName_$x\">First Name</label>";
  echo "<input id=\"firstName_$x\" name=\"firstName_$x\" type=\"text\" placeholder=\"First Name\" required>";
  echo "</div>";

  echo "<div class=\"pure-control-group\">";
  echo "<label for=\"lastName_$x\">Last Name</label>";
  echo "<input id=\"lastName_$x\" name=\"lastName_$x\" type=\"text\" placeholder=\"Last Name\" required>";
  echo "</div>";

	echo "<div class=\"pure-control-group\">";
  echo "<label for=\"age_$x\">Age</label>";
  echo "<input id=\"age_$x\" name=\"age_$x\" type=\"text\" placeholder=\"Age\" required>";
  echo "</div>";

  echo "<div class=\"pure-control-group\">";
  echo "<label for=\"email1_$x\">Rutgers Email</label>";
  echo "<input id=\"email1_$x\" name=\"email1_$x\" type=\"text\" placeholder=\"Primary Email\" required>";
  echo "</div>";

  echo "<div class=\"pure-control-group\">";
  echo "<label for=\"reEmail_$x\">Confirm Email</label>";
  echo "<input id=\"reEmail_$x\" name=\"reEmail_$x\" type=\"text\" placeholder=\"Confirm Email\" required>";
  echo "</div>";



  echo "</fieldset>";
  echo "</div>";
  if($NUM_USERS >1){
    echo "<hr>";
  }


//Demographic Survey

// echo "<hr>";
// echo "<label ><h4></h4></label>";
//
// echo "<div class=\"pure-form-stacked\">";
//
// echo "<fieldset>";
//
// // Likert
// $questionnaire->printQuestions(23,24);
//
// echo "</fieldset>";
// echo "</div>";


echo "<div class=\"pure-form-stacked\">";
echo "<fieldset>";

echo "<hr>";

// $questionnaire->printQuestions();
$questionnaire->printQuestions(0,0);

?>

<div class="pure-control-group">
<div id="date_firstchoice_1_div"><label name="date_firstchoice_1">Choice of date:</label>
<select name="date_firstchoice_1" id="date_firstchoice_1" required>
<option disabled selected>--Select one--</option>
<?php

	foreach(availableDates() as $d){
		echo "<option>";
		echo "$d";
		echo "</option>";
	}
 ?>
<!-- <option>Monday September 14, 9:00-11:30 AM</option>
<option>Monday September 14, 12:00-2:30 PM</option>
<option>Monday September 14, 3:00-5:30 PM</option>
<option>Monday September 14, 6:00-8:30 PM</option>
<option>Thursday September 17, 9:00-11:30 AM</option>
<option>Thursday September 17, 12:00-2:30 PM</option>
<option>Thursday September 17, 3:00-5:30 PM</option>
<option>Thursday September 17, 6:00-8:30 PM</option>
<option>Friday September 18, 9:00-11:30 AM</option>
<option>Friday September 18, 12:00-2:30 PM</option>
<option>Friday September 18, 3:00-5:30 PM</option>
<option>Friday September 18, 6:00-8:30 PM</option>
<option>Monday September 21, 9:00-11:30 AM</option>
<option>Monday September 21, 12:00-2:30 PM</option>
<option>Monday September 21, 3:00-5:30 PM</option>
<option>Monday September 21, 6:00-8:30 PM</option>
<option>Thursday September 24, 9:00-11:30 AM</option>
<option>Thursday September 24, 12:00-2:30 PM</option>
<option>Thursday September 24, 3:00-5:30 PM</option>
<option>Thursday September 24, 6:00-8:30 PM</option>
<option>Friday September 25, 9:00-11:30 AM</option>
<option>Friday September 25, 12:00-2:30 PM</option>
<option>Friday September 25, 3:00-5:30 PM</option>
<option>Friday September 25, 6:00-8:30 PM</option>
<option>Monday September 28, 9:00-11:30 AM</option>
<option>Monday September 28, 12:00-2:30 PM</option>
<option>Monday September 28, 3:00-5:30 PM</option>
<option>Monday September 28, 6:00-8:30 PM</option>
<option>Thursday October 1, 9:00-11:30 AM</option>
<option>Thursday October 1, 12:00-2:30 PM</option>
<option>Thursday October 1, 3:00-5:30 PM</option>
<option>Thursday October 1, 6:00-8:30 PM</option>
<option>Friday October 2, 9:00-11:30 AM</option>
<option>Friday October 2, 12:00-2:30 PM</option>
<option>Friday October 2, 3:00-5:30 PM</option>
<option>Friday October 2, 6:00-8:30 PM</option>
<option>Monday October 5, 9:00-11:30 AM</option>
<option>Monday October 5, 12:00-2:30 PM</option>
<option>Monday October 5, 3:00-5:30 PM</option>
<option>Monday October 5, 6:00-8:30 PM</option>
<option>Thursday October 8, 9:00-11:30 AM</option>
<option>Thursday October 8, 12:00-2:30 PM</option>
<option>Thursday October 8, 3:00-5:30 PM</option>
<option>Thursday October 8, 6:00-8:30 PM</option>
<option>Friday October 9, 9:00-11:30 AM</option>
<option>Friday October 9, 12:00-2:30 PM</option>
<option>Friday October 9, 3:00-5:30 PM</option>
<option>Friday October 9, 6:00-8:30 PM</option> -->
</select>
<br>
</div>
</div>

<?php
//
//
// $questionnaire->printQuestions(3,5);
// $questionnaire->printQuestions(7,7);
echo "</fieldset>";
echo "</div>";



echo "</fieldset>";
echo "</div>";


}
?>
        <hr>
        	<button class="pure-button pure-button-primary" type="submit">Submit</button>
    </form>
</div>
</body>
<?php $questionnaire->printPostamble();?>
</html>
<?php
	}
	else
	{
?>
	<html>
	<head>
	</head>
	<body>
	<h3>Interactive Search Study: Complete Previous Page!!!!</h3>
	<hr>
	<p>You have to first submit the number of registrants for participating in the study.</p>
	<p>Please visit the <a href="http://coagmento.org/fall2015intent/signup_intro.php">signup introduction</a> first.</p>
	</body>
	</html>
<?php
	}
}

else if ($closed)
{
	echo "<html>\n";
  echo "<head>\n";
  echo "<title>Interactive Search Study: Currently Closed</title>\n";
  echo "</head>\n";
  echo "<body class=\"body\">\n<center>\n<br/><br/>\n";
  echo "<table class=body align=center>\n";
  echo "<tr><td align=center>Our study is currently closed at this time, and we are currently not accepting new recruits.  We apologize for any inconvenience.</td></tr>\n";
  echo "</table></body>\n";
  echo "</html>";



}else if($section_closed){
  echo "<html>\n";
  echo "<head>\n";
  echo "<title>Interactive Search Study: Currently Closed</title>\n";
  echo "</head>\n";
  echo "<body>\n";
  echo "<br/><br/>\n";
  echo "<hr/>\n";
  echo "<p>The number of required for this type of grouping has been reached at this point.</p>\n";
  echo "<p>If you wanted to register as a pair but would still like to participate, please register as individual users.</p>\n";
  echo "<hr/>\n";
  echo "</body>";
  echo "</html>";
}else{


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
}
?>
