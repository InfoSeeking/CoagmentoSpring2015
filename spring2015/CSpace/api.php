<?php
session_start();

require_once("../core/Base.class.php");
$base = new Base();
if(!$base->isUserActive()){
  exit("Not logged in");
}
echo "HERE";
