<?php
require_once('core/Connection.class.php');

//$query = "SELECT COUNT(*) AS num_recruits FROM recruits";
//$connection = Connection::getInstance();
//$results = $connection->commit($query);
//$line = mysql_fetch_array($results, MYSQL_ASSOC);
$num_recruits = 0;

$recruit_limit =100; // Current Recruitment Limit as of 07/15/2014

    $closed=true;

//    $query = "SELECT a.ct as k, COUNT(a.ct) as v from (SELECT projectID, COUNT(projectID) as ct FROM recruits GROUP BY projectID) a GROUP BY a.ct";
//    $connection = Connection::getInstance();
//    $results = $connection->commit($query);
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
//
//    $section_closed = false;
//    if(isset($_POST['num_users'])){
//        if($_POST['num_users'] == 2 && $ct_array[$_POST['num_users']]>=14){
//            $section_closed = true;
//        }else if ($_POST['num_users'] == 1 && $ct_array[$_POST['num_users']]>=21){
//            $section_closed = true;
//        }
//    }


    $closed = false;

if($num_recruits<=$recruit_limit && !$closed && !$section_closed)
{

	if(1)
	{

        $NUM_USERS = 1;

	?>
<html>
<head>
  <link rel="stylesheet" href="study_styles/custom/text.css">
  <link rel="stylesheet" href="study_styles/pure-release-0.5.0/buttons.css">
  <link rel="stylesheet" href="study_styles/pure-release-0.5.0/forms.css">

	<title>
    	Collaborative Search Study: Registration for Participation
    </title>
    <link rel="stylesheet" type="text/css" href="styles.css" />
<script type="text/javascript">

	var alertColor = "Red";
	var okColor = "White";


	function validateForm(form)
	{
		var isValid = 1;
		form.action = "signupGroup.php";

        <?php
        for($x=1;$x<=$NUM_USERS;$x++){

            echo "isValid &= validateField(form.firstName_$x);\n";
            echo "isValid &= validateField(form.lastName_$x);\n";
            echo "isValid &= validateEmail(form.email1_$x,form.reEmail_$x);\n";
            echo "isValid &= validateField(form.username_$x);\n";
            echo "isValid &= validateField(form.pwd_$x);\n";
            echo "isValid &= validateField(form.repwd_$x);\n";
            echo "isValid &= validateSelectField(document.getElementById(\"instructor_$x\"));\n";
            echo "isValid &= validatePwd(form.pwd_$x,form.repwd_$x);\n";

//            echo "isValid &= isRadioSelected(form.year_$x, \"yeardiv_$x\");\n";
//            echo "isValid &= isRadioSelected(form.sex_$x, \"sexdiv_$x\");\n";
            echo "isValid &= validateField(form.instructor_$x);\n";
//            echo "isValid &= validateField(form.researchtopic_$x);\n";

        }
        ?>

//        isValid &= isRadioSelected(document.getElementsByName("sessionday"), "sessiondaydiv");

		//isValid &= isRadioSelected(form.interest1, "interest1");
		//isValid &= isRadioSelected(form.interest2, "interest2");


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
        if (field.text == "")
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
	<form class="pure-form pure-form-aligned" method="post" onsubmit="return validateForm(this)">
		<table class="style1" width=90%>
			<tr>
			  <td colspan=2>
				<ul>
				<li>This is a study signup form. <strong>All the fields are required</strong>.</li>
				<li>To sign up, please fill up the registration details below and we will get back to you with the follow up instructions.</li>
				<li>Once you complete this form, we will contact you if there is any issue with your requested participation and with follow up instructions. <strong></strong></li>
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
                <li>Your group is also eligible for an additional <strong>$40 cash</strong> prize per person for best performers, measured by amount of activity using the Coagmento tool.</li>
				<li>Note that you will be eligible for compensation only if you complete the study and follow all guidelines.</li>
                <li><strong>You must currently be enrolled in 04:547:220 Retrieving and Evaluating Electronic Information.</strong></li>
                <!--<li>Please note that you cannot participate in this study if you already participated in the Coagmento Lab Search Study in <a href="http://coagmento.rutgers.edu/summer2012/studyInfo.php">2012</a>, <a href="http://coagmento.rutgers.edu/studyRecruitment/signup.php">2013</a>, or <a href="http://userstudy2014.coagmento.rutgers.edu/userstudy2014/signup_intro.php">Summer 2014</a>.</li>
				<li>You <strong>must be an undergraduate student</strong> to be eligible to participate in this study.</li>-->
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



                                                                                                                  <?php


echo "<input type=\"hidden\" name=\"num_users\" value=\"$NUM_USERS\">";
for($x=1;$x<=$NUM_USERS;$x++){

// echo "<table class=\"style1\" border=\"1\">";
if($x==1 && $NUM_USERS==1){
echo "<h3>Enter Participant details</h3>";
// echo "<tr><th colspan=2 align=center bgcolor=\"#F2F2F2\">Enter Participant details</th></tr>";
}else{
echo "<h3>Participant $x</h3>";
// echo "<tr><th colspan=2 align=center bgcolor=\"#F2F2F2\">Participant $x</th></tr>";

}

// echo "<tr><td>First name</td><td> <input type=\"text\" size=25 name=\"firstName_$x\" value=\"\" /></td></tr>";
// echo "<tr><td bgcolor=\"#F2F2F2\">Last name</td><td bgcolor=\"#F2F2F2\"> <input type=\"text\"  size=25 name=\"lastName_$x\" value=\"\" /></td></tr>";
// echo "<tr><td>Primary Email</td><td> <input type=\"text\"  size=25 name=\"email1_$x\" value=\"\" /></td></tr>";
// echo "<tr><td bgcolor=\"#F2F2F2\">Confirm Email</td><td bgcolor=\"#F2F2F2\"> <input type=\"text\" size=25  name=\"reEmail_$x\" value=\"\" /></td></tr>";
// echo "<tr><td>Username</td><td> <input type=\"text\"  size=25 name=\"username_$x\" value=\"\" /></td></tr>";
// echo "<tr><td>Password</td><td> <input type=\"password\"  size=25 name=\"pwd_$x\" value=\"\" /></td></tr>";
// echo "<tr><td bgcolor=\"#F2F2F2\">Confirm Pasword</td><td bgcolor=\"#F2F2F2\"> <input type=\"password\" size=25  name=\"repwd_$x\" value=\"\" /></td></tr>";
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
echo "<select name=\"instructor_$x\" id=\"instructor_$x\" required><option disabled selected></option><option>Dr. Nina Wacholder</option><option>Dr. Nick Belkin</option></select>";
echo "</div>";

// echo "<tr><td bgcolor=\"#F2F2F2\">Confirm Pasword</td><td bgcolor=\"#F2F2F2\"> <input type=\"password\" size=25  name=\"repwd_$x\" value=\"\" /></td></tr>";


//echo "<tr><td>Your year in college</td><td><div id=\"yeardiv_$x\"><input type=\"radio\" name=\"year_$x\" value=\"Freshman\" />Freshman  <input type=\"radio\" name=\"year_$x\" value=\"Sophomore\" />Sophomore<input type=\"radio\" name=\"year_$x\" value=\"Junior\" />Junior <input type=\"radio\" name=\"year_$x\" value=\"Senior\" />Senior </div></td></tr>";

// echo "<tr><td bgcolor=\"#F2F2F2\">Sex</td><td bgcolor=\"#F2F2F2\"><div id=\"sexdiv_$x\"><input type=\"radio\"  name=\"sex_$x\" value=\"F\" />Female  <input type=\"radio\" name=\"sex_$x\" value=\"M\" />Male</div></td></tr>";
// echo "<tr><td>Section of your<br>04:192:201 Communication in <br>Relationships class</td><td> <input type=\"text\" size=25 name=\"coursename_$x\" value=\"\" /></td></tr>";

// echo "<tr><td>Instructor of your<br>04:547:220 Retrieving and<br/>Evaluating Electronic<br/>Information class</td><td><select name=\"instructor_$x\" id=\"instructor_$x\"><option disabled selected></option><option>Dr. Nina Wacholder</option><option>Dr. Nick Belkin</option></select></td></tr>";
// echo "<tr><td bgcolor=\"#F2F2F2\">Your research topic</td><td bgcolor=\"#F2F2F2\"> <input type=\"text\" size=25 name=\"researchtopic_$x\" value=\"\" /></td></tr>";

// echo "</table><br><br>";
if($NUM_USERS >1){
  echo "<hr>";
}


}
?>


<!--<table class="style1" border="1">
<tr><td>Which study session do<br>you want to attend?</td>

<td><div id="sessiondaydiv">-->
<?php

// if($NUM_USERS ==1){
// echo "<input type=\"radio\" name=\"sessionday\" value=\"Thursday 11/6 10:00-11:00 AM\" />Thursday 11/6 10:00-11:00 AM<br>";
// echo "<input type=\"radio\" name=\"sessionday\" value=\"Monday 11/10 2:00-3:00 PM\" />Monday 11/10 2:00-3:00 PM";
// }else{
// echo "<input type=\"radio\" name=\"sessionday\" value=\"Friday 11/7 1:00-2:00 PM\" />Friday 11/7 1:00-2:00 PM<br>";
// echo "<input type=\"radio\" name=\"sessionday\" value=\"Friday 11/7 3:00-4:00 PM\" />Friday 11/7 3:00-4:00 PM<br>";
// echo "<input type=\"radio\" name=\"sessionday\" value=\"Tuesday 11/11 3:00-4:00 PM\" />Tuesday 11/11 3:00-4:00 PM<br>";
// echo "<input type=\"radio\" name=\"sessionday\" value=\"Wednesday 11/12 3:00-4:00 PM\" />Wednesday 11/12 3:00-4:00 PM";
// }


?>
<!--</div></td></tr>


</table>

<table class="style1">
<strong>Please come to your scheduled session at least 5 minutes early to fill out some paperwork.</strong><tr><td>
</td></tr></table>-->



			<!-- <tr>
				<td align="center" colspan=2> -->
        <div class="pure-controls">
					<button class="pure-button pure-button-primary" type="submit">Submit</button>
        </div>
      </fieldset>

				<!-- </td>
			</tr> -->
			<!-- <tr>
				<td align="center" colspan=2> -->
					<div style="display: none; background: Red; text-align:center;" id="alertForm"><strong>Please Complete the Fields in Red and Try Again</strong></div>
				<!-- </td>
			</tr> -->
		<!-- </td>
	</tr>
		</table> -->
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
