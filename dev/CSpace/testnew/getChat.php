<?php
	session_start();
	require_once("connect.php");
	if (isset($_SESSION['CSpace_userID'])) {
		$userID = $_SESSION['CSpace_userID'];
		if (isset($_SESSION['CSpace_projectID']))
                {
			$projectID = $_SESSION['CSpace_projectID'];
                        $projectTitle = $_SESSION['CSpace_projectTitle'];
                }
		else {
			$query = "SELECT projects.projectID, title FROM projects,memberships WHERE memberships.userID='$userID' AND (projects.description LIKE '%Untitled project%' OR projects.description LIKE '%Default project%') AND projects.projectID=memberships.projectID";
			$results = mysql_query($query) or die(" ". mysql_error());
			$line = mysql_fetch_array($results, MYSQL_ASSOC);
			$projectID = $line['projectID'];
                        $projectTitle = $line['$title'];
		}

              if ($projectTitle=="")
                  $projectTitle="Default";

              if (($projectID > 0)&&($projectTitle != ""))
              {
                  require_once "../CSpace/chat/src/phpfreechat.class.php"; // adjust to your own path
                  //echo $projectID." - ".$projectTitle;
                  $params["serverid"] = md5(__FILE__);
                  /*$params["container_type"] = "Mysql";
                  $params["container_cfg_mysql_host"] = "localhost";
                  $params["container_cfg_mysql_database"] = "shahonli_coagmento";
                  $params["container_cfg_mysql_username"] = "shahonli_super";
                  $params["container_cfg_mysql_password"] = "superman-2010!";*/
                  $params["nick"] = $_SESSION['userName'].$userID; //$_POST['nickname'];
                  $params["title"] = "Coagmento";
                  $params["display_ping"] = FALSE;
                  $params["displaytabclosebutton"] = FALSE;
                  $params["showwhosonline"] = FALSE;
                  $params["btn_sh_whosonline"] = TRUE;
                  $params["displaytabimage"]= FALSE;
                  $params["height"]= "180px";
                  $params["startwithsound"] = TRUE;
                  $params["max_text_len"] = 5000;
                  $params["timeout"] = 10000;
                  $params["date_format"] = "m/d/Y";
                  $params["time_format"] = "H:i";
                  $params["short_url_width"] = 20;
                  $params["showsmileys"] = FALSE;
                  //$params["connect_at_startup"] = FALSE;
                  //$params["frozen_channels"] = array();
                  //$params["frozen_channels"] = array($projectTitle.$projectID);
                  $params["channels"] = array($projectTitle.$projectID);
                  $params["dyn_params"] = array("nick","frozen_channels");
                  $params["max_channels"] = 1;
                  //$params['frozen_nick'] = true;
                  $params["max_msg"] = 0;
                  $params["max_nick_len"]   = 20;
                  $params['admins'] = array('admin'  => 'soportechatSummer2011');
                  $params['skip_proxies'] = array('censor','noflood');
                  $chat = new phpFreeChat($params);
              }
  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	
	<title>Coagmento Sidebar</title>
  	<style type="text/css">
                    .cursorType{
                            cursor:pointer;
                            cursor:hand;
                    }

        </style>
    </head>

<body background=#FFFFFF>

<table>
	<tr>
		<td>
<!-- 			<div id="statusMessage">&nbsp;&nbsp;<span style="font-size:10px;color:red;">Warning: Coagmento is turned off.</span><br/>&nbsp;&nbsp;<span style="color:blue;text-decoration:underline;cursor:pointer;font-size:10px;" onClick="tabsReload(0,'source');">Activate it</span>. <span style="color:blue;text-decoration:underline;cursor:pointer;font-size:10px;" onClick="tabsReload(0,'source');">Learn more.</span></div> -->
				<span style="font-size:10px;"><div id="currentProj"></div></span>
<!-- 				<div id="reload"><span style="font-size:11px;color:blue;text-decoration:underline;cursor:pointer;" onClick="location.reload(true);">Reload the Sidebar</div>-->

							<?php
                                                            if (($projectID > 0)&&($projectTitle != ""))
                                                            {
                                                                $chat->printChat();
                                                           
                                                            }
                                                             else
                                                             {
                                                                 echo "In order to use the chat you must select a project first.";
                                                             }
								//require_once("sidebarChat.php");
							?>
		</td>
	</tr>
</table>


<?php
	} 
	else {
		echo "Your session has expired. Please <a href=\"http://www.coagmento.org/loginOnSideBar.php\" target=_self style=\"color:blue;text-decoration:underline;cursor:pointer;\">login</a> again.\n";
	}
?>
</body>
</html>