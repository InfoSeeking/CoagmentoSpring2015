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
	setInterval ("refreshPage()", 5000);
	var bustcachevar = 1; //bust potential caching of external pages after initial request? (1=yes, 0=no)
	var loadedobjects = "";
	var rootdomain = "http://"+window.location.hostname;
	var bustcacheparameter = "";

	function loadPage() {
		var tabIndex = readCookie("CSpace_sidebarTab");
		switch (tabIndex) {
			case '0':
				ajaxpage('sidebarChat.php', 'chatBox');
				var chatBox = document.getElementById('chatBox');
				chatBox.scrollTop = chatBox.scrollHeight;
				var height = chatBox.scrollHeight;
				document.f.message.focus();
				break;
			case '1':
				ajaxpage('sidebarQueries.php', 'queriesBox');
				queriesReady();
/*
				var queriesBox = document.getElementById('queriesBox');
				var name = queriesBox.id;
//				alert(name);
				queriesBox.scrollTop = 160;
				var height = queriesBox.scrollHeight;
//				alert(height);
*/
				break;
			case '2':
				ajaxpage('sidebarDocs.php', 'docsBox');
				break;
			case '3':
				ajaxpage('sidebarSnippets.php', 'snippetsBox');
				break;
		}
	}

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
			return false

		page_request.onreadystatechange=function() {
			loadpage(page_request, containerid)
		}

		if (bustcachevar) //if bust caching of external page
			bustcacheparameter=(url.indexOf("?")!=-1)? "&"+new Date().getTime() : "?"+new Date().getTime();
		page_request.open('GET', url+bustcacheparameter, true);
		page_request.send(null);
	}

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

	function loadpage(page_request, containerid){
		if (page_request.readyState == 4 && (page_request.status==200 || window.location.href.indexOf("http")==-1))
			document.getElementById(containerid).innerHTML=page_request.responseText;
	}
</script>

<!--begin custom header content for this example-->
<style type="text/css">
.yui-navset div.loading div {
    background:url(assets/loading.gif) no-repeat center center;
    height:8em; /* hold some space while loading */
}

#example-canvas h2 {padding: 0 0 .5em 0;}
</style>

<!--end custom header content for this example-->

</head>

<body class="yui-skin-sam">
<?php
	require_once("connect.php");
	$userID = $_SESSION['userID'];
	$projectID = $_SESSION['projectID'];
	if (isset($_POST['message'])) {
		$query = "SELECT username FROM users WHERE userID='$userID'";
		$results = mysql_query($query) or die(" ". mysql_error());
		$line = mysql_fetch_array($results, MYSQL_ASSOC);
		$userName = $line['username'];
		$message = addslashes($_POST['message']);
		// Get the date, time, and timestamp
		$timestamp = time();
		$datetime = getdate();
	    $date = date('Y-m-d', $datetime[0]);
		$time = date('H:i:s', $datetime[0]);
		$query = "INSERT INTO chat VALUES('','$userID','$userName','$projectID','$message','$timestamp','$date','$time')";
		$results = mysql_query($query) or die(" ". mysql_error());
	}
?>
<div id="container" style="height:400px;overflow:hidden;">

<script type="text/javascript">
	var tabView = new YAHOO.widget.TabView("demo");

	tabView.addTab(new YAHOO.widget.Tab({
        label: 'Chat',
        dataSrc: 'sidebarChat.php',
        content: '',
        cacheData: false,
        dataTimeout: 500,
        active: true
    }));

    tabView.addTab(new YAHOO.widget.Tab({
        label: 'Queries',
        dataSrc: 'sidebarQueries.php',
        content: '',
        cacheData: false
    }));

    tabView.addTab(new YAHOO.widget.Tab({
        label: 'Docs',
        dataSrc: 'sidebarDocs.php',
        content: '',
        cacheData: false
    }));

    tabView.addTab(new YAHOO.widget.Tab({
        label: 'Snippets',
        dataSrc: 'sidebarSnippets.php',
        content: '',
        cacheData: false
    }));
	var tab0 = myTabs.getTab(0);
	function handleContentChange(e) {
        alert(e.prevValue);
    }

	tab0.addListener('contentChange', handleContentChange);
    tab0.set('content', '<p>Updated tab content.</p>';
</script>

<div id="demo" class="yui-navset">
    <ul class="yui-nav">
        <li class="selected"><a href="#tab1"><em>Tab One Label</em></a></li>
        <li><a href="#tab2"><em>Tab Two Label</em></a></li>
        <li><a href="#tab3"><em>Tab Three Label</em></a></li>
    </ul>
    <div class="yui-content">
        <div><p>Tab One Content</p></div>
        <div><p>Tab Two Content</p></div>
        <div><p>Tab Three Content</p></div>
    </div>
</div>

<script type="text/javascript">
//	var myTabs = new YAHOO.widget.TabView('demo');
//	alert(test);
//	alert(myTabs);
</script>

<hr/>
<div id="static">
<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/" target=_content><font color=blue>Coagmento Homepage</font></a><br/>
<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/CSpace/" target=_content><font color=blue>CSpace</font></a><br/>
<hr/>
<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/CSpace/profile.php" target=_content><font color=blue>My profile</font></a><br/>
<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/CSpace/log.php" target=_content><font color=blue>My log</font></a><br/>
<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/CSpace/report.php" target=_content><font color=blue>Generate report</font></a>
<hr/>
<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/CSpace/projects.php" target=_content><font color=blue>My projects</font></a><br/>
<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/CSpace/collaborators.php" target=_content><font color=blue>My collaborators</font></a><br/>
<hr/>
<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/CSpace/documentation.php" target=_content><font color=blue>Documentation</font></a><br/>
<a href="mailto:chirag@unc.edu?subject=Coagmento" target=_content><font color=blue>Contact</font></a>
<hr/>
</div>
</body>
</html>
