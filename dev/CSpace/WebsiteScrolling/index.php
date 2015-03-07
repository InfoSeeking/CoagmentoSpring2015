<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>Website Horizontal Scrolling with jQuery</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="description" content="Website Horizontal Scrolling with jQuery" />
        <meta name="keywords" content="jquery, horizontal, scrolling, scroll, smooth"/>
        <link rel="stylesheet" href="css/style.css" type="text/css" media="screen"/>
        
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js" type="text/javascript"></script> 
        <script type="text/javascript" src="sylvester.js"></script>
        <script type="text/javascript" src="purecssmatrix.js"></script>
        <script type="text/javascript" src="jquery.animtrans.js"></script>
        <script type="text/javascript" src="jquery.zoomooz.js"></script>
    </head>
    <style>
        a{
            color:#fff;
            text-decoration:none;
        }
        a:hover{
            text-decoration:underline;
        }
        span.reference{
            position:fixed;
            left:10px;
            bottom:10px;
            font-size:13px;
            font-weight:bold;
        }
        span.reference a{
            color:#fff;
            text-shadow:1px 1px 1px #000;
            padding-right:20px;
        }
        span.reference a:hover{
            color:#ddd;
            text-decoration:none;
        }
    </style>
    <body>
    
	<?php
	
	echo '<link href="css/style.css" rel="stylesheet" type="text/css" />';
	
	require_once("../connect.php"); 
	
	$userID = 2;
	$title = "Coagmento";
	
	$query = "SELECT * FROM users WHERE userID=$userID";
	$results = mysql_query($query) or die(" ". mysql_error());
	$line = mysql_fetch_array($results, MYSQL_ASSOC);
	$firstName = $line['firstName'];
	$lastName = $line['lastName'];
	
	?>
    
        <div class="section black" id="section1">
        
        <ul class="nav">
        	<li>User: <? echo "$firstName $lastName" ?></li>
            <li>Today</li>
            <li><a href="#section2">Yesterday</a></li>
            <li><a href="#section3">Two days ago</a></li>
        </ul><br/><br/>
            
            <h2>CSpace - Instructions</h2>
            <p>
                Welcome to your CSpace! Navigate through your search result history by clicking on the thumbnails to view details and the surrounding area to zoom out.<br/><br/>
            </p>
            
           <p> <? $query = "SELECT * FROM pages ORDER BY date,time LIMIT 20";
	$results = mysql_query($query) or die(" ". mysql_error());
	$records = 0;
	
	while ($line = mysql_fetch_array($results, MYSQL_ASSOC)) {
		$title = $line['title'];
		$url = $line['url'];
		$date = $line['date'];
		$time = $line['time'];

		echo "<div class='searches'><a href=\"$url\">$title</a> <br /> $date $time<br/></div>";
		$records++;
	}
	echo "</tr></table><br/><br/>"; ?></p>
            
            
        </div>
        <div class="section black" id="section2">
            <h2>Section 2</h2>
            <p>
                ‘A fathomless and boundless deep,
                There we wander, there we weep;
                On the hungry craving wind
                My Spectre follows thee behind.

            </p>
            <ul class="nav">
                <li><a href="#section1">1</a></li>
                <li>2</li>
                <li><a href="#section3">3</a></li>
            </ul>
        </div>
        <div class="section black" id="section3">
            <h2>Section 3</h2>
            <p>
                ‘He scents thy footsteps in the snow
                Wheresoever thou dost go,
                Thro’ the wintry hail and rain.
                When wilt thou return again?

            </p>
            <ul class="nav">
                <li><a href="#section1">1</a></li>
                <li><a href="#section2">2</a></li>
                <li>3</li>
            </ul>
        </div>

        <!-- The JavaScript -->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>		
        <script type="text/javascript" src="jquery.easing.1.3.js"></script>
        <script type="text/javascript">
            $(function() {
                $('ul.nav a').bind('click',function(event){
                    var $anchor = $(this);
                    /*
                    if you want to use one of the easing effects:
                    $('html, body').stop().animate({
                        scrollLeft: $($anchor.attr('href')).offset().left
                    }, 1500,'easeInOutExpo');
                     */
                    $('html, body').stop().animate({
                        scrollLeft: $($anchor.attr('href')).offset().left
                    }, 800);
                    event.preventDefault();
                });
            });
        </script>
    </body>
</html>