<?php
	session_start();
	ob_start();
	require_once("header.php");
	require_once("connect.php");
	$pageName = "CSpace/updates.php";
	require_once("../counter.php");
		
	// If the user tried to login	
	if (isset($_SESSION['userID'])) {
		$userID = $_SESSION['userID'];
?>
		<br/>
		<center>
		<table class="body" width=90%>
			<tr><td>This page lists the updates with Coagmento toolbar/sidebar as well as CSpace. Note that updates in CSpace usually do not require any updates on the client side. Some of the updates for toolbar/sidebar can also be accessed without updating your installation of Coagmento. With each of the updates for toolbar/sidebar, supported versions are indicated. So you know if you need to update your Coagmento installation or not. We recommend you keep the latest version, as some of the features of CSpace may not work with previous versions of Coagmento toolbar/sidebar.</td></tr>
			<tr bgcolor=#CCFFAA><td><strong>Updates for CSpace</strong></td></tr>
			<tr><td>
			<ul>
				<li>Support for filtering the <a href="log.php">log</a> using results as objects. (05/15/2009)</li>
				<li>Objects (docs, queries, snippets, notes) can be moved from one project to another through your <a href="log.php">log page</a>. (05/15/2009)</li>
				<li><a href="log.php">Log page</a> now shows the log of the active project instead of all the projects. (05/15/2009)</li>
			</ul></td></tr>
			<tr bgcolor=#CCFFAA><td><strong>Updates for Coagmento toolbar/sidebar</strong></td></tr>
			<tr><td>
			<ul>
				<li>(1.0a-1.1a) Fixed a bug that reported wrong views for a page sometimes. (05/19/2009)</li>
				<li>(1.1a) Support for 'Untitled' project. Now all you need to get started is to login. Project 'Untitled' is selected by default. Together with the ability of moving objects around in your CSpace (see above), this allows one to do unplanned/serendipitous browsing, and then later organize/share the results. (05/15/2009)</li>
				<li>(1.1a) Once logged in, it is possible now to start saving documents, collecting snippets, or making annotations without selecting an active project. (05/15/2009)</li>
				<li>(1.1a) Clicking on the project status portion of toolbar takes one to one's log page for that project. (05/15/2009)</li>
				<li>(1.0a-1.1a) Improved chat. (05/15/2009)</li>
				<li>(1.0a) Rearranged tabs in the sidebar. Chat now remains open all the time. (05/06/2009)</li>
				<li>(1.0a) Objects in the tabs are displayed in chronological order. (05/06/2009)</li>
				<li>(1.0a) Status of your collaborators (for a given project) is now shown in the sidebar. (05/06/2009)</li>
				<li>(1.0a) A link to this page (updates) added. Next to this link will be the latest version of Coagmento Firefox extension. (05/06/2009)</li>
			</ul></td></tr>
			<tr bgcolor=#CCFFAA><td><strong>Downloads</strong></td></tr>
			<tr><td><a href="../downloads/coagmento_1.1a.xpi">Coagmento Firefox extension 1.1a</a> (Release: 05/15/2009)</td></tr>
			<tr><td><a href="../downloads/coagmento_1.0a.xpi">Coagmento Firefox extension 1.0a</a> (Release: 05/05/2009)</td></tr>
		</table>
		</center>
		<br/><br/>
<?php
	}
	else {
		echo "<br/><br/><center>\n<table class=\"body\">\n";
		echo "<tr><td>Sorry. Looks like we had trouble knowing who you are!<br/>Please try <a href=\"index.php\">logging in</a> again.</td></tr>\n";
		echo "</table>\n</center>\n<br/><br/><br/><br/>\n";
	} 		
	require_once("footer.php");
?>
  <!-- end #footer --></div>
<!-- end #container --></div>

</body>
</html>
