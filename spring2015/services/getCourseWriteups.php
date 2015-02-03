
<tml>
<head>
<title>View Course Writeups</span><br/><br/></th></tr>
<tr><td><hr/></td></tr></title>
<link rel="stylesheet" href="../study_styles/pure-release-0.5.0/buttons.css">
<link rel="stylesheet" href="../study_styles/pure-release-0.5.0/forms.css">
<link rel="stylesheet" href="../study_styles/pure-release-0.5.0/tables.css">
<link rel="stylesheet" href="../study_styles/custom/text.css">

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
<div id="login_div" style="display:block;">
<div class="pagecontainer">
	<center>
<table class="body" width="90%">
<tr><td><center><h2>View Student Writeups</h2></center></td></tr>
</table>
<form class="pure-form" id="login_form" action="getCourseWriteups.php" method="post" onsubmit="return validate(this)">
<table class="body">
<tr><td>Username</td><td>&nbsp;&nbsp; <input type="text" id="username" name="username" size=20 required/></td></tr>
<tr><td>Password</td><td>&nbsp;&nbsp; <input type="password" id="password" name="password" size=20 required/></td></tr>
<tr><td colspan="2"><br/></td></tr>
<tr><td colspan="2" align="center"><button class="pure-button pure-button-primary" type="submit"/>Submit</button></td></tr>
</table>
</center>
</form>
</div>





<?php

	session_start();
	require_once('../core/Connection.class.php');
	require_once('../core/Base.class.php');
	require_once('../core/Util.class.php');
    require_once('../core/Stage.class.php');

    echo "<hr><br><br>";

    function getColor($value)
	{
		if (($value % 2) == 0)
			$color="\"#F2F2F2\"";
		else
			$color="\"White\"";

		return $color;
	}




	if (isset($_POST['username']))
	{
		$username = $_POST['username'];
		$instructorName = '';
		$instructorID = 0;
		$port = 0;
		$apikey="87b40a9c3818d6cde3d9960db9c4d1a57199ec86fc165f082fbeac072154d559";
		$stageID=-1;
		$password=$_POST['password'];

		if($username=='belkin'){
			$instructorName = "Dr. Nicholas Belkin";
			$apikey="87b40a9c3818d6cde3d9960db9c4d1a57199ec86fc165f082fbeac072154d559";
		}else if($username=='ninwac'){
			$instructorName = "Dr. Nina Wacholder";
			$apikey="87b40a9c3818d6cde3d9960db9c4d1a57199ec86fc165f082fbeac072154d559";
		}

		$query = "SELECT * FROM instructors WHERE username='$username' AND password='$password'";

		$connection = Connection::getInstance();
		$results = $connection->commit($query);


		if (mysql_num_rows($results) > 0) //insert session one end stage if necessary
		{

						echo "<center><table class=\"pure-table pure-table-striped\"><thead>";
						echo "<th>Group</th><th>Link</th></thead>";
            $line = mysql_fetch_array($results,MYSQL_ASSOC);
            $instructorID = $line['instructorID'];
            $port = $line['etherpadPort'];

            $connection = Connection::getInstance();
            $base = Base::getInstance();


            $query = "SELECT projectID FROM recruits R WHERE R.instructorID='$instructorID' GROUP BY R.projectID";

            $results = $connection->commit($query);

						echo "<tbody>";
            while($line = mysql_fetch_array($results,MYSQL_ASSOC)){
                $projectID=$line['projectID'];
                $namequery = "SELECT firstName, lastName FROM recruits WHERE projectID='$projectID'";

								echo "<tr>";
								echo "<td><ul>";
								$nameresults = $connection->commit($namequery);
                while($nameline = mysql_fetch_array($nameresults,MYSQL_ASSOC)){
										$firstName = $nameline['firstName'];
										$lastName = $nameline['lastName'];
										echo "<li>$firstName $lastName</li>";
                }
								echo "</ul></td>";

								$padID = "spring2015_report-$projectID--1-";
								$url = "http://coagmentopad.rutgers.edu:".$port."/api/1/getReadOnlyID?apikey=".$apikey."&padID=".$padID;

								$padquery = "SELECT readOnlyID,available FROM etherpad_submissions WHERE projectID='$projectID'";
								$padresults = $connection->commit($padquery);
								$exists = mysql_num_rows($padresults)>0;
								$readOnlyID = '';
								$available = 0;

								if($exists){
									$padline = mysql_fetch_array($padresults,MYSQL_ASSOC);
									$available = $padline['available'];
									$readOnlyID = $padline['readOnlyID'];
								}

								echo "<td>";
								if(!$exists || !$available){

									$data=file_get_contents($url);
									$data_str = $data;
									$data=json_decode($data);
									$valid = ($data->{'code'} == 0);


									if($valid){
											$readOnlyID = addslashes($data->{'data'}->{'readOnlyID'});
											$url = "http://coagmentopad.rutgers.edu:".$port."/p/".$readOnlyID;
											echo "<center><button onclick=\"javascript:window.open('$url','_blank')\">Get Pad</button></center>";
									}else{
											echo "(No pad text available.)";
									}


									$q='';
									if(!$exists){
										$q="INSERT INTO etherpad_submissions (projectID,readOnlyID,available) VALUES ('$projectID','$readOnlyID','$valid')";
									}else{
										$q="UPDATE etherpad_submissions SET available='$valid' WHERE projectID='$projectID'";
									}
									$r = $connection->commit($q);

								}else{
									$url = "http://coagmentopad.rutgers.edu:".$port."/p/".$readOnlyID;
									echo "<center><button onclick=\"javascript:window.open('$url','_blank')\">Get Pad</button></center>";
								}
								echo "</td>";
								echo "</tr>";







            }

						echo "</tbody></table></center>";

        }else{
                echo "<div style=\"background-color:red;\">The credentials you have entered are incorrect.  Please check your input and try again.</div>";
        }
    }


    ?>









</body></html>
