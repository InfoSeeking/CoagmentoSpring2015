<?php
	session_start();
	require_once('../core/Base.class.php');
	require_once('../core/Connection.class.php');
	require_once('../core/Settings.class.php');
	require_once('../core/Stage.class.php');
	require_once('../core/Util.class.php');

	$base = Base::getInstance();
	$settings = Settings::getInstance();
	$homeURL = $settings->getHomeURL();
	$page = "";

	$base->checkTimeout();

	if(!$base->isSessionActive()){
			header("Location: loginOnSideBar.php");
			exit("NO");
	}
	//echo "Allow Comm: ".$stage->getAllowCommunication();
    $projectID = $base->getProjectID();
		 	$b = $base->getAllowCommunication();
			$br = $base->getAllowBrowsing();
		 	$s = isset($_SESSION['CSpace_userID']);
		  // Util::getInstance()->saveAction("testing sidebar $b $br $s",$base->getStageID(),$base);

	/*---COMMENTED OUT ON 05/23/2014-----*/
	if ($base->getAllowCommunication()==1)
	{
    			/*
                 *
                 * SIMPLIFIED CHAT
                 *
                 *

                require_once "chat/src/phpfreechat.class.php"; // adjust to your own path
			    $params["serverid"] = md5(__FILE__);
    			$params["dyn_params"] = array("nick"); //,"frozen_channels");
    			$params["max_channels"] = 1;
    			//$params["channels"] = array("chat".$base->getProjectID()."-".$base->getQuestionID());
    			$params["nick"] = $base->getUserName();
    			$params["short_url"] = false;
    			$params["display_ping"] = false;
    			$params["displaytabimage"]= false;
    			$params["displaytabclosebutton"] = false;
    			$params["showwhosonline"] = false;
    			$params["showsmileys"] = false;
    			$params["time_format"] = "H:i";
    			$params["timeout"] = 1000000;
    			$params["max_msg"] = 0;
    			//$params["shownotice"] = 2;
    			$params["max_text_len"] = 5000;
    			$params['skip_proxies'] = array('censor','noflood');
    			$params["height"]= "180px";
    			$params["title"] = "Coagmento";
    			$params['admins'] = array('admin'  => 'soportechat');
    			//$params["connect_at_startup"] = true;
  				$params["refresh_delay"] = 2000; // 2000ms = 2s
  				$chat = new phpFreeChat($params);
                 *
                 *
                 *
                 */

        /*
         *
         * COMPLICATED CHAT
         *
         */
        require_once "phpfreechat-1.7/src/phpfreechat.class.php"; // adjust to your own path
        //echo $projectID." - ".$projectTitle;
        $projectTitle = "Group ";
        $params["serverid"] = md5(__FILE__);
        /*$params["container_type"] = "Mysql";
         $params["container_cfg_mysql_host"] = "localhost";
         $params["container_cfg_mysql_database"] = "shahonli_coagmento";
         $params["container_cfg_mysql_username"] = "shahonli_super";
         $params["container_cfg_mysql_password"] = "superman-2010!";*/
        $params["nick"] = $base->getUserName(); //$_POST['nickname'];
        $params["title"] = "ITI 220";
        $params["display_ping"] = FALSE;
        $params["displaytabclosebutton"] = FALSE;
        $params["display_pfc_logo"] = FALSE;
        $params["showwhosonline"] = FALSE;
        $params["btn_sh_whosonline"] = false;
        $params["displaytabimage"]= FALSE;
        $params["height"]= "180px";
        //$params["startwithsound"] = TRUE;
        $params["max_text_len"] = 5000;
        $params["timeout"] = 10000;
        //$params["date_format"] = "m/d/Y";
        //$params["time_format"] = "H:i";
        //$params["short_url_width"] = 20;
        $params["showsmileys"] = FALSE;
        //$params["connect_at_startup"] = FALSE;
        //$params["frozen_channels"] = array();
        //$params["frozen_channels"] = array($projectTitle.$projectID);
        $params["channels"] = array($projectTitle.$projectID);
        //$params["dyn_params"] = array("nick","frozen_channels");
        $params["dyn_params"] = array("nick"); //,"frozen_channels");
        $params["max_channels"] = 1;
        //$params['frozen_nick'] = true;
        $params["max_msg"] = 0;
        //$params["max_nick_len"]   = 20;
        //$params['admins'] = array('admin'  => 'soportechatSummer2011');
        $params['admins'] = array('admin'  => 'soportechat');
        $params['skip_proxies'] = array('censor','noflood');
        $params["refresh_delay"] = 2000;

				$params["btn_sh_smileys"] = false;

				//To refresh cache, set this flag to true, then in chat box type /rehash
      //  $params["isadmin"] = TRUE;
        $chat = new phpFreeChat($params);
	}

	$page = $base->getPage();
