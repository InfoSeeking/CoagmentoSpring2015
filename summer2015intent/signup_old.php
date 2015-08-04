<?php
require_once('core/Connection.class.php');

$query = "SELECT COUNT(*) AS num_recruits FROM recruits";
$connection = Connection::getInstance();
$results = $connection->commit($query);
$line = mysql_fetch_array($results, MYSQL_ASSOC);
$num_recruits = $line['num_recruits'];

$recruit_limit =72; // Current Recruitment Limit as of 07/15/2014

    $closed=false;
if($num_recruits<=$recruit_limit && !$closed)
{

	if(isset($_POST['consentRead']))
	{
	?>
<html>
<head>

	<title>
    	Interactive Search Study: Registration for Participation
    </title>
    <link rel="stylesheet" type="text/css" href="styles.css" />
<script type="text/javascript">

	var alertColor = "Red";
	var okColor = "White";


	function validateForm(form)
	{
		var isValid = 1;
		form.action = "signupSingle.php";
		isValid &= validateField(form.firstName);
		isValid &= validateField(form.lastName);
		isValid &= validateEmail(form.email1,form.reEmail);
        isValid &= isRadioSelected(form.year, "yeardiv");

		isValid &= isRadioSelected(form.sex, "sexdiv");
		isValid &= validateField(form.coursename);
		isValid &= validateField(form.researchtopic);
        isValid &= isRadioSelected(form.sessionday, "sessiondaydiv");

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

	function isRadioSelected(radioButtons, obj)
	{
		for (i=radioButtons.length-1; i > -1; i--)
			if (radioButtons[i].checked)
			{
				document.getElementById(obj).style.backgroundColor = okColor;
				return true;
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

	function viewDetailsSingle(check)
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
	<h3>Interactive Search Study: Registration for Participation</h3>
	<form method="post" onsubmit="return validateForm(this)">
		<table class="style1" width=90%>
			<tr>
			  <td colspan=2>
				<ul>
				<li>This is a study signup form. <strong>All the fields are required</strong>.</li>
				<li>To sign up, please fill up the registration details below and we will get back to you with the follow up instructions.</li>
				<li>Once you complete this form, we will contact you if there is any issue with your requested participation and with follow up instructions. <strong></strong></li>
				<li><a href="mailto:chris.leeder@rutgers.edu?subject=Study inquiry">Contact us</a> if you have any questions.</li>
				</ul>
				</td>
			</tr>
<!--
Registration
-->
			<tr>
				<td>
					<p><strong>Check here to if you would like to read recruitment details again. </strong><input type="checkbox" name="viewInstructionsCheckSingle" id="viewInstructionsCheckSingle" onclick="viewDetailsSingle(this)" /></p>
					<br />
					<div style="display: none; background: #F2F2F2; text-align:center; border-style:solid; width:70%; border-color:blue; padding:25px;" id="singleStudyDetails">
	 					<table class="style1" width="100%">
							<tr>
								<td>
									<ul>
                     <li>By participating in this study you will perform online research using an experimental browser plug-in, answer some questionnaires, and be interviewed briefly.</li>
                     <li>The study will take place in Room 413 of Alexander Library.</li>
                     <li>The study consists of one hour-long session.</li>
                                          <li>You will receive <strong>$10</strong> cash for participating in the session.</li>
                     <li>Note that you will be eligible for compensation <strong>only</strong> if you complete the session and follow all guidelines.</li>
                     <li>You can participate <strong>only once</strong> in this study.</li>
                     <li>Please note that you <strong>cannot</strong> participate in this study if you already participated in the Coagmento Lab Search Study in <a href="http://coagmento.rutgers.edu/summer2012/studyInfo.php">2012</a>, <a href="http://coagmento.rutgers.edu/studyRecruitment/signup.php">2013</a>, or <a href="http://userstudy2014.coagmento.rutgers.edu/userstudy2014/signup_intro.php">Summer 2014</a>.</li>
                     <li>You must be an undergraduate student to be eligible to participate in this study.</li>
                     <li>Proficiency in English is required.</li>
                     <li>Intermediate typing and online search skills are required.</li>
                     <li><strong>You must currently be enrolled in 01:355:201 Research in the Disciplines.</strong></li>
                     <li>No identifying information about you will be shared.</li>


                     </ul>
									<br />
									<p>Choosing or declining to participate in this study will not affect your class standing or grades at Rutgers. You will not be offered or receive any special consideration if you take part in this research; it is purely voluntary. This study has been approved by the Rutgers Institutional Review Board (IRB Study #E13-046), and will be supervised by Dr. Chirag Shah (chirags@rutgers.edu) at the School of Communication and Information.</p>
								</td>
							</tr>
	  					</table>
					</div>
					<table class="style1" border="1">
							<tr><th colspan=2 align=center bgcolor="#F2F2F2">Enter Participant details</th></tr>
							<tr><td>First name</td><td> <input type="text" size=25 name="firstName" value="" /></td></tr>
							<tr><td bgcolor="#F2F2F2">Last name</td><td bgcolor="#F2F2F2"> <input type="text"  size=25 name="lastName" value="" /></td></tr>
							<tr><td>Primary Email</td><td> <input type="text"  size=25 name="email1" value="" /></td></tr>
							<tr><td bgcolor="#F2F2F2">Confirm Email</td><td bgcolor="#F2F2F2"> <input type="text" size=25  name="reEmail" value="" /></td></tr>
                                                                                                                                                                                                                                                                    <tr><td>Your year in college</td><td><div id="yeardiv"><input type="radio" name="year" value="Freshman" />Freshman  <input type="radio" name="year" value="Sophomore" />Sophomore<input type="radio" name="year" value="Junior" />Junior <input type="radio" name="year" value="Senior" />Senior </div></td></tr>

                                                                                                                                                                                                                                                                                                                                                    <tr><td bgcolor="#F2F2F2">Sex</td><td bgcolor="#F2F2F2"><div id="sexdiv"><input type="radio"  name="sex" value="F" />Female  <input type="radio" name="sex" value="M" />Male</div></td></tr>
                                                                                                                                                                                                                                                                                                                                                    <tr><td>Topic of your<br>01:355:201 Research in<br>the Disciplines class</td><td> <input type="text" size=25 name="coursename" value="" /></td></tr>
                                                                                                                                                                                                                                                                                                                                                    <tr><td bgcolor="#F2F2F2">Your research topic</td><td bgcolor="#F2F2F2"> <input type="text" size=25 name="researchtopic" value="" /></td></tr>
                                                                                                                                                                                                                                                                                                                                                    <tr><td>Which study session do<br>you want to attend?</td><td><div id="sessiondaydiv"><input type="radio" name="sessionday" value="Monday 10/27 6:00-7:00 PM" />Monday 10/27 6:00-7:00 PM<br><input type="radio" name="sessionday" value="Tuesday 10/28 3:00-4:00 PM" />Tuesday 10/28 3:00-4:00 PM<br><input type="radio" name="sessionday" value="Friday 10/31 2:00-3:00 PM" />Friday 10/31 2:00-3:00 PM

                                                                                                                                                                                                                                                                                                                                                    </div></td></tr>


					</table>



			<tr>
				<td align="center" colspan=2>
					<input type="submit" value="Submit" style="width:100px; height:40px; />
				</td>
			</tr>
			<tr>
				<td align="center" colspan=2>
					<div style="display: none; background: Red; text-align:center;" id="alertForm"><strong>Please Complete the Fields in Red and Try Again</strong></div>
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
	else
	{
?>
	<html>
	<head>
	</head>
	<body>
	<h3>Interactive Search Study: Read Consent Form!!!!</h3>
	<hr>
	<p>You have to first read the consent page and agree to the conditions before registering for participating in the study.</p>
	<p>Please visit <a href="http://coagmento.org/spring2015/consent.php">consent form</a> first, read and accept the study conditions.</p>
	</body>
	</html>
<?php
	}
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
