<?php
session_start();
require_once('core/Connection.class.php');
require_once('core/Questionnaires.class.php');

$num_recruits = 0;
$recruit_limit =100; // Current Recruitment Limit as of 07/15/2014
$section_closed = false;
$closed=true;
$closed = false;

if($num_recruits<=$recruit_limit && !$closed && !$section_closed)
{
	if(1)
	{
        $NUM_USERS = 1;
        $questionnaire = Questionnaires::getInstance();
				$questionnaire->clearCache();
        $questionnaire->populateQuestionsFromDatabase("spring2015","questionID ASC");


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
				<li>Use this form to register for the paid research study on collaborative research <strong>for Friday, June 26 (time TBD).</strong></li>
				<li>Please fill out the information below then click Submit.</li>
				<li>You will receive a confirmation email within 24-48 hours with details about time, date, and location of your session.</li>
				<li>NOTE: You <strong>cannot</strong> participate in this study if you participated in the Spring 2015 Coagmento study in ITI 220.</li>
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
									<p>During this study you will perform online research using an experimental browser plug-in and answer questionnaires.</p>
									<p>The study will last approximately 50-70 minutes and take place in the School of Communication and Information building.</p>
									<p>You will receive <strong>$20 cash</strong> for participating in the study.</p>
					        <p>You are also eligible for an additional <strong>$20 cash prize</strong> for best performance, measured by amount of activity using the Coagmento tool.</p>

					        <p>Requirements:
					          <ul>
					            <li>You must be at least 18 years old to participate.</li>
					            <li>Proficiency in English is required.</li>
					            <li>Intermediate typing and online search skills are required.</li>
					            <li>Note: You <strong>cannot</strong> participate in this study if you participated in the Spring 2015 Coagmento study in ITI 220.</li>
					          </ul>
					        </p>



									<p>Choosing or declining to participate in this study will not affect your class standing or grades at Rutgers. You will not be offered or receive any special consideration if you take part in this research; it is purely voluntary. This study has been approved by the Rutgers Institutional Review Board (IRB Study #E13-046), and will be supervised by Dr. Chirag Shah (chirags@rutgers.edu) at the School of Communication and Information.</p>
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


$questionnaire->printQuestions(0,1);


$questionnaire->printQuestions(3,5);
$questionnaire->printQuestions(7,7);
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
  echo "<body>\n";
  echo "<p style='background-color:red;'>Sorry! The user study registration is currently closed.</p>\n";
  echo "<br/><br/>\n";
  echo "<hr/>\n";
  echo "<p>The number of participants required has been reached at this point.</p>\n";
  echo "<p>If more user participation is required, we will reopen the study registration and send another round of recruitment emails.</p>\n";
  echo "<hr/>\n";
  echo "</body>";
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
  echo "<body class=\"body\">\n<center>\n<br/><br/>\n";
  echo "<table class=body align=center>\n";
  echo "<tr><td align=center>Our study is currently closed at this time, and we are currently not accepting new recruits.  We apologize for any inconvenience.</td></tr>\n";
  echo "</table></body>\n";
  echo "</html>";

}
?>
