<?php
	session_start();
	if (!isset($_SESSION['CSpace_userID'])) {
		echo "<br/><br/>Sorry. Your session has expired. Please <a href=\"http://www.coagmento.org\">login again</a>.";
	}
	else {
		$userID = $_SESSION['CSpace_userID'];
		require_once("connect.php");
		$query = "SELECT * FROM users WHERE userID='$userID'";
		$results = mysql_query($query) or die(" ". mysql_error());
		$line = mysql_fetch_array($results, MYSQL_ASSOC);
		$name = $line['firstName'] . " " . $line['lastName'];
		$loginCount = $line['loginCount'];
		$type = $line['type'];
?>
<table class="body" width=100%>
	<tr><td><img src="../img/tip.jpg" height=25 /><span style="font-weight:bold;">Tip</span>: <?php require_once("getTip.php");?></td><td align="right"><img src="../img/cspace.jpg" height=50 style="vertical-align:middle;border:0" /> <span style="font-weight:bold;font-size:20px">CSpace</span></td></tr>
	<tr bgcolor="#C3D9FF"><td colspan=2>&nbsp;&nbsp;Visit the <span style="color:blue;text-decoration:underline;cursor:pointer;" onClick="ajaxpage('help.php', 'content');">help page</span> to download the Coagmento plug-in - your first step to start harvesting the power of Coagmento!</td></tr>
<!--
	<tr bgcolor="#EFEFEF"><td colspan=2>&nbsp;&nbsp;<span style="font-weight:bold;">New:</span> you can choose your sidebar modules from the <span style="color:blue;text-decoration:underline;cursor:pointer;" onClick="ajaxpage('settings.php','content');">settings</span>.</td></tr>
	<tr bgcolor="#EFEFEF"><td colspan=2>&nbsp;&nbsp;<span style="font-weight:bold;">New:</span> you can now create and join <span style="color:blue;text-decoration:underline;cursor:pointer;" onClick="ajaxpage('showPublicProjs.php','content');">open (public) projects</span>.</td></tr>
-->
</table>
	<?php
		$query = "SELECT * FROM actions WHERE action='download' AND userID='$userID' AND value='2.3'";
		$results = mysql_query($query) or die(" ". mysql_error());
		if (mysql_num_rows($results)==0) 
			echo "<img src=\"../img/download.jpg\" height=25px/> <span style=\"color:green;font-weight:bold;\">A new version of Coagmento Firefox plugin is available.</span> Go to the <span style=\"color:blue;text-decoration:underline;cursor:pointer;\" onClick=\"ajaxpage('help.php', 'content');\">help page</span> to download it.<br/><br/>\n";
	?>
<table class="body" width=100%>
	<tr>
		<td width=60% valign=top>
			<table class="body" width=100%>
				<tr><td align=left valign=center><img src="../img/updates.jpg" height=25px style="vertical-align:middle;" /> <span style="color:blue;text-decoration:underline;cursor:pointer;font-weight:bold;" onClick="ajaxpage('updates.php', 'content');">Updates</span></td></tr>
				<tr>
				<?php
					$query1 = "SELECT lastActionTimestamp FROM users WHERE userID='$userID'";
					$results1 = mysql_query($query1) or die(" ". mysql_error());
					$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
					$lastActionTimestamp = $line1['lastActionTimestamp'];
					
					$query2 = "SELECT count(*) as num FROM memberships,actions WHERE actions.projectid=memberships.projectid AND actions.userid!='$userID' and memberships.userid='$userID' AND actions.timestamp>='$lastActionTimestamp' AND actions.action='page'";
					$results2 = mysql_query($query2) or die(" ". mysql_error());
					$line2 = mysql_fetch_array($results2, MYSQL_ASSOC);
					$numPages = $line2['num'];
					
					$query2 = "SELECT count(*) as num FROM memberships,actions WHERE actions.projectid=memberships.projectid AND actions.userid!='$userID' and memberships.userid='$userID' AND actions.timestamp>='$lastActionTimestamp' AND actions.action='query'";
					$results2 = mysql_query($query2) or die(" ". mysql_error());
					$line2 = mysql_fetch_array($results2, MYSQL_ASSOC);
					$numQueries = $line2['num'];
					
					$query2 = "SELECT count(*) as num FROM memberships,actions WHERE actions.projectid=memberships.projectid AND actions.userid!='$userID' and memberships.userid='$userID' AND actions.timestamp>='$lastActionTimestamp' AND actions.action='save-snippet'";
					$results2 = mysql_query($query2) or die(" ". mysql_error());
					$line2 = mysql_fetch_array($results2, MYSQL_ASSOC);
					$numSnippets = $line2['num'];
					
					$query2 = "SELECT count(distinct actions.projectID) as num FROM memberships,actions WHERE actions.projectid=memberships.projectid AND actions.userid!='$userID' and memberships.userid='$userID' AND actions.timestamp>='$lastActionTimestamp'";
					$results2 = mysql_query($query2) or die(" ". mysql_error());
					$line2 = mysql_fetch_array($results2, MYSQL_ASSOC);
					$numProj = $line2['num'];
					
				?>
					<td>Since your last login,
						<ul>
							<li>Your collaborators viewed <?php echo $numPages;?> webpages, ran <?php echo $numQueries;?> searches, and saved <?php echo $numSnippets;?> snippets in <?php echo $numProj;?> different projects.</li>
<!-- 							<li>The system found ?? new links betwteen different objects in your data.</li> -->
<!-- 							<li>The system collected ?? new results for your monitoring searches.</li> -->
						</ul>
					</td>
				</tr>
			</table>
		</td>
		<td width=40% valign=top>
			<table class="body" width=100%>
				<tr><td align=left valign=center><img src="../img/messages.jpg" height=25px style="vertical-align:middle;" /> <span style="color:blue;text-decoration:underline;cursor:pointer;font-weight:bold;" onClick="ajaxpage('messages.php?loginCount=<?php echo $loginCount;?>','content');">Messages</span></td></tr>
				<tr>
					<td>
						<?php				
							if ($loginCount<=1) {
								echo "Have you seen the video tutorials about how to use Coagmento? If not, please return to <a href=\"http://www.coagmento.org\">Coagmento's homepage</a> and watch those tutorials.<br/><br/>";
								echo "Since this is the first time you are logging in, you may want to access our <span style=\"color:blue;text-decoration:underline;cursor:pointer;\" onClick=\"ajaxpage('help.php', 'content');\">help page</span> to get started on using Coagmento. From this page you can download the latest version of Coagmento plugin for Firefox.<br/><br/>\n";
								echo "Remember, at any time, you can access your CSpace by clicking on 'CSpace' button on your Coagmento toolbar. Using your CSpace, you can manage your data, projects and collaborators. You can also explore different patterns from your browsing history and prepare research reports.";
							}
							else if ($loginCount>1 && $loginCount<=10) {
								echo "Have you seen the video tutorials about how to use Coagmento? If not, please return to <a href=\"http://www.coagmento.org\">Coagmento's homepage</a> and watch those tutorials.<br/><br/>";
								echo "Remember to turn on Coagmento by clicking on 'Activate' or 'Turn On' on the toolbar. This will let Coagmento record the addresses of the websites you visit and the searches you do while you are logged in. Coagmento never stores any passwords or other sensitive information about you and you always can turn the recording off, or even delete the recorded data later.<br/><br/>";
								echo "You seem to have used Coagmento a few times. How are things going? Care to share your views with us? Click <span style=\"color:blue;text-decoration:underline;cursor:pointer;\" onClick=\"ajaxpage('../feedback.php', 'content');\">here</span> to submit your feedback.";
							}
							else if ($loginCount>10) {
								echo "Looks like you have had a chance to use Coagmento quite a bit. Care to share your views with us? Click <span style=\"color:blue;text-decoration:underline;cursor:pointer;\" onClick=\"ajaxpage('../feedback.php', 'content');\">here</span> to submit your feedback.";
							}
						?>
					</td>
				</tr>
				<tr bgcolor="#C3F9FF">
					<td align=center>
						<span style="color:blue;text-decoration:underline;cursor:pointer;" onClick="ajaxpage('recommendCoagmento.php','content');">Recommend</span> Coagmento and earn points!
					</td>
				</tr>
				<tr bgcolor="#C3F9FF">
					<td align=center>
						<a href="http://www.facebook.com/share.php?u=http%3A%2F%2Fwww.coagmento.org%2F"><img src="../img/facebook.jpg" style="vertical-align:middle;border:0" height=30px /></a> <a href="http://www.facebook.com/share.php?u=http%3A%2F%2Fwww.coagmento.org%2F">Share on Facebook!</a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan=2><br/></td></tr>
	<tr>
		<td width=60% valign=top>
			<table class="body" width=100%>
				<tr><td align=left valign=center><img src="../img/help.jpg" height=25px style="vertical-align:middle;" /> <span style="color:blue;text-decoration:underline;cursor:pointer;font-weight:bold;" onClick="ajaxpage('help.php', 'content');">Help</span></td></tr>
				<tr>
					<td>
						Coagmento is a system, which includes a <span style="font-weight:bold;">plugin</span> that you install in your Firefox browser, and <span style="font-weight:bold;">CSpace</span>, your online space to manage your online information gathered using the plugin.<br/>
						You are in your CSpace. To start using Coagmento, please <span style="color:blue;text-decoration:underline;cursor:pointer;" onClick="ajaxpage('help.php', 'content');">download and install</span> a Firefox plugin. More instructions can be found on the <span style="color:blue;text-decoration:underline;cursor:pointer;" onClick="ajaxpage('help.php', 'content');">help page</span>. 
					</td>
				</tr>
				<tr><td><br/></td></tr>
				<tr>
					<td>
						Want to create a new project? Expand the 'Projects' tab on the left. Want to add a collaborator? Expand the 'Collaborators' tab on the left. Optionally, you can also click on the projects or collaborators numbers reported at the top here.
					</td>
				</tr>
			</table>
		</td>
		<td width=40% valign=top>
			<table class="body" width=100%>
				<tr><td align=left valign=center><img src="../img/issues.jpg" height=25px style="vertical-align:middle;" /> <span style="color:blue;text-decoration:underline;cursor:pointer;font-weight:bold;" onClick="ajaxpage('issues.php', 'content');">Known issues</span></td></tr>
				<tr>
					<td>
						<ul>
							<li>The toolbar/sidebar may slow down the browser unexpectedly. Some instances are reported, but a consistent reason has not been determined.</li>
							<li>Toolbar does not update the information immediately. The update happens once the page is reloaded, or a new tab or window is selected.</li>
						</ul>
					</td>
				</tr>
			</table>
		</td>
	</tr>	
</table>
<br/>
<table>
	<tr><td><hr/></td></tr>
	<?php
		if (preg_match("/subject/", $type)) {
//			echo "<tr bgcolor=#EFEFEF><td>The Coagmento Beta Testing Study is over and the winners of various prizes have been notified. Thank you for participating.</td></tr>\n";
			echo "<tr bgcolor=#EFEFEF><td>You have signed up for using Coagmento in your school project. If you have also signed the consent form to participate in our beta testing study, you may win $25 iTunes Gift Cards based on the <span style=\"color:blue;text-decoration:underline;cursor:pointer;\" onClick=\"ajaxpage('points.php','content');\">points</span> you earn. Check out the <span style=\"color:blue;text-decoration:underline;cursor:pointer;\" onClick=\"ajaxpage('studyTerms.php','content');\">details</span>.</td></tr>\n";

			$query = "SELECT * FROM actions WHERE action='demographic' AND userID='$userID'";
			$results = mysql_query($query) or die(" ". mysql_error());
			if (mysql_num_rows($results)==0) 
				echo "<tr bgcolor=#EFEFEF><td><span style=\"font-weight:bold\">Important</span>: you still haven't submitted your demographic information. Please do this ASAP to remain qualified for winning the prizes. Click <span style=\"color:blue;text-decoration:underline;cursor:pointer;\" onClick=\"ajaxpage('demographic.php', 'content');\">here</span>.</td></tr>\n";
			$query = "SELECT * FROM actions WHERE action='pre-study' AND userID='$userID'";
			$results = mysql_query($query) or die(" ". mysql_error());
			if (mysql_num_rows($results)==0) 
				echo "<tr bgcolor=#EFEFEF><td><span style=\"font-weight:bold\">Important</span>: you still haven't submitted your pre-study information. Please do this ASAP to remain qualified for winning the prizes. Click <span style=\"color:blue;text-decoration:underline;cursor:pointer;\" onClick=\"ajaxpage('preStudy.php', 'content');\">here</span>.</td></tr>\n";
				
			$query = "SELECT * FROM actions WHERE action='mid-study' AND value='2' AND userID='$userID'";
			$results = mysql_query($query) or die(" ". mysql_error());
			if (mysql_num_rows($results)==0) 
				echo "<tr bgcolor=#EFEFEF><td><span style=\"font-weight:bold\">New</span>: Please fill in the <span style=\"color:blue;text-decoration:underline;cursor:pointer;\" onClick=\"ajaxpage('midStudy.php', 'content');\">mid-study questionnaire</span> to qualify for this month's prizes.</td></tr>\n";
			$query = "SELECT * FROM actions WHERE action='end-study' AND userID='$userID'";
			$results = mysql_query($query) or die(" ". mysql_error());
			if (mysql_num_rows($results)==0) 
				echo "<tr bgcolor=#EFEFEF><td><span style=\"font-weight:bold\">New</span>: Please fill in the <span style=\"color:blue;text-decoration:underline;cursor:pointer;\" onClick=\"ajaxpage('endStudy.php', 'content');\">end-study questionnaire</span> to qualify for <span style=\"font-weight:bold\">$25 iTunes Gift Cards</span>.</td></tr>\n";

		}
		else {
//			echo "<tr bgcolor=#EFEFEF><td>Since you are already trying out Coagmento, why not earn some rewards for doing so? <span style=\"color:blue;text-decoration:underline;cursor:pointer;\" onClick=\"ajaxpage('studyTerms.php','content');\">Sign up</span> as an official beta tester! All you have to do is use Coagmento regularly and provide us some feedback. In return, you will be entered in monthly drawings for prizes, such as the <span style=\"font-weight:bold\">new iPod Nanos</span>. It's that easy!</td></tr>";
		}
	?>
	<tr><td><hr/></td></tr>
</table>
<?php
	}
?>