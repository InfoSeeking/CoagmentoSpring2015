
<html>
<head>
<title>View Course Writeups</title>
<link rel="stylesheet" href="study_styles/bootstrap-lumen/css/bootstrap.min.css">
<link rel="stylesheet" href="study_styles/custom/text.css">
<link rel="stylesheet" href="styles.css">

</head>
<script type="text/javascript">

var is_ff;
var alertColor = "Red";
var okColor = "White";


function validate(form)
{
    return true;
}

function changeColor(field,color)
{
    field.style.background = color;
}


</script>
<noscript>
<style type="text/css">
.pagecontainer {display:none;}
</style>
<div class="noscriptmsg">
You don't have Javascript enabled.  You must enable it in your browser to proceed with the task.
</div>
</noscript>

<body class="body" >

  <div class="panel panel-default" style="width:95%;  margin:auto">
    <div class="panel-body">
  <center><h2>Edit Users</h2></center>
<div id="login_div" style="display:block;">

<?php

	session_start();
	require_once('core/Connection.class.php');

    echo "<hr><br><br>";


	$query = "SELECT firstName, lastName, username, `password`,userID FROM (SELECT * FROM recruits INNER JOIN (SELECT userID as uID, username, `password` FROM users) b on recruits.userID=b.uID) c";
	$connection = Connection::getInstance();
	$results = $connection->commit($query);


	if (mysql_num_rows($results) > 0)
	{

					echo "<center><table class=\"table  table-striped table-bordered\" style=\"width:auto\">";
					echo "<thead><th>First Name</th><th>Last Name</th><th>Username</th><th>Password</th></thead>";

					echo "<tbody>";
          while($line = mysql_fetch_array($results,MYSQL_ASSOC)){
							echo "<tr>";
							$firstname = $line['firstName'];
							$lastname = $line['lastName'];
							$username = $line['username'];
              $userID = $line['userID'];
							echo "<td>$firstname</td><td>$lastname</td><td>$username</td>";
              echo "<td><button class='btn btn-primary' onclick=\"location.href='editUser.php?userID=$userID'\">Edit</button></td>";
							echo "</tr>";
          }

					echo "</tbody></table></center>";

      }else{
              echo "<div style=\"background-color:red;\">The credentials you have entered are incorrect.  Please check your input and try again.</div>";
      }
    ?>


</div>
</div>
</body></html>
