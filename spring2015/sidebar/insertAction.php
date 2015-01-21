<?php
	session_start();
	require_once('../core/Base.class.php');
	require_once('../core/Util.class.php');	

	$base = Base::getInstance();
	
	if ($base->isSessionActive())
	{
        if (isset($_GET['value']))
        {        	
        	$action = $_GET['action'];
        	$value = $_GET['value'];
        	
        	Util::getInstance()->saveAction($action,$value,$base);
        }  
    }
?>