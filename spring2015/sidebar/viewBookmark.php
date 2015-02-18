<?php
session_start();
require_once('../core/Base.class.php');
require_once('../core/Connection.class.php');
require_once('../core/Util.class.php');
require_once('../core/Tags.class.php');
require_once('../core/Bookmark.class.php');

$base = new Base();

if (!$base->isSessionActive())
{
	exit("Not logged in");
}
if (!isset($_GET['value']))
{
	exit("Invalid value");
}

$bookmarkID = $_GET['value'];
$updated = false;

if (isset($_POST["action"]) && $_POST["action"] == "update"){
		$notes = $_POST["notes"];
		$tags = $_POST["tags"];
		Bookmark::update($bookmarkID, $notes, $tags);
		$updated = true;
}


Util::getInstance()->saveAction("View Bookmark",$bookmarkID, $base);


$query = "SELECT bookmarkID, userID, (SELECT username from users b where a.userID = b.userID) username, url, title, time, rating, note
FROM bookmarks a
WHERE bookmarkID = $bookmarkID";

$connection = Connection::getInstance();
$results = $connection->commit($query);
$numRows = mysql_num_rows($results);

$tags = new Tags();
$available_tags = $tags->retrieveFromProject($base->getProjectID());
$used_tags = Tags::retrieveFromBookmark($bookmarkID);

if ($numRows == 0)
{
	exit("Bookmark not found");
}
$line = mysql_fetch_array($results, MYSQL_ASSOC);
$url = $line['url'];
$title = stripslashes($line['title']);
$username = $line['username'];
$time = $line['time'];
$userID = $line['userID'];
$rating = $line['rating'];
$note = $line['note'];

$editable = true;
$user = "";
if ($base->getUserID()==$userID){
	$user = "You";
}
else {
	$user = $username;
	$editable = false;
}

?>

<html>
    <head>
			<title>Bookmark View</title>
			<link href="../lib/select2/select2.css" rel="stylesheet" type="text/css" />
			<script type="text/javascript" src="../lib/jquery-2.1.3.min.js"></script>
			<script type="text/javascript" src="../lib/select2/select2.full.min.js"></script>
			<style>
				#container{
					width: 320px;
					margin: 0px auto;
				}
				textarea{
					display: block;
					width: 300px;
				}
				.row {
					margin-top: 20px;
				}
				#tag-input{
					width: 300px;
				}
				.feedback{
					background: #99FFA7;
					padding: 5px 10px;
				}
				.submit{
					margin-top: 20px;
					padding: 2px 5px;
				}
			</style>
    </head>
	<script type="text/javascript" src="js/utilities.js"></script>

<body>
			<form action="#" method="post">
				<div id="container">
					<?php if($updated){
						echo "<p class='feedback'>Tag updated!</p>";
					}
					?>
					<h3><a href="<?php echo $url; ?>" target="_new"><?php echo $title; ?></a></h3>
					<h4>Saved by <strong><?php echo $user;?></strong> at <strong><?php echo $time;?></strong></h4>

					<div class="row">
						<label>Notes</label><br/>
						<textarea name="notes" <?php if(!$editable) echo "disabled"; ?>><?php if(!is_null($note) && $note != "") echo $note; ?></textarea>
					</div>
					<div class="row">
						<label>Tags (separate with comma)</label><br/>
						<select name="tags[]" id="tag-input" multiple="multiple" <?php if(!$editable) echo "disabled"; ?>>
							<?php
							//show all user tags
							foreach($available_tags as $tag){
								$extra = "";
								if(in_array($tag, $used_tags)){
									$extra = "selected";
								}
								printf("<option %s value='%s'>%s</option>", $extra, $tag["name"], $tag["name"]);
							}
							?>
						</select>
					</div>
					<input type="hidden" name="bookmarkID" value="<?php echo $bookmarkID; ?>" />
					<input type="hidden" name="action" value="update" />
					<?php if($editable): ?>
					<input type="submit" value="Update Bookmark" class="submit"/>
					<?php endif ?>
				</div>
			</form>
			<hr>
			<?php
			
			$projectID = $base->getProjectID();
			$query = "SELECT * FROM (SELECT url,userID,projectID FROM bookmarks WHERE bookmarkID = $bookmarkID) a INNER JOIN (SELECT * FROM snippets WHERE projectID='$projectID') b on a.userID=b.userID AND a.url=b.url";

			$connection = Connection::getInstance();
			$results = $connection->commit($query);

			$count = 1;
			while ($line = mysql_fetch_array($results, MYSQL_ASSOC)){
				echo "<p><strong>Snippet $count:</strong> ";
				$snippet =$line['snippet'];
				if (trim($snippet)!=""){
					echo $snippet;
				}else{
					echo "(no text)";
				}
				echo "</p>";
				$count += 1;
			}

			?>
	<script>
	var previous_tags = $("#tag-input").val() || [];
	$("#tag-input").select2({
		tags: true,
		tokenSeparators: [',']
	}).on("change", function(el){
		var changeType = ""; //add or remove
		var changeTag = "";
		var current_tags = $(this).val();
		for(var i = 0; i < current_tags.length; i++){
			var t = current_tags[i];
			var loc = previous_tags.indexOf(t);
			if(loc != -1){
				previous_tags.splice(loc, 1);
			} else {
				//added new tag
				changeType = "add";
				changeTag = t;
				break;
			}
		}
		if(changeType == ""){
			//ought to be exactly one tag left
			changeType = "remove";
			if(previous_tags.length == 1){
				changeTag = previous_tags[0];
			}
		}
		previous_tags = current_tags;
		changeTag = changeTag.trim();
		if(changeType != "" && changeTag != ""){
			//send ajax request to add action TODO
			$.ajax({
				url: "insertAction.php",
				type: "GET",
				data : {
					"action" : "tag_" + changeType,
					"value" : changeTag
				},
				success: function(){
					console.log(changeTag, changeType);
					console.log("Recorded");
				}
			})
		}
	});
	</script>
</body>
</html>
