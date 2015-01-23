<?php
session_start();
require_once("../core/Base.class.php");
require_once("../core/Bookmark.class.php");
require_once("../core/Page.class.php");
require_once("views/generators/bookmark.php");

$base = new Base();
if(!$base->isUserActive()){
  exit("Not logged in");
}

//simple routing
$PAGE = "ALL";
$valid_pages = array("ALL", "BOOKMARKS", "SNIPPETS", "SEARCHES", "ANNOTATIONS", "PAGE_VISITS");
if(isset($_GET["page"])){
  $PAGE = $_GET["page"];
}
if(!in_array($PAGE, $valid_pages)){
  exit("Invalid page " . $PAGE);
}


function extend_data($arr, $type){
  $extended = array();
  foreach($arr as $row){
    array_push($extended, array(
      "type" => $type,
      "data" => $row
    ));
  }
  return $extended;
}

function timestamp_merge($arr1, $arr2){
  $merged = array();
  $i1 = 0;
  $i2 = 0;
  while($i1 < count($arr1) || $i2 < count($arr2)){
    $choice = null;
    if($i1 == count($arr1)){
      $choice = $arr2[$i2];
      $i2++;
    } else if($i2 == count($arr2)){
      $choice = $arr1[$i1];
      $i1++;
    } else {
      $t1 = $arr1[$i1]["data"]["timestamp"];
      $t2 = $arr2[$i2]["data"]["timestamp"];
      if($t1 > $t2){
        $choice = $arr1[$i1];
        $i1++;
      } else {
        $choice = $arr2[$i2];
        $i2++;
      }
    }
    array_push($merged, $choice);
  }
  return $merged;
}

$feed_data = array(); //sorted by date




switch($PAGE){
  case "ALL":
    $bookmarks = extend_data(Bookmark::retrieveFromProject($base->getProjectID()), "bookmark");
    $pages = extend_data(Page::retrieveFromProject($base->getProjectID()), "page");
    $feed_data = timestamp_merge($bookmarks, $pages);
  break;
  case "BOOKMARKS":
    $bookmarks = extend_data(Bookmark::retrieveFromProject($base->getProjectID()), "bookmark");
    $feed_data = $bookmarks;
  break;
  case "PAGE_VISITS":
    $pages = extend_data(Page::retrieveFromProject($base->getProjectID()), "page");
    $feed_data = $pages;
  break;
}

require_once("views/layout.php");
