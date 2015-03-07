<?php
	session_start();
	ob_start();
	require_once("header.php");
	require_once("connect.php");
	$pageName = "CSpace/documentation.php";
	require_once("../counter.php");
		
	// If the user tried to login	
	if (isset($_SESSION['userID'])) {
		$userID = $_SESSION['userID'];
?>
		<br/>
		<center>
		<table class="body" width=90%>
			<tr bgcolor=#CCFFAA><td><strong>What is Coagmento?</strong></td></tr>
			<tr><td>Coagmento is Latin for "working together" or "joining together". Project Coagmento is initiated to (1) understand how people seek and use information in collaboration, (2) methods and techniques that are used in such explicitly defined collaborations, and (3) create tools and services to support Collaborative Information Seeking (CIS).</td></tr>
			<tr bgcolor=#CCFFAA><td><strong>What are Coagmento toolbar and sidebar?</strong></td></tr>
			<tr><td>Coagmento toolbar and sidebar are Firefox extensions (or add-on or plug-in). They work on any platform that Firefox works on and they are supported on Firefox 1.5 and higher. You need to have Javascript and cookies enabled in your browser. You can download the latest version (1.0a) from <a href="http://www.coagmento.org/downloads/coagmento_1.0a.xpi">here</a>.</td></tr>
			<tr bgcolor=#CCFFAA><td><strong>Installing the plug-in</strong></td></tr>
			<tr><td>There are two simple ways to install Coagmento plug-in.<br/>You can click <a href="http://www.coagmento.org/downloads/coagmento_1.0a.xpi">here</a>. Firefox may ask you if you trust this website and/or want to install this software. Accept all that and you will be guided through the installation process.<br/>			
			The other option is to download the plug-in from <a href="http://www.coagmento.org/downloads/coagmento_1.0a.xpi">here</a> by right clicking on that link and saving the file to your hard drive. Now drag and drop the downloaded file to your browser window. Firefox will guide you through the installation process for this extension.<br/>At the end of any one of the above methods, you will have to restart your browser to make the extension effective.<br/>Once you restart the browser, click on 'View->Toolbars->Coagmento Toolbar' to view the toolbar, and click on 'View->Sidebars->Coagmento Sidebar' to view the sidebar. The sidebar can also be opened or closed using the shortcut Option+Shift+C on Mac, or Ctrl+Shift+C on PC. Now you are good to go!</td></tr>		
			<tr bgcolor=#CCFFAA><td><strong>Using Coagmento toolbar</strong></td></tr>
			<tr><td>Before you can start using Coagmento toolbar or sidebar, you need to login to your CSpace (explained below). A typical snapshot of Coagmento toolbar is presented in Figure 1 and its functionality described below.
			<ul>
			<li><em>CSpace</em>: Clicking on this button takes you to your CSpace (described later).</li>
			<li><em>Activate/Deactivate</em>: Once clicked the button shows 'Deactivate', and all the sites that you visit and queries you use in your browser are recorded in your CSpace. You can click on this button again (Deactivate) to stop this recording.</li>
			<li><em>Save/Remove</em>: Use this button to save or remove an already saved page.</li>
			<li><em>Snip</em>: You can highlight a part of a page and click this button to save that part as a snippet. While saving a snippet, you also have an option of making some notes about that snippet.</li>
			<li><em>Annotate</em>: Use this to make some notes about the current page (irrespective of saving a snippet).</li>
			<li><em>Page status</em>: The next section on the right shows various statistics about the displayed page. Clicking on 'View count', 'Snippets', or 'Annotations' brings up more information about them.</li>
			<li><em>Project status</em>: The right-most section of the toolbar displays the latest statistics about the project that you are working on.</li>
			</ul>
			Note that the toolbar is constantly in sync with the server. Therefore, you always get the latest information displayed. This information is culmination of all the collaborators for the given project.
			</td></tr>
			<tr><td align=center><a href="../img/coagmento_toolbar.jpg"><img src="../img/coagmento_toolbar.jpg"/ width=800></a><br/><em>Figure 1: Snapshot of Coagmento toolbar</em><br/>
			</td></tr>
			<tr bgcolor=#CCFFAA><td><strong>Using Coagmento sidebar</strong></td></tr>
			<tr><td>Coagmento sidebar has four tabs as shown in Figure 2. The 'Chat' tab enables one to communicate with the collaborators of the current project. The 'Queries', 'Docs', and 'Snippets' tabs list the queries, saved documents, and saved snippets for the active project. All of these objects are presented with the username of the collaborator who used/saved them. Clicking on any of these objects brings it up in the browser window (opened in the currently active tab).<br/>Similar to the toolbar, the sidebar is also constantly in sync with the server, providing the latest information about your project. This means, it also has persistent information. You won't loose any information by closing the sidebar.
			</td></tr>
			<tr><td align=center>
			<a href="../img/coagmento_sidebar1.jpg"><img src="../img/coagmento_sidebar1.jpg"/ width=200 height=350></a>&nbsp;&nbsp;<a href="../img/coagmento_sidebar2.jpg"><img src="../img/coagmento_sidebar2.jpg"/ width=200 height=350></a>&nbsp;&nbsp;<a href="../img/coagmento_sidebar3.jpg"><img src="../img/coagmento_sidebar3.jpg"/ width=200 height=350></a>&nbsp;&nbsp;<a href="../img/coagmento_sidebar4.jpg"><img src="../img/coagmento_sidebar4.jpg"/ width=200 height=350></a><br/><em>Figure 2: Snapshots of Coagmento sidebar</em>
			</td></tr>
			<tr bgcolor=#CCFFAA><td><strong>What is CSpace?</strong></td></tr>
			<tr><td>CSpace is your collaborative space (or Coagmento Space). It is intended to give you a workspace where you can track your projects and collaborations. When you activate the Coagmento toolbar (described above), several actions that you do in your browser, such as visiting a website and executing a query, will start getting recorded in your CSpace. In addition to this, you can also make notes and collect snippets from webpages, and they are all collected in your CSpace.</td></tr>
			<tr bgcolor=#CCFFAA><td><strong>Using CSpace</strong></td></tr>
			<tr><td>Once you login to your CSpace, you can access your <a href="profile.php">profile</a>, look at the <a href="log.php">data</a> collected in your CSpace, or create <a href="report.php">reports</a>.<br/>You can also add <a href="collaborators.php">collaborators</a> to your projects, and create new <a href="projects.php">projects</a>. Note that in order to have your toolbar and sidebar working properly, you need to select one of your projects as an active project. This can be done by simply clicking on the name of that project in your CSpace.</td></tr>
			<tr bgcolor=#CCFFAA><td><strong>Privacy</strong></td></tr>
			<tr><td>Once you 'Activate' the Coagmento toolbar, the following actions are recorded: (1) sites that you visit (either by typing a URL or clicking a link), and (2) queries you use on search engines and certain sites, (3) any page that you mark 'Save' using the toolbar, (4) any snippet that you collect, (5) any annotation that you make. They are all recorded with the timestamps.<br/>All of these recorded actions and objects are available through your <a href="log.php">log</a>. You can delete any of the entries that we have recorded on the server.<br/>You also have read-access to such actions of your collaborators. These actions and objects (including yours) can be seen when you <a href="report.php">generate a report.</a><br/>Other personal information about you, such as your name, email, password, etc. can be accessed by you only and are never shared. Your password is always encrypted and no one (other than yourself) can know it!</td></tr>
			<tr bgcolor=#CCFFAA><td><strong>Known issues and limitations</strong></td></tr>
			<tr><td>Following are some of the issues and limitations with Coagmento. If you find more, let us know!
			<ul>
			<li>Some special characters are not handled right while collecting snippets.</li>
			<li>Status updates and sidebar refreshes may not be very responsive on slower internet connections.</li>
			<li>Sometimes discrepancies are found between the server status and the client status regarding user's login. This results in client side reporting statistics about a project that is actually not active on the server side. This can be resolved by re-logging in the server (visit your CSpace).</li>
			<li>Since chat is set to refresh every five seconds, it may disrupt a message being typed if the refreshing happens during the typing.</li>
			</ul>
			</td></tr>
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
