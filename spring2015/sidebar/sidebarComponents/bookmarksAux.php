<?php
    require_once('../../core/Connection.class.php');
    require_once('../../core/Base.class.php');
    require_once('../../core/User.class.php');
    require_once('functions.php');


    echo "<a alt=\"Refresh\" class=\"cursorType\" onclick=\"javascript:reload('sidebarComponents/bookmarks.php','bookmarksBox')\" style=\"font-size:12px; font-weight: bold; color:orange\">Reload</a>\n";
    echo "<div id=\"floatBookmarkLayer\" style=\"position:absolute;  width:150px;  padding:16px;background:#FFFFFF;  border:2px solid #2266AA;  z-index:100; display:none \"></div>";
    echo "<div id=\"floatBookmarkLayerDelete\" style=\"position:absolute;  width:150px;  padding:16px;background:#FFFFFF;  border:2px solid #2266AA;  z-index:100; display:none \"></div>";
    echo "<table width=100% cellspacing=0>\n";
    echo "<tr>";
    /*echo "<td align=\"center\"><img src=\"images/asc.gif\" height=\"10\" width=\"10\" alt=\"Asc\" class=\"cursorType\" onclick=\"javascript:changeOrder('Bookmarks','userName asc','bookmarksBox','bookmarks.php')\"><span style=\"font-size:10px; color:#FFFFFF\">-</span><img src=\"images/desc.gif\" height=\"10\" width=\"10\" alt=\"Desc\" class=\"cursorType\" onclick=\"javascript:changeOrder('Bookmarks','userName desc','bookmarksBox','bookmarks.php')\"></td>";
     echo "<td align=\"left\"><img src=\"images/asc.gif\" height=\"10\" width=\"10\" alt=\"Asc\" class=\"cursorType\" onclick=\"javascript:changeOrder('Bookmarks','title asc','bookmarksBox','bookmarks.php')\"><span style=\"font-size:10px; color:#FFFFFF\">-</span><img src=\"images/desc.gif\" height=\"10\" width=\"10\" alt=\"Desc\" class=\"cursorType\" onclick=\"javascript:changeOrder('Bookmarks','title desc','bookmarksBox','bookmarks.php')\"></td>";
     echo "<td align=\"center\"><img src=\"images/asc.gif\" height=\"10\" width=\"10\" alt=\"Asc\" class=\"cursorType\" onclick=\"javascript:changeOrder('Bookmarks','finalRating asc','bookmarksBox','bookmarks.php')\"><span style=\"font-size:10px; color:#FFFFFF\">-</span><img src=\"images/desc.gif\" height=\"10\" width=\"10\" alt=\"Desc\" class=\"cursorType\" onclick=\"javascript:changeOrder('Bookmarks','finalRating desc','bookmarksBox','bookmarks.php')\"></td>";
     echo "<td align=\"center\"><img src=\"images/asc.gif\" height=\"10\" width=\"10\" alt=\"Asc\" class=\"cursorType\" onclick=\"javascript:changeOrder('Bookmarks','snippetID asc','bookmarksBox','bookmarks.php')\"><span style=\"font-size:10px; color:#FFFFFF\">-</span><img src=\"images/desc.gif\" height=\"10\" width=\"10\" alt=\"Desc\" class=\"cursorType\" onclick=\"javascript:changeOrder('Bookmarks','snippetID desc','bookmarksBox','bookmarks.php')\"></td>";
     //echo "<td></td>";*/
    echo "</tr>";

    //    TODO: May not have been part of this code.  Delete?
    //    echo "Your session has expired. Please <a href=\"http://www.coagmento.org/loginOnSideBar.php\" target=_content><span style=\"color:blue;text-decoration:underline;cursor:pointer;\">login</span> again.\n";

    $base = Base::getInstance();
    $projectID = $base->getProjectID();
    $userMap = $userMap = User::getIDMap($projectID);
    $userID = $base->getUserID();
    $connection = Connection::getInstance();
    $questionID = $base->getQuestionID();
    $query = "SELECT * FROM bookmarks WHERE projectID='$projectID' AND questionID='$questionID' AND status=1";
    $results = $connection->commit($query);
    $bgColor = '#E8E8E8';

    $numRows = mysql_num_rows($results);


    while($line = mysql_fetch_array($results, MYSQL_ASSOC)){
        $bookmarkID = $line['bookmarkID'];
        //$userName = TODO : use a username.  Make map from userID to username, for each user in the project.
        $userIDItem = $line['userID'];
        $userName = isset($userMap[$userIDItem]) ? $userMap[$userIDItem] : "";
        $rating = $line['rating'];

        $note = $line['note'];

        $url = $line['url'];
        $title = stripslashes($line['title']);
        $type = 'text';
        $time = $line['time'];
        $date = strtotime($line['date']);
        $date = strftime("%m/%d", $date);
        $noteAux = substr($note, 0, 20);

//        if ($noteAux!="")
//            $title = $noteAux . '..';
//        else
//        {
            if (!$title)
                $title = $url;

            if (strlen($title)>25) {
                $title = substr($title, 0, 20);
                $title = $title . '..';
            }
//        }


        echo "<tr style=\"background:$bgColor;\"><td><span style=\"font-size:10px\">$userName</span>&nbsp;</td><td><span style=\"font-size:10px\">";
        //echo "<a alt=\"View\" class=\"cursorType\" onclick=\"javascript:showSnippet('floatSnippetLayer',null,'$snippetID','$type')\" style=\"font-size:10px; color:blue\">$title</a></span></td>\n";
        $viewBookmarkOnWindow = "window.open('viewBookmark.php?value=$bookmarkID','Bookmark View','directories=no, toolbar=no, location=no, status=no, menubar=no, resizable=no,scrollbars=yes,width=400,height=300,left=600')";
        echo "<a alt=\"View\" class=\"cursorType\" onclick=\"javascript:$viewBookmarkOnWindow\" onmouseover=\"javascript:showBookmark('floatBookmarkLayer',null,'$bookmarkID','$type')\" onmouseout=\"javascript:hideLayer('floatBookmarkLayer')\" style=\"font-size:10px; color:blue\">$title</a></span></td>\n";
        //                echo "<a alt=\"View\" class=\"cursorType\" onclick=\"javascript:$viewSnipetOnWindow\" onmouseover=\"javascript:showSnippet('floatSnippetLayer',null,'$snippetID','$type')\" onmouseout=\"javascript:hideLayer('floatSnippetLayer')\" style=\"font-size:10px; color:blue\">$title</a></span></td>\n";
        //			if ($url)
        //				echo "<font color=blue><a alt=\"View\" class=\"cursorType\" onclick=\"javascript:showSnippet('floatSnippetLayer',null,'$snippetID','$type')\" style=\"font-size:10px\">$title</a></span></td>\n";
        //			else
        //				echo "<font color=blue><a alt=\"View\" class=\"cursorType\" onclick=\"javascript:showSnippet('floatSnippetLayer',null,'$snippetID','$type')\" style=\"font-size:10px\">$snippet</a></span></td>\n";

        //$fullSnippet = "[Source: " . $url . "] || ".$snippet;

        echo "<input type=\"hidden\" id=\"bookmarkValue$bookmarkID\" value=\"$bookmarkID\">";
        echo "<input type=\"hidden\" id=\"note$bookmarkID\" value=\"$note\">";
        echo "<input type=\"hidden\" id=\"source$bookmarkID\" value=\"$title\">";
        echo "<input type=\"hidden\" id=\"url$bookmarkID\" value=\"$url\">";
        echo "<input type=\"hidden\" id=\"time$bookmarkID\" value=\"$time\">";
        $ratingRepresentation = getBookmarkRatingRepresentation($rating, $bookmarkID,'Bookmarks','floatBookmarkLayer','bookmarksBox','bookmarks.php');
        echo "<td align=\"center\">$ratingRepresentation</td>";
        echo "<td align=\"right\" onmouseover=\"javascript:showTime('floatBookmarkLayer',null,'$bookmarkID')\" onmouseout=\"javascript:hideLayer('floatBookmarkLayer')\"><span style=\"font-size:10px\">$date</span></td>";

        //TEMP: REMOVED THIS FOR EDUSEARCH -> Matt

        if ($userID==$userIDItem)
            echo "<td align=\"right\" class=\"cursorType\" onclick=\"javascript:deleteItem('floatSnippetLayerDelete',null,'$bookmarkID','bookmarks','bookmarksBox','bookmarks.php')\"><span style=\"font-size:10px; color:red; font-weight: bold \"> <a style=\"font-size:10px; color:$bgColor\"> - </a>X</span></td>";
        else
            echo "<td></td>";
        
        /*echo "<td align=\"right\">";
         if ($url)
         echo "<font color=blue><a href=\"$url\" class=\"tt\" target=_content style=\"font-size:10px\"><img src=\"images/link.gif\" height=\"18\" width=\"18\" alt=\"Go\" class=\"cursorType\" /></a>\n";
         else
         echo "<img src=\"images/blank.gif\" height=\"18\" width=\"18\">";

         echo "<span style=\"font-size:10px; color:$bgColor\">-</span><img src=\"images/copy.gif\" height=\"18\" width=\"18\" alt=\"Copy\" class=\"cursorType\" onclick=\"javascript:copyToClipboard('snippetValue$snippetID')\"></td>";
         */

        echo "</tr>";

        if ($bgColor == '#E8E8E8')
            $bgColor = '#FFFFFF';
        else
            $bgColor = '#E8E8E8';

    }
    echo "</table>\n";


	//else {
	//	echo "Your session has expired. Please <a href=\"http://www.coagmento.org/loginOnSideBar.php\" target=_content><span style=\"color:blue;text-decoration:underline;cursor:pointer;\">login</span> again.\n";
	//}
    ?>
