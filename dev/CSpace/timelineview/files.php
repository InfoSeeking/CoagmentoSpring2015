<?php /*
include('user_agent.php'); // Redirecting http://mobile.site.info
// site.com data */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<LINK REL=StyleSheet HREF="style.css" TYPE="text/css" MEDIA=screen>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
<script type="text/javascript" src="../js/utilities.js"></script>

<?php 
  include('func.php');
?>

<script type="text/javascript"> 
$(document).ready(function(){
$(".flip").click(function(){
    $(".panel").slideToggle("slow");
  });
});
</script>
</head>

<body>

<div id="topbar">
	<div class="left" style="float: left; "> <!-- min-width: 790px; width: 60%; -->
        <h2><a href="index.php">Coagmento CSpace</a></h2><br/>
    </div>
    
        	<div style="float: left;">
    				<?php
					session_start();
					require_once('../connect.php');
					$userID = $_SESSION['CSpace_userID'];
					$projectID = $_SESSION['CSpace_projectID'];
					$query = "SELECT * FROM users WHERE userID='$userID'";
					$results = mysql_query($query) or die(" ". mysql_error());
					$line = mysql_fetch_array($results, MYSQL_ASSOC);
					$userName = $line['firstName'] . " " . $line['lastName'];
					$avatar = $line['avatar'];
					$lastLogin = $line['lastLoginDate'] . ", " . $line['lastLoginTime'];
					$points = $line['points'];
					$query = "SELECT count(*) as num FROM memberships WHERE userID='$userID'";
					$results = mysql_query($query) or die(" ". mysql_error());
					$line = mysql_fetch_array($results, MYSQL_ASSOC);
					$projectNums = $line['num'];
					$query = "SELECT count(distinct mem2.userID) as num FROM memberships as mem1,memberships as mem2 WHERE mem1.userID!=mem2.userID AND mem1.projectID=mem2.projectID AND mem1.userID='$userID'";
					$results = mysql_query($query) or die(" ". mysql_error());
					$line = mysql_fetch_array($results, MYSQL_ASSOC);
					$collabNums = $line['num'];
					/* <td><img src=\"../../img/$avatar\" width=45 height=45 style=\"vertical-align:middle;border:0\" /></td> */
					echo "<div class='top_links' style='border-left: 1px solid #ccc; padding-left: 15px;'><table style='font-size: 12px;'><tr><td valign=\"middle\">&nbsp;&nbsp;Welcome, <span style=\"font-weight:bold\">$userName</span> to your <a href='main.php'>CSpace</a>.<br/>&nbsp;&nbsp;Current login: $lastLogin<br/>&nbsp;&nbsp;Points earned: <a href='points.php'>$points</a></td><td valign=\"middle\">&nbsp;&nbsp;</td><td valign=\"middle\">&nbsp;&nbsp;You have <a href='projects.php?userID=$userID'>$projectNums projects</a> and <a href='collaborators.php?userID=1'>$collabNums collaborators</a>.<br/>&nbsp;&nbsp;<span id=\"currProj\"></span><br/>&nbsp;&nbsp;<a href='projects.php?userID=$userID'>Select a different project.</a></td></tr></table></div>";
				?>
                </div>
                
    <div class="right" style="position: fixed; top: 25px; right: 20px;">

    	<p class="flip" style="float: right;"><!-- <img src="menu.png" /> --> <?php echo '<img src="http://'.$_SERVER['HTTP_HOST'].'/img/'.$avatar.'" width=45 height=45 style="vertical-align:middle;border:3px solid #000;">'; ?><br/><img src="arrow.png"/></p>
        <div style="clear:both;"></div>
        <div class="panel">
        	<table>
            	<tr>
                	<td valign="top" width="150">
                    	<b>Collaborators</b><br/>
                        <a href="../addCollaborator.php">Add</a>
                        <a href="../currentCollaborators.php">View</a><br/>
                        
                        <b>Projects</b>
                        <a href="../createProject.php">Create</a>
                        <a href="../projects.php">Select</a>
                        <a href="../showPublicProjs.php">Join</a>
                    </td>
                	<td valign="top" width="150">
                    	<b>Sharing</b>
                        <a href="../showRecommendations.php">Recommendations</a>
                        <a href="../interProject.php">Inter-project</a><br/>
                        
                   		<b>Workspace</b>
                        <a href="../etherpad.php">Editor</a>
                        <a href="../files.php">Files</a>
                        <a href="../printreport.php">Print reports</a>
                    </td>
                    <td valign="top" width="150">
                    	<b>Settings</b>
                        <a href="../profile.php">Profile</a>
                        <a href="../settings.php">Options</a>
                    </td>
                </tr>
                <!-- <tr height="10">
                	<td></td>
                </tr> -->
                <!-- <tr>
                	<td colspan=3 valign="top">
                    	<a href="" style="color: #95ba23 !important; border: 0 !important; display: inline-block !important;">CSpace</a>&nbsp;&nbsp;
                		<a href="" style="color: #95ba23 !important; border: 0 !important; display: inline-block !important;">Log out</a>
                    </td>
				</tr> -->
            </table>
        </div>
    </div>
    
