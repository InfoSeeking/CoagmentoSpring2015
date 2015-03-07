
<script type="text/javascript" src="jquery_1.6.1.js"></script>
<script type="text/javascript"><!--
$(document).ready(function() {
  // select all the links with class="lnk", when one of them is clicked, get its "href" value
  // load the content from that URL and place it into the tag with id="content"
  $('a.lnk').click(function() {
    var url = $(this).attr('href');
    $('#content').load(url);
    return false;
  });
});
--> </script> 

<script type="text/javascript">
 function foo(bar) {
	  if(bar == "all-all-all-all-") {
		 $('#content').load('extern.php', function() {
  alert('Load was performed.');
});
	  }
  }
</script>

		<link rel="stylesheet" href="style.css" type="text/css" />

		<!-- This includes the ImageFlow CSS and JavaScript -->
		<link rel="stylesheet" href="coverflow/imageflow.packed.css" type="text/css" />
		<script type="text/javascript" src="coverflow/imageflow.packed.js"></script>

		<style type="text/css">
			p.flip {
			z-index: 1000;
			position:absolute;
			right: 0;
			color: #fff;
			}
            div.panel,p.flip
            {
            margin:0px;
            text-align:center;
            }
            div.panel
            {
            height:155px;
            display:none;
            background: #000;
			border-bottom: 1px solid #333;
			margin: 0;
			width: 100%;
			position:absolute;
			z-index: 999;
			padding-top: 10px;
            }
            div.panel a {
            display: block;
            margin: 0;
            padding: 0;
            font-size: 12px;
            color: #ccc;
            text-decoration: none;
            }
            div.panel a:hover {
            color: #ccc;
            }
        </style>
        
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>

        <script type="text/javascript"> 
		$(document).ready(function(){
		$(".flip").click(function(){
			$(".panel").slideToggle("slow");
		  });
		});
		</script>
	<?php 
    // Connecting to database
	require_once("connect.php");    
	$userID=2;
    
	//Incorporate the queries from timeline.php that manage the filter parameters that the user provides.
	//q=projects,user,year,month.... you have take the parameters from q and create a query
    //$getPage="SELECT * FROM pages,thumbnails WHERE thumbnails.thumbnailID=pages.thumbnailID AND pages.userID=".$userID." AND pages.projectID='8'";
    $pageResult = mysql_query($getPage) or die(" ". mysql_error());
    ?>
    
    <p class="flip" style="display: block; padding: 10px;"><?php echo '<img src="http://'.$_SERVER['HTTP_HOST'].'/img/'.$avatar.'" width=45 height=45 style="vertical-align:middle;border:3px solid #000;">'; ?><br/><img src="arrow.png"/></p>
        
        <script type="text/javascript">
            $(document).ready(function() {
                if(<?php echo json_encode($str) ?> == 'all-all-all-all-') {
                    $('#content').load('extern.php');
                }
            });
        </script>
    </div>
    
</div>




<!-- <a href="extern.php" title="Get extern" class="lnk">Get extern</a> -->
<div id="content"></div>
</body>
</html>