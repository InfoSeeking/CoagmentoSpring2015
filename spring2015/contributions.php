<table class="contributions">
  <thead><tr><th>User</th><th>Saved Bookmarks</th><th>Saved Snippets</th><th>Saved Searches</th></thead>
<?php
/*
Small script to echo out summary of user contributions
Ensure to require connection and base before including this file.
*/
$cxn = Connection::getInstance();
$base = Base::getInstance();
$projectID = $base->getProjectID();
$group = array();

$q =  "select u.username as username, b.userID, count(b.userID) as count from bookmarks b, users u where b.projectID=$projectID AND b.userID = u.userID group by userID";
$results = $cxn->commit($q);
while($row = mysql_fetch_assoc($results)){
  $group[$row["username"]] = array(
    "bookmarks" => $row["count"]
  );
}
$q =  "select u.username as username, b.userID, count(b.userID) as count from snippets b, users u where b.projectID=$projectID AND b.userID = u.userID group by userID";
$results = $cxn->commit($q);
while($row = mysql_fetch_assoc($results)){
  $group[$row["username"]]["snippets"] = $row["count"];
}
$q =  "select u.username as username, b.userID, count(b.userID) as count from queries b, users u where b.projectID=$projectID AND b.userID = u.userID group by userID";
$results = $cxn->commit($q);
while($row = mysql_fetch_assoc($results)){
  $group[$row["username"]]["searches"] = $row["count"];
}

foreach($group as $user => $data){
  printf("<tr><td>%s</td><td>%d</td><td>%d</td><td>%d</td>", $user, $data["bookmarks"], $data["snippets"], $data["searches"]);
}
?>
</table>
