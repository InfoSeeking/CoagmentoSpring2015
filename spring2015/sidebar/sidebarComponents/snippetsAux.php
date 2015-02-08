<?php
    require_once('../../core/Connection.class.php');
    require_once('../../core/Base.class.php');
    require_once('../../core/User.class.php');

	//if ((isset($_SESSION['CSpace_userID']))) {
		//require_once("functions.php");
		//require_once("../connect.php"); USE MYSQL CONNECTION
        /*        $userID = $_SESSION['CSpace_userID'];
		if (isset($_SESSION['CSpace_projectID']))
			$projectID = $_SESSION['CSpace_projectID'];
		$orderBy = $_SESSION['orderBySnippets'];*/
    echo "<a alt=\"Refresh\" class=\"cursorType\" onclick=\"javascript:reload('sidebarComponents/snippets.php','snippetsBox')\" style=\"font-size:12px; font-weight: bold; color:orange\">Reload</a>\n";
    echo "<div id=\"floatSnippetLayer\" style=\"position:absolute;  width:150px;  padding:16px;background:#FFFFFF;  border:2px solid #2266AA;  z-index:100; display:none \"></div>";
    echo "<div id=\"floatSnippetLayerDelete\" style=\"position:absolute;  width:150px;  padding:16px;background:#FFFFFF;  border:2px solid #2266AA;  z-index:100; display:none \"></div>";
    echo "<table width=100% cellspacing=0>\n";
    echo "<tr>";
    echo "<td align=\"center\"><img src=\"images/asc.gif\" height=\"10\" width=\"10\" alt=\"Asc\" class=\"cursorType\" onclick=\"javascript:changeOrder('snippets','userName asc','snippetsBox','snippets.php')\"><span style=\"font-size:10px; color:#FFFFFF\">-</span><img src=\"images/desc.gif\" height=\"10\" width=\"10\" alt=\"Desc\" class=\"cursorType\" onclick=\"javascript:changeOrder('snippets','userName desc','snippetsBox','snippets.php')\"></td>";
    echo "<td align=\"left\"><img src=\"images/asc.gif\" height=\"10\" width=\"10\" alt=\"Asc\" class=\"cursorType\" onclick=\"javascript:changeOrder('snippets','title asc','snippetsBox','snippets.php')\"><span style=\"font-size:10px; color:#FFFFFF\">-</span><img src=\"images/desc.gif\" height=\"10\" width=\"10\" alt=\"Desc\" class=\"cursorType\" onclick=\"javascript:changeOrder('snippets','title desc','snippetsBox','snippets.php')\"></td>";
    //  echo "<td align=\"center\"><img src=\"images/asc.gif\" height=\"10\" width=\"10\" alt=\"Asc\" class=\"cursorType\" onclick=\"javascript:changeOrder('snippets','finalRating asc','snippetsBox','snippets.php')\"><span style=\"font-size:10px; color:#FFFFFF\">-</span><img src=\"images/desc.gif\" height=\"10\" width=\"10\" alt=\"Desc\" class=\"cursorType\" onclick=\"javascript:changeOrder('snippets','finalRating desc','snippetsBox','snippets.php')\"></td>";
     echo "<td align=\"center\"><img src=\"images/asc.gif\" height=\"10\" width=\"10\" alt=\"Asc\" class=\"cursorType\" onclick=\"javascript:changeOrder('snippets','snippetID asc','snippetsBox','snippets.php')\"><span style=\"font-size:10px; color:#FFFFFF\">-</span><img src=\"images/desc.gif\" height=\"10\" width=\"10\" alt=\"Desc\" class=\"cursorType\" onclick=\"javascript:changeOrder('snippets','snippetID desc','snippetsBox','snippets.php')\"></td>";
     echo "<td></td>";
    echo "</tr>";

