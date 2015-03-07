<?php
	session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>Coagmento</title>
	<style type="text/css">
	/*margin and padding on body element
	  can introduce errors in determining
	  element position and are not recommended;
	  we turn them off as a foundation for YUI
	  CSS treatments. */
	body {
		margin:0;
		padding:0;
	}
	</style>

	<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.7.0/build/fonts/fonts-min.css" />
	<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.7.0/build/tabview/assets/skins/sam/tabview.css" />
	<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/yahoo-dom-event/yahoo-dom-event.js"></script>

	<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/connection/connection-min.js"></script>
	<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/element/element-min.js"></script>
	<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/tabview/tabview-min.js"></script>

	<script type="text/javascript">
		setInterval ("tabsReload()", 3000);
		setInterval ("chatReady()", 1000);
//		setInterval ("setChatScroll()", 1000);

		function chatSet() {
//			alert('setting chat');
//			ajaxpage('sidebarChat.php', 'chat');
			setChatStatus();
			ajaxpage('sidebarChat.php', 'chat');
			setChatScroll();
		}
	</script>

	<!--begin custom header content for this example-->
	<style type="text/css">
	.yui-navset div.loading div {
	    background:url(assets/loading.gif) no-repeat center center;
	}

	#example-canvas h2 {padding: 0 0 .5em 0;}
	</style>
	<!--end custom header content for this example-->
</head>

<body class="yui-skin-sam" onload="chatSet();">
<?php
	require_once("connect.php");
	$pageName = "CSpace/sidebar.php";
	require_once("../counter.php");

	$userID = $_SESSION['userID'];
	if (isset($_SESSION['projectID']))
		$projectID = $_SESSION['projectID'];
	else {
		$query = "SELECT projects.projectID FROM projects,memberships WHERE memberships.userID='$userID' AND projects.description LIKE '%Untitled project%' AND projects.projectID=memberships.projectID";
		$results = mysql_query($query) or die(" ". mysql_error());
		$line = mysql_fetch_array($results, MYSQL_ASSOC);
		$projectID = $line['projectID'];
	}
	if (isset($_POST['message'])) {
		$query = "SELECT * FROM users WHERE userID='$userID'";
		$results = mysql_query($query) or die(" ". mysql_error());
		$line = mysql_fetch_array($results, MYSQL_ASSOC);
		$userName = $line['username'];
		$color = $line['color'];
		$message = addslashes($_POST['message']);
		// Get the date, time, and timestamp
		$timestamp = time();
		$datetime = getdate();
	    $date = date('Y-m-d', $datetime[0]);
		$time = date('H:i:s', $datetime[0]);
		$query = "INSERT INTO chat VALUES('','$userID','$userName','$color','$projectID','$message','$timestamp','$date','$time')";
		$results = mysql_query($query) or die(" ". mysql_error());
	}
?>
<div id="chat" style="background-color:#FFFFFF;height:200px;overflow:auto;">Loading chat...</div>
<div id="chatMessage">
<form name="f" action="sidebar.php" method=post>
	<input id="t" type="text" size=25 name="message"/>
	<input type="submit" value="Send" />
</form>
</div>
<?php
	if (isset($_POST['message'])) {
		echo "\t<script type=\"text/javascript\">\n\tdocument.f.message.focus();\n";
		echo "\tsetChatStatus();\n";
		echo "\t</script>\n";
//		echo "chatBox = document.getElementById('chat');\n";
//		echo "chatBox.scrollTop = chatBox.scrollHeight;\n</script>\n";
	}
?>
<div id="container" style="height:240px;overflow:hidden;"></div>