</div>

<div id="container">
<h3>Files</h3>
<?php
	session_start();
	if (!isset($_SESSION['CSpace_userID'])) {
		echo "Sorry. Your session has expired. Please <a href=\"http://www.coagmento.org\">login again</a>.";
	}
	else {
		$userID = $_SESSION['CSpace_userID'];
		$projectID = $_SESSION['CSpace_projectID'];
?>
	<script type="text/javascript" src="js/webtoolkit.aim.js"></script>
	<script type="text/javascript">
		function startCallback() {
			// make something useful before submit (onStart)
			return true;
		}
 
		function completeCallback(response) {
			// make something useful after (onComplete)
			document.getElementById('nr').innerHTML = parseInt(document.getElementById('nr').innerHTML) + 1;
			document.getElementById('r').innerHTML = response;
		}
	</script>
<!-- <table class="body" width=100%>
	<tr bgcolor="#EFEFEF">
		<td colspan=2>
			<span style="cursor:pointer;"><div onclick="switchMenu('help');">Click here to expand or collapse the help.</div></span>
		</td>
	</tr>
	<tr>
		<td colspan=2>
			<div id="help" style="display:none;text-align:left;font-size:11px;background:#EFEFEF">
			Here you can upload files and/or download them to/from your currently selected project.
			</div>
		</td>
	</tr>
</table> -->
<table class="body" width=100%>
	<?php
		require_once("../connect.php");
	
        echo "<tr><td><form action=\"index.php?file\" enctype=\"multipart/form-data\" method=\"post\" onsubmit=\"return AIM.submit(this, {'onStart' : startCallback, 'onComplete' : completeCallback}\">";
        echo "Upload a new file: <input name=\"uploaded\" type=\"file\"/> <input type=\"submit\" value=\"Upload\"/></form></td></tr>\n";
//        echo "<br/>Description: <input type=\"text\" name=\"description\" size=40 /> <input type=\"submit\" value=\"Upload\"/></form></td></tr>\n";
        echo "<tr><td><br/></td></tr>\n";
        echo "</table>\n";
        echo "<table class=\"body\" width=100%>\n";
//        echo "</table></td></tr></table>\n<br/><br/><br/><br/>\n";	
		echo "<tr><td style=\"background:#EFEFEF;font-weight:bold\" colspan=4>Existing files for your active project</td></tr>\n";
		echo "<tr><td style=\"font-weight:bold\" align=center>Delete</td><td style=\"font-weight:bold\">Name</td><td style=\"font-weight:bold\">Uploaded by</td><td style=\"font-weight:bold\" align=center>Time</td></tr>\n";
		$query = "SELECT * FROM files WHERE userID='$userID' AND projectID='$projectID' AND status=1";
		$results = mysql_query($query) or die(" ". mysql_error());
		while($line = mysql_fetch_array($results, MYSQL_ASSOC)) {
			$name = $line['name'];
			$fileName = $line['fileName'];
//			$description = $line['description'];
			$fUserID = $line['userID'];
			$query1 = "SELECT firstName,lastName FROM users WHERE userID='$fUserID'";
			$results1 = mysql_query($query1) or die(" ". mysql_error());
			$line1 = mysql_fetch_array($results1, MYSQL_ASSOC);
			$fullName = $line1['firstName'] . " " . $line1['lastName'];
			$date = $line['date'];
			$time = $line['time'];
			echo "<tr><td align=center>X</td><td><a href=\"files/".$fileName."\">$name</a></td><td>$fullName</td><td align=center>$date, $time</td></tr>\n";
//			echo "<tr><td></td><td colspan=3><font color=\"gray\">$description</font></td></tr>\n";
		}
	}
?>
</table>
</div>

</body>
</html>