?>


<?php
	$base = Base::getInstance();
	// Temporary fix for disabling toolbar buttons when clicked Finish
	if(isset($_GET['disallowbrowsing'])){
		$base->setAllowBrowsing(0);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />

<link rel="Coagmento icon" type="image/x-icon" href="../img/favicon.ico">
<link rel="stylesheet" type="text/css" href="ajaxtabs/ajaxtabs.css" />
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.7.0/build/fonts/fonts-min.css" />
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.7.0/build/tabview/assets/skins/sam/tabview.css" />
<style>
#pfc_cmd_container{
	display: none;
}
#pfc_bbcode_container{
	display: none;
}
</style>
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/yahoo-dom-event/yahoo-dom-event.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/connection/connection-min.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/element/element-min.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/tabview/tabview-min.js"></script>

<script type="text/javascript" src="js/utilities-old.js"></script>
<script type="text/javascript" src="ajaxtabs/ajaxtabs.js"></script>



<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript"> jQuery.noConflict(); </script>
<script type="text/javascript">





/***********************************************
 * Ajax Tabs Content script v2.2- � Dynamic Drive DHTML code library (www.dynamicdrive.com)
 * This notice MUST stay intact for legal use
 * Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
 ***********************************************/

	var homeURL = "<?php echo $homeURL;?>"
	var uri = homeURL+"services/checkStageSidebar.php";

	// setInterval ("reload('sidebarComponents/snippets.php','snippetsBox')", 5000);
	// setInterval ("refreshBookmarks()", 5000);
	// setInterval ("reload('sidebarComponents/searches.php','queriesBox')", 5000);


	var InfiniteAjaxRequest = function () {
		 jQuery.ajax({
    	        url: uri,
    	        success: function(data) {
    	            // do something with "data"
    	             //alert("hi1: "+data);
    	            if (data!="0")
        	        {

						if (data=="5")
						{
							//alert(data);
							<?php
									echo "document.location = '".$homeURL."sidebar/sidebar.php?show=true';\n";
							?>
						}
						if (data=="4")
						{
							//alert(data);
							<?php
									echo "document.location = '".$homeURL."sidebar/sidebar.php?clean=true';\n";
							?>
						}
						if (data=="2")
						{
							//alert(data);
							<?php
									if ((!(isset($_GET['answer'])))&& (!(isset($_GET['clean']))))
									{
										//echo "alert(data);";
										//echo "content.wrappedJSObject.location = '".$homeURL."instruments/".$page."?answer=true';\n";
										echo "content.location = '".$homeURL."instruments/".$page."?answer=true';\n";
										echo "document.location = '".$homeURL."sidebar/sidebar.php?answer=true&snippets=true';\n";
										//echo "document.location = '".$homeURL."sidebar/sidebar.php?show=true';\n";
										//echo "return;";
									}
									else
										//echo "InfiniteAjaxRequest(uri);";
										echo "setTimeout(\"InfiniteAjaxRequest()\",2000);";
							?>
						}
						 else if (data=="1")
						 {
						<?php
								//echo "alert(\"hi\");";
								if (!(isset($_GET['show'])))
								{
									echo "document.location = '".$homeURL."sidebar/sidebar.php?show=true';\n";
									//echo "return;";
								}
								else
									//echo "InfiniteAjaxRequest(uri);";
									echo "setTimeout(\"InfiniteAjaxRequest()\",2000);";
						?>

						 }
						 else if (data=="3")
								<?php
										if (!(isset($_GET['clean'])))
										{
											echo "document.location = '".$homeURL."sidebar/sidebar.php?clean=true';\n";
											//echo "document.location = '".$homeURL."sidebar/sidebar.php';\n";
											//echo "return;";
										}
										else
											//echo "InfiniteAjaxRequest(uri);";
											echo "setTimeout(\"InfiniteAjaxRequest()\",2000);";
								?>
    	            }
    	            else
    	            	setTimeout("InfiniteAjaxRequest()",2000);
    	        },
    	        error: function(xhr, ajaxOptions, thrownError) {
    	        }
    	    });
    	};

    	//InfiniteAjaxRequest(homeURL+"services/checkStageSidebar.php");
    	InfiniteAjaxRequest ();
    	//setTimeout("InfiniteAjaxRequest()",3000);
</script>

<title>
Sidebar
</title>


