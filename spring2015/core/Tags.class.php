<?php
require_once('Connection.class.php');
require_once('Base.class.php');
require_once('Action.class.php');

class Tags extends Base{
  public function __construct(){
    parent::__construct();
  }

  public function getTagsForUser(){

  }

  public function getTagsForPage($bookmarkID){

  }

  public function updateTagForUser($tagID, $new_name){

  }

  /*
   * @param array $tags An array of strings
   */
  public function assignTagsToBookmark($bookmarkID, $tags){
    //first replace tags in tags table
    $q = "REPLACE INTO tags (`user_id`, `name`) VALUES ";
    $arr = array();
    $cxn = Connection::getInstance();
    foreach($tags as $name){
      $ins = sprintf("(%d, '%s')", $this->userID, $cxn->esc($name));
      array_push($arr, $ins);
    }
    $q .= implode(",", $arr);
    $cxn->commit($q);
    //now insert into tag_assignments
  }
}
