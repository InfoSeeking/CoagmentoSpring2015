<?php 	session_start();
        if ((isset($_SESSION['CSpace_userID'])))
            {
                $userName = $_SESSION['userName'];
                $title = project.$_SESSION['CSpace_projectID'];
                if ($_SESSION['CSpace_projectID']=="")
                { echo
                        "<script>alert('In order to open the editor, you must first select a project from your CSpace'); window.location.href='http://www.coagmento.org/CSpace/projects.php';</script>";
						
                } else {
                            require_once("connect.php");
                            $userID = $_SESSION['CSpace_userID'];
                            $pQuery = "SELECT points FROM users WHERE userID='$userID'";
                            $pResults = mysql_query($pQuery) or die(" ". mysql_error());
                            $pLine = mysql_fetch_array($pResults, MYSQL_ASSOC);
                            $totalPoints = $pLine['points'];
                            $newPoints = $totalPoints+20;
                            $pQuery = "UPDATE users SET points=$newPoints WHERE userID='$userID'";
                            $pResults = mysql_query($pQuery) or die(" ". mysql_error());

                            $timestamp = time();
                            $datetime = getdate();
                            $date = date('Y-m-d', $datetime[0]);
                            $time = date('H:i:s', $datetime[0]);
                            $projectID = $_SESSION['CSpace_projectID'];
                            $userID = $_SESSION['CSpace_userID'];
                            $ip=$_SERVER['REMOTE_ADDR'];
                            $action = 'editor';
                            $value = $title;

                            $query = "INSERT INTO actions (userID, projectID, timestamp, date, time, action, value, ip) VALUES ('$userID', '$projectID', '$timestamp', '$date', '$time', '$action', '$value','$ip')";
                      	    $results = mysql_query($query) or die(" ". mysql_error());

                            header("Location: http://coagmentopad.rutgers.edu/$title?nickname=$userName");
                            exit;
                       }
            }
            else {
                    echo "Your session has expired. Please <a href=\"http://www.coagmento.org/\" target=_content><span style=\"color:blue;text-decoration:underline;cursor:pointer;\">login</span> again.\n";

                 }

?> 