//    TODO: May not have been part of this code.  Delete?
//    echo "Your session has expired. Please <a href=\"http://www.coagmento.org/loginOnSideBar.php\" target=_content><span style=\"color:blue;text-decoration:underline;cursor:pointer;\">login</span> again.\n";

        $base = Base::getInstance();

        $projectID = $base->getProjectID();
        $userMap = $userMap = User::getIDMap($projectID);
        $userID = $base->getUserID();
        $connection = Connection::getInstance();
        $questionID = $base->getQuestionID();
        $table = "snippets";
        $orderBy = "snippetID DESC";
        if (isset($_SESSION['orderBy'.$table])){
          $orderBy = $_SESSION['orderBy'.$table];
        }

        $query = "SELECT * FROM (SELECT * FROM snippets WHERE projectID='$projectID' AND questionID='$questionID' AND status=1) a INNER JOIN (SELECT userID,userName FROM users) b ON b.userID=a.userID ORDER BY ".$orderBy;
        $results = $connection->commit($query);
        $bgColor = '#E8E8E8';

        $numRows = mysql_num_rows($results);


            while($line = mysql_fetch_array($results, MYSQL_ASSOC)){
                $snippetID = $line['snippetID'];
                $userIDItem = $line['userID'];
                $userName = isset($userMap[$userIDItem]) ? $userMap[$userIDItem] : "";

                $note = $line['note'];
                $snippet = stripslashes($line['snippet']);

                $url = $line['url'];
                $title = stripslashes($line['title']);
                $type = $line['type'];
                $time = $line['time'];
                $date = strtotime($line['date']);
                $date = strftime("%m/%d", $date);
                $noteAux = substr($note, 0, 20);

                if ($noteAux!="")
                    $title = $noteAux . '..';
                else
                {
                    if (!$title)
                        $title = $url;

                    if (strlen($title)>25) {
                        $title = substr($title, 0, 20);
                        $title = $title . '..';
                    }
                }


                echo "<tr style=\"background:$bgColor;\"><td><span style=\"font-size:10px\">$userName</span></td>";
                echo "<td><span style=\"font-size:10px\">";
                //echo "<a alt=\"View\" class=\"cursorType\" onclick=\"javascript:showSnippet('floatSnippetLayer',null,'$snippetID','$type')\" style=\"font-size:10px; color:blue\">$title</a></span></td>\n";
                $viewSnipetOnWindow = "window.open('viewSnippet.php?value=$snippetID','Snippet View','directories=no, toolbar=no, location=no, status=no, menubar=no, resizable=no,scrollbars=yes,width=400,height=400,left=600')";
                echo "<a alt=\"View\" class=\"cursorType\" onclick=\"javascript:$viewSnipetOnWindow\" onmouseover=\"javascript:showSnippet('floatSnippetLayer',null,'$snippetID','$type')\" onmouseout=\"javascript:hideLayer('floatSnippetLayer')\" style=\"font-size:10px; color:blue\">$title</a></span></td>\n";
//                echo "<a alt=\"View\" class=\"cursorType\" onclick=\"javascript:$viewSnipetOnWindow\" onmouseover=\"javascript:showSnippet('floatSnippetLayer',null,'$snippetID','$type')\" onmouseout=\"javascript:hideLayer('floatSnippetLayer')\" style=\"font-size:10px; color:blue\">$title</a></span></td>\n";
                //			if ($url)
                //				echo "<font color=blue><a alt=\"View\" class=\"cursorType\" onclick=\"javascript:showSnippet('floatSnippetLayer',null,'$snippetID','$type')\" style=\"font-size:10px\">$title</a></span></td>\n";
                //			else
                //				echo "<font color=blue><a alt=\"View\" class=\"cursorType\" onclick=\"javascript:showSnippet('floatSnippetLayer',null,'$snippetID','$type')\" style=\"font-size:10px\">$snippet</a></span></td>\n";

                //$fullSnippet = "[Source: " . $url . "] || ".$snippet;

                echo "<input type=\"hidden\" id=\"snippetValue$snippetID\" value=\"$snippet\">";
                echo "<input type=\"hidden\" id=\"note$snippetID\" value=\"$note\">";
                echo "<input type=\"hidden\" id=\"source$snippetID\" value=\"$title\">";
                echo "<input type=\"hidden\" id=\"url$snippetID\" value=\"$url\">";
                echo "<input type=\"hidden\" id=\"time$snippetID\" value=\"$time\">";
                //$ratingRepresentation = getRatingRepresentation($finalRating, $snippetID,'snippets','floatSnippetLayer','snippetsBox','snippets.php');
                // echo "<td align=\"center\"></td>";
                echo "<td align=\"right\" onmouseover=\"javascript:showTime('floatSnippetLayer',null,'$snippetID')\" onmouseout=\"javascript:hideLayer('floatSnippetLayer')\"><span style=\"font-size:10px\">$date</span></td>";

                //TEMP: REMOVED THIS FOR EDUSEARCH -> Matt
                if ($userID==$userIDItem)
                    echo "<td align=\"right\" class=\"cursorType\" onclick=\"javascript:deleteItem('floatSnippetLayerDelete',null,'$snippetID','snippets','snippetsBox','snippets.php')\"><span style=\"font-size:10px; color:red; font-weight: bold \"> <a style=\"font-size:10px; color:$bgColor\"> - </a>X</span></td>";
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
