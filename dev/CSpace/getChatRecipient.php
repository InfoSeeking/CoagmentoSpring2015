<?php
session_start();
if(isset($_SESSION['recipientid']))
	echo $_SESSION['recipientid'];