<script type="text/javascript">
	var bustcachevar = 1; //bust potential caching of external pages after initial request? (1=yes, 0=no)
	var loadedobjects = "";
	var rootdomain = "http://"+window.location.hostname;
	var bustcacheparameter = "";

	// Function to load an external URL in a container
	function ajaxpage(url, containerid) {
		var page_request = false;
		if (window.XMLHttpRequest) // if Mozilla, Safari etc
			page_request = new XMLHttpRequest();
		else if (window.ActiveXObject){ // if IE
			try {
				page_request = new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch (e){
				try{
					page_request = new ActiveXObject("Microsoft.XMLHTTP");
				}
				catch (e){}
			}
		}
		else
			return false;

		page_request.onreadystatechange=function() {
			loadpage(page_request, containerid)
		}

		if (bustcachevar) //if bust caching of external page
			bustcacheparameter=(url.indexOf("?")!=-1)? "&"+new Date().getTime() : "?"+new Date().getTime();
		page_request.open('GET', url+bustcacheparameter, true);
		page_request.send(null);
	}

	// Function to load a page in a container by making a HTTP request
	function loadpage(page_request, containerid){
		if (page_request.readyState == 4 && (page_request.status==200 || window.location.href.indexOf("http")==-1))
			document.getElementById(containerid).innerHTML=page_request.responseText;
	}

	// Create a YUI TabView control
	var tabView = new YAHOO.widget.TabView();

	(function() {
	    tabView.addTab(new YAHOO.widget.Tab({
	        label: 'Queries',
	        dataSrc: 'sidebarQueries.php',
	        content: 'Loading queries...',
	        cacheData: false
	    }));

	    tabView.addTab(new YAHOO.widget.Tab({
	        label: 'Docs',
	        dataSrc: 'sidebarDocs.php',
	        content: 'Loading saved docs...',
	        cacheData: false
	    }));

	    tabView.addTab(new YAHOO.widget.Tab({
	        label: 'Snippets',
	        dataSrc: 'sidebarSnippets.php',
	        content: 'Loading saved snippets...',
	        cacheData: false
	    }));

	    tabView.appendTo('container');

	    activeTab = tabView.getTab(0);
	    activeTab.addListener('click', queriesActive);
	    activeTab.addListener('contentChange', queriesReady);

	    activeTab = tabView.getTab(1);
	    activeTab.addListener('click', docsActive);
	    activeTab.addListener('contentChange', docsReady);

	    activeTab = tabView.getTab(2);
	    activeTab.addListener('click', snippetsActive);
	    activeTab.addListener('contentChange', snippetsReady);

	    var tabIndex = readCookie('CSpace_sidebarTab');
		tabView.selectTab(tabIndex);
		if (readCookie('CSpace_sidebarTab')==null)
		    document.cookie = 'CSpace_sidebarTab=0; expires=""; path=/';
	})();

	// Function to execute when queries tab becomes active.
	function queriesActive(e) {
		var tabIndex = readCookie('CSpace_sidebarTab');
		switch (tabIndex) {
			case '1':
				var docsBox = document.getElementById('docsBox');
				var scrollHeight = docsBox.scrollTop;
				document.cookie = 'CSpace_docsScroll='+scrollHeight+'; expires=""; path=/';
				break;

			case '2':
				var snippetsBox = document.getElementById('snippetsBox');
				var scrollHeight = snippetsBox.scrollTop;
				document.cookie = 'CSpace_snippetsScroll='+scrollHeight+'; expires=""; path=/';
				break;
		}

		document.cookie = 'CSpace_sidebarTab=0; expires=""; path=/';
	}

	// Function to execute when docs tab becomes active.
	function docsActive(e) {
		var tabIndex = readCookie('CSpace_sidebarTab');
		switch (tabIndex) {
			case '0':
				var queriesBox = document.getElementById('queriesBox');
				var scrollHeight = queriesBox.scrollTop;
				document.cookie = 'CSpace_queriesScroll='+scrollHeight+'; expires=""; path=/';
				break;

			case '2':
				var snippetsBox = document.getElementById('snippetsBox');
				var scrollHeight = snippetsBox.scrollTop;
				document.cookie = 'CSpace_snippetsScroll='+scrollHeight+'; expires=""; path=/';
				break;
		}
		document.cookie = 'CSpace_sidebarTab=1; expires=""; path=/';
	}

	// Function to execute when the snippets tab becomes active.
	function snippetsActive(e) {
		var tabIndex = readCookie('CSpace_sidebarTab');
		switch (tabIndex) {
			case '0':
				var queriesBox = document.getElementById('queriesBox');
				var scrollHeight = queriesBox.scrollTop;
				document.cookie = 'CSpace_queriesScroll='+scrollHeight+'; expires=""; path=/';
				break;

			case '1':
				var docsBox = document.getElementById('docsBox');
				var scrollHeight = docsBox.scrollTop;
				document.cookie = 'CSpace_docsScroll='+scrollHeight+'; expires=""; path=/';
				break;
		}
		document.cookie = 'CSpace_sidebarTab=2; expires=""; path=/';
	}

	function setChatScroll () {
//		alert('called');
		var chatBox = document.getElementById('chat');
//		var scrollHeight = chatBox.scrollHeight;
		chatBox.scrollTop = 5000;
	}

	function setChatStatus() {
		document.cookie = 'CSpace_chatStatus=0; expires=""; path=/';
	}

	// Refresh chat and online status
	function chatReady(e) {
		req = new phpRequest("http://<?php echo $_SERVER['HTTP_HOST']; ?>/CSpace/chatStatus.php");
		var projectID = readCookie('CSpace_projectID');
		req.add('projectID', projectID);
		var response = req.execute();
		var previousStatus = readCookie('CSpace_chatStatus');
//		alert(previousStatus+', '+response);

		if (response!=previousStatus || (previousStatus==0)) {
//			alert(previousStatus+', '+response);
			ajaxpage('sidebarChat.php', 'chat');
			setChatScroll();
			document.cookie = 'CSpace_chatStatus='+response+'; expires=""; path=/';
		}

		ajaxpage('sidebarOnlineStatus.php', 'online');

//		var chatBox = document.getElementById('chat');
//		var scrollHeight = chatBox.scrollHeight;
//		var scrollHeight = readCookie('CSpace_chatScroll');
//		chatBox.scrollTop = scrollHeight;
	}

	// Refresh queries list
	function queriesReady(e) {
		var queriesBox = document.getElementById('queriesBox');
		var scrollHeight = readCookie('CSpace_queriesScroll');
		queriesBox.scrollTop = scrollHeight;
	}

	// Refresh saved docs list
	function docsReady(e) {
		var docsBox = document.getElementById('docsBox');
		var scrollHeight = readCookie('CSpace_docsScroll');
		docsBox.scrollTop = scrollHeight;
	}

	// Refresh saved snippets list
	function snippetsReady(e) {
		var snippetsBox = document.getElementById('snippetsBox');
		var scrollHeight = readCookie('CSpace_snippetsScroll');
		snippetsBox.scrollTop = scrollHeight;
	}

	// Refresh the tabs. However, we need to reload only the active tab.
	function tabsReload() {
		var tabIndex = readCookie('CSpace_sidebarTab');

		// See which tab was active
		switch (tabIndex) {
			case '0':
				var queriesBox = document.getElementById('queriesBox');
				var scrollHeight = queriesBox.scrollTop;
				document.cookie = 'CSpace_queriesScroll='+scrollHeight+'; expires=""; path=/';
				break;

			case '1':
				var docsBox = document.getElementById('docsBox');
				var scrollHeight = docsBox.scrollTop;
				document.cookie = 'CSpace_docsScroll='+scrollHeight+'; expires=""; path=/';
				break;

			case '2':
				var snippetsBox = document.getElementById('snippetsBox');
				var scrollHeight = snippetsBox.scrollTop;
				document.cookie = 'CSpace_snippetsScroll='+scrollHeight+'; expires=""; path=/';
				break;
		}

		// Chat is always active
/*
		var chatBox = document.getElementById('chat');
		var scrollHeight = chatBox.scrollTop;
		document.cookie = 'CSpace_chatScroll='+scrollHeight+'; expires=""; path=/';
*/

		tabView.selectTab(tabIndex); // Re-select the active tab, thus reloading its content
//		chatReady(); // Refresh the chat
	}

	// Read a cookie's value
	function readCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	}

	//Start phpRequest Object
	function phpRequest(serverScript) {
		//Set some default variables
		this.parms = new Array();
		this.parmsIndex = 0;

		//Set the server url
		this.server = serverScript;

		//Add two methods
		this.execute = phpRequestExecute;
		this.add = phpRequestAdd;
	}

	function phpRequestAdd(name,value) {
	    //Add a new pair object to the params
	    this.parms[this.parmsIndex] = new pair(name,value);
	    this.parmsIndex++;
	}

	//var lastURL = "";

	function phpRequestExecute() {
	    //Set the server to a local variable
	    var targetURL = this.server;

	    //Try to create our XMLHttpRequest Object
	    try {
	        var httpRequest = new XMLHttpRequest();
	    }
	    catch (e) {
	        alert('Error creating the connection!');
	        return;
	    }

	    //Make the connection and send our data
	    try {
	        var txt = "?1";
	        for(var i in this.parms) {
	            txt = txt+'&'+this.parms[i].name+'='+this.parms[i].value;
	        }
	        //Two options here, only uncomment one of these
	        //GET REQUEST
			var currentURL = targetURL+txt;
	//		if (currentURL != lastURL) {
	//			lastURL = currentURL;
		        httpRequest.open("GET", currentURL, false, null, null);
		        httpRequest.send('');
	//		}
	    }
	    catch (e) {
	//        alert('An error has occured calling the external site: '+e);
	        return false;
	    }

	    //Make sure we received a valid response
	    switch(httpRequest.readyState) {
	        case 1,2,3:
	 //           alert('Bad Ready State: '+httpRequest.status);
	            return false;
	            break;
	        case 4:
	            if(httpRequest.status !=200) {
	 //               alert('The server respond with a bad status code: '+httpRequest.status);
	                return false;
	            }
	            else {
	                var response = httpRequest.responseText;
	            }
	            break;
	    }
	    return response;
	}

	function pair(name,value) {
	    this.name = name;
	    this.value = value;
	}
</script>

<div id="online">Loading online status...</div>

<hr/>
<div id="static">
	<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/" target=_content><font color=blue>Coagmento Homepage</font></a> &bull;
	<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/CSpace/" target=_content><font color=blue>CSpace</font></a><br/>
	<hr/>
	<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/CSpace/profile.php" target=_content><font color=blue>My profile</font></a> &bull;
	<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/CSpace/log.php" target=_content><font color=blue>My log</font></a> &bull;
	<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/CSpace/report.php" target=_content><font color=blue>Generate report</font></a>
	<hr/>
	<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/CSpace/collaborators.php" target=_content><font color=blue>My collaborators</font></a> &bull;
	<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/CSpace/projects.php" target=_content><font color=blue>My projects</font></a>
	<hr/>
	<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/CSpace/documentation.php" target=_content><font color=blue>Documentation</font></a> &bull;
	<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/CSpace/updates.php" target=_content><font color=blue>Updates</font></a> (1.1a) &bull;
	<a href="mailto:chirag@unc.edu?subject=Coagmento" target=_content><font color=blue>Contact</font></a>
	<hr/>
</div>
</body>
</html>
