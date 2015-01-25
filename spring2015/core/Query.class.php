<?php

require_once('Connection.class.php');
require_once('Base.class.php');

class Query extends Base {

  public function __construct(){
    parent::__construct();
  }


  public static function retrieveFromUser($userID, $projectID=FALSE){

  }

  public static function retrieveFromProject($projectID, $start=0, $limit=200){
    $cxn=Connection::getInstance();
    $query = sprintf("SELECT queries.*, users.username FROM queries, users WHERE queries.projectID=%d AND queries.userID=users.userID ORDER BY queries.timestamp DESC LIMIT %d, %d", $projectID, $start, $limit);
    $queries = array();
    $results = $cxn->commit($query);
    while($record = mysql_fetch_assoc($results)){
      array_push($queries, $record);
    }
    return $queries;
  }

}
?>
