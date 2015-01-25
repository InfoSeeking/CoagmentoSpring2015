<?php
require_once('Connection.class.php');
require_once('Base.class.php');
require_once('Action.class.php');

class Tags extends Base{
  public function __construct(){
    parent::__construct();
  }

  public function getTagsForUser(){
    $cxn = Connection::getInstance();
    $q = sprintf("SELECT * FROM tags WHERE userID=%d", $this->userID);
    $arr_results = array();
    $results = $cxn->commit($q);
    while($row = mysql_fetch_assoc($results)){
      array_push($arr_results, array(
        "tagID" => $row["tagID"],
        "name" => $row["name"]
      ));
    }
    return $arr_results;
  }

  public function retrieveFromProject($projectID){
    $cxn = Connection::getInstance();
    $q = sprintf("select distinct tags.* FROM tags, tag_assignments WHERE tag_assignments.tagID = tags.tagID AND tag_assignments.userID IN (select users.userID from users where users.projectID=%d);", $projectID);
    $arr_results = array();
    $results = $cxn->commit($q);
    while($row = mysql_fetch_assoc($results)){
      array_push($arr_results, array(
        "tagID" => $row["tagID"],
        "name" => $row["name"]
      ));
    }
    return $arr_results;
  }

  public function updateTagForUser($tagID, $new_name){
    // will be used in CSpace
  }

  /*
   * @param array $tags An array of strings
   */
  public function assignTagsToBookmark($bookmarkID, $tags){
    if(count($tags) == 0){
      return;
    }
    /* By using IGNORE if user is assigning a previously created tag,
     * it will not insert it again
    */
    $q = "INSERT IGNORE INTO tags (`userID`, `name`) VALUES ";
    $arr = array();
    $cxn = Connection::getInstance();
    foreach($tags as $name){
      $ins = sprintf("(%d, '%s')", $this->userID, $cxn->esc(trim($name)));
      array_push($arr, $ins);
    }
    $q .= implode(",", $arr);
    $cxn->commit($q);

    //now insert into tag_assignments
    $q = "INSERT INTO tag_assignments (`userID`, `bookmarkID`, `tagID`) VALUES ";
    $arr = array();
    foreach($tags as $name){
      $ins = sprintf("(%d, %d, (SELECT tagID FROM tags WHERE userID=%d AND name='%s'))", $this->userID, $bookmarkID, $this->userID, $cxn->esc($name));
      array_push($arr, $ins);
    }
    $q .= implode(",", $arr);
    $cxn->commit($q);
  }
}
