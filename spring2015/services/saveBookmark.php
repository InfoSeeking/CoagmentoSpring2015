<?php
	session_start();

    require_once('../core/Base.class.php');
		require_once('../core/Tags.class.php');

    $base = Base::getInstance();
		$base->registerActivity();
    $userID = $base->getUserID();
    $projectID = $base->getProjectID();

	$title = $_GET['title'];
	$originalURL = $_GET['page'];
	$url = $originalURL;
	$host = "";
	$p = parse_url($url);
	if ($p){
		$host = $p['host'];
	}
	// Get the date, time, and timestamp

    $timestamp = $base->getTimestamp();
    $date = $base->getDate();
    $time = $base->getTime();
    $localDate = $_GET['localDate'];
	$localTime = $_GET['localTime'];
	$localTimestamp = $_GET['localTimestamp'];


?>

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

			// Get user's tags
			$tags = new Tags();
			$available_tags = $tags->retrieveFromProject($projectID);
			require_once("templates/bookmark.php");
?>
