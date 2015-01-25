<?php

require_once('Connection.class.php');
require_once('Base.class.php');

class Snippet extends Base {

  public function __construct(){
    parent::__construct();
  }


  public static function retrieveFromUser($userID, $projectID=FALSE){

  }

  public static function retrieveFromProject($projectID, $start=0, $limit=200){
    $cxn=Connection::getInstance();
    $query = sprintf("SELECT snippets.*, users.username FROM snippets, users WHERE snippets.projectID=%d AND snippets.userID=users.userID ORDER BY snippets.timestamp DESC LIMIT %d, %d", $projectID, $start, $limit);
    $snippets = array();
    $results = $cxn->commit($query);
    while($record = mysql_fetch_assoc($results)){
      array_push($snippets, $record);
    }
    return $snippets;
  }

}
?>
