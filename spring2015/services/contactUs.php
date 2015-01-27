<?php
	session_start();
	require_once('../core/Connection.class.php');
	require_once('../core/Settings.class.php');
	require_once('../core/Base.class.php');

  if (!Base::getInstance()->isSessionActive())
  {
		exit("Not logged in, please <a href='index.php'>log in here</a>");
	}

  $base = Base::getInstance();
	$stg = Settings::getInstance();
	$cxn = Connection::getInstance();
	if(isset($_POST["action"]) && $_POST["action"] == "send-email"){
		$message = $cxn->esc($_POST["message"]);
		$username = $base->getUserName();
		$userID = $base->getUserID();
		$email = $cxn->esc($_POST["email"]);
		//store in database
		$q = sprintf("INSERT INTO contact_messages (`message`, `email`, `userID`, `username`) VALUES ('%s', '%s', %d, '%s')", $message, $email, $userID, $username);
		$cxn->commit($q);

		//send ourselves an email
		$email_message = sprintf("Email : %s\nUsername/ID : %s/%d\nMessage: %s\n", $email, $username, $userID, $message);
		mail($stg->getContactEmails(), "Coagmento Spring 2015 contact message", $email_message);
		exit("email-sent");
	}
?>
<html>
<head>
	<link rel="stylesheet" href="../study_styles/custom/text.css">
	<title>Contact Us</title>
	<style type="text/css">
	#container{
		width: 500px;
		margin: 10px auto;
	}
	form{
		width: 500px;
	}

	.row{
		margin-bottom: 10px;
	}
	.row label{
		display: inline-block;
		width: 200px;
		font-size: 12px;
	}
	.row input[type=email]{
		width: 300px;
	}
	.row textarea{
		width: 100%;
	}
	</style>
	<script src="../lib/jquery-2.1.3.min.js"></script>
</head>
<body class="body">
	<div id="container">
		<h2>Contact Us</h2>
		<p>Are you having issues with the extension? Questions on how to use it? Let us know</p>
		<form action="#" method="post">
			<div class="row">
				<label>Your email <br/>(so we can contact you)</label><input name="email" type="email" required />
			</div>
			<div class="row">
				<label>Message</label><br/><textarea name="message" required></textarea>
			</div>
			<div class="row">
				<input type="submit" value="Send email" />
			</div>
		</form>
	</div>

	<script>
		var cform = $("form");
		cform.on("submit", function(e){
			//send ajax request
			var param = {
				message : cform.find("[name=message]").val(),
				email : cform.find("[name=email]").val(),
				action : "send-email"
			};
			$.ajax({
				url: "contactUs.php",
				data: param,
				method: "post",
				success: function(resp){
					if(resp == "email-sent"){
						window.close();
					} else {
						alert("Something went wrong, could not send email");
					}
				}
			})
			e.preventDefault();
		})
	</script>
</body>
</html>
