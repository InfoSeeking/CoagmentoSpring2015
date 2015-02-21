<?php
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
        $questionnaire->populateQuestionsFromDatabase("spring2015","questionID ASC");

	?>
<html>
<head>
  <link rel="stylesheet" href="study_styles/custom/text.css">
  <link rel="stylesheet" href="study_styles/pure-release-0.5.0/buttons.css">
  <link rel="stylesheet" href="study_styles/pure-release-0.5.0/forms.css">
  <link rel="stylesheet" href="study_styles/pure-release-0.5.0/grids-min.css">
  <!-- <link rel="stylesheet" href="study_styles/pure-release-0.5.0/pure-min.css"> -->
	<title>
    	Collaborative Search Study: Registration for Participation
    </title>
    <link rel="stylesheet" type="text/css" href="styles.css" />

    <style>
    select {
      font-size:13px;
    }
    </style>
<script type="text/javascript">

	var alertColor = "Red";
	var okColor = "White";


	function validateForm(form)
	{
		var isValid = 1;
		form.action = "signupGroup.php";

        <?php
        for($x=1;$x<=$NUM_USERS;$x++){

            echo "isValid &= validateSelectField(document.getElementById(\"year_$x\"));\n";

            echo "if(isRadioSelected(document.getElementsByName(\"doneproj_$x\"),\"doneproj_div_$x\") && radioSelectedValue(document.getElementsByName(\"doneproj_$x\"))==\"Yes\"){\n";
              echo "isValid &= validateSelectField(document.getElementById(\"outcome_satisfaction_$x\"));\n";
              echo "isValid &= validateSelectField(document.getElementById(\"experience_satisfaction_$x\"));\n";
            echo "}\n";
            echo "isValid &= validateSelectField(document.getElementById(\"topic_knowledge_$x\"));\n";
            echo "isValid &= validateSelectField(document.getElementById(\"search_experience_$x\"));\n";
            echo "isValid &= validateSelectField(document.getElementById(\"motivation_$x\"));\n";


            echo "isValid &= isRadioSelected(document.getElementsByName(\"gender_$x\"),\"gender_div_$x\");\n";
            echo "isValid &= isRadioSelected(document.getElementsByName(\"doneproj_$x\"),\"doneproj_div_$x\");\n";
            echo "isValid &= isRadioSelected(document.getElementsByName(\"pc_$x\"),\"pc_div_$x\");\n";


            $args = array(
              "lk_group_assign_productive",
              "lk_group_ideas",
              "lk_group_fun",
              "lk_alone_efficient",
              "lk_teacher_efficient",
              "lk_close_work_learning",
              "lk_help_from_members",
              "lk_group_work_like",
              "lk_one_does_most",
              "lk_happy_as_leader",
              "lk_group_fits_habits",
              "lk_group_discuss_waste"
            );

            foreach($args as $pref){
              echo "isValid &= isRadioSelected(document.getElementsByName(\"".$pref."_$x\"),\"".$pref."_div_$x\");\n";
            }

            echo "isValid &= isRankedOrderValid(\"work_strategies_div\");\n";
            echo "isValid &= isRankedOrderValid(\"obstacles_div\");\n";


          // Older stuff
            echo "isValid &= validateField(form.firstName_$x);\n";
            echo "isValid &= validateField(form.lastName_$x);\n";
            echo "isValid &= validateEmail(form.email1_$x,form.reEmail_$x);\n";
            echo "isValid &= validateField(form.username_$x);\n";
            echo "isValid &= validateField(form.pwd_$x);\n";
            echo "isValid &= validateField(form.repwd_$x);\n";
            echo "isValid &= validateSelectField(document.getElementById(\"instructor_$x\"));\n";
            echo "isValid &= validatePwd(form.pwd_$x,form.repwd_$x);\n";
            echo "isValid &= validateField(form.instructor_$x);\n";

        }
        ?>
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

	function isCheckboxSelected(checkbox, obj)
	{
		if (checkbox.checked)
		{
			document.getElementById(obj).style.backgroundColor = okColor;
			return true;
		}

		document.getElementById(obj).style.backgroundColor = alertColor;

		return false;
	}

  function isRankedOrderValid(divid){
    var inputs = document.getElementById(divid).getElementsByTagName('input');
    var count = 0;
    for (i=inputs.length-1; i > -1; i--) {
      if(inputs[i].value != ""){
        count += 1;
      }
    }

    if (count != 3){
      for (i=inputs.length-1; i > -1; i--) {
        inputs[i].style.backgroundColor = alertColor;
      }
      return false;
    }else{
      for (i=inputs.length-1; i > -1; i--) {
        inputs[i].style.backgroundColor = okColor;
      }
    }

    for (i=inputs.length-1; i > -1; i--) {
      for (j=i-1; j > -1; j--) {
        if(inputs[i].value==inputs[j].value && inputs[i].value!="" && inputs[i].value!=""){
          for (k=inputs.length-1; k > -1; k--) {
            inputs[k].style.backgroundColor = alertColor;
          }
          return false;
        }
      }
    }

    for (i=inputs.length-1; i > -1; i--) {
      inputs[i].style.backgroundColor = okColor;
    }
    return true;

  }

	function validateField(field)
	{
		if (field.value == "")
		{
			changeColor(field,alertColor);
			return false;
		}
		else
		{
			changeColor(field,okColor);
			return true;
		}
	}

  function validateSelectField(field)
  {

      if (field.value == "")
      {
          changeColor(field,alertColor);
          return false;
      }
      else
      {
          changeColor(field,okColor);
          return true;
      }
  }

	function isRadioSelected(radioButtons, obj)
	{

		for (i=radioButtons.length-1; i > -1; i--) {
			if (radioButtons[i].checked)
			{
				document.getElementById(obj).style.backgroundColor = okColor;
				return true;
			}
        }

		document.getElementById(obj).style.backgroundColor = alertColor;

		return false;
	}

  function radioSelectedValue(radioButtons)
  {

    for (i=radioButtons.length-1; i > -1; i--) {
      if (radioButtons[i].checked)
      {
        // alert(radioButtons[i].value);
        return radioButtons[i].value;
      }
    }

    return false;
  }

  function showHideRadio(radioButtons,showdiv){
    for (i=radioButtons.length-1; i > -1; i--) {
          if (radioButtons[i].checked)
          {
            if(radioButtons[i].value == "Yes"){
              document.getElementById(showdiv).style.display="block";
            }else if (radioButtons[i].value == "No"){
              document.getElementById(showdiv).style.display="none";
            }
          }
      }
  }

	function validateEmail(field1, field2)
	{
		if (field1.value != field2.value)
		{
			changeColor(field1,alertColor);
			changeColor(field2,alertColor);
			return false;
		}
		else
			if (!isValidadEmail(field1.value))
			{
				changeColor(field1,alertColor);
				changeColor(field2,alertColor);
				return false;
			}
			else
			{
				changeColor(field1,okColor);
				changeColor(field2,okColor);
				return true;
			}
	}

	function validateEmail2(field1)
	{
		if ((field1.value.length != 0) && !isValidadEmail(field1.value))
		{
				changeColor(field1,alertColor);
				return false;
			}
			else
			{
				changeColor(field1,okColor);
				return true;
			}
	}

	function changeColor(field,color)
	{
		field.style.background = color;
	}

	function isValidadEmail(email)
	{
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}

	function viewDetails(check)
	{
		if (check.checked)
			document.getElementById("singleStudyDetails").style.display = "block";
		else
			document.getElementById("singleStudyDetails").style.display = "none";
	}


	function validatePwd(field1, field2)
	{
		if (field1.value != field2.value || field1.value.length < 1)
		{
			changeColor(field1,alertColor);
			changeColor(field2,alertColor);
			return false;
		}

		else
		{
			changeColor(field1,okColor);
			changeColor(field2,okColor);
			return true;
		}
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
	<h3>Collaborative Search Study: Registration for Participation</h3>
		<table class="style1" width=90%>
			<tr>
			  <td colspan=2>
				<ul>
				<li>Use this form to register for the paid research study in ITI 220. <strong>All the fields are required</strong>.</li>
				<li>Please fill in your participant details, then answer the questionnaire below and click Submit.</li>
				<li>You will receive a confirmation email.</li>
				<li><a href="mailto:study220@rutgers.edu?subject=Study inquiry">Contact us</a> if you have any questions.</li>
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
				<ul>
				<li>By participating in this study you will perform online research using an experimental browser plug-in, answer some questionnaires, and be interviewed briefly.</li>
				<li>You will use the Coagmento collaborative search system while you work on your group project on IT Market Sector Analysis report.</li>
				<li>You will receive <strong>$40 cash</strong> for participating in the study.</li>
                <li>Your group is also eligible for an additional <strong>$20 cash</strong> prize per person for best performers, measured by amount of activity using the Coagmento tool.</li>
				<li>Note that you will be eligible for compensation only if you complete the study and follow all guidelines.</li>
        <li><strong>You must currently be enrolled in 04:547:220 Retrieving and Evaluating Electronic Information.</strong></li>
				<li>You must be at least 18 years old to participate.</li>
				<li>Proficiency in English is required.</li>
				<li>Intermediate typing and online search skills are required.</li>
                <li>No identifying information about you will be shared.</li>
        </ul>
									<br />
									<p>Choosing or declining to participate in this study will not affect your class standing or grades at Rutgers. You will not be offered or receive any special consideration if you take part in this research; it is purely voluntary. This study has been approved by the Rutgers Institutional Review Board (IRB Study #E13-046), and will be supervised by Dr. Chirag Shah (chirags@rutgers.edu) at the School of Communication and Information.</p>
								</td>
							</tr>
	  					</table>
					</div>


<form class="pure-form" method="post" onsubmit="return validateForm(this)">
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
  echo "<label for=\"email1_$x\">Primary Email</label>";
  echo "<input id=\"email1_$x\" name=\"email1_$x\" type=\"text\" placeholder=\"Primary Email\" required>";
  echo "</div>";

  echo "<div class=\"pure-control-group\">";
  echo "<label for=\"reEmail_$x\">Confirm Email</label>";
  echo "<input id=\"reEmail_$x\" name=\"reEmail_$x\" type=\"text\" placeholder=\"Confirm Email\" required>";
  echo "</div>";

  echo "<div class=\"pure-control-group\">";
  echo "<label for=\"username_$x\">Username</label>";
  echo "<input id=\"username_$x\" size=25 name=\"username_$x\" type=\"text\" placeholder=\"Username\" required>";
  echo "</div>";

  echo "<div class=\"pure-control-group\">";
  echo "<label for=\"pwd_$x\">Password</label>";
  echo "<input id=\"pwd_$x\" size=25 name=\"pwd_$x\" type=\"password\" placeholder=\"Password\" required>";
  echo "</div>";

  echo "<div class=\"pure-control-group\">";
  echo "<label for=\"repwd_$x\">Confirm Pasword</label>";
  echo "<input id=\"repwd_$x\" size=25 name=\"repwd_$x\" type=\"password\" placeholder=\"Confirm Pasword\" required>";
  echo "</div>";

  echo "<div class=\"pure-control-group\">";
  echo "<label name=\"instructor_$x\">Instructor of your 04:547:220 Retrieving and Evaluating Electronic Information class</label>";
  echo "<select name=\"instructor_$x\" id=\"instructor_$x\" required><option disabled selected>--Select one--</option><option>Dr. Nina Wacholder</option><option>Dr. Nick Belkin</option></select>";
  echo "</div>";

  echo "</fieldset>";
  echo "</div>";
  if($NUM_USERS >1){
    echo "<hr>";
  }


//Demographic Survey

echo "<div class=\"pure-form-stacked\">";
echo "<fieldset>";

echo "<hr>";


$questionnaire->printQuestions(0,8);


echo "</fieldset>";
echo "<hr>";
echo "</div>";

$questionnaire->printQuestions(9,9);

echo "<hr>";
$questionnaire->printQuestions(10,10);

echo "<hr>";

echo "<label ><h4>Please indicate how much you agree or disagree with the following statements:</h4></label>";
echo "<div class=\"pure-control-group\">";
echo "<div style=\"max-width:600\">";

// Likert
$questionnaire->printQuestions(11);



echo "</div>";
echo "</div>";

echo "</fieldset>";
echo "</div>";


}
?>
        <hr>
        	<button class="pure-button pure-button-primary" type="submit">Submit</button>
					<div style="display: none; background: Red; text-align:center;" id="alertForm"><strong>Please Complete the Fields in Red and Try Again</strong></div>
    </form>
</div>
</body>
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
	<p>Please visit the <a href="http://coagmento.org/spring2015/signup_intro.php">signup introduction</a> first.</p>
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
