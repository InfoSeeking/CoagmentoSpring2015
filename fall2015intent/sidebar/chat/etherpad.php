<?php
    require_once('../../core/Base.class.php');
    session_start();
    $base = Base::getInstance();
    
    if (isset($base->getUserID()))
        {
            $userName = $base->getUserName();
            $title = project.$base->getProjectID();
            if ($base->getProjectID()=="")
            { echo
                    "<script>alert('In order to open the editor, you must first select a project from your CSpace');</script>";
                    header("Location: http://coagmento.org/CSpace/projects.php");
                    exit;
            } else {
                require_once('../../core/Connection.class.php');
                $userID = $base->getUserID();
                $query = "SELECT points FROM users WHERE userID='$userID'";
                $connection = Connection::getInstance();
                $results = $connection->commit($query);
                $line = mysql_fetch_array($results, MYSQL_ASSOC);
                $totalPoints = $line['points'];
                $newPoints = $totalPoints+20;
                $query = "UPDATE users SET points=$newPoints WHERE userID='$userID'";
                $results = $connection->commit($query);
                
                $timestamp = $base->getTimestamp();
                $date = $base->getDate();
                $time = $base->getTime();
                $projectID = $base->getProjectID();
                $userID = $base->getUserID();
                $ip=$base->getIP();
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