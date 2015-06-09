<?php
require_once('core/Connection.class.php');
require_once('core/Base.class.php');
	

if (isset($_POST['payment_data'])) 
{
	
	$base = new Base();

	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$email = $_POST['email'];
	
	$payRecd = 0;
	if($_POST['receivedPay'])
	{
		$payRecd = 1;
	}
	else
	{
		$payRecd = 0;
	}
	
	$time = $base->getTime();
	$date = $base->getDate();
	$timestamp = $base->getTimestamp();
	
	$query = "INSERT INTO payment_confirmation (firstName,lastName, email, paymentReceived, date, time, timestamp)
											  VALUES('$firstName','$lastName','$email','$payRecd','$date','$time','$timestamp')";
	$connection = Connection::getInstance();			
	$results = $connection->commit($query);
	
	
	// WEB APPLICATION NOTIFICATION TO THE PARTICIPANT
			echo "<html>\n";
			echo "<head><title>Thank You</title></head>";
			echo "<body>\n";
			echo "<p>Thank You!</p>";
			echo "<p>Your involvement with the Exploratory Search Study is now complete.</p>";
			echo "</body>\n";
			echo "</html>\n";
}
		
else
{
	
?>
<html>
<head>
<title>Payment Confirmation
</title>
<script type="text/javascript">

	function validate(form)
	{
		var result = true;
		result = result && (form.firstName.value != "");
		result = result && (form.lastName.value != "");
		result = result && (form.email.value != "");
		result = result && (isValidEmail(form.email.value));
		result = result && (receivedPay.checked);
				
		if (!result)
		{	
			document.getElementById("alert").style.display = "block";
			return false;
		}
		else
		{
			document.getElementById("alert").style.display = "none";
			return true;
		}
		
	}	
	
	function isValidEmail(email) 
	{ 
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}
	
	function enableConfirm(check)
	{
		if (check.checked)
			document.getElementById("acceptPay").disabled = false;
			
		else
			document.getElementById("acceptPay").disabled = true;
	}
	
	 
</script>

</head>
<body class="body">
<center>
	<br/>
	<form id="form" action="paymentConfirmation.php" method="post" onsubmit="return validate(this)">
	<table class="body" width=100%>
		<tr><th colspan=2 align=center><span style="font-weight:bold; font-size:20px">Exploratory Search User Study: Payment Confirmation</span><br/><br/></th></tr>
		<tr><td><hr/></td></tr>	
		<tr><td>We thank you for completing the user study successfully.</td></tr>
		<tr><td>This is to receive your confirmation that you have received an email with $20 Amazon gift card as compensation for successfully completing and participating in the exploratory search user study 2014.<br/></td></tr>
		<tr><td><strong>You must fill in all fields.</strong></td></tr>	
		<tr><td><hr/></td></tr>	
	</table>
	<table align=center>
		<tr><td colspan=3><div style="display: none; background: Red; text-align:center;" id="alert"><strong>You must fill in all fields</strong></div></td></tr>			
		<tr><td align=left>First Name</td><td align=left> <input type="text" size=25 name="firstName"/></td></tr>
		<tr><td align=left>Last Name</td><td align=left>  <input type="text" size=25 name="lastName"</td></tr>
		<tr><td align=left>Email</td><td align=left>  <input type="text" size=25 name="email"</td></tr>
	</table>
	<table>
		<tr><td><br/><br/></td></tr>	
		<tr><td><input type="checkbox" name="receivedPay" id="receivedPay" onclick="enableConfirm(this)" /><strong> I have received $20 worth Amazon gift card via email as compensation for successfully completing the participation in exploratory search user study 2014.</strong></td></tr>
		
		<tr><td colspan=2><br/></td></tr>	
		<tr><td colspan=2 align=center><input type="hidden" name="payment_data" value="true"/>
		<input type="submit" id="acceptPay" value="Confirm" disabled=true style="width:100px; height:40px;"/>
		</td></tr>	
										
	</table>
	</form>
<br/>
</center>
</body>
</html>
<?php

}

?>
