<?php
	session_start();
	if (!isset($_SESSION['CSpace_userID'])) {
		echo "Sorry. Your session has expired. Please <a href=\"http://www.coagmento.org\">login again</a>.";
	}
	else {
		$userID = $_SESSION['CSpace_userID'];
		$projectID = $_SESSION['CSpace_projectID'];
?>
<table class="body" width=100%>
	<tr><td style="font-weight:bold;"><span style="color:blue;text-decoration:underline;cursor:pointer;font-weight:bold;" onClick="ajaxpage('main.php','content');">CSpace</span> > Workspace</td><td align="right"><img src="../img/workspace.jpg" height=50 style="vertical-align:middle;border:0" /> <span style="font-weight:bold;font-size:20px">Workspace</span></td></tr>
	<tr bgcolor="#EFEFEF">
		<td colspan=2>
			<span style="cursor:pointer;"><div onclick="switchMenu('help');">Click here to expand or collapse the help.</div></span>
		</td>
	</tr>
	<tr>
		<td colspan=2>
			<div id="help" style="display:none;text-align:left;font-size:11px;background:#EFEFEF">
			Coagmento lets you work with your collected objects, including searches, snippets, and bookmarks. Here, you can see these objects, access them, as well as prepare a report that you can print.
			</div>
		</td>
	</tr>
</table>
<table class="body" width=100%>
	<tr><td colspan=2><br/></td></tr>
	<?php
		require_once("connect.php");
		$query = "SELECT title FROM projects WHERE projectID='$projectID'";
		$results = mysql_query($query) or die(" ". mysql_error());
		$line = mysql_fetch_array($results, MYSQL_ASSOC);
		$title = $line['title'];
		$query1 = "SELECT * FROM queries WHERE projectID='$projectID' AND status=1 ORDER BY timestamp";
		$results1 = mysql_query($query1) or die(" ". mysql_error());
		$numSearches = mysql_num_rows($results1);
		$query2 = "SELECT distinct url FROM pages WHERE projectID='$projectID' AND status=1";
		$results2 = mysql_query($query2) or die(" ". mysql_error());	
		$numPages = mysql_num_rows($results2);
		$query3 = "SELECT distinct url FROM pages WHERE projectID='$projectID' AND result=1 AND status=1";
		$results3 = mysql_query($query3) or die(" ". mysql_error());
		$numBookmarks = mysql_num_rows($results3);
		$query4 = "SELECT * FROM snippets WHERE projectID='$projectID' AND status=1 ORDER BY timestamp";
		$results4 = mysql_query($query4) or die(" ". mysql_error());
		$numSnippets = mysql_num_rows($results4);
		$query5 = "SELECT * FROM annotations WHERE projectID='$projectID' AND status=1 ORDER BY timestamp";
		$results5 = mysql_query($query5) or die(" ". mysql_error());
		$numAnnotations = mysql_num_rows($results5);
	?>
	<tr><td>Displaying objects for project <span style="font-weight:bold"><?php echo $title?></span></td><td align=right><span style="color:blue;text-decoration:underline;cursor:pointer;" onClick="window.open('printObjects.php?objects=all', 'Coagmento - Print Searches', 'width=450,height=450,scrollbars=yes');
">Print All</span></td></tr>
	<tr><td colspan=2><br/></td></tr>
	<tr>
		<td>
			<span style="cursor:pointer;"><div onclick="switchMenu('wSearches');">Show/hide <span style="font-weight:bold"> <?php echo $numSearches;?> searches</span> for project <span style="font-weight:bold"><?php echo $title?></span></div></span>
		</td>
		<td align=right><span style="color:blue;text-decoration:underline;cursor:pointer;" onClick="window.open('printObjects.php?objects=queries', 'Coagmento - Print Searches', 'width=450,height=450,scrollbars=yes');
">Print Searches</span></td>
	</tr>
	<tr>
		<td colspan=2>
			<div id="wSearches" style="display:none;text-align:left;font-size:11px;">
			<table>
			<?php
				while ($line1 = mysql_fetch_array($results1, MYSQL_ASSOC)) {
					$queryText = $line1['query'];
					$source = $line1['source'];
					$url = $line1['url'];
					$date = $line1['date'];
					$cUserID = $line1['userID'];
					$queryU = "SELECT * FROM users WHERE userID='$cUserID'";
					$resultsU = mysql_query($queryU) or die(" ". mysql_error());
					$lineU = mysql_fetch_array($resultsU, MYSQL_ASSOC);
					$userName = $lineU['username'];
					echo "<tr><td style=\"font-size:10px;\"> $userName &nbsp;&nbsp;</td><td style=\"font-size:10px;color:gray;\"> $date &nbsp;&nbsp;</td><td style=\"font-size:10px;\"> <a href=\"$url\" style=\"font-size:10px;\" target=_blank>$queryText</a> (<span style=\"color:green;font-size:10px;\">$source</span>) </td></tr>\n";
				}
			?>
			</table>
			</div>
		</td>
	</tr>
	<tr><td><br/></td></tr>
	<tr>
		<td>
			<span style="cursor:pointer;"><div onclick="switchMenu('wPages');">Show/hide <span style="font-weight:bold"> <?php echo $numPages;?> webpages</span> for project <span style="font-weight:bold"><?php echo $title?></span></div></span>
		</td>
		<td align=right><span style="color:blue;text-decoration:underline;cursor:pointer;" onClick="window.open('printObjects.php?objects=pages', 'Coagmento - Print Searches', 'width=450,height=450,scrollbars=yes');
">Print Webpages</span></td>
	</tr>
	<tr>
		<td colspan=2>
			<div id="wPages" style="display:none;text-align:left;font-size:11px;">
			<table>
			<?php
				$query2 = "SELECT * FROM pages WHERE projectID='$projectID' AND status=1 GROUP BY url";
				$results2 = mysql_query($query2) or die(" ". mysql_error());
				while ($line2 = mysql_fetch_array($results2, MYSQL_ASSOC)) {
					$url = $line2['url'];
					$pTitle = $line2['title'];
					$source = $line2['source'];
					$date = $line2['date'];
					$cUserID = $line2['userID'];
					$queryU = "SELECT * FROM users WHERE userID='$cUserID'";
					$resultsU = mysql_query($queryU) or die(" ". mysql_error());
					$lineU = mysql_fetch_array($resultsU, MYSQL_ASSOC);
					$userName = $lineU['username'];
					echo "<tr><td style=\"font-size:10px;\"> $userName &nbsp;&nbsp;</td><td style=\"font-size:10px;color:gray;\"> $date &nbsp;&nbsp;</td><td style=\"font-size:10px;\"> <a href=\"$url\" style=\"font-size:10px;\" target=_blank>$pTitle</a> (<span style=\"color:green;font-size:10px;\">$source</span>) </td></tr>\n";
				}
			?>
			</table>
			</div>
		</td>
	</tr>
	<tr><td><br/></td></tr>
	<tr>
		<td>
			<span style="cursor:pointer;"><div onclick="switchMenu('wBookmarks');">Show/hide <span style="font-weight:bold"> <?php echo $numBookmarks;?> bookmarks</span> for project <span style="font-weight:bold"><?php echo $title?></span></div></span>
		</td>
		<td align=right><span style="color:blue;text-decoration:underline;cursor:pointer;" onClick="window.open('printObjects.php?objects=bookmarks', 'Coagmento - Print Searches', 'width=450,height=450,scrollbars=yes');
">Print Bookmarks</span></td>
	</tr>
	<tr>
		<td colspan=2>
			<div id="wBookmarks" style="display:none;text-align:left;font-size:11px;">
			<table>
			<?php
				$query3 = "SELECT * FROM pages WHERE projectID='$projectID' AND result=1 AND status=1 AND status=1 GROUP BY url";
				$results3 = mysql_query($query3) or die(" ". mysql_error());
				while ($line3 = mysql_fetch_array($results3, MYSQL_ASSOC)) {
					$url = $line3['url'];
					$pTitle = $line3['title'];
					$source = $line3['source'];
					$date = $line3['date'];
					$cUserID = $line3['userID'];
					$queryU = "SELECT * FROM users WHERE userID='$cUserID'";
					$resultsU = mysql_query($queryU) or die(" ". mysql_error());
					$lineU = mysql_fetch_array($resultsU, MYSQL_ASSOC);
					$userName = $lineU['username'];
					echo "<tr><td style=\"font-size:10px;\"> $userName &nbsp;&nbsp;</td><td style=\"font-size:10px;color:gray;\"> $date &nbsp;&nbsp;</td><td style=\"font-size:10px;\"> <a href=\"$url\" style=\"font-size:10px;\" target=_blank>$pTitle</a> (<span style=\"color:green;font-size:10px;\">$source</span>) </td></tr>\n";
				}
			?>
			</table>
			</div>
		</td>
	</tr>
	<tr><td><br/></td></tr>
	<tr>
		<td>
			<span style="cursor:pointer;"><div onclick="switchMenu('wSnippets');">Show/hide <span style="font-weight:bold"> <?php echo $numSnippets;?> snippets</span> for project <span style="font-weight:bold"><?php echo $title?></span></div></span>
		</td>
		<td align=right><span style="color:blue;text-decoration:underline;cursor:pointer;" onClick="window.open('printObjects.php?objects=snippets', 'Coagmento - Print Searches', 'width=450,height=450,scrollbars=yes');
">Print Snippets</span></td>
	</tr>
	<tr>
		<td colspan=2>
			<div id="wSnippets" style="display:none;text-align:left;font-size:11px;">
			<table>
			<?php
				while ($line4 = mysql_fetch_array($results4, MYSQL_ASSOC)) {
					$url = $line4['url'];
					$cUserID = $line4['userID'];
					$date = $line4['date'];
					$snippet = stripslashes($line4['snippet']);
					$note = stripslashes($line4['note']);
					$queryU = "SELECT * FROM users WHERE userID='$cUserID'";
					$resultsU = mysql_query($queryU) or die(" ". mysql_error());
					$lineU = mysql_fetch_array($resultsU, MYSQL_ASSOC);
					$userName = $lineU['username'];
					echo "<tr><td style=\"font-size:10px;\">$userName</td><td>&nbsp;&nbsp;</td><td><a href=\"$url\"  style=\"font-size:10px;\" target=_blank>$url</a></td></tr>\n";
					echo "<tr><td style=\"font-size:10px;color:gray;\">$date</td><td>&nbsp;&nbsp;</td><td style=\"font-size:10px;\">$snippet<br/><span style=\"color:gray;\">$note</span></td></tr>\n";
				}
			?>
			</table>
			</div>
		</td>
	</tr>
	<tr><td><br/></td></tr>
	<tr>
		<td>
			<span style="cursor:pointer;"><div onclick="switchMenu('wAnnotations');">Show/hide <span style="font-weight:bold"> <?php echo $numAnnotations;?> annotations</span> for project <span style="font-weight:bold"><?php echo $title?></span></div></span>
		</td>
		<td align=right><span style="color:blue;text-decoration:underline;cursor:pointer;" onClick="window.open('printObjects.php?objects=annotations', 'Coagmento - Print Searches', 'width=450,height=450,scrollbars=yes');
">Print Annotations</span></td>
	</tr>
	<tr>
		<td colspan=2>
			<div id="wAnnotations" style="display:none;text-align:left;font-size:11px;">
			<table>
			<?php
				while ($line5 = mysql_fetch_array($results5, MYSQL_ASSOC)) {
					$url = $line5['url'];
					$cUserID = $line5['userID'];
					$date = $line5['date'];
					$note = stripslashes($line5['note']);
					$queryU = "SELECT * FROM users WHERE userID='$cUserID'";
					$resultsU = mysql_query($queryU) or die(" ". mysql_error());
					$lineU = mysql_fetch_array($resultsU, MYSQL_ASSOC);
					$userName = $lineU['username'];
					echo "<tr><td style=\"font-size:10px;\">$userName</td><td>&nbsp;&nbsp;</td><td><a href=\"$url\"  style=\"font-size:10px;\" target=_blank>$url</a></td></tr>\n";
					echo "<tr><td style=\"font-size:10px;color:gray;\">$date</td><td>&nbsp;&nbsp;</td><td style=\"font-size:10px;\">$note</td></tr>\n";
				}			
			?>
			</table>
			</div>
		</td>
	</tr>
</table>
<?php
	}
?>
