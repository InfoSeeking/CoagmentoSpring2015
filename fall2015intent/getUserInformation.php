
<html>
<head>
<title>View Course Writeups</title>
<link rel="stylesheet" href="study_styles/pure-release-0.5.0/buttons.css">
<link rel="stylesheet" href="study_styles/pure-release-0.5.0/forms.css">
<link rel="stylesheet" href="study_styles/pure-release-0.5.0/tables.css">
<link rel="stylesheet" href="study_styles/custom/text.css">

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

<body class="style1">
  <center><h2>Print Users</h2></center>
<div id="login_div" style="display:block;">

<?php

	session_start();
	require_once('core/Connection.class.php');
	require_once('core/Base.class.php');
	require_once('core/Util.class.php');
    require_once('core/Stage.class.php');

    echo "<hr><br><br>";

    function getColor($value)
	{
		if (($value % 2) == 0)
			$color="\"#F2F2F2\"";
		else
			$color="\"White\"";

		return $color;
	}


	$query = "SELECT firstName, lastName, username, `password` FROM (SELECT * FROM recruits INNER JOIN (SELECT userID as uID, username, `password` FROM users) b on recruits.userID=b.uID) c";
	$connection = Connection::getInstance();
	$results = $connection->commit($query);
  $base = Base::getInstance();

	if (mysql_num_rows($results) > 0) //insert session one end stage if necessary
	{

					echo "<center><table class=\"pure-table pure-table-striped\">";
					echo "<thead><th>First Name</th><th>Last Name</th><th>Username</th><th>Password</th></thead>";

					echo "<tbody>";
          while($line = mysql_fetch_array($results,MYSQL_ASSOC)){
							echo "<tr>";
							$firstname = $line['firstName'];
							$lastname = $line['lastName'];
							$username = $line['username'];
							$password = htmlspecialchars($line['password']);
							echo "<td>$firstname</td><td>$lastname</td><td>$username</td><td>$password</td>";
							echo "</tr>";
          }

					echo "</tbody></table></center>";

      }else{
              echo "<div style=\"background-color:red;\">The credentials you have entered are incorrect.  Please check your input and try again.</div>";
      }
    ?>


</body></html>