<?php
	session_start();
	require_once('../core/Connection.class.php');
	require_once('../core/Base.class.php');
	require_once('../core/Action.class.php');
	require_once('../core/Util.class.php');
	require_once("utilityFunctions.php");
	require_once("OAuth.php"); // Authorization for yahoo search api
	//require_once('../core/Settings.class.php');

    
    //GOOGLE INFO
    //API KEY: AIzaSyBbxT1VXCd2wFr3QBEtCVMCum615ex_OWA
    // cx = '000269924908061019336:sgscwswbgfq';

if (Base::getInstance()->isSessionActive())
{
	$localTime = $_GET['localTime'];
	$localDate = $_GET['localDate'];
	$localTimestamp = $_GET['localTimestamp'];
	
	$base = new Base();
	
	
	if (isset($_GET['action']) && !($_GET['action']==""))
	{
		$actionVal = $_GET['action'];		
		$action = new Action($actionVal,0); //add later the ID of the tab
		$action->setBase($base);
		$action->setLocalTimestamp($localTimestamp);
		$action->setLocalTime($localTime);
		$action->setLocalDate($localDate);
		$action->save();		
	}
		
	$originalURL = $_GET['URL'];
	
	//When implementing full version verify membership
	if (!isset($_SESSION['CSpace_lastURL']) || $originalURL!=$_SESSION['CSpace_lastURL'])
	{	
		$title = $_GET['title'];
        $title = str_replace(" - Mozilla Firefox","",$title);
		$title = addslashes($title);
		$url = $originalURL;
	
		// Parse the URL to extract the source
		$url = str_replace("http://", "", $url); // Remove 'http://' from the reference
		$url = str_replace("https://", "", $url); // Remove 'https://' from the reference
		$url = str_replace("com/", "com.", $url);
		$url = str_replace("org/", "org.", $url);
		$url = str_replace("edu/", "edu.", $url);
		$url = str_replace("gov/", "gov.", $url);
		$url = str_replace("us/", "us.", $url);
		$url = str_replace("ca/", "ca.", $url);
		$url = str_replace("uk/", "uk.", $url);
		$url = str_replace("es/", "es.", $url);
		$url = str_replace("net/", "net.", $url);

		$entry = explode(".", $url);
		$i = 0;
		$isWebsite = 0;
        $site = NULL;
		
		while (isset($entry[$i]) && ($isWebsite == 0))
		{
			$entry[$i] = strtolower($entry[$i]);
			if (($entry[$i] == "com") || ($entry[$i] == "edu") || ($entry[$i] == "org") || ($entry[$i] == "gov") || ($entry[$i] == "info") || ($entry[$i] == "us") || ($entry[$i] == "ca") || ($entry[$i] == "es") || ($entry[$i] == "uk") || ($entry[$i] == "net"))
			{
				$isWebsite = 1;
                if(($entry[$i] == "uk") && strpos($originalURL,'uk.yahoo.com') !== false){
                    $domain = $entry[$i+2];
                    $site = $entry[$i+1];
                }else if(($entry[$i] == "uk") && strpos($originalURL,'uk.search.yahoo.com') !== false){
                    $domain = $entry[$i+3];
                    $site = $entry[$i+2];
                }else if(($entry[$i] == "uk") && strpos($originalURL,'.co.uk') !== false){
                    $domain = $entry[$i];
                    $site = $entry[$i-2];
                }else{
                    $domain = $entry[$i];
                    $site = $entry[$i-1];
                }
			}
			$i++;
		} 

		// Extract the query if there is any
		$queryString = extractQuery($originalURL);
	    $queryString = addslashes($queryString);
		
		$_SESSION['CSpace_lastURL'] = $originalURL;
		
		//$base = new Base();
		$projectID = $base->getProjectID();
		$userID = $base->getUserID();
		$time = $base->getTime();
		$date = $base->getDate();
		$timestamp = $base->getTimestamp();
		$stageID = $base->getStageID();
		$questionID = $base->getQuestionID();
		
		$query = "INSERT INTO pages (userID, projectID, stageID, questionID, url, title, source, query, timestamp, date, time, `localTimestamp`, `localDate`, `localTime`) 
				              VALUES('$userID','$projectID','$stageID','$questionID','$originalURL','$title','$site','$queryString','$timestamp','$date','$time','$localTimestamp','$localDate','$localTime')";
		
		$connection = Connection::getInstance();			
		$results = $connection->commit($query);
		$pageID = $connection->getLastID();
		
		$action = new Action('page',$pageID);
		$action->setBase($base);
		$action->setLocalTimestamp($localTimestamp);
		$action->setLocalTime($localTime);
		$action->setLocalDate($localDate);
		$action->save();		
		
		// Finding the search engine used for each query
		$searchEngine=0;
		if (strpos($originalURL,'www.google.com') !== false || strpos($originalURL,'google.co.uk') !== false)
		{
    		$searchEngine=1;
		}	
		else if (strpos($originalURL,'search.yahoo.com') !== false || strpos($originalURL,'uk.yahoo.com') !== false || strpos($originalURL,'yahoo.co.uk') !== false)
		{
			$searchEngine=2;
		}
		else if (strpos($originalURL,'www.bing.com') !== false) 
		{
			$searchEngine=3;
		}
		else
		{
			$searchEngine=4;
		}
		
			
		if ($queryString)
		{
            
            if(strpos($originalURL,'google.co.uk') !== false){
                $site = "google UK";
            }
            
            
			$resultsPage = urlencode($originalURL);
//            Top results stored in separate "webPages" folder
//            $topResults = file_get_contents($resultsPage);
//			$query = "INSERT INTO queries (userID, projectID, stageID, questionID, query, source, url, title, topResults, timestamp, date, time, `localTimestamp`, `localDate`, `localTime`)
//			                       VALUES ('$userID','$projectID','$stageID','$questionID','$queryString','$site','$originalURL','$title','$topResults','$timestamp','$date','$time','$localTimestamp','$localDate','$localTime')";
            
            $query = "SELECT * FROM queries WHERE userID='$userID' AND stageID='$stageID' AND query='$queryString' AND source='$site'";
            $connection = Connection::getInstance();
			$results = $connection->commit($query);
            
            
            
            $exists_serp = 0;
            if (mysql_num_rows($results) > 0){
                $exists_serp = 1;
            }else{
                $exists_serp = 0;
            }
            
            
            

            $query = "INSERT INTO queries (userID, projectID, stageID, questionID, query, source, url, title, timestamp, date, time, `localTimestamp`, `localDate`, `localTime`, status)
            VALUES ('$userID','$projectID','$stageID','$questionID','$queryString','$site','$originalURL','$title','$timestamp','$date','$time','$localTimestamp','$localDate','$localTime','1')";
            
			$connection = Connection::getInstance();
			$results = $connection->commit($query);
			$queryID = $connection->getLastID();
		
					
			$action->setAction("query and $searchEngine");
			$action->setValue($queryID);
			$action->save();
			
			/*-----Code to save Google SERP page results as json files-----*/
			if($searchEngine==1)
			{
                if($exists_serp == 0){
                    $query_stringwithplus = urlencode($queryString); //need to encode to get query string words separated by + sign
                    $data = '';
                    if(strpos($originalURL,'google.co.uk') !== false){
                        $cmd = "curl -e http://coagmento.org " . "'https://www.googleapis.com/customsearch/v1?key=AIzaSyBbxT1VXCd2wFr3QBEtCVMCum615ex_OWA&cx=000269924908061019336:sgscwswbgfq&googlehost=google.co.uk&q=".$query_stringwithplus."'";
                        $data=shell_exec($cmd);
                    }else{
                        $cmd = "curl -e http://coagmento.org " . "'https://www.googleapis.com/customsearch/v1?key=AIzaSyBbxT1VXCd2wFr3QBEtCVMCum615ex_OWA&cx=000269924908061019336:sgscwswbgfq&q=".$query_stringwithplus."'";
                        $data=shell_exec($cmd);
                    }
                    $filename_content = "Google_SERP_user".$userID."_stage".$stageID."_page".$pageID."_query".$queryID.".json";
                    $fileHandle_content = fopen("/www/coagmento.org/htdocs/spring2015/webPages/".$filename_content, 'w') or die("file could not be accessed/created");
                    fwrite($fileHandle_content, $data);
                    fclose($fileHandle_content);
                }
			}
					
			/**************************************************/
			/*-----Code to save Yahoo SERP page results as json files-----*/
			/*-----Technically this works but in order to get search data, you have to pay money :(. So not activated at this point.-----*/
			/*	
			else if($searchEngine==2)
 			{
				$query_stringwithplus = urlencode($queryString);
				$cc_key  = "dj0yJmk9bWlMcU5hUGVJclpEJmQ9WVdrOVRHbHlNVVJCTnpRbWNHbzlNQS0tJnM9Y29uc3VtZXJzZWNyZXQmeD01ZA--";  
				$cc_secret = "a6ff4151bc8adbfaacad47d06d84a2340b9369b9";  
				$url = "http://yboss.yahooapis.com/ysearch/news,web";  
				$args = array();  
				$args["q"] = $query_stringwithplus;  
				$args["format"] = "json";  
   
				$consumer = new OAuthConsumer($cc_key, $cc_secret);  
				$request = OAuthRequest::from_consumer_and_token($consumer, NULL,"GET", $url, $args);  
				$request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $consumer, NULL);  
				$url = sprintf("%s?%s", $url, "q=".$query_stringwithplus);  
				$ch = curl_init();  
				$headers = array($request->to_header());  
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);  
				curl_setopt($ch, CURLOPT_URL, $url);  
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);  
				$data = curl_exec($ch); 
				$filename_content = "Yahoo_SERP_user".$userID."_stage".$stageID."_page".$pageID.".json";
				$fileHandle_content = fopen("/www/userstudy2014.coagmento.rutgers.edu/htdocs/contentPages/".$filename_content, 'w') or die("file could not be accessed/created");
				fwrite($fileHandle_content, $data);
				fclose($fileHandle_content); 

			}
			*/
			/**************************************************/
			
			/**************************************************/
			/*-----Code to save Bing SERP page results as json files-----*/
			else if($searchEngine==3)
			{
				$query_stringwithplus = urlencode($queryString); //need to encode to get query string words separated by + sign
				$account_key = 'QEnKG3ytiksVuOX7nrnj+agA38LD1qSkSMDnNqMQbog';
  				$url = "https://api.datamarket.azure.com/Bing/Search/v1/Web?\$format=json&Query='".$query_stringwithplus."'";
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_FRESH_CONNECT,true);
				curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)"); 
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); 
				curl_setopt($ch, CURLOPT_USERPWD, $account_key . ":" . $account_key);
				$json = curl_exec($ch);
				curl_close($ch);
				$filename_content = "Bing_SERP_user".$userID."_stage".$stageID."_page".$pageID."_query".$queryID.".json";
				$fileHandle_content = fopen("/www/coagmento.org/htdocs/spring2015/webPages/".$filename_content, 'w') or die("file could not be accessed/created");
				fwrite($fileHandle_content, $json);
				fclose($fileHandle_content);
				
			}
			/**************************************************/
			/**************************************************/
			/*-----Code to save other SERP page results as text files-----*/
			else 
			{
				$query_stringwithplus = urlencode($queryString); //need to encode to get query string words separated by + sign
				$request =  "curl -e http://coagmento.org " .$url;
				$data=shell_exec($request);
				$filename_content = "Other_SERP_user".$userID."_stage".$stageID."_page".$pageID."_query".$queryID.".json";
				$fileHandle_content = fopen("/www/coagmento.org/htdocs/spring2015/webPages/".$filename_content, 'w') or die("file could not be accessed/created");
				fwrite($fileHandle_content, $data);
				fclose($fileHandle_content);
			}
			/**************************************************/
			
		}	
		
		
		/* ----ADDED on 05/27/2014 to get content pages saved as HTML in: htdocs/contentPages/----*/	
		else
		{

		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, $originalURL);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);

		$filename_content = "CONTENT_user".$userID."_stage".$stageID."_page".$pageID.".html";
		$fileHandle_content = fopen("/www/coagmento.org/htdocs/spring2015/webPages/".$filename_content, 'w') or die("file could not be accessed/created");
		fwrite($fileHandle_content, $data);
		fclose($fileHandle_content);
		/* ----------------------------------------------------------------------*/	
		
		}
									
	}
}
?>
