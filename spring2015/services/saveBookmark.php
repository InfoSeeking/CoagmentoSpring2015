<?php
	session_start();
    
    require_once('../core/Base.class.php');
    
    $base = Base::getInstance();
    $userID = $base->getUserID();
    $projectID = $base->getProjectID();

	$title = $_GET['title'];
	$originalURL = $_GET['page'];
	$url = $originalURL;
	// Get the date, time, and timestamp

    $timestamp = $base->getTimestamp();
    $date = $base->getDate();
    $time = $base->getTime();
    $localDate = $_GET['localDate'];
	$localTime = $_GET['localTime'];
	$localTimestamp = $_GET['localTimestamp'];

    
?>
<html>
<head>
	<title>Bookmark</title>
	<link href="../styles.css" rel="stylesheet" type="text/css" />
</head>
<?php
			require_once("utilityFunctions.php");

			// Parse the URL to extract the source
			$url = str_replace("http://", "", $url); // Remove 'http://' from the reference
			$url = str_replace("com/", "com.", $url);
			$url = str_replace("org/", "org.", $url);
			$url = str_replace("edu/", "edu.", $url);
			$url = str_replace("gov/", "gov.", $url);
			$url = str_replace("us/", "us.", $url);
			$url = str_replace("ca/", "ca.", $url);
			$url = str_replace("uk/", "uk", $url);
			$url = str_replace("es/", "es.", $url);
			$url = str_replace("net/", "net.", $url);
			$entry = explode(".", $url);
			$i = 0;
			$isWebsite = 0;
			while (($entry[$i]) && ($isWebsite == 0)) {
				$entry[$i] = strtolower($entry[$i]);
				if (($entry[$i] == "com") || ($entry[$i] == "edu") || ($entry[$i] == "org") || ($entry[$i] == "gov") || ($entry[$i] == "info") || ($entry[$i] == "us") || ($entry[$i] == "ca") || ($entry[$i] == "es") || ($entry[$i] == "uk") || ($entry[$i] == "net")) {
					$isWebsite = 1;
					$site = $entry[$i-1];
					$domain = $entry[$i];
				}
				$i++;
			}
            
			// Extract the query if there is any
			$queryString = extractQuery($originalURL);

            echo "<body class=\"body\" onload=\"document.f.annotation.focus();\">\n";
            echo "<br/><center>\n";
            echo "<form name=\"f\" action=\"saveBookmarkAux.php\" method=POST>\n";
            echo "<table class=\"body\" width=90%>";
            echo "<tr><th>Bookmark the following page: <a href=\"$originalURL\">$title</a><br/><br/></th></tr>\n";
            echo "<tr><td align=center><em>What is useful about this source? How would you use it in writing your paper?</em><br/><textarea cols=35 rows=6 name=\"annotation\"></textarea><input type=\"hidden\" name=\"originalURL\" value=\"$originalURL\"/><input type=\"hidden\" name=\"source\" value=\"$url\"/><input type=\"hidden\" name=\"title\" value=\"$title\"/><input type=\"hidden\" name=\"site\" value=\"$site\"/><input type=\"hidden\" name=\"queryString\" value=\"$queryString\"/>'</td></tr>\n";
            echo "<input type=\"hidden\" name=\"localDate\" value=\"$localDate\"/>";
            echo "<input type=\"hidden\" name=\"localTime\" value=\"$localTime\"/>";
            echo "<input type=\"hidden\" name=\"localTimestamp\" value=\"$localTimestamp\"/>";
            echo "<tr><td align=center><br>How good is this page? Rate it:</td></tr></table>";
            echo "<table><tr><td><input type=\"radio\" name=\"rating\" value=\"1\"></td>";
            echo "<td><input type=\"radio\" name=\"rating\" value=\"2\"></td>";
            echo "<td><input type=\"radio\" name=\"rating\" value=\"3\"></td>";
            echo "<td><input type=\"radio\" name=\"rating\" value=\"4\"></td>";
            echo "<td><input type=\"radio\" name=\"rating\" value=\"5\"></td></tr>";
            echo "<tr align=center><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr></table>";
            echo "<table><tr><td align=center><br><input type=\"submit\" value=\"Save\" /> <input type=\"button\" value=\"Cancel\" onclick=\"window.close();\" /></td></tr></table>\n";
            echo "</table>";
            echo "</form>\n";
?>
</body>
</html>