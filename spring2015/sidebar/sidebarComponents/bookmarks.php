<?php
	if (session_id() == "")
        session_start();
    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Bookmarks</title>
<style type="text/css">
	.cursorType{
		cursor:pointer;
		cursor:hand;
	}
</style>
</head>
<body>
<div id="bookmarksBox" style="height:250px;overflow:auto;">
<?php
	require_once("bookmarksAux.php");
?>
</div>
</body>
</html>
