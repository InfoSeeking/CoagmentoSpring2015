<?php
	session_start();
	require_once("connect.php");
	if (isset($_SESSION['CSpace_userID'])) {
		$userID = $_SESSION['CSpace_userID'];
		if (isset($_SESSION['CSpace_projectID']))
			$projectID = $_SESSION['CSpace_projectID'];
		else {
			$query = "SELECT projects.projectID FROM projects,memberships WHERE memberships.userID='$userID' AND (projects.description LIKE '%Untitled project%' OR projects.description LIKE '%Default project%') AND projects.projectID=memberships.projectID";
			$results = mysql_query($query) or die(" ". mysql_error());
			$line = mysql_fetch_array($results, MYSQL_ASSOC);
			$projectID = $line['projectID'];
		}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="Coagmento icon" type="image/x-icon" href="../img/favicon.ico">
	<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.7.0/build/fonts/fonts-min.css" />
	<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.7.0/build/tabview/assets/skins/sam/tabview.css" />
	<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/yahoo-dom-event/yahoo-dom-event.js"></script>

	<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/connection/connection-min.js"></script>
	<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/element/element-min.js"></script>
	<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/tabview/tabview-min.js"></script>

	<script type="text/javascript" src="js/utilities.js"></script>

	<script type="text/javascript">

		setInterval ("refresh()", 5000);
		setInterval ("getNotifications()", 7000);
                //Verify from where the sidebar was loaded. If the trigger was the login page, then the main content page is reloaded in order to update the toolbar.
                if (gup("flagLogin")=="true")
                    window._content.location = "http://<?php echo $_SERVER['HTTP_HOST']; ?>/CSpace/"; //Due to Firefox security policies, it cannot load pages tha are out of the domain. It is possible, however, changing the properties

		var projID = 0;

		function initialize() {
			// Get the active project
			req = new phpRequest("http://<?php echo $_SERVER['HTTP_HOST']; ?>/CSpace/checkStatus.php");
			req.add('version','300');
			req.add('object','chat');
			var response = req.execute();
			var res = response.split(":");
			if (res[0]>0)
				projID = res[1];
		}

		function loadAll() {
//			ajaxpage('sidebarChat.php','chat');
			ajaxpage('collabOnline.php', 'collabOnline');
			var chatMessages = document.getElementById('chatMessages');
			chatMessages.scrollTop = chatMessages.scrollHeight;
		}

		function refresh() {
			ajaxpage("currentProj.php", 'currentProj');
			req = new phpRequest("http://<?php echo $_SERVER['HTTP_HOST']; ?>/CSpace/checkStatus.php");
			req.add('version','300');
			req.add('object','chat');
			var response = req.execute();
			var res = response.split(":");
			if (res[0]>0) {
				if (projID!=res[1])
				location.reload(true);
			}
			else {
				// Status for chat
				req = new phpRequest("http://<?php echo $_SERVER['HTTP_HOST']; ?>/CSpace/objectStatus.php");
				req.add('version','300');
				req.add('object','chat');
				var response = req.execute();
				if (response==1) {
					ajaxpage('chatList.php','chatMessages');
					var chatMessages = document.getElementById('chatMessages');
					chatMessages.scrollTop = chatMessages.scrollHeight;
				}
			}
		}

		function getNotifications() {
			ajaxpage('notifications.php','notifications');
		}

		function addAction (action, value) {
			req = new phpRequest("http://<?php echo $_SERVER['HTTP_HOST']; ?>/CSpace/addAction.php");
			req.add('action', action);
			req.add('value', value);
			var response = req.execute();
		}
	</script>
	<title>Coagmento</title>
	<link rel="stylesheet" href="css/styles.css" type="text/css" />
</head>

<body onload="initialize();refresh();getNotifications();" background=#FFFFFF>
<table class="body">
	<tr>
		<td>
<!-- 			<div id="statusMessage">&nbsp;&nbsp;<span style="font-size:10px;color:red;">Warning: Coagmento is turned off.</span><br/>&nbsp;&nbsp;<span style="color:blue;text-decoration:underline;cursor:pointer;font-size:10px;" onClick="tabsReload(0,'source');">Activate it</span>. <span style="color:blue;text-decoration:underline;cursor:pointer;font-size:10px;" onClick="tabsReload(0,'source');">Learn more.</span></div> -->
				<span style="font-size:10px;"><div id="currentProj"></div></span>
<!-- 				<div id="reload"><span style="font-size:11px;color:blue;text-decoration:underline;cursor:pointer;" onClick="location.reload(true);">Reload the Sidebar</div> -->
			<ul class="acc2" id="acc2">

				<?php
					$query1 = "SELECT * FROM options WHERE userID='$userID' AND `option`='sidebar-chat'";
					$results1 = mysql_query($query1) or die(" ". mysql_error());
					$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
					$value = $line1['value'];
					if (!$value || $value=='on') {
				?>
				<li>
					<h4><img src="../img/chat.jpg" width=36 style="vertical-align:middle;border:0" /> Chat<br/><span style="color:gray;font-size:10px;">Chat with collaborators of the active project.</span></h4>
					<div class="acc-section2">
						<div id="chat" class="acc-content2">
							<?php
								require_once("sidebarChat.php");
							?>
						</div>
					</div>
				</li>
				<?php
					}
				?>

				<?php
					$query1 = "SELECT * FROM options WHERE userID='$userID' AND `option`='sidebar-history'";
					$results1 = mysql_query($query1) or die(" ". mysql_error());
					$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
					$value = $line1['value'];
					if (!$value || $value=='on') {
				?>
				<li>
					<h4><img src="../img/history.jpg" width=32 style="vertical-align:middle;border:0" />&nbsp; History<br/><span style="color:gray;font-size:10px;">See personal/shared history and objects.</span></h4>
					<div class="acc-section2">
						<div id="history" class="acc-content2">
							<?php
								require_once("sidebarHistory.php");
							?>
						</div>
					</div>
				</li>
				<?php
					}
				?>

				<?php
					$query1 = "SELECT * FROM options WHERE userID='$userID' AND `option`='sidebar-notepad'";
					$results1 = mysql_query($query1) or die(" ". mysql_error());
					$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
					$value = $line1['value'];
					if (!$value || $value=='on') {
				?>
				<li>
					<h4><img src="../img/notepad.jpg" width=30 style="vertical-align:middle;border:0" />&nbsp;&nbsp; Notepad<br/><span style="color:gray;font-size:10px;">Write/share notes for the active project.</span></h4>
					<div class="acc-section2">
						<div id="notepad" class="acc-content2">
							<?php
								require_once("sidebarNotepad.php");
							?>
						</div>
					</div>
				</li>
				<?php
					}
				?>

				<?php
					$query1 = "SELECT * FROM options WHERE userID='$userID' AND `option`='sidebar-notifications'";
					$results1 = mysql_query($query1) or die(" ". mysql_error());
					$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
					$value = $line1['value'];
					if (!$value || $value=='on') {
				?>
				<li>
					<h4><img src="../img/notification.jpg" width=38 style="vertical-align:middle;border:0" /> Notifications<br/><span style="color:gray;font-size:10px;">Recent actions of your collaborators.</span></h4>
					<div class="acc-section2">
						<div id="notifications" class="acc-content2">
							No notifications available.
						</div>
					</div>
				</li>
				<?php
					}
				?>
			</ul>
		</td>
	</tr>
</table>

<script type="text/javascript" src="script.js"></script>

<script type="text/javascript">

var parentAccordion=new TINY.accordion.slider("parentAccordion");
parentAccordion.init("acc2","h4",0,-1);

var nestedAccordion=new TINY.accordion.slider("nestedAccordion");
nestedAccordion.init("nested","h4",1,-1,"acc-selected");

</script>
<?php
                    /*function redirect($loc){
                        echo "<script>window._content.location.href='".$loc."'</script>";
                    }

                    if($_GET['flagLogin']=="true")
                        redirect("http://<?php echo $_SERVER['HTTP_HOST']; ?>/CSpace/");*/


	} // if (isset($_SESSION['CSpace_userID']))
	else {
		echo "Your session has expired. Please <a href=\"http://".$_SERVER['HTTP_HOST']."/loginOnSideBar.php\" target=_self style=\"color:blue;text-decoration:underline;cursor:pointer;\">login</a> again.\n";
	}
?>
</body>
</html>