<link rel="stylesheet" href="css/stylesSidebarFusion.css" type="text/css" />
<style type="text/css">
.cursorType{
cursor:pointer;
cursor:hand;
}

</style>

</head>
<?php

	$base = Base::getInstance();



	if ($base->isSessionActive())
	{

	  if (isset($_GET['show'])) //&&(!(isset($_GET['answer']))))
	  {
        echo "<body>";

		//first region
		if ($base->getAllowCommunication()==1)
		{

?>






<script type="text/javascript">


<?php
     $height = "100px";
     if ($base->getStageID()>=120)
     {
         $height = "300px";
     }
    ?>
</script>



<table class="body">
<tr>
<td>
<!-- 			<div id="statusMessage">&nbsp;&nbsp;<span style="font-size:10px;color:red;">Warning: Coagmento is turned off.</span><br/>&nbsp;&nbsp;<span style="color:blue;text-decoration:underline;cursor:pointer;font-size:10px;" onClick="tabsReload(0,'source');">Activate it</span>. <span style="color:blue;text-decoration:underline;cursor:pointer;font-size:10px;" onClick="tabsReload(0,'source');">Learn more.</span></div> -->
<span style="font-size:10px;"><div id="currentProj"></div></span>
<!-- 				<div id="reload"><span style="font-size:11px;color:blue;text-decoration:underline;cursor:pointer;" onClick="location.reload(true);">Reload the Sidebar</div>-->





<ul class="acc2" id="acc2">
<?php
    $userID = Base::getInstance()->getUserID();
    $query = "SELECT numUsers from users WHERE userID='$userID'";
    $connection = Connection::getInstance();
    $results = $connection->commit($query);
    $line = mysql_fetch_array($results,MYSQL_ASSOC);
    $num_users = $line['numUsers'];

    if($num_users>1){
        ?>


<li>
<h4><img src="../img/chat.jpg" width=32 style="vertical-align:middle;border:0" /> Chat <span style="color:gray;font-size:10px;"></span></h4>
<div class="acc-section2">


<div id="chat" class="acc-content2">
<?php
    if (($projectID > 0)&&($projectTitle != ""))
    {
        $chat->printChat();

    }
    else
    {
        echo "In order to use the chat you must select a project first.ID".$projectID."title".$projectTitle;
    }
    //require_once("sidebarChat.php");
    ?>
</div>



</div>
</li>
<?php
    }
    ?>



<li style="padding-top: 0px">
<h4><img src="../img/history.jpg" width=32 style="vertical-align:middle;border:0" />&nbsp; History <span style="color:gray;font-size:10px;"></span></h4>
<div class="acc-section2">
<div id="history" class="acc-content2">
<ul id="tabs" class="shadetabs">

<li><a href="sidebarComponents/bookmarks.php" rel="tabscontainer" class="selected">Bookmarks</a></li>

<li><a href="sidebarComponents/snippets.php" rel="tabscontainer">Snippets</a></li>

<li><a href="sidebarComponents/searches.php" rel="tabsycontainer">Searches</a></li>


</ul>
<div id="tabsdivcontainer" style="border:1px solid gray; width:96%; margin-bottom: 1em; padding: 2%">  </div>
<script type="text/javascript">
var tabs=new ddajaxtabs("tabs", "tabsdivcontainer");
tabs.setpersist(true);
tabs.setselectedClassTarget("link"); //"link" or "linkparent"
tabs.init();
</script>
</div>
</div>
</li>








</ul>
</td>
</tr>
</table>


<script type="text/javascript" src="script.js"></script>


<script type="text/javascript">
/*
Removed to auto show sections

var parentAccordion=new TINY.accordion.slider("parentAccordion");
parentAccordion.init("acc2","h4",0,-1);

var nestedAccordion=new TINY.accordion.slider("nestedAccordion");
nestedAccordion.init("nested","h4",1,-1,"acc-selected");
*/

var last_activity_time = null;
function attemptActivityRefresh(){
	if(!last_activity_time){
		last_activity_time = (new Date()).getTime();
		return;
	}
	var curtime = (new Date()).getTime();
	if(curtime - last_activity_time > 10000){
		console.log("Refreshing");
		//ping to update activity
		jQuery.ajax({
			url: homeURL + "services/refreshActivity.php"
		});
		last_activity_time = curtime;
	}
}
jQuery("body").on("mousemove", function(){
	attemptActivityRefresh();
});
jQuery("body").on("keyup", function(){
	attemptActivityRefresh();
});
</script>

<?php

		}
	}
  }
?>

<?php
//printf("<small>Activity detected %d seconds ago</small>", time() - $_SESSION["LAST_ACTIVE"]);
?>

</body>
</html>
