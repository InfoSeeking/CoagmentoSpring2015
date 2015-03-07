<?php
if($_REQUEST['url']!='')
{
function get($a,$b,$c)
{ // Gets a string between 2 strings
$y = explode($b,$a);
$x = explode($c,$y[1]);
return $x[0];
}
$url=get_meta_tags("".$_REQUEST['url'].""); 
?>
<div class="result">
<div class="title pad"><?php echo get(file_get_contents(''.$_REQUEST['url'].''), "<title>", "</title"); ?></div>
<div class="pad"><strong>Description: </strong><i style="color:#008000;"><?php echo ($url["description"]); ?></i></div>
<div class="pad" style="font-size:10px;"><strong>Keywords: </strong><?php echo substr($url["keywords"], 0, 128); ?>..</div>
<div class="pad" style="font-size:10px; color:#999;"><strong style="color:#333;">Copyright: </strong><?php echo ($url["copyright"]); ?></div>
<div><img <?php echo get(file_get_contents(''.$_REQUEST['url'].''), "<img", "/>"); ?> /></div>
</div>
<?php
}
?>