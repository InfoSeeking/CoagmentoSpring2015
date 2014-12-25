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
        require_once "chat/src/phpfreechat.class.php"; // adjust to your own path
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
        echo $projectTitle.$projectID;
        $params["dyn_params"] = array("nick","frozen_channels");
        $params["max_channels"] = 1;
        //$params['frozen_nick'] = true;
        $params["max_msg"] = 0;
        $params["max_nick_len"]   = 20;
        $params['admins'] = array('admin'  => 'soportechatSummer2011');
        $params['skip_proxies'] = array('censor','noflood');
        $chat = new phpFreeChat($params);
        echo "start";
        $chat->handleRequest("/send 74bc4e574a665657d2f36068bca5b9d8 0d9c71628ad7d374933678ada7fb11ca AJAX_TEST");
        echo "end";
    }
  }
  else {
    echo "Your session has expired. Please <a href=\"http://www.coagmento.org/loginOnSideBar.php\" target=_self style=\"color:blue;text-decoration:underline;cursor:pointer;\">login</a> again.\n";
  }
?>


</body>
</html>