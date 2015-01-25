<?php
session_start();
require_once("../core/Base.class.php");
require_once("../core/Bookmark.class.php");
require_once("../core/Page.class.php");
require_once("../core/Snippet.class.php");
require_once("../core/Query.class.php");
require_once("../core/Tags.class.php");
require_once("assets/php/util.php");

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


$feed_data = array(); //sorted by date
$tag_data = array(); //only for bookmarks page

$projectID = $base->getProjectID();
switch($PAGE){
  case "ALL":
    $bookmarks = extend_data(Bookmark::retrieveWithTagsFromProject($projectID), "bookmark");
    //$pages = extend_data(Page::retrieveFromProject($projectID), "page");
    $snippets = extend_data(Snippet::retrieveFromProject($projectID), "snippet");
    $searches = extend_data(Query::retrieveFromProject($projectID), "search");
    $feed_data = timestamp_merge($feed_data, $bookmarks);
    $feed_data = timestamp_merge($feed_data, $snippets);
    $feed_data = timestamp_merge($feed_data, $searches);
  break;
  case "BOOKMARKS":
    $raw_bookmarks = array();
    if(!empty($_GET["bookmark_tag_filter"])){
      $raw_bookmarks = Bookmark::retrieveFromProjectAndTag($projectID, $_GET["bookmark_tag_filter"]);
    } else {
      $raw_bookmarks = Bookmark::retrieveWithTagsFromProject($projectID);
    }
    $bookmarks = extend_data($raw_bookmarks, "bookmark");
    $tag_data = Tags::retrieveFromProject($projectID);
    $feed_data = $bookmarks;
  break;
  case "PAGE_VISITS":
    $pages = extend_data(Page::retrieveFromProject($projectID), "page");
    $feed_data = $pages;
  break;
  case "SNIPPETS":
    $snippets = extend_data(Snippet::retrieveFromProject($projectID), "snippet");
    $feed_data = $snippets;
  break;
  case "SEARCHES":
    $searches = extend_data(Query::retrieveFromProject($projectID), "search");
    $feed_data = $searches;
    break;
}

require_once("views/layout.php");
