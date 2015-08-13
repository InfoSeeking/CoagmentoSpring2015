<?php
	require_once('core/Connection.class.php');

    $closed=false;
    if(!$closed){
?>
<html>
<head>
	<title>
    	 Interactive Search Study: Consent Form
    </title>
        <link rel="stylesheet" type="text/css" href="styles.css" />
<script type="text/javascript">

	var alertColor = "Red";
	var okColor = "White";


	function validateForm(form)
	{
		//hello
		var isValid = 1;
		form.action = "signup.php";
	}


	function enableAccept(check)
	{
		if (check.checked)
			document.getElementById("acceptReg").disabled = false;
		else
			document.getElementById("acceptReg").disabled = true;
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
<div id="signupConsent" align="center">
	<h3>Interactive Search Study: Consent Form</h3>
	<form method="post" onsubmit="return validateForm(this)">
		<table class="style1" width=90%>
			<tr>
			  <td colspan=2>
			  <p>PLEASE <strong>READ</strong> THE FOLLOWING INFORMATION <strong>CAREFULLY</strong> AND YOUR CONSENT TO PARTICIPATE IN THIS STUDY.</p>
				<li><strong>Conducted by:</strong> Rutgers University School of Communication and Information</li>
  	 			<li><strong>Project: </strong> 	CIS3: Collaborative Information Seeking Support and Services in Libraries [IRB Protocol #E13-046]</li>
				<li><strong>Principal Investigator:</strong>	Dr. Chirag Shah (<a href="mailto:chirags@rutgers.edu?subject=Study inquiry">chirags@rutgers.edu</a>)</li>
				<li><strong>Co-Investigators:</strong> 	Chris Leeder (<a href="mailto:chris.leeder@rutgers.edu?subject=Study inquiry">chris.leeder@rutgers.edu</a>)
                </li>
				<li><strong>Duration of the Session: </strong>	1 hour</li>
				<li><strong>Number of Sessions: </strong>	1</li>
				<li><strong>Total Compensation: </strong>	$10</li>
				<li><strong>Approximate # of Participants: </strong>	60</li>
				<li><strong>Participation limitations: </strong>	Normal or corrected to normal vision and hearing, normal motor control, and at least 18 years old</li>
				</ul>


				<p><strong>General:</strong> You are being asked to participate in a research project.</p>
				<p><strong>Study Description: </strong> We are conducting a study to understand users' search behavior in the information seeking process. We wish to obtain feedback on the functions and usefulness of our interactive search system, and on your experience while performing search tasks.</p>
<p><strong>Procedures:</strong> If you decide to be in this study, you will attend a session in a lab at the Alexander Library during which you will search for sources for your 01:355:201 Research in the Disciplines assignment using a custom Firefox plugin. Instruction will be given in using the plugin. </p>
				<p><strong>Benefits:</strong> There is no direct benefit to you; however, your participation will help in assisting the researchers understand user search behavior to design better interfaces and provide better personalizations in information seeking tasks. If you are interested in receiving the published results of our study you may contact one of the researchers above. </p>
				<p><strong>Costs: </strong>There are no costs to you for participating in this study.</p>
				<p><strong>Compensation to You:</strong> You will be paid $10 for your participation in this study in both sessions. Please note that no compensation will be given for partial participation. You must complete the full hour session.</p>
				<p><strong>Foreseeable Risks or Discomforts:</strong> This study is expected to involve no more than minimal risks associated with the motor control and movements involved with operating a computer.</p>
				<p><strong>Confidentiality: </strong>This research is confidential. The research records will include some information about you and this information will be stored in such a manner that some linkage between your identity and the response in the research exists. Some of the information collected about you includes your name and email. This information will be coded such that no identifying information about you will be revealed. Also note that we will keep this information confidential by limiting access to the research data and keeping it in a secure location and in password-protected servers. The research team and the Institutional Review Board (a committee that reviews research studies in order to protect research participants) at Rutgers University are the only parties that will be allowed to see the data, except as may be required by law. If a report of this study is published, or the results are presented at a professional conference, only group results will be stated. All study data will be kept for three years.</p>
				<p>Participation in this study is confidential. Any information collected about you will be kept private to the extent allowed by law.</p>
				<p><strong>Contact Persons: </strong>If you have questions about the IRB, call or write the principle investigator above at: Chirag Shah, 4 Huntington street, New Brunswick, NJ 08901 848-932-8807 or contact via <a href="mailto:chirags@rutgers.edu?subject=Study inquiry">email</a>. For general questions about the user study, contact the co-investigator via <a href="mailto:chris.leeder@rutgers.edu?subject=Study inquiry">email</a>.</p>
				<p><strong>Statement of Rights: </strong>You have rights as a research volunteer. Taking part in this study is completely voluntary. If you do not take part, you will have no penalty. You may stop taking part in this study at any time with no penalty. You do not waive legal rights by signing this consent form. If you have any questions about your rights as a research volunteer, call or write the IRB Administrator at Rutgers University at:</p>
					<p>
					 Rutgers University Institutional Review Board for the Protection of Human Subjects
					<br>Office of Research and Sponsored Programs
					<br>3 Rutgers Plaza
					<br>New Brunswick, NJ 08901-8559
					<br>Tel: 848-932-0150
					<br>Email: <a href="mailto:humansubjects@orsp.rutgers.edu?subject=IRB Protocol #E13-046 Study inquiry">humansubjects@orsp.rutgers.edu</a>
					<br>
					<br>
					</p>

			</td>
			</tr>

			<tr>
				<td>
					<p><input type="checkbox" name="readConsent" id="readConsent" onclick="enableAccept(this)" /><strong> I HAVE READ AND UNDERSTOOD THE TERMS AND CONDITIONS AND LIKE TO PROVIDE MY CONSENT TO PARTICIPATE IN THIS STUDY. </strong></p>
				</td
			</tr>
			<tr>
					<td align="center" colspan=2>
						<input type="submit" id="acceptReg" value="Accept" disabled=true style="width:100px; height:40px;"/>
						<input type="hidden" id="consentRead" name="consentRead"/>
					</td>

			</tr>
		</table>
    </form>
</div>
</body>
</html>

<?php
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
