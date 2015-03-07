<?php
    session_start();
    if ((isset($_SESSION['CSpace_userID'])))
    {
        $userName= $_SESSION['userName'];
        $projectID = $_SESSION['CSpace_projectID'];

        $padID = $_GET['padID'];
        $padUser = $_GET['userName'];

        if (($userName==$padUser)&&($projectID==$padID))
        {
            echo 1;
        }
        else
            {
                echo 0;
            }
    }
    else
        {
                echo 3;
    }
?>