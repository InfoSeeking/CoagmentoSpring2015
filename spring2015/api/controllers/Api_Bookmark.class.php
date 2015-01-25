<?php
require_once("../core/Bookmark.class.php");
class Api_Bookmark{
  public static $METHODS = array("delete");
  public static function delete(){
    $id = req("bookmarkID");
    Bookmark::delete($id);
    finish("success");
  }
}
