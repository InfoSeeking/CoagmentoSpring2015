<?php
	require_once('core/Connection.class.php');
	require_once('core/Base.class.php');
?>
<html>
<head>
<title>Interactive Search Study: Sign Up</title>
<link rel="stylesheet" type="text/css" href="styles.css" />
<style type="text/css">
		.cursorType{
		cursor:pointer;
		cursor:hand;
		}
</style>
</head>

<body class="style1">
<?php
    $query = "SELECT sessionday, COUNT(*) as ct from recruits GROUP BY sessionday";
    
    $connection = Connection::getInstance();
    
    $tuesday_limit = 24;
    $friday_limit = 24;
    $tbd_limit = 24;
    $results = $connection->commit($query);
    $tuesday_actual = 0;
    $friday_actual = 0;
    $tbd_actual = 0;
    while($line = mysql_fetch_array($results, MYSQL_ASSOC)){
        if(strpos($line['sessionday'],'Tuesday 10/28') !== false){
            $tuesday_actual = $line['ct'];
        }else if(strpos($line['sessionday'],'Friday 10/31') !== false){
            $friday_actual = $line['ct'];
        }else if(strpos($line['sessionday'],'Monday 10/27') !== false){
            $tbd_actual = $line['ct'];
        }
    }
    $left = 1;

    if (isset($_POST['sessionday'])){
        if(strpos($_POST['sessionday'],'Tuesday 10/28') !== false){
            $left = $tuesday_limit - $tuesday_actual;
        }else if(strpos($_POST['sessionday'],'Friday 10/31') !== false){
            $left = $friday_limit - $friday_actual;
        }else if(strpos($_POST['sessionday'],'Monday 10/27') !== false){
            $left = $tbd_limit - $tbd_actual;
        }
    }
    if (isset($_POST['sessionday']) && $left <= 0){
        echo "<p style='background-color:red;'>We apologize, but the day that you've chosen is already taken.</p>";
        echo "<p>The following are the remaining days with available openings:</p>";
        echo "<ul style=\"list-style-type: none;\">";
        if($tbd_limit - $tbd_actual > 0){
            echo "<li>Monday 10/27 6:00-7:00 PM</li>";
        }
        if($tuesday_limit - $tuesday_actual > 0){
        echo "<li>Tuesday 10/28 3:00-4:00 PM</li>";
        }
        if($friday_limit - $friday_actual > 0){
        echo "<li>Friday 10/31 2:00-3:00 PM</li>";
        }
        
        echo "</ul>";
        echo "<p>Please click the button below to return to the sign up form.</p>";
        echo "<input type=\"button\" value=\"Go Back\" onClick=\"javascript:history.go(-1)\" />";

  
        }else if (
	   (isset($_POST['firstName'])) && 
	   (isset($_POST['lastName'])) && 
	   (isset($_POST['email1'])) &&  
	   (isset($_POST['year'])) &&
   	   (isset($_POST['sex'])) &&
   	   (isset($_POST['coursename'])) &&
	   (isset($_POST['researchtopic'])) &&
        (isset($_POST['sessionday']))
	   ) 
		{  	
			$connection = Connection::getInstance();	
			$base = new Base();
			
						
			//ADDING PARTICIPANT REGISTRATION DETAILS
			$firstName= stripslashes($_POST['firstName']);
			$lastName = stripslashes($_POST['lastName']);
			$email1 = $_POST['email1'];
            $sex = $_POST['sex'];
            $year = $_POST['year'];
            $coursename = addslashes($_POST['coursename']);
            $researchtopic = $_POST['researchtopic'];
            $sessionday = $_POST['sessionday'];
            

			$time = $base->getTime();
			$date = $base->getDate();
			$timestamp = $base->getTimestamp();
			$user_ip = $base->getIP();
		
			$query = "INSERT INTO recruits (firstName, lastName, email1, sex, approved, date, time, timestamp, year, coursename, researchtopic, sessionday) VALUES('$firstName','$lastName','$email1','$sex','1', '$date', '$time', '$timestamp', '$year', '$coursename', '$researchtopic', '$sessionday')";

            $results = $connection->commit($query);
			$recruitsID = $connection->getLastID();
			
									
			
			
				
			
			//Convert the binary flag native language English to 'yes' or 'no'
//				if($english==1)
//				{
//					$english_text = "Yes";
//				}
//				else
//				{
//					$english_text = "No";
//				}
			
			// SEND NOTIFICATION EMAIL TO RESEARCHER							
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: Chris Leeder <chris.leeder@rutgers.edu>' . "\r\n";
			

			
			$subject = "Interactive search study participation confirmation";
			
			$message = "<html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type content='text/html; charset=utf-8' />";
			$message .= "\r\n";
			$message .= "<title>Interactive study participation confirmation email</title></head>\n<body>\n";
			$message .= "\r\n";
			$message .= "Hello,<br/><br/>Thank you for your interest in taking part in our study. The details of your session are shown below.<br/><br/>";
			$message .= "\r\n";
            $message .= "<strong>Your name:</strong> $firstName $lastName<br/>";
			$message .= "\r\n";
			$message .= "<strong>Your scheduled time:</strong> $sessionday<br/>";
			$message .= "\r\n";
            
            $message .= "The study will take place in <strong>Room 413 of Alexander Library</strong>.<br/><br/>";
			$message .= "\r\n";
            $message .= "Please arrive <strong>BEFORE</strong> the start of the study. The study will start exactly on time. <br/><br/>";
			$message .= "\r\n";
            $message .= "You must complete the <strong>ENTIRE</strong> one hour study to be paid.<br/><br/>";
			$message .= "\r\n";
            $message .= "You will receive $10 for your participation in this study.<br/><br/>";
			$message .= "\r\n";
            
            
            
            
            $message .= "\r\n";
			$message .= "Feel free to contact me if you have any questions.<br/><br/>Sincerely,<br/>Chris Leeder<br/>Postdoctoral Researcher<br/>Rutgers University School of Communication and Information<br/>chris.leeder@rutgers.edu<br/>";
			$message .= "\r\n";
			$message .= "</body></html>";

			//$message = rtrim(chunk_split(base64_encode($message))); 

			mail ('chris.leeder@rutgers.edu', $subject, $message, $headers); //Copy to researchers conducting the study
			mail ('mmitsui@scarletmail.rutgers.edu', $subject, $message, $headers); //Copy to researchers conducting the study
			mail ($email1, $subject, $message, $headers); //Notificaiton to Participant's primary email

			// WEB APPLICATION NOTIFICATION TO THE PARTICIPANT
			echo "<table>\n";
			echo "<tr><td><br/><br/></td></tr>\n";
			echo "<tr><td align=left>Thank you for submitting your request for participating in this study. An email has been sent to you with this confirmation. If you do not receive this email in an hour or have any further question about this study, feel free to <a href=\"mailto:chris.leeder@rutgers.edu?subject=Study inquiry\">contact us</a>.<hr/></td></tr>\n";
			echo "<tr><td><strong>Participant information</strong></td></tr>\n";
			echo "<tr><td>First name: $firstName</td></tr>\n";
			echo "<tr><td>Last name: $lastName</td></tr>\n";
			echo "<tr><td>Email: $email1</td></tr>\n";
            echo "<tr><td>Year in college: $year</td></tr>\n";
			echo "<tr><td>Sex: $sex</td></tr>\n";
			echo "<tr><td>Topic of your 01:355:201 Research in the Disciplines class: $coursename</td></tr>\n";
            echo "<tr><td>Research topic: $researchtopic</td></tr>\n";
			echo "<tr><td>Study session: $sessionday</td></tr>\n";
			echo "<tr><td><hr/>You can close this window now or navigate away. We will contact you soon via email.</td></tr>\n";
			echo "</table>\n";
			
			
		}
		else
		{
			echo "<p>You forgot to complete one or more required values. Please click the button below to return to the sign up form.</p>\n";
			echo "<input type=\"button\" value=\"Go Back\" onClick=\"javascript:history.go(-1)\" />";
		}
	
?>
<br/>
</body>
</html>

