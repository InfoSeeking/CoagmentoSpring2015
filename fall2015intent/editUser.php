
<html>
<head>
<title>View Course Writeups</title>

<link rel="stylesheet" href="study_styles/bootstrap-lumen/css/bootstrap.min.css">
<link rel="stylesheet" href="study_styles/custom/text.css">
<link rel="stylesheet" href="styles.css">

</head>
<noscript>
<style type="text/css">
.pagecontainer {display:none;}
</style>
<div class="noscriptmsg">
You don't have Javascript enabled.  You must enable it in your browser to proceed with the task.
</div>
</noscript>

<body class="body">
  <div class="panel panel-default" style="width:95%;  margin:auto">
    <div class="panel-body">


<div id="login_div" style="display:block;">

<?php

	session_start();
	require_once('core/Connection.class.php');

  $submitted = 0;
  $message = '';

  if(isset($_POST['user_info'])){
    $submitted = 1;
    $userID = $_POST['userID'];
    $lastbootuptime = $_POST['lastbootuptime'];
    $cxn = Connection::getInstance();



    $query = "UPDATE users SET lastbootuptime='$lastbootuptime' WHERE userID='$userID'";
    $results = $cxn->commit($query);


    $consent_study = "NULL";
    $consent_continued = "NULL";
    $consent_audiovideo = "NULL";
    $consent_furtheruse = "NULL";

    if(isset($_POST['consent_study'])){
      $consent_study = $_POST['consent_study'];
    }

    if(isset($_POST['consent_continued'])){
      $consent_continued = $_POST['consent_continued'];
    }

    if(isset($_POST['consent_audiovideo'])){
      $consent_audiovideo = $_POST['consent_audiovideo'];
    }

    if(isset($_POST['consent_furtheruse'])){
      $consent_furtheruse = $_POST['consent_furtheruse'];
    }

    $arrived = "NULL";
    if(isset($_POST['arrived'])){
      $arrived = $_POST['arrived'];
    }

    $receiptnumber = $_POST['receiptnumber'];

    $query = "UPDATE users SET lastbootuptime='$lastbootuptime' WHERE userID='$userID'";
    $results = $cxn->commit($query);


    $query = "UPDATE recruits SET consent_study=$consent_study , consent_furtheruse=$consent_furtheruse , consent_audiovideo=$consent_audiovideo , consent_continued=$consent_continued , receiptnumber=$receiptnumber WHERE userID='$userID'";
    $results = $cxn->commit($query);

    $query = "UPDATE users SET arrived=$arrived WHERE userID='$userID'";
    $results = $cxn->commit($query);

    $message = "Your changes were made to the user's profile.";
  }else if(isset($_POST['project_info_1'])){
    $userID = $_POST['userID'];
    $cxn = Connection::getInstance();
    $finishTopic1 = "NULL";
    if(isset($_POST['finishTopic1'])){
      $finishTopic1 = $_POST['finishTopic1'];
    }
    $query = "UPDATE users SET finishTopic1=$finishTopic1 WHERE userID='$userID'";
    $results = $cxn->commit($query);
    $submitted = 1;
    $message = "Your changes were made to task 1.";
  }else if(isset($_POST['project_info_2'])){
    $userID = $_POST['userID'];
    $cxn = Connection::getInstance();
    $finishTopic2 = "NULL";
    if(isset($_POST['finishTopic2'])){
      $finishTopic2 = $_POST['finishTopic2'];
    }
    $query = "UPDATE users SET finishTopic2=$finishTopic2 WHERE userID='$userID'";
    $results = $cxn->commit($query);
    $submitted = 1;
    $message = "Your changes were made to task 2.";
  }


  if(isset($_POST['project_info_1']) || isset($_POST['project_info_2'])){
    $userID = $_POST['userID'];
    $projectID = $_POST['projectID'];
    $stageID = $_POST['stageID'];

    $cxn = Connection::getInstance();

    $query = "SELECT * FROM video_segments WHERE userID='$userID' AND stageID='$stageID'";
    $results = $cxn->commit($query);

    if(mysql_num_rows($results) > 0){
      $query = "DELETE FROM video_segments WHERE userID='$userID' AND stageID='$stageID'";
      $results = $cxn->commit($query);
    }


    $query = "SELECT * from users WHERE userID='$userID'";

    $results = $cxn->commit($query);
    $line = mysql_fetch_array($results,MYSQL_ASSOC);
    $topicAreaID = "NULL";

    if(isset($_POST['project_info_1'])){
        $topicAreaID = $line['topicAreaID1'];
    }else if(isset($_POST['project_info_2'])){
        $topicAreaID = $line['topicAreaID2'];
    }


    // $videofilepath = "/mnt/space/www/coagmento.org/htdocs/fall2015intent/data/videos/mp4/";
    // $videofilename = $_POST['videofilename'];
    $csvfilename = $_POST['csvfilename'];

    $tmp_name = $_FILES['csvfile']['tmp_name'];

    if (($handle = fopen($tmp_name, "r")) !== FALSE) {
      $data = fgetcsv($handle, 1000, "\t");
      while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE) {

          if(count($data) > 1){
            $elapsedtime=mysql_escape_string($data[0]);
            $recording=mysql_escape_string($data[1]);
            $task=mysql_escape_string($data[2]);
            $event=mysql_escape_string($data[3]);
            $details=mysql_escape_string($data[4]);
            $owner=mysql_escape_string($data[5]);
            $notes=mysql_escape_string($data[6]);
            $title=mysql_escape_string($data[7]);
            $score=mysql_escape_string($data[8]);

            $query = "INSERT INTO video_segments (userID,projectID,stageID,questionID,`Elapsed Time`,`Recording`,`Event`,`Details`,`Owner`,`Notes`,`Title`,`Score`) VALUES ('$userID','$projectID','$stageID',$topicAreaID,'$elapsedtime','$recording','$event','$details','$owner','$notes','$title','$score')";
            $cxn->commit($query);

          }
          // $num = count($data);
          // echo "<p> $num fields in line $row: <br /></p>\n";
          // $row++;
          // for ($c=0; $c < $num; $c++) {
          //     echo $data[$c] . "<br />\n";
          // }
      }
      fclose($handle);
    }




  }


    // $utf8_1 = utf8_encode($iso88591);
    // $utf8_2 = iconv('ISO-8859-1', 'UTF-8', $iso88591);

    // print_r($_FILES);
    // echo "BEGIN";


    // if(isset($_FILES['videofile'])){
    //   echo "BEGIN";
    //
    //   $tmp_name = $_FILES['videofile']['tmp_name'];
    //   $target_file = $videofilepath.$videofilename;
    //   $com = fopen($videofilepath.$videofilename, "ab");
    //   // $out = fopen($target_file, "wb");
    //
    //   if ( $com ) {
    //       // Read binary input stream and append it to temp file
    //       $in = fopen($tmp_name, "rb");
    //       if ( $in ) {
    //           while ( $buff = fread( $in, 1048576 ) ) {
    //               // fwrite($out, $buff);
    //               fwrite($com, $buff);
    //               echo "WRITE";
    //           }
    //       }
    //       fclose($in);
    //       // fclose($out);
    //   }
    //   fclose($com);
    //
    // }
    // move_uploaded_file($_FILES["videofile"]["tmp_name"], );







  $userID = $_GET['userID'];
  $query = "SELECT * from recruits WHERE userID='$userID'";
  $cxn = Connection::getInstance();
  $results = $cxn->commit($query);
  if(mysql_num_rows($results)==0){
    echo "<center><h2>Edit Users</h2></center>";
    echo "<p>The user you specified cannot be found.  Please go back and select another user.</p>";
  }else{

    $line = mysql_fetch_array($results,MYSQL_ASSOC);
    $firstname = $line['firstName'];
    $lastname = $line['lastName'];
    $projectID = $line['projectID'];
    $receiptnumber = $line['receiptnumber'];
    $consent_study = $line['consent_study'];
    $consent_continued = $line['consent_continued'];
    $consent_audiovideo = $line['consent_audiovideo'];
    $consent_furtheruse = $line['consent_furtheruse'];

    $query = "SELECT * from users WHERE userID='$userID'";
    $cxn = Connection::getInstance();
    $results = $cxn->commit($query);
    $line = mysql_fetch_array($results,MYSQL_ASSOC);
    $arrived = $line['arrived'];


    echo "<center><h2>Edit Users: $firstname $lastname</h2></center><hr/><br/>";
    if($submitted != 0){
        echo "<div class=\"alert alert-success\">";
        echo "<strong>Success!</strong> $message";
        echo "</div>";

    }
    echo "<form action='editUser.php?userID=$userID' method='post' enctype='multipart/form-data'>";
    echo "<input type=\"hidden\" id=\"user_info\" name=\"user_info\" value=\"1\">";
    echo "<center><table class=\"table table-striped table-bordered\" style=\"width:auto\">";
    echo "<thead><th>Name</th><th>Value</th></thead>";
    echo "<tbody>";
    echo "<tr><td>First Name</td><td>$firstname</td></tr>";
    echo "<tr><td>Last Name</td><td>$lastname</td></tr>";
    echo "<tr><td>Receipt Number</td><td><input type=\"text\" name=\"receiptnumber\" value=\"$receiptnumber\"></td></tr>";

    echo "<tr><td>Arrived To Study?</td>";
    if($arrived === NULL){
      echo "<td><input type=\"radio\" name=\"arrived\" value=\"1\">Yes   <input type=\"radio\" name=\"arrived\" value=\"0\">No</td>";
    }
    else if($arrived==1){
      echo "<td><input type=\"radio\" name=\"arrived\" value=\"1\" checked>Yes   <input type=\"radio\" name=\"arrived\" value=\"0\">No</td>";
    }else{
      echo "<td><input type=\"radio\" name=\"arrived\" value=\"1\">Yes   <input type=\"radio\" name=\"arrived\" value=\"0\" checked>No</td>";
    }
    echo "</tr>";



    echo "<tr><td>First Consent Form?</td>";
    if($consent_study === NULL){
      echo "<td><input type=\"radio\" name=\"consent_study\" value=\"1\">Yes   <input type=\"radio\" name=\"consent_study\" value=\"0\">No</td>";
    }
    else if($consent_study==1){
      echo "<td><input type=\"radio\" name=\"consent_study\" value=\"1\" checked>Yes   <input type=\"radio\" name=\"consent_study\" value=\"0\">No</td>";
    }else{
      echo "<td><input type=\"radio\" name=\"consent_study\" value=\"1\">Yes   <input type=\"radio\" name=\"consent_study\" value=\"0\" checked>No</td>";
    }
    echo "</tr>";


    echo "<tr><td>Video and Logging Consent Form? </td>";
    if($consent_continued === NULL){
        echo "<td><input type=\"radio\" name=\"consent_continued\" value=\"1\">Yes   <input type=\"radio\" name=\"consent_continued\" value=\"0\">No</td>";
    }
    else if($consent_continued==1){
      echo "<td><input type=\"radio\" name=\"consent_continued\" value=\"1\" checked>Yes   <input type=\"radio\" name=\"consent_continued\" value=\"0\">No</td>";
    }else{
      echo "<td><input type=\"radio\" name=\"consent_continued\" value=\"1\">Yes   <input type=\"radio\" name=\"consent_continued\" value=\"0\" checked>No</td>";
    }
    echo "</tr>";

    echo "<tr><td>Audio/Video Addendum Consent Form? </td>";
    if($consent_audiovideo===NULL){
      echo "<td><input type=\"radio\" name=\"consent_audiovideo\" value=\"1\">Yes   <input type=\"radio\" name=\"consent_audiovideo\" value=\"0\">No</td>";
    }else if($consent_audiovideo==1){
      echo "<td><input type=\"radio\" name=\"consent_audiovideo\" value=\"1\" checked>Yes   <input type=\"radio\" name=\"consent_audiovideo\" value=\"0\">No</td>";
    }else if($consent_audiovideo==0){
      echo "<td><input type=\"radio\" name=\"consent_audiovideo\" value=\"1\">Yes   <input type=\"radio\" name=\"consent_audiovideo\" value=\"0\" checked>No</td>";
    }
    echo "</tr>";

    echo "<tr><td>Further Use Consent Form? </td>";
    if($consent_furtheruse === NULL){
      echo "<td><input type=\"radio\" name=\"consent_furtheruse\" value=\"1\">Yes   <input type=\"radio\" name=\"consent_furtheruse\" value=\"0\">No</td>";
    }else if($consent_furtheruse==1){
      echo "<td><input type=\"radio\" name=\"consent_furtheruse\" value=\"1\" checked>Yes   <input type=\"radio\" name=\"consent_furtheruse\" value=\"0\">No</td>";
    }else if($consent_furtheruse==0){
      echo "<td><input type=\"radio\" name=\"consent_furtheruse\" value=\"1\">Yes   <input type=\"radio\" name=\"consent_furtheruse\" value=\"0\" checked>No</td>";
    }
    echo "</tr>";


    $query = "SELECT * from users WHERE userID='$userID'";
    $cxn = Connection::getInstance();
    $results = $cxn->commit($query);
    $line = mysql_fetch_array($results,MYSQL_ASSOC);

    $lastbootuptime = $line['lastbootuptime'];

    echo "<tr><td>Last Bootup Time</td><td><textarea type=\"text\" name=\"lastbootuptime\" rows=\"1\" cols=\"35\">$lastbootuptime</textarea></td></tr>";
    echo "<tr><td colspan='2'><center>";
    echo "<input type=\"hidden\" name=\"userID\" id=\"userID\" value=\"$userID\">";
    echo "<input type=\"hidden\" name=\"projectID\" id=\"projectID\" value=\"$projectID\">";


    echo "<button class='btn btn-primary'>Submit</button></center></td></tr>";

    echo "</tbody></table></center>";
    echo "</form>";












    $topicAreaID1 = $line['topicAreaID1'];
    $topicAreaID2 = $line['topicAreaID2'];

    $query = "SELECT * from questions_study WHERE questionID='$topicAreaID1'";
    $cxn = Connection::getInstance();
    $results = $cxn->commit($query);
    $line = mysql_fetch_array($results,MYSQL_ASSOC);

    $topic = $line['topic'];
    $category = $line['category'];


    $query = "SELECT * from users WHERE userID='$userID'";
    $cxn = Connection::getInstance();
    $results = $cxn->commit($query);
    $line = mysql_fetch_array($results,MYSQL_ASSOC);
    $finishTopic1 = $line['finishTopic1'];
    $finishTopic2 = $line['finishTopic2'];
    // $videofilename1 = "user$userID"."task1.mp4";
    // $videofilename2 = "user$userID"."task2.mp4";
    $csvfilename1 = "user$userID"."task1.csv";
    $csvfilename2 = "user$userID"."task2.csv";


    echo "<br/><br/><br/>";
    echo "<form action='editUser.php?userID=$userID' method='post' enctype='multipart/form-data'>";
    echo "<input type=\"hidden\" id=\"project_info_1\" name=\"project_info_1\" value=\"1\">";
    echo "<center><table class=\"table table-striped table-bordered\" style=\"width:auto\">";
    echo "<thead><th colspan='2'>Part 1: $topic - $category</th></thead>";
    echo "<tbody>";
    echo "<tr><td>Finish?</td>";
    if($finishTopic1 === NULL){
      echo "<td><input type=\"radio\" name=\"finishTopic1\" value=\"1\">Yes   <input type=\"radio\" name=\"finishTopic1\" value=\"0\">No</td>";
    }if($finishTopic1 == 1){
      echo "<td><input type=\"radio\" name=\"finishTopic1\" value=\"1\" checked>Yes   <input type=\"radio\" name=\"finishTopic1\" value=\"0\">No</td>";
    }else if($finishTopic1 == 0){
      echo "<td><input type=\"radio\" name=\"finishTopic1\" value=\"1\">Yes   <input type=\"radio\" name=\"finishTopic1\" value=\"0\" checked>No</td>";
    }
    echo "</tr>";

    // echo "<tr><td>Video File Name</td><td>$videofilename1</td></tr>";
    // echo "<tr><td>Upload Video</td><td><input type=\"hidden\" name=\"videofilename\" id=\"videofilename\" value=\"$videofilename1\"><input type=\"file\" name=\"videofile\" id=\"videofile\"></td></tr>";
    echo "<tr><td>CSV File Name</td><td>$csvfilename1</td></tr>";
    echo "<tr><td>Upload Intent Annotation CSV</td><td><input type=\"hidden\" name=\"csvfilename\" id=\"csvfilename\" value=\"$csvfilename1\"><input type=\"file\" name=\"csvfile\" id=\"csvfile\"></td></tr>";

    echo "<tr><td colspan='2'><center>";
    echo "<input type=\"hidden\" name=\"userID\" id=\"userID\" value=\"$userID\">";
    echo "<input type=\"hidden\" name=\"projectID\" id=\"projectID\" value=\"$projectID\">";
    echo "<input type=\"hidden\" name=\"stageID\" id=\"stageID\" value=\"15\">";

    echo "<button class='btn btn-primary'>Submit</button></center></td></tr>";
    echo "</tbody></table></center>";
    echo "</form>";











    $query = "SELECT * from questions_study WHERE questionID='$topicAreaID2'";
    $cxn = Connection::getInstance();
    $results = $cxn->commit($query);
    $line = mysql_fetch_array($results,MYSQL_ASSOC);

    $topic = $line['topic'];
    $category = $line['category'];
    echo "<br/><br/><br/>";
    echo "<form action='editUser.php?userID=$userID' method='post' enctype='multipart/form-data'>";
    echo "<input type=\"hidden\" id=\"project_info_2\" name=\"project_info_2\" value=\"1\">";
    echo "<center><table class=\"table table-striped table-bordered\" style=\"width:auto\">";
    echo "<thead><th colspan='2'>Part 2: $topic - $category</th></thead>";
    echo "<tbody>";
    echo "<tr><td>Finish?</td>";
    if($finishTopic2 === NULL){
      echo "<td><input type=\"radio\" name=\"finishTopic2\" value=\"1\">Yes   <input type=\"radio\" name=\"finishTopic2\" value=\"0\">No</td>";
    }else if($finishTopic2 == 1){
      echo "<td><input type=\"radio\" name=\"finishTopic2\" value=\"1\" checked>Yes   <input type=\"radio\" name=\"finishTopic2\" value=\"0\">No</td>";
    }else if($finishTopic2 == 0){
      echo "<td><input type=\"radio\" name=\"finishTopic2\" value=\"1\">Yes   <input type=\"radio\" name=\"finishTopic2\" value=\"0\" checked>No</td>";
    }
    echo "</tr>";

    // echo "<tr><td>Video File Name</td><td>$videofilename2</td></tr>";
    // echo "<tr><td>Upload Video</td><td><input type=\"hidden\" name=\"videofilename\" id=\"videofilename\" value=\"$videofilename2\"><input type=\"file\" name=\"videofile\" id=\"videofile\"></td></tr>";
    echo "<tr><td>CSV File Name</td><td>$csvfilename2</td></tr>";
    echo "<tr><td>Upload Intent Annotation CSV</td><td><input type=\"hidden\" name=\"csvfilename\" id=\"csvfilename\" value=\"$csvfilename2\"><input type=\"file\" name=\"csvfile\" id=\"csvfile\"></td></tr>";

    echo "<tr><td colspan='2'><center>";
    echo "<input type=\"hidden\" name=\"userID\" id=\"userID\" value=\"$userID\">";
    echo "<input type=\"hidden\" name=\"projectID\" id=\"projectID\" value=\"$projectID\">";
    echo "<input type=\"hidden\" name=\"stageID\" id=\"stageID\" value=\"45\">";

    echo "<button class='btn btn-primary'>Submit</button></center></td></tr>";
    echo "</tbody></table></center>";
    echo "</form>";


  }
  ?>

</div>
</div>
</body></html>
