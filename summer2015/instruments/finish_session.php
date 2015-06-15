<?php
	session_start();
	require_once('../core/Util.class.php');
	require_once('../core/Base.class.php');
	require_once('../core/Connection.class.php');

	Util::getInstance()->checkSession();

	if (Util::getInstance()->checkCurrentPage(basename( __FILE__ )))
	{

		Util::getInstance()->moveToNextStageEndSession();

		$query = "UPDATE users SET status = 0 WHERE userID = ".Base::getInstance()->getUserID();
		$connection = Connection::getInstance();
		$results = $connection->commit($query);

		session_destroy();

		/// Retrieve email addresses of the user
		$email1 ="";
		$email2 ="";
		$query = "SELECT email1, email2 FROM recruits WHERE userID=" .Base::getInstance()->getUserID();
		$results = $connection->commit($query);

		if(mysql_num_rows($results)>0)
		{
			$line = mysql_fetch_array($results, MYSQL_ASSOC);
			$email1 = $line['email1'];

		}




        //send:
        //1) snippets
        //2) bookmarks
        //3) etherpad
		//Finish session 1



				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: Chris Leeder <cal293@scarletmail.rutgers.edu>' . "\r\n";

				$subject = "Interactive search study completion";

				$message = "<html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type content='text/html; charset=utf-8' />";
				$message .= "\r\n";
				$message .= "<title>Interactive search study completion</title></head>\n<body>\n";
				$message .= "\r\n";
				$message .= "Hello,<br/><br/>Thank you for completing our study!<br/><br/>";
				$message .= "\r\n";
				$message .= "We have attached to this e-mail the snippets, bookmarks, and Task Pad you've created for your own personal use.<br/><br/>";
				$message .= "\r\n";
				$message .= "Feel free to contact me if you have any questions.<br/><br/>Sincerely,<br/>Chris Leeder<br/>Postdoctoral Researcher<br/>Rutgers University School of Communication and Information<br/>chris.leeder@rutgers.edu<br/>";
				$message .= "\r\n";

        //snippets
        $projectID = Base::getInstance()->getProjectID();
        $query = "SELECT * from snippets WHERE projectID='$projectID'";
        $connection = Connection::getInstance();
        $results = $connection->commit($query);
        $message .= "<center><strong><u>Snippets</u></strong></center><br><br>";
        $message .= "\r\n";
        $ct=0;
        while($line = mysql_fetch_array($results,MYSQL_ASSOC)){
            $ct+=1;
            $title = $line['title'];
            $url = $line['url'];
            $snippet = $line['snippet'];

            $message .= "<u>Snippet $ct</u><br>";
            $message .= "<u>Page title:</u> $title<br>";
            $message .= "<u>URL:</u> $url<br>";
            $message .= "<u>Note:</u> $snippet<br>";

        }
        $message .= "<br><br>";


        //bookmarks
        $query = "SELECT * from bookmarks WHERE projectID='$projectID'";
        $connection = Connection::getInstance();
        $results = $connection->commit($query);
        $message .= "<center><strong><u>Bookmarks</u></strong></center><br><br>";
        $message .= "\r\n";
        $ct=0;
        while($line = mysql_fetch_array($results,MYSQL_ASSOC)){
            $ct+=1;
            $title = $line['title'];
            $url = $line['url'];
            $rating = $line['rating'];
            $note = $line['note'];

            $message .= "<u>Bookmark $ct</u><br>";
            $message .= "<u>Page title:</u> $title<br>";
            $message .= "<u>URL:</u> $url<br>";
            $message .= "<u>Rating:</u> $rating<br>";
            $message .= "<u>Note:</u> $note<br>";

        }

        $message .= "<br><br>";


        $port = 9000;
        $apikey="857212484544558872d773276b65eba2d916510f2022c613e5e4517cc57d863c";
        $stageID=70;
        $questionID=2;
        $padID = "spring2015_report-$projectID-$stageID-$questionID";
        $url = "http://coagmentopad.rutgers.edu:".$port."/api/1/getText?apikey=".$apikey."&padID=".$padID;

        $data=file_get_contents($url);
        $data=json_decode($data);
        $text = '';
        if($data->{'code'} == 0){
            $text= $data->{'data'}->{'text'};
            $text = str_replace("\n","<br/>",$text);
            $text = str_replace("*","",$text);
        }else{
            $text = "None";
        }
        $message .= "<center><strong><u>Task Pad</u></strong></center><br><br>";
        $message .= "<u>Text:</u> $text<br>";

        $message .= "<br><br>";


        //etherpad
				$message .= "</body></html>";

				mail ('chris.leeder@rutgers.edu', $subject, $message, $headers); //Copy to researchers conducting the study
				mail ('mmitsui@scarletmail.rutgers.edu', $subject, $message, $headers); //Copy to researchers conducting the study
				mail ($email1, $subject, $message, $headers); //Notificaiton to Participant's primary email

        $base = new Base();
        Util::getInstance()->saveAction('logout',0,$base);



				//Save action
				// Send an email at the end of session 1 instruting users to log in 2 days after to complete the second session




		?>
		<html>
		<head>
		<title>Completed Study
		</title>
		</head>
		<body class="body">
		<center>
			<br/>
			<table class="body" width="503">
				<tr><td align="center"><br/>Thank you for participating in this study!<td/></tr>
				<tr><td align="center"><br/>Please sign for receiving your incentive payment on the way out.<td/></tr>
				<tr><td align="center"><br/><br /><td/></tr>
				<!--<tr><td align="center"><a href="../logout.php">Click here to exit.</a></td></tr>-->
			</table>
		</center>
		</body>
		</html>
<?php


}

?>
