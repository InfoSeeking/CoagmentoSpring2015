<?php
	session_start();
	if (!isset($_SESSION['CSpace_userID'])) {
		echo "<br/><br/>Sorry. Your session has expired. Please <a href=\"http://www.coagmento.org\">login again</a>.";
	}
	else {
?>
<script type="text/javascript" src="js/utilities.js"></script>
<table class="body" width=100%>
	<tr><td style="font-weight:bold;"><span style="color:blue;text-decoration:underline;cursor:pointer;font-weight:bold;" onClick="ajaxpage('main.php','content');">CSpace</span> > Issues</td><td align="right"><img src="../img/issues.jpg" height=50 style="vertical-align:middle;border:0" /> <span style="font-weight:bold;font-size:20px">Known Issues</span></td></tr>
</table>
<table class="body" width=100%>
	<tr>
		<td>
			<ul>
				<li>The toolbar/sidebar may slow down the browser unexpectadly. Some instances are reported, but a consisent reason has not been determined.</li>
				<li>Toolbar does not update the information immediately. The update happens once the page is reloaded, or a new tab or window is selected.</li>
				<li>There is an issue with changing the projects. When you choose a different project as your active project, you should see the 'Current project' name changed above. If it doesn't, reload the page.</li>
			</ul>
		</td>
	</tr>
</table>
<br/>
Had any other issues? <span style="color:blue;text-decoration:underline;cursor:pointer;" onClick="ajaxpage('../feedback.php', 'content');">Please tell us</span>.
<?php
	}
?>