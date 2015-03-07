
<!DOCTYPE html>

<html>

<!--
	This is a jQuery Tools standalone demo. Feel free to copy/paste.
	                                                         
	http://flowplayer.org/tools/demos/
	
	Do *not* reference CSS files and images from flowplayer.org when in production  

	Enjoy!
-->

<head>
	<title>Coagmento - CSpace</title>

	<!-- include the Tools -->
	<script src="http://cdn.jquerytools.org/1.2.6/full/jquery.tools.min.js"></script>
	 
	<!-- tab styling -->
	<link rel="stylesheet" type="text/css" href="css/time.css"/>
</head>

<body>




<!-- tabs -->

<ul class="css-tabs">
	<li><a href="today.php">Today</a></li>
	<li><a href="yesterday.php">Yesterday</a></li>
	<li><a href="twodaysago.php">Two Days Ago</a></li>
    <li><a href="oneweekago.php">One Week Ago</a></li>
    <li><a href="all.php">All</a></li>
</ul>



<!-- single pane. it is always visible -->
<div class="css-panes"></div>

<!-- activate tabs with JavaScript -->
<script>


$(function() {

	$("ul.css-tabs").tabs("div.css-panes", {effect: 'ajax'});

});
</script>



</body>

</html>