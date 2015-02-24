<?php
/*
Simpler login page for workspace. Allows redirect.
Maybe we can use this as a replacement for the sidebar login as well.
*/
	session_start();
  require_once('core/Connection.class.php');
	require_once("core/Base.class.php");
	require_once("core/Util.class.php");
  require_once("pubnub-helper.php");
	$base = Base::getInstance();
  $feedback = "";

  function onLogin(){
    global $feedback;
    $username = $_POST['username'];
    $password = sha1($_POST['password']);
    $error = false;
    $connection = Connection::getInstance();
    $query = "SELECT * FROM users WHERE username='$username' AND password_sha1='$password' AND status=1";
    $results = $connection->commit($query);
    if(mysql_num_rows($results) == 0){
      $feedback = "Incorrect username/password, please try again";
      return;
    }
    $row = mysql_fetch_array($results, MYSQL_ASSOC);
    $userID = $row['userID'];
    $projectID = $row['projectID'];
    $studyID = $row['study'];
    if(is_null($projectID) || $projectID <= 0){
      $feedback = "You have not yet been assigned to a group in our system.  Please wait until you have been assigned to log in";
      return;
    }
    $base = Base::getInstance();
    $base->setUserName($username);
    $base->setUserID($userID);
    $base->setProjectID($projectID);
    $base->setStageID(-1);
    $base->setStudyID($studyID);
    Util::getInstance()->saveAction('login',0,$base);
    pubnubPublishToUser("1");
    if(isset($_GET['redirect'])){
      header("Location: ".  $_GET['redirect']);
    }
  }

  if(isset($_POST['action']) && $_POST['action'] == 'login'){
    onLogin();
  }
?>
<html>
  <head>
    <style type="text/css">
      .feedback{
        background:#EEE;
        padding: 5px 10px;
      }
      #container{
        width: 400px;
        margin: 10px auto;
      }
      .row label{
        display: inline-block;
        width: 100px;
      }
      .row{
        margin-bottom: 10px;row
    </style>
  </head>
  <body>
    <div id="container">
      <?php if($feedback != ""): ?>
        <p class="feedback"><?php echo $feedback; ?></p>
      <?php endif; ?>
      <form action="#" method="post">
        <div class="row">
          <label for="username">Username</label><input type="text" id="username" name="username" />
        </div>
        <div class="row">
          <label for="password">Password</label><input type="password" id="password" name="password" />
        </div>
        <input type="hidden" name="action" value="login" />
        <div class="row">
          <input type="submit" value="Log in" />
        </div>
      </form>
    </div>
  </body>
<html>