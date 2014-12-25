<?php
	session_start();
	if (!isset($_SESSION['CSpace_userID'])) {
		echo "<br/><br/>Sorry. Your session has expired. Please <a href=\"http://www.coagmento.org\">login again</a>.";
	}
	else {
?>
<script type="text/javascript" src="js/utilities.js"></script>
<table class="body" width=100%>
	<tr><td style="font-weight:bold;"><span style="color:blue;text-decoration:underline;cursor:pointer;font-weight:bold;" onClick="ajaxpage('main.php','content');">CSpace</span> > Messages</td><td align="right"><img src="../img/messages.jpg" height=50 style="vertical-align:middle;border:0" /> <span style="font-weight:bold;font-size:20px">Messages</span></td></tr>
</table>
<table class="body" width=100%>
	<tr>
		<td>
			<?php			
				$loginCount = $_GET['loginCount'];	
				if ($loginCount<=1) {
					echo "Have you seen the video tutorials about how to use Coagmento? If not, please return to <a href=\"http://www.coagmento.org\">Coagmento's homepage</a> and watch those tutorials.<br/><br/>";
					echo "Since this is the first time you are logging in, you may want to access our <span style=\"color:blue;text-decoration:underline;cursor:pointer;\" onClick=\"ajaxpage('help.php', 'content');\">help page</span> to get started on using Coagmento. From this page you can download the latest version of Coagmento plugin for Firefox.<br/><br/>\n";
					echo "Remember, at any time, you can access your CSpace by clicking on 'CSpace' button on your Coagmento toolbar. Using your CSpace, you can manage your data, projects and collaborators. You can also explore different patterns from your browsing history and prepare research reports.";
				}
				else if ($loginCount>1 && $loginCount<=10) {
					echo "Have you seen the video tutorials about how to use Coagmento? If not, please return to <a href=\"http://www.coagmento.org\">Coagmento's homepage</a> and watch those tutorials.<br/><br/>";
					echo "Remember to turn on Coagmento by clicking on 'Activate' on the toolbar. This will let Coagmento record the addresses of the websites you visit and the searches you do while you are logged in. Coagmento never stores any passwords or other sensitive information about you and you always can turn the recording off, or even delete the recorded data later.<br/><br/>";
					echo "You seem to have used Coagmento a few times. How are things going? Care to share your views with us? Click <span style=\"color:blue;text-decoration:underline;cursor:pointer;\" onClick=\"ajaxpage('../feedback.php', 'content');\">here</span> to submit your feedback.";
				}
				else if ($loginCount>10) {
					echo "Looks like you have had a chance to use Coagmento quite a bit. Care to share your views with us? Click <span style=\"color:blue;text-decoration:underline;cursor:pointer;\" onClick=\"ajaxpage('../feedback.php', 'content');\">here</span> to submit your feedback.";
				}
			?>
			<br/>
			Since Coagmento is work-in-progress, there may be bugs and some things may not work as fast or as effective as desired. Have patience! And provide us <span style="color:blue;text-decoration:underline;cursor:pointer;" onClick="ajaxpage('../feedback.php','content');">your feedback</span>. On the <span style="color:blue;text-decoration:underline;cursor:pointer;" onClick="ajaxpage('help.php','content');">help page</span> you can also see a number of 'how-to's.
		</td>
	</tr>
</table>
<?php
	}
?>