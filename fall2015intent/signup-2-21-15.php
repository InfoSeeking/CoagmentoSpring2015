<?php
require_once('core/Connection.class.php');

//$query = "SELECT COUNT(*) AS num_recruits FROM recruits";
//$connection = Connection::getInstance();
//$results = $connection->commit($query);
//$line = mysql_fetch_array($results, MYSQL_ASSOC);
$num_recruits = 0;

$recruit_limit =100; // Current Recruitment Limit as of 07/15/2014

$section_closed = false;
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
									<ul>
				<li>By participating in this study you will perform online research using an experimental browser plug-in, answer some questionnaires, and be interviewed briefly.</li>
				<li>You will use the Coagmento collaborative search system while you work on your group project on IT Market Sector Analysis report.</li>
				<li>You will receive <strong>$40 cash</strong> for participating in the study.</li>
                <li>Your group is also eligible for an additional <strong>$20 cash</strong> prize per person for best performers, measured by amount of activity using the Coagmento tool.</li>
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

  // echo "<tr><td>First name</td><td> <input type=\"text\" size=25 name=\"firstName_$x\" value=\"\" /></td></tr>";
  // echo "<tr><td bgcolor=\"#F2F2F2\">Last name</td><td bgcolor=\"#F2F2F2\"> <input type=\"text\"  size=25 name=\"lastName_$x\" value=\"\" /></td></tr>";
  // echo "<tr><td>Primary Email</td><td> <input type=\"text\"  size=25 name=\"email1_$x\" value=\"\" /></td></tr>";
  // echo "<tr><td bgcolor=\"#F2F2F2\">Confirm Email</td><td bgcolor=\"#F2F2F2\"> <input type=\"text\" size=25  name=\"reEmail_$x\" value=\"\" /></td></tr>";
  // echo "<tr><td>Username</td><td> <input type=\"text\"  size=25 name=\"username_$x\" value=\"\" /></td></tr>";
  // echo "<tr><td>Password</td><td> <input type=\"password\"  size=25 name=\"pwd_$x\" value=\"\" /></td></tr>";
  // echo "<tr><td bgcolor=\"#F2F2F2\">Confirm Pasword</td><td bgcolor=\"#F2F2F2\"> <input type=\"password\" size=25  name=\"repwd_$x\" value=\"\" /></td></tr>";
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

  // echo "<tr><td bgcolor=\"#F2F2F2\">Confirm Pasword</td><td bgcolor=\"#F2F2F2\"> <input type=\"password\" size=25  name=\"repwd_$x\" value=\"\" /></td></tr>";


  //echo "<tr><td>Your year in college</td><td><div id=\"yeardiv_$x\"><input type=\"radio\" name=\"year_$x\" value=\"Freshman\" />Freshman  <input type=\"radio\" name=\"year_$x\" value=\"Sophomore\" />Sophomore<input type=\"radio\" name=\"year_$x\" value=\"Junior\" />Junior <input type=\"radio\" name=\"year_$x\" value=\"Senior\" />Senior </div></td></tr>";

  // echo "<tr><td bgcolor=\"#F2F2F2\">Sex</td><td bgcolor=\"#F2F2F2\"><div id=\"sexdiv_$x\"><input type=\"radio\"  name=\"sex_$x\" value=\"F\" />Female  <input type=\"radio\" name=\"sex_$x\" value=\"M\" />Male</div></td></tr>";
  // echo "<tr><td>Section of your<br>04:192:201 Communication in <br>Relationships class</td><td> <input type=\"text\" size=25 name=\"coursename_$x\" value=\"\" /></td></tr>";

  // echo "<tr><td>Instructor of your<br>04:547:220 Retrieving and<br/>Evaluating Electronic<br/>Information class</td><td><select name=\"instructor_$x\" id=\"instructor_$x\"><option disabled selected>--Select one--</option><option>Dr. Nina Wacholder</option><option>Dr. Nick Belkin</option></select></td></tr>";
  // echo "<tr><td bgcolor=\"#F2F2F2\">Your research topic</td><td bgcolor=\"#F2F2F2\"> <input type=\"text\" size=25 name=\"researchtopic_$x\" value=\"\" /></td></tr>";

  // echo "</table><br><br>";
  if($NUM_USERS >1){
    echo "<hr>";
  }


//Demographic Survey

echo "<div class=\"pure-form-stacked\">";
echo "<fieldset>";

echo "<hr>";
echo "<div class=\"pure-control-group\">";
echo "<label name=\"year_$x\">Year in college</label>";
echo "<select name=\"year_$x\" id=\"year_$x\" required><option disabled selected>--Select one--</option><option>Freshman</option><option>Sophomore</option><option>Junior</option><option>Senior</option></select>";
echo "</div><br>";

echo "<div class=\"pure-control-group\">";
echo "<label name=\"gender_$x\">Gender</label>";
echo "<div id=\"gender_div_$x\">";
echo "<label for=\"gender_$x\" class=\"pure-radio\">";
echo "<input id=\"gender_1_$x\" type=\"radio\" name=\"gender_$x\" value=\"Male\"> Male ";
echo "<input id=\"gender_2_$x\" type=\"radio\" name=\"gender_$x\" value=\"Female\"> Female";
echo "</label>";
echo "</div>";
echo "</div><br>";

echo "<div class=\"pure-control-group\">";
echo "<label name=\"pc_$x\">Do you have a laptop or personal computer that you can use during this study?</label>";
echo "<div id=\"pc_div_$x\">";
echo "<label for=\"pc_$x\" class=\"pure-radio\">";
echo "<input id=\"pc_1_$x\" type=\"radio\" name=\"pc_$x\" value=\"Yes\"> Yes ";
echo "<input id=\"pc_2_$x\" type=\"radio\" name=\"pc_$x\" value=\"No\"> No ";
echo "</label>";
echo "</div>";
echo "</div><br>";


echo "<div class=\"pure-control-group\">";
echo "<label name=\"doneproj_$x\">Have you worked on a group project in class previously?</label>";
echo "<div id=\"doneproj_div_$x\">";
echo "<label for=\"doneproj_$x\" class=\"pure-radio\">";
echo "<input id=\"doneproj_1_$x\" type=\"radio\" name=\"doneproj_$x\" value=\"Yes\" onclick=\"showHideRadio(document.getElementsByName('doneproj_$x'),'outcome_satisfaction_div_$x');showHideRadio(document.getElementsByName('doneproj_$x'),'experience_satisfaction_div_$x');\"> Yes ";
echo "<input id=\"doneproj_2_$x\" type=\"radio\" name=\"doneproj_$x\" value=\"No\" onclick=\"showHideRadio(document.getElementsByName('doneproj_$x'),'outcome_satisfaction_div_$x');showHideRadio(document.getElementsByName('doneproj_$x'),'experience_satisfaction_div_$x');\"> No ";
echo "</label>";
echo "</div>";
echo "</div><br>";

echo "<div style=\"display: none; padding-left:60px; background-color:#F2F2F2\" id=\"outcome_satisfaction_div_$x\" class=\"pure-control-group\">";
echo "<label for=\"outcome_satisfaction_$x\">If yes, how satisfied were you with the outcome of your group project?</label>";
echo "<select name=\"outcome_satisfaction_$x\" id=\"outcome_satisfaction_$x\"><option disabled selected>--Select one--</option><option>Not at all</option><option>Some</option><option>A little</option><option>Very</option></select>";
echo "<br></div>";


echo "<div style=\"display: none; padding-left:60px; background-color:#F2F2F2\" id=\"experience_satisfaction_div_$x\" class=\"pure-control-group\">";
echo "<label for=\"experience_satisfaction_$x\" >If yes, how satisfied were you with your group work experience?</label>";
echo "<select name=\"experience_satisfaction_$x\" id=\"experience_satisfaction_$x\"><option disabled selected>--Select one--</option><option>Not at all</option><option>Some</option><option>A little</option><option>Very</option></select>";
echo "<br></div>";


echo "<div class=\"pure-control-group\">";
echo "<label for=\"topic_knowledge_$x\">How knowledgeable are you now about your research topic?</label>";
echo "<select name=\"topic_knowledge_$x\" id=\"topic_knowledge_$x\" required><option disabled selected>--Select one--</option><option>Not at all</option><option>Some</option><option>A little</option><option>Very</option></select>";
echo "</div><br>";

echo "<div class=\"pure-control-group\">";
echo "<label for=\"search_experience_$x\">How experienced are you with tasks that require searching for information from multiple sources and synthesizing it in a report?</label>";
echo "<select name=\"search_experience_$x\" id=\"search_experience_$x\" required><option disabled selected>--Select one--</option><option>Not at all</option><option>Some</option><option>A little</option><option>Very</option></select>";
echo "</div><br>";

echo "<div class=\"pure-control-group\">";
echo "<label for=\"motivation_$x\">How motivated are you to work on this project?</label>";
echo "<select name=\"motivation_$x\" id=\"motivation_$x\" required><option disabled selected>--Select one--</option><option>Not at all</option><option>Some</option><option>A little</option><option>Very</option></select>";
echo "</div>";

echo "</fieldset>";
echo "<hr>";
echo "</div>";





echo "<label><h4>The following are some work strategies that can be useful during group projects.</h4><h4>Please rank in order the top three that you think are most important<br>for successful group work.  Please enter \"1\" for the most important, <br>\"2\" for the second most important, and \"3\" for the third. <br>Choose only three responses.</h4></label>";
echo "<div class=\"pure-form-aligned\">";
echo "<div id=\"work_strategies_div\">";
echo "<fieldset>";

$args = array(
  array("assigning specific tasks","strat_assign_tasks"),
  array("communicating through email or text messages","strat_comm_text"),
  array("dividing work between group members","strat_divide_work"),
  array("establishing goals","strat_establish_goals"),
  array("meeting in person","strat_meet_in_person"),
  array("meeting virtually through tools such as Skype or Google Hangouts","strat_meet_virtual"),
  array("scheduling regular meetings","strat_schedule_meetings"),
  array("setting deadlines","strat_set_deadlines"),
  array("tracking progress","strat_track_progress"),
  array("using collaborative tools such as Google Docs","strat_use_collab_tools"));

foreach($args as $value){
  $pref = $value[1];
  $description = $value[0];
  echo "<div class=\"pure-control-group\" style=\"background-color:#F2F2F2\">";
  echo "<label for=\"".$pref."_$x\">$description</label>";
  echo "<input id=\"".$pref."_$x\" size=1 maxlength=\"1\" onkeypress='return (event.charCode < 47) || (event.charCode >= 49 && event.charCode <= 51) || (event.charCode >= 97 && event.charCode <= 99)' name=\"".$pref."_$x\" type=\"text\">";
  echo "</div>";
}
echo "</div>";
echo "</fieldset>";
echo "</div>";
echo "</div>";



echo "<label ><h4>The following are some obstacles or challenges that may occur during group projects.</h4><h4>Please rank in order the top three that you think you might encounter <br>while completing this group project.  Please enter \"1\" for the most important, <br>\"2\" for the second most important, and \"3\" for the third. <br>Choose only three responses.</h4></label>";
echo "<div class=\"pure-form-aligned\">";
echo "<div id=\"obstacles_div\">";


$args = array(

array("achieving consensus","obs_consensus"),
array("communication with group members","obs_comm_group"),
array("coordination between group members","obs_coord"),
array("lack of leadership","obs_lack_leadership"),
array("lack of motivation","obs_lack_motivation"),
array("lack of time","obs_lack_time"),
array("meeting deadlines","obs_meet_deadlines"),
array("procrastination","obs_procrastination"),
array("scheduling conflicts","obs_sched_conflict"),
array("unequal participation","obs_unequal_participation"));

foreach($args as $value){
  $pref = $value[1];
  $description = $value[0];
  echo "<div class=\"pure-control-group\" style=\"background-color:#F2F2F2\">";
  echo "<label for=\"".$pref."_$x\">$description</label>";
  echo "<input id=\"".$pref."_$x\" size=1 maxlength=\"1\" onkeypress='return (event.charCode < 47) || (event.charCode >= 49 && event.charCode <= 51) || (event.charCode >= 97 && event.charCode <= 99)' name=\"".$pref."_$x\" type=\"text\">";
  echo "</div>";
}

echo "</div>";
echo "</fieldset>";
echo "<hr/>";
echo "</div>";
echo "</div>";


echo "<label ><h4>Please indicate how much you agree or disagree with the following statements:</h4></label>";
echo "<div class=\"pure-control-group\">";
echo "<div style=\"max-width:600\">";


$args = array(
  array("1.	Assigning specific tasks to group members makes group-work productive","lk_group_assign_productive"),
  array("2.	Group-work generates many good ideas","lk_group_ideas"),
  array("3.	Group-work is more fun than studying alone","lk_group_fun"),
  array("4.	I learn more efficiently by myself than in a group","lk_alone_efficient"),
  array("5.	Traditional teacher-focused education is more efficient than group-work","lk_teacher_efficient"),
  array("6.	In order to learn it is important that the group works closely together","lk_close_work_learning"),
  array("7.	I often get help from other group members","lk_help_from_members"),
  array("8.	I like group-work","lk_group_work_like"),
  array("9.	In group work one person often ends up doing most of the work","lk_one_does_most"),
  array("10.	I am happy to take on the role of the leader in a group-work context","lk_happy_as_leader"),
  array("11.	Group-work fits my study habits","lk_group_fits_habits"),
  array("12.	Group discussions are often a waste of time","lk_group_discuss_waste")
);
foreach ($args as $value){
  $question = $value[0];
  $pref = $value[1];
  echo "<div style=\"border:1px solid gray; border-right-width:0px;border-left-width:0px\">";
  echo "<label \">$question</label>";
  echo "<div id=\"".$pref."_div_$x\">";
  echo "<div class=\"pure-g\">";
  echo "<div style=\"background-color:#F2F2F2\" class=\"pure-u-1-5\"><label for=\"".$pref."_1_$x\" class=\"pure-radio\"><input id=\"".$pref."_1_$x\" type=\"radio\" name=\"".$pref."_$x\" value=\"Strongly Disagree\">Strongly Disagree</label></div>";
  echo "<div class=\"pure-u-1-5\"><label for=\"".$pref."_2_$x\" class=\"pure-radio\"><input id=\"".$pref."_2_$x\" type=\"radio\" name=\"".$pref."_$x\" value=\"Somewhat Disagree\">Somewhat Disagree</label></div>";
  echo "<div style=\"background-color:#F2F2F2\" class=\"pure-u-1-5\"><label for=\"".$pref."_3_$x\" class=\"pure-radio\"><input id=\"".$pref."_3_$x\" type=\"radio\" name=\"".$pref."_$x\" value=\"Neutral\">Neutral</label></div>";
  echo "<div class=\"pure-u-1-5\"><label for=\"".$pref."_4_$x\" class=\"pure-radio\"><input id=\"".$pref."_4_$x\" type=\"radio\" name=\"".$pref."_$x\" value=\"Somewhat Agree\">Somewhat Agree</label></div>";
  echo "<div style=\"background-color:#F2F2F2\" class=\"pure-u-1-5\"><label for=\"".$pref."_5_$x\" class=\"pure-radio\"><input id=\"".$pref."_5_$x\" type=\"radio\" name=\"".$pref."_$x\" value=\"Strongly Agree\">Strongly Agree</label></div>";
  echo "</div>";
  echo "</div>";
  // echo "<div class=\"pure-g\">";
  // echo "<div style=\"background-color:#F2F2F2\" class=\"pure-u-1-5\"><label for=\"".$pref."_1_$x\" class=\"pure-radio\"><input id=\"".$pref."_1_$x\" type=\"radio\" name=\"".$pref."_$x\" value=\"Strongly Disagree\"></label></div>";
  // echo "<div class=\"pure-u-1-5\"><label for=\"".$pref."_2_$x\" class=\"pure-radio\"><input id=\"".$pref."_2_$x\" type=\"radio\" name=\"".$pref."_$x\" value=\"Somewhat Disagree\"></label></div>";
  // echo "<div style=\"background-color:#F2F2F2\" class=\"pure-u-1-5\"><label for=\"".$pref."_3_$x\" class=\"pure-radio\"><input id=\"".$pref."_3_$x\" type=\"radio\" name=\"".$pref."_$x\" value=\"Neutral\"></label></div>";
  // echo "<div class=\"pure-u-1-5\"><label for=\"".$pref."_4_$x\" class=\"pure-radio\"><input id=\"".$pref."_4_$x\" type=\"radio\" name=\"".$pref."_$x\" value=\"Somewhat Agree\"></label></div>";
  // echo "<div style=\"background-color:#F2F2F2\" class=\"pure-u-1-5\"><label for=\"".$pref."_5_$x\" class=\"pure-radio\"><input id=\"".$pref."_5_$x\" type=\"radio\" name=\"".$pref."_$x\" value=\"Strongly Agree\"></label></div>";
  // echo "</div>";
  echo "</div>";

}
echo "</div>";
echo "</div>";

echo "</fieldset>";
// echo "<hr />";
echo "</div>";


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
        <hr>
        	<button class="pure-button pure-button-primary" type="submit">Submit</button>



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
