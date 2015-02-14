<?php
	require_once('core/Connection.class.php');
	require_once('core/Base.class.php');
?>
<html>
<head>
	<link rel="stylesheet" href="study_styles/custom/text.css">
	<link rel="stylesheet" href="study_styles/pure-release-0.5.0/buttons.css">
	<link rel="stylesheet" href="study_styles/pure-release-0.5.0/forms.css">
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
//    $query = "SELECT sessionday, COUNT(*) as ct from recruits GROUP BY sessionday";
//
//    $connection = Connection::getInstance();
//
//    $tuesday_limit = 24;
//    $friday_limit = 24;
//    $tbd_limit = 24;
//    $monday_limit = 24;
//    $wednesday_limit = 24;
//    $late_tuesday_limit = 24;
//
//    $results = $connection->commit($query);
//    $tuesday_actual = 0;
//    $friday_actual = 0;
//    $tbd_actual = 0;
//    $monday_actual = 0;
//    $wednesday_actual = 0;
//    $late_tuesday_actual = 0;
//    while($line = mysql_fetch_array($results, MYSQL_ASSOC)){
//        if(strpos($line['sessionday'],'Friday 11/7 1:00-2:00 PM') !== false){
//            $tuesday_actual = $line['ct'];
//        }else if(strpos($line['sessionday'],'Friday 11/7 3:00-4:00 PM') !== false){
//            $friday_actual = $line['ct'];
//        }else if(strpos($line['sessionday'],'Thursday 11/6 10:00-11:00 AM') !== false){
//            $tbd_actual = $line['ct'];
//        }else if(strpos($line['sessionday'],'Monday 11/10 2:00-3:00 PM') !== false){
//            $monday_actual = $line['ct'];
//        }else if(strpos($line['sessionday'],'Tuesday 11/11 3:00-4:00 PM') !== false){
//            $late_tuesday_actual = $line['ct'];
//        }else if(strpos($line['sessionday'],'Wednesday 11/12 3:00-4:00 PM') !== false){
//            $wednesday_actual = $line['ct'];
//        }
//    }
//    $left = 1;
//
//    if (isset($_POST['sessionday'])){
//        if(strpos($_POST['sessionday'],'TFriday 11/7 1:00-2:00 PM') !== false){
//            $left = $tuesday_limit - $tuesday_actual;
//        }else if(strpos($_POST['sessionday'],'Friday 11/7 3:00-4:00 PM') !== false){
//            $left = $friday_limit - $friday_actual;
//        }else if(strpos($_POST['sessionday'],'Thursday 11/6 10:00-11:00 AM') !== false){
//            $left = $tbd_limit - $tbd_actual;
//        }
//        else if(strpos($line['sessionday'],'Monday 11/10 2:00-3:00 PM') !== false){
//            $left = $monday_limit - $monday_actual;
//        }else if(strpos($line['sessionday'],'Tuesday 11/11 3:00-4:00 PM') !== false){
//            $left = $late_tuesday_limit - $late_tuesday_actual;
//        }else if(strpos($line['sessionday'],'Wednesday 11/12 3:00-4:00 PM') !== false){
//            $left = $wednesday_limit - $wednesday_actual;
//        }
//    }
//    if (isset($_POST['sessionday']) && $left <= 0){
    if(0){
        echo "<p style='background-color:red;'>We apologize, but the day that you've chosen is already taken.</p>";
        echo "<p>The following are the remaining days with available openings:</p>";
        echo "<ul style=\"list-style-type: none;\">";
//        if($tbd_limit - $tbd_actual > 0){
//            echo "<li>Thursday 11/6 10:00-11:00 AM</li>";
//        }
//        if($tuesday_limit - $tuesday_actual > 0){
//        echo "<li>Friday 11/7 1:00-2:00 PM</li>";
//        }
//        if($friday_limit - $friday_actual > 0){
//        echo "<li>Friday 11/7 3:00-4:00 PM</li>";
//        }

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

//            $query = "SELECT a.ct as k, COUNT(a.ct) as v from (SELECT projectID, COUNT(projectID) as ct FROM recruits GROUP BY projectID) a GROUP BY a.ct";
//            $connection = Connection::getInstance();
//            $results = $connection->commit($query);
//
//            $ct_array = array();
//
//            while($line = mysql_fetch_array($results, MYSQL_ASSOC)){
//                if($line['k'] == 1 && $line['v'] < 21){
//                    $closed = false;
//                }
//                else if($line['k'] == 2 && $line['v'] < 14){
//                    $closed = false;
//                }
//                $ct_array[$line['k']] = $line['v'];
//            }
//
//            $section_closed = false;
//            if($_POST['num_users'] == 2 && $ct_array[$_POST['num_users']]>=14){
//                $section_closed = true;
//            }else if ($_POST['num_users'] == 1 && $ct_array[$_POST['num_users']]>=21){
//                $section_closed = true;
//            }


            $closed = false;
            $section_closed = false;

            if(!$closed && !$section_closed){
                $NUM_USERS = 1;
//                $NUM_USERS = $_POST['num_users'];




                $query = "SELECT MAX(projectID) as max from recruits WHERE userID <100";
                $results = $connection->commit($query);
                $line = mysql_fetch_array($results, MYSQL_ASSOC);

                $projectID = $line['max']+1;
                $sessionday = $_POST['sessionday'];

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
//                    $password = random_password_generator();
//                    $password_sha1 = sha1($password);

                    $firstName= stripslashes($_POST["firstName_$x"]);
                    $lastName = stripslashes($_POST["lastName_$x"]);
                    $email1 = $_POST["email1_$x"];
                    $sex = $_POST["sex_$x"];
                    $year = $_POST["year_$x"];
                    $coursename = addslashes($_POST["coursename_$x"]);
                    $researchtopic = $_POST["researchtopic_$x"];
                    $username =$_POST["username_$x"];


                    $time = $base->getTime();
                    $date = $base->getDate();
                    $timestamp = $base->getTimestamp();
                    $user_ip = $base->getIP();

                    $query = "INSERT INTO recruits (firstName, lastName, email1, sex, approved, date, time, timestamp, year, coursename, researchtopic, sessionday,projectID,userID,instructorID) VALUES('$firstName','$lastName','$email1','','1', '$date', '$time', '$timestamp', '', '', '', '','$projectID','$next_userID','$instructorID')";

                    $results = $connection->commit($query);
                    $recruitsID = $connection->getLastID();

                    $query = "INSERT INTO users (userID,projectID,username,password_sha1,status,study,optout,numUsers,topicAreaID) VALUES ('$next_userID','$projectID','$username','$password_sha1','1','1','0','$NUM_USERS','$instructorID')";
                    $results = $connection->commit($query);


                }







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
                $headers .= 'From: Matthew Mitsui <mmitsui@scarletmail.rutgers.edu>' . "\r\n";



                $subject = "Interactive search study participation confirmation";

                $message = "<html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type content='text/html; charset=utf-8' />";
                $message .= "\r\n";
                $message .= "<title>Interactive study participation confirmation email</title></head>\n<body>\n";
                $message .= "\r\n";
                $message .= "Thank you for your interest in taking part in our study. The details are shown below.<br/>";
                $message .= "\r\n";
                $message .= "<strong>Participant name:</strong><br/>";

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
								$message .= "Username: $username<br/>\r\n";
								$message .= "Password: $password<br/>\r\n";

                $message .= "<strong>Your ITI 220 instructor:</strong><br/>$instructorName<br/><br/>";
                $message .= "\r\n";











                $message .= "The study will run $studyDates.<br/><br/>";
                $message .= "\r\n";
                $message .= "You will use the Coagmento collaborative search system while you work on your on IT Market Sector Analysis report.<br/><br/>";
                $message .= "\r\n";
								$message .= "You will receive <strong>$40 cash</strong> for your participation in this study.<br/><br/>";
								$message .= "\r\n";
								$message .= "Your group is also eligible for <strong>an additional $40 cash prize</strong> for best performers, measured by amount of activity using the Coagmento tool.<br/><br/>";
								$message .= "\r\n";
								$message .= "Note that you will be eligible for compensation only if you complete the study and follow all instructions.<br/><br/>";

                // if($NUM_USERS<2){
                //     $message .= "You will receive $15 for your participation in this study.<br/><br/>";
                //     $message .= "\r\n";
                // }else{
                //     $message .= "Each of you will receive $20 for your participation in this study.<br/><br/>";
                //     $message .= "\r\n";
                // }

                // $message .= "You are eligible for a cash $20 first prize and $10 second prize for best performers.<br/><br/>";
                // $message .= "\r\n";




                $message .= "\r\n";
                $message .= "Feel free to contact me if you have any questions.<br/><br/>Sincerely,<br/>Chris Leeder<br/>Postdoctoral Researcher<br/>Rutgers University School of Communication and Information<br/>chris.leeder@rutgers.edu<br/>";
                $message .= "\r\n";
                $message .= "</body></html>";

                //$message = rtrim(chunk_split(base64_encode($message)));

//                mail ('chris.leeder@rutgers.edu', $subject, $message, $headers); //Copy to researchers conducting the study
                mail ('mmitsui@scarletmail.rutgers.edu', $subject, $message, $headers); //Copy to researchers conducting the study
                for($x=1;$x<=$NUM_USERS;$x++){
                    $email = $_POST["email1_$x"];
                    $firstName = $_POST["firstName_$x"];
                    $lastName = $_POST["lastName_$x"];
                    $message .= $firstName." ".$lastName."<br/>";
                    $message .= "\r\n";
                    mail ($email1, $subject, $message, $headers); //Notificaiton to Participant's primary email
                }


                // WEB APPLICATION NOTIFICATION TO THE PARTICIPANT
                echo "<table>\n";
                echo "<tr><td></td></tr>\n";
                echo "<tr><td align=left>Thank you for submitting your request for participating in this study. An email has been sent to you with this confirmation. If you do not receive this email in an hour or have any further question about this study, feel free to <a href=\"mailto:chris.leeder@rutgers.edu?subject=Study inquiry\">contact us</a>.<hr/></td></tr>\n";
                echo "<tr><td><strong>Participant information</strong></td></tr>\n";

                for($x=1;$x<=$NUM_USERS;$x++){
                    $email1 = $_POST["email1_$x"];
                    $firstName = $_POST["firstName_$x"];
                    $lastName = $_POST["lastName_$x"];
//                    $year = $_POST["year_$x"];
//                    $sex = $_POST["sex_$x"];
//                    $coursename = $_POST["coursename_$x"];
//                    $researchtopic = $_POST["researchtopic_$x"];
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

//                    echo "<tr><td>Year in college: $year</td></tr>\n";
//                    echo "<tr><td>Sex: $sex</td></tr>\n";
                    echo "<tr><td>Instructor of your 04:547:220 Retrieving and Evaluating Electronic Information class: $instructorName</td></tr>\n";
//                    echo "<tr><td>Research topic: $researchtopic</td></tr>\n";


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
