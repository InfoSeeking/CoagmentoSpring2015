<?php
	session_start();
	$userID = $_SESSION['CSpace_userID'];
?>
<table class="body" width=100%>
	<tr><td align="right"><img src="../img/settings2.jpg" height=50 style="vertical-align:middle;border:0" /> <span style="font-weight:bold;font-size:20px">Toolbar Options</span></td></tr>
	<tr bgcolor="#EFEFEF">
		<td>
			<span style="cursor:pointer;"><div onclick="switchMenu('help');">Click here to expand or collapse the help.</div></span>
		</td>
	</tr>
	<tr>
		<td>
			<div id="help" style="display:none;text-align:left;font-size:11px;background:#EFEFEF">
			Here you can configure various options for your Coagmento toolbar.
			</div>
		</td>
	</tr>
	<tr><td><br/></td></tr>
<?php
	require_once("connect.php");
	if (isset($_GET['option'])) {
		$option = $_GET['option'];
		$value = $_GET['value'];
		switch ($option) {
			case 'page-status':
				$query = "SELECT * FROM options WHERE userID='$userID' AND `option`='page-status'";
				$results = mysql_query($query) or die(" ". mysql_error());
				$line = mysql_fetch_array($results, MYSQL_ASSOC);
				if (mysql_num_rows($results)==0) {
					$query = "INSERT INTO options VALUES('','$userID','0','$option','$value')";
					$results = mysql_query($query) or die(" ". mysql_error());	
				}
				else {
					$query = "UPDATE options SET value='$value' WHERE userID='$userID' AND `option`='page-status'";
					$results = mysql_query($query) or die(" ". mysql_error());
				}					
		}
	}
	echo "<tr><td><table class=\"style1\">";
	$query = "SELECT * FROM options WHERE userID='$userID' AND `option`='page-status'";
	$results = mysql_query($query) or die(" ". mysql_error());
	$line = mysql_fetch_array($results, MYSQL_ASSOC);
	$value = $line['value'];
	if (!$value || $value=='off')
		echo "<tr><td>Page status (views, annotations, snippets) on the toolbar is currently off. <span style=\"color:blue;text-decoration:underline;cursor:pointer;\" onClick=\"ajaxpage('pluginOptions.php?option=page-status&value=on', 'content');\">Turn it on</span>.<br/>You may have to switch to a different tab or reload a page afterward to see its effect.</td></tr>\n";
	else
		echo "<tr><td>Page status (views, annotations, snippets) on the toolbar is currently on. <span style=\"color:blue;text-decoration:underline;cursor:pointer;\" onClick=\"ajaxpage('pluginOptions.php?option=page-status&value=off', 'content');\">Turn it off</span>.<br/>You may have to switch to a different tab or reload a page afterward to see its effect.</td></tr>\n";
	echo "</td></tr>\n";
	echo "</table>\n";
?>