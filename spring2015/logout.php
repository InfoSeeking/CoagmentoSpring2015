<?php
	session_start();
	require_once('core/Base.class.php');
	require_once('core/Connection.class.php');
	require_once('core/Util.class.php');
	require_once('pubnub-helper.php');

	if (Base::getInstance()->isSessionActive())
	{
		require_once("pubnub-helper.php");
		pubnubPublishToUser("3");
		$base = Base::getInstance();
		$base->setAllowCommunication(0);
		$base->setAllowBrowsing(0);
		session_destroy();
		unset($_SESSION['CSpace_userID']);
		//Save action

		Util::getInstance()->saveAction('logout',0,$base);
		// pubnub 3
		echo "1";
	}


?>
