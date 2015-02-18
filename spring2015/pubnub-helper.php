<?php
require_once('sidebar/pubnub-lib/autoloader.php');
use Pubnub\Pubnub;

function pubnubPublishToUser($msg){
    $pubnub = new Pubnub(array('publish_key'=>'pub-c-c65f91dd-c2b5-42c5-be54-2107495df5fa','subscribe_key'=>'sub-c-36a53ccc-5ae9-11e4-92e9-02ee2ddab7fe'));
    $base = Base::getInstance();
    $userID = $base->getUserID();
    $message = array('message'=> $msg);
    $res=$pubnub->publish("spr15-".$base->getStageID()."-".$base->getProjectID()."-checkStage".$userID,$message);
}
?>
