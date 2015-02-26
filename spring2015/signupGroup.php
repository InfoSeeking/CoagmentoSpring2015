<?php
	session_start();
	require_once('core/Connection.class.php');
	require_once('core/Base.class.php');
	require_once('core/Questionnaires.class.php');
?>
<html>
<head>
	<link rel="stylesheet" href="study_styles/custom/text.css">
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
		$questionnaire = Questionnaires::getInstance();
		// print_r($questionnaire->getQuestions());
		// Check if questionnaire is compelte.

    function random_password_generator($length = 10) {
        $char_lower = 'abcdefghijklmnopqrstuvwxyz';
        $char_upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $char_num = '0123456789';
        $char_punc = '*&%!?#*$@^';
        $randomString = '';

        $randomString .= $char_upper[rand(0, strlen($char_upper) - 1)];
        $randomString .= $char_lower[rand(0, strlen($char_lower) - 1)];
        $randomString .= $char_lower[rand(0, strlen($char_lower) - 1)];
        $randomString .= $char_num[rand(0, strlen($char_num) - 1)];
        $randomString .= $char_lower[rand(0, strlen($char_lower) - 1)];
        $randomString .= $char_upper[rand(0, strlen($char_upper) - 1)];
        $randomString .= $char_punc[rand(0, strlen($char_punc) - 1)];

        return $randomString;
    }
    if(0){
        echo "<p style='background-color:red;'>We apologize, but the day that you've chosen is already taken.</p>";
        echo "<p>The following are the remaining days with available openings:</p>";
        echo "<ul style=\"list-style-type: none;\">";
        echo "</ul>";
        echo "<p>Please click the button below to return to the sign up form.</p>";
        echo "<input type=\"button\" value=\"Go Back\" onClick=\"javascript:history.go(-1)\" />";


    }else if (
                  (isset($_POST['num_users'])) &&
	   (isset($_POST['firstName_1'])) &&
	   (isset($_POST['lastName_1'])) &&
	   (isset($_POST['email1_1'])) &&
	   (isset($_POST['username_1'])) &&
   	   (isset($_POST['pwd_1'])) &&
	   (isset($_POST['repwd_1'])) &&
        (isset($_POST['instructor_1']))
	   )
		{
			$connection = Connection::getInstance();
			$base = new Base();


            $closed = false;
            $section_closed = false;

            if(!$closed && !$section_closed){
                $NUM_USERS = 1;
                $query = "SELECT MAX(projectID) as max from recruits WHERE userID <1000";
                $results = $connection->commit($query);
                $line = mysql_fetch_array($results, MYSQL_ASSOC);

                $projectID = $line['max']+1;
                // $sessionday = $_POST['sessionday'];

                for($x=1; $x<=$NUM_USERS; $x++){
                    //ADDING PARTICIPANT REGISTRATION DETAILS
                    $instructorName = $_POST["instructor_$x"];
                    $query = "SELECT instructorID from instructors WHERE instructorName='$instructorName'";
                    $results = $connection->commit($query);
                    $line = mysql_fetch_array($results, MYSQL_ASSOC);
                    $instructorID = $line['instructorID'];
                    $query = "SELECT MAX(userID) as max FROM recruits WHERE userID <1000";
                    $results = $connection->commit($query);
                    $line = mysql_fetch_array($results,MYSQL_ASSOC);
                    $next_userID = $line['max']+1;
                    $password = $_POST["pwd_$x"];
                    $password_sha1 = sha1($password);
                    $firstName= stripslashes($_POST["firstName_$x"]);
                    $lastName = stripslashes($_POST["lastName_$x"]);
                    $email1 = $_POST["email1_$x"];
                    $sex = $_POST["gender_$x"];
                    $year = $_POST["year_$x"];
                    // $coursename = addslashes($_POST["coursename_$x"]);
                    // $researchtopic = $_POST["researchtopic_$x"];
                    $username =$_POST["username_$x"];
                    $time = $base->getTime();
                    $date = $base->getDate();
                    $timestamp = $base->getTimestamp();
                    $user_ip = $base->getIP();

                    $query = "INSERT INTO recruits (firstName, lastName, email1, sex, approved, date, time, timestamp, year, coursename, researchtopic, sessionday,projectID,userID,instructorID) VALUES('$firstName','$lastName','$email1','','1', '$date', '$time', '$timestamp', '', '', '', '','0','$next_userID','$instructorID')";
                    $results = $connection->commit($query);
                    $recruitsID = $connection->getLastID();

                    $query = "INSERT INTO users (userID,projectID,username,password_sha1,status,study,optout,numUsers,topicAreaID) VALUES ('$next_userID','0','$username','$password_sha1','1','1','0','$NUM_USERS','$instructorID')";
                    $results = $connection->commit($query);
										$userID = $next_userID;

										foreach($_POST as $k=>$v){
											// echo "KEY: $k, VALUE: $v";
											if(strpos($k,"_$x")==strlen($k)-strlen("_$x")){
												$keytoadd = substr($k,0,-strlen("_$x"));
												// echo "ADDING ANSWER:".(string)$keytoadd;
												$questionnaire->addAnswer($keytoadd,$v);
											}
										}
										$questionnaire->commitAnswersToDatabase(array("$userID"),array('userID'),'questionnaire_recruitment');
                }


                // SEND NOTIFICATION EMAIL TO RESEARCHER
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: Study 220 <study220@rutgers.edu>' . "\r\n";



                $subject = "Interactive search study participation confirmation";

                $message = "<html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type content='text/html; charset=utf-8' />";
                $message .= "\r\n";
                $message .= "<title>Interactive study participation confirmation email</title></head>\n<body>\n";
                $message .= "\r\n";
                $message .= "Thank you for your interest in taking part in our study. The details are shown below.<br/>";
                $message .= "\r\n";
                $message .= "<strong>Participant name: </strong>";

                for($x=1;$x<=$NUM_USERS;$x++){
                    $firstName = $_POST["firstName_$x"];
                    $lastName = $_POST["lastName_$x"];
                    $message .= $firstName." ".$lastName."<br/>";
                    $message .= "\r\n";
                }
								$instructorName = $_POST["instructor_1"];
								$studyDates = "";
								if(strpos($instructorName,"Belkin") !== false){
									$instructorName = "Professor Belkin";
									$studyDates = "March 6 through May 3";
								}else if(strpos($instructorName,"Wacholder") !== false){
									$instructorName = "Professor Wacholder";
									$studyDates = "March 23 through May 4";
								}


								$username = $_POST["username_1"];
								$password = $_POST["pwd_1"];
								$message .= "<strong>Username:</strong> $username<br/>\r\n";
								$message .= "<strong>Password:</strong> $password<br/>\r\n";

                $message .= "<strong>Your ITI 220 instructor:</strong><br/>$instructorName<br/><br/>";
                $message .= "\r\n";











                $message .= "The study will run $studyDates.<br/><br/>";
                $message .= "\r\n";
                $message .= "You will use the Coagmento collaborative search system while you work on your on IT Market Sector Analysis report.<br/><br/>";
                $message .= "\r\n";
								$message .= "You will receive <strong>$40 cash</strong> for your participation in this study.<br/><br/>";
								$message .= "\r\n";
								$message .= "Your group is also eligible for <strong>an additional $20 cash prize</strong> per person for best performers, measured by amount of activity using the Coagmento tool.<br/><br/>";
								$message .= "\r\n";
								$message .= "Note: To receive payment you must complete the study and answer the three online questionnaires.<br/><br/>";


                $message .= "\r\n";
                $message .= "Feel free to <a href=\"mailto:study220@rutgers.edu?subject=Study inquiry\">contact us</a> if you have any questions.";
								$message .= "\r\n";
                $message .= "</body></html>";


                mail ('cal293@scarletmail.rutgers.edu ', $subject, $message, $headers); //Copy to researchers conducting the study
								mail ('mmitsui@scarletmail.rutgers.edu', $subject, $message, $headers); //Copy to researchers conducting the study
								mail ('kevin.eric.albertson@gmail.com', $subject, $message, $headers); //Copy to researchers conducting the study
                for($x=1;$x<=$NUM_USERS;$x++){
                    $email = $_POST["email1_$x"];
                    $firstName = $_POST["firstName_$x"];
                    $lastName = $_POST["lastName_$x"];
                    $message = $firstName." ".$lastName.",<br/><br/>".$message;
                    $message .= "\r\n";
                    // mail ($email1, $subject, $message, $headers); //Notificaiton to Participant's primary email
                }


                // WEB APPLICATION NOTIFICATION TO THE PARTICIPANT
                echo "<table>\n";
                echo "<tr><td></td></tr>\n";
                echo "<tr><td align=left>Thank you for submitting your request for participating in this study. An email has been sent to you with this confirmation. If you do not receive this email in an hour or have any further question about this study, feel free to <a href=\"mailto:study220@rutgers.edu?subject=Study inquiry\">contact us</a>.<hr/></td></tr>\n";
                echo "<tr><td><strong>Participant information</strong></td></tr>\n";

                for($x=1;$x<=$NUM_USERS;$x++){
                    $email1 = $_POST["email1_$x"];
                    $firstName = $_POST["firstName_$x"];
                    $lastName = $_POST["lastName_$x"];
                    $username =$_POST["username_$x"];
                    $password = $_POST["pwd_$x"];
                    $instructorName = $_POST["instructor_$x"];

										$studyDates = "";
										if(strpos($instructorName,"Belkin") !== false){
											$instructorName = "Professor Belkin";
											$studyDates = "March 6 - May 3";
										}else if(strpos($instructorName,"Wacholder") !== false){
											$instructorName = "Professor Wacholder";
											$studyDates = "March 23 - May 4";
										}

                    if($NUM_USERS>=2){
                        echo "<tr><td><br><br></td></tr>";
                        echo "<tr><td><strong>Participant $x</strong></td></tr>\n";
                    }
                    echo "<tr><td>First name: $firstName</td></tr>\n";
                    echo "<tr><td>Last name: $lastName</td></tr>\n";
                    echo "<tr><td>Email: $email1</td></tr>\n";
                    echo "<tr><td>Username: $username</td></tr>\n";
                    echo "<tr><td>Password: $password</td></tr>\n";
                    echo "<tr><td>Instructor of your 04:547:220 Retrieving and Evaluating Electronic Information class: $instructorName</td></tr>\n";
                }

                if($NUM_USERS>=2){
                    echo "<tr><td><br><br></td></tr>";
                }

								$instructorName = $_POST["instructor_1"];
								$studyDates = "";
								if(strpos($instructorName,"Belkin") !== false){
									$instructorName = "Professor Belkin";
									$studyDates = "March 6 - May 3";
								}else if(strpos($instructorName,"Wacholder") !== false){
									$instructorName = "Professor Wacholder";
									$studyDates = "March 23 - May 4";
								}

                echo "<tr><td><strong>Study dates: $studyDates</strong></td></tr>\n";
								echo "<br><br>";
                echo "<tr><td><hr/>You can close this window now or navigate away. We will contact you soon via email.</td></tr>\n";
                echo "</table>\n";
            }else if($closed){
                echo "<p style='background-color:red;'>Sorry! The user study registration is currently closed.</p>\n";
                echo "<br/><br/>\n";
                echo "<hr/>\n";
                echo "<p>The number of participants required has been reached at this point.</p>\n";
                echo "<p>If more user participation is required, we will reopen the study registration and send another round of recruitment emails.</p>\n";
                echo "<hr/>\n";
            }else if ($section_closed){
                echo "<br/><br/>\n";
                echo "<hr/>\n";
                echo "<p>The number of required for this type of grouping has been reached at this point.</p>\n";
                echo "<p>If you wanted to register as a pair but would still like to participate, please register as individual users.</p>\n";
                echo "<hr/>\n";
            }


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
