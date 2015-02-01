<?php
	session_start();
	require_once('core/Base.class.php');
	require_once('core/Util.class.php');

	if (Base::getInstance()->isSessionActive())
	{
			session_destroy();
			//Save action
			$base = new Base();
			$base->setAllowCommunication(0);
			$base->setAllowBrowsing(0);
			Util::getInstance()->saveAction('logout',0,$base);
			echo "1";
	}


?>
