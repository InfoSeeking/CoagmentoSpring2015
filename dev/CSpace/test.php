<html> 
<head> 
	<title>Coagmento 3D</title> 
	<style>
	html, body {
		height: 100%;
	}
	body {
		color:white;
		background-color: #000;
		margin: 0;
		font-family: Arial;
		overflow: hidden;
	}
	a:visited {
		color:white;
	}
	.thumbnail {
		width:100px;
		height:100px;
		cursor: default;
		border:1px solid rgba(127, 255, 255, 0.25);
		box-shadow: 0 0 20px rgba(0, 255, 255, 0.5);
	}
	.thumbnail:hover {
		border:1px solid rgba(127, 255, 255, 0.75);
		box-shadow:0 0 20px rgba(0, 255, 255, 0.75);
	}
	.thumbnail .date {
		position: absolute;
		top: 20px;
		right: 20px;
		font-size: 20px;
		color: rgba(127,255,255,0.75);
	}
	#menu {
		position: absolute;
		/*width: 100%;*/
	}
	button {
		color: rgba(127,255,255,0.75);
		background: transparent;
		outline: 1px solid rgba(127,255,255,0.75);
		border: 0px;
		padding: 5px 10px;
	}
	button:hover {
		background-color: rgba(0,255,255,0.5);
	}
	button:active {
		color: #000000;
		background-color: rgba(0,255,255,0.75);
	}

	</style> 
</head> 
<body> 
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>  
	<script src="js/three.min.js"></script>
	<!--<script src="js/controls/TrackballControls.js"></script>-->
	<script src="js/renderers/CSS3DRenderer.js"></script>
	<script src="js/tween.min.js"></script>

	<div id="container"></div>

	<div id="menu">
	<?php 
		// Connecting to database
		require_once('connect.php');
		session_start();

		if (!isset($_SESSION['CSpace_userID'])) {
			echo "Sorry. Your session has expired. Please <a href=\"http://www.coagmento.org\">login again</a>.";
		}
		else {

		$userID = $_SESSION['CSpace_userID'];

		$getPage="SELECT * FROM pages,thumbnails WHERE thumbnails.thumbnailID=pages.thumbnailID AND pages.userID=".$userID." AND NOT url = 'about:blank' AND NOT url like '%coagmento.org%' AND NOT url like '%coagmentopad.rutgers.edu%'";
		$pageResult = mysql_query($getPage) or die(" ". mysql_error());

		$hasResult = FALSE; // Check if there are any results
		
		$compareDate = '';
		$compareYear = '';
		$compareMonth = '';
		$compareDay = '';
		$setDate = false;
		
		$entered_first = false;
		$contain = false;
		}

	  	while($line = mysql_fetch_array($pageResult)) {
			$thumb = $line['fileName'];
			$title = $line['title'];
			$comp_date = $line['date'];

			$hasThumb = $line['thumbnailID'];
			$val = $row['value'];

			if($value == $val) {
			// Bookmarked
			
			// Label by year, month ,day
			$comp_date = $line['date'];
			$comp_year = date("Y",strtotime($comp_date));
			$comp_month = date("m",strtotime($comp_date));
			$comp_day = date("d",strtotime($comp_date));
			
			if($setDate == false) {
				$compareDate = $comp_date;
				$compareYear = $comp_year;
				$compareMonth = $comp_month;
				$compareDay = $comp_day;
				$setDate = true;
			}

		// try adding to array with $comp_year and $comp_date. use JS to sort $comp_year in array???
			if($comp_date == $compareDate) {
				if($entered_first == false) {
					$entered_first = true;
					
					// Converting months to word format
					switch ($comp_month) {
						case 01:
							$le_month = "Jan";
							$jan[] = array($thumb, $title, $comp_date);								
							break;
						case 02:
							$le_month = "Feb";
							$feb[] = array($thumb, $title, $comp_date);
							break;
						case 03:
							$le_month = "Mar";
							$mar[] = array($thumb, $title, $comp_date);
							break;
						case 04:
							$le_month = "Apr";
							$apr[] = array($thumb, $title, $comp_date);
							break;
						case 05:
							$le_month = "May";
							$may[] = array($thumb, $title, $comp_date);
							break;
						case 06:
							$le_month = "Jun";
							$jun[] = array($thumb, $title, $comp_date);
							break;
						case 07:
							$le_month = "Jul";
							$jul[] = array($thumb, $title, $comp_date);
							break;
						case 08:
							$le_month = "Aug";
							$aug[] = array($thumb, $title, $comp_date);
							break;
						case 09:
							$le_month = "Sep";
							$sep[] = array($thumb, $title, $comp_date);
							break;
						case 10:
							$le_month = "Oct";
							$oct[] = array($thumb, $title, $comp_date);
							break;
						case 11:
							$le_month = "Nov";
							$nov[] = array($thumb, $title, $comp_date);
							break;
						case 12:
							$le_month = "Dec";
							$dec[] = array($thumb, $title, $comp_date);
							break;
					  }
					
					echo '<div class="year"><h2>'.$comp_year.'</h2></div>';
					echo '<button id='.$le_month.'-'.$comp_year.' class="month" value="'.$le_month.'"><h3>'.$le_month.'</h3></button>';						
					// echo '<button id="day">'.$comp_date.'</button>';

					$contain = true;
				}
			}
			else {
				// Converting months to word format
				switch ($comp_month) {
							case 01:
							$le_month = "Jan";
							$jan[] = array($thumb, $title, $comp_date);								
							break;
						case 02:
							$le_month = "Feb";
							$feb[] = array($thumb, $title, $comp_date);
							break;
						case 03:
							$le_month = "Mar";
							$mar[] = array($thumb, $title, $comp_date);
							break;
						case 04:
							$le_month = "Apr";
							$apr[] = array($thumb, $title, $comp_date);
							break;
						case 05:
							$le_month = "May";
							$may[] = array($thumb, $title, $comp_date);
							break;
						case 06:
							$le_month = "Jun";
							$jun[] = array($thumb, $title, $comp_date);
							break;
						case 07:
							$le_month = "Jul";
							$jul[] = array($thumb, $title, $comp_date);
							break;
						case 08:
							$le_month = "Aug";
							$aug[] = array($thumb, $title, $comp_date);
							break;
						case 09:
							$le_month = "Sep";
							$sep[] = array($thumb, $title, $comp_date);
							break;
						case 10:
							$le_month = "Oct";
							$oct[] = array($thumb, $title, $comp_date);
							break;
						case 11:
							$le_month = "Nov";
							$nov[] = array($thumb, $title, $comp_date);
							break;
						case 12:
							$le_month = "Dec";
							$dec[] = array($thumb, $title, $comp_date);
							break;
						}
					  
				$contain = false;
				
				if($comp_year != $compareYear) {
					echo '<div class="year"><h2>'.$comp_year.'</h2></div>';
				}
				
				if($comp_month != $compareMonth) {
					echo '<button id='.$le_month.'-'.$comp_year.' class="month" value="'.$le_month.'"><h3>'.$le_month.'</h3></button>';
					
					// if($comp_day == $compareDay)
					// 	echo '<button id="day">'.$comp_date.'</button>';
					
				}					

				// if($comp_day != $compareDay) {
				// 	echo '<button id="day">'.$comp_date.'</button>';
				// }
				
				if($contain == false) {
					$contain = true;
				}
				
				$compareDate = $comp_date;
				$compareYear = $comp_year;
				$compareMonth = $comp_month;
				$compareDay = $comp_day; 
			}

			$hasResult = TRUE;
		}
		$arr[] = array($thumb, $title, $comp_date);
	}		
	?>
	</div>

	<script> 
	var thumbnails = <?php echo json_encode($arr); ?>, player;
	var jan = <?php echo json_encode($jan);?>;	
	var feb = <?php echo json_encode($feb);?>;
	var mar = <?php echo json_encode($mar);?>;	
	var apr = <?php echo json_encode($apr);?>;	
	var may = <?php echo json_encode($may);?>;
	var jun = <?php echo json_encode($jun);?>;	
	var jul = <?php echo json_encode($jul);?>;
	var aug = <?php echo json_encode($aug);?>;
	var sep = <?php echo json_encode($sep);?>;
	var nov = <?php echo json_encode($nov);?>;
	var oct = <?php echo json_encode($oct);?>;
	var dec = <?php echo json_encode($dec);?>;	

	var objects = [];
	var targets = { table: [], sphere: [], helix: [], grid: [] };

	var camera, scene, renderer;
	var controls;

	init();
	animate();

	function init() {

		camera = new THREE.PerspectiveCamera( 75, window.innerWidth / window.innerHeight, 1, 1000 );
		camera.position.z = 1800;

		scene = new THREE.Scene();

		for ( var i = 0; i < thumbnails.length; i ++ ) {

			var thumbnail = thumbnails[ i ];

			var element = document.createElement( 'div' );
				element.style.width = '100px';
				element.style.height = '100px';
				element.name = thumbnail[1];

			var time = document.createElement( 'div' );
				time.className = 'date';
				time.textContent = thumbnail[2];
				element.appendChild( time );

			var image = document.createElement( 'img' );
			// image.addEventListener( 'load', function ( event ) {

			// 	var object = this.properties.object;

			// }, false );

				image.className = 'thumbnail';		
				image.style.position = 'absolute';
				image.style.width = 100;
				image.style.height= 100;
				image.src = 'http://<?php echo $_SERVER['HTTP_HOST']; ?>/CSpace/thumbnails/small/' + thumbnail[0]; //thumbnail[0];
				element.appendChild( image );

				var object = new THREE.CSS3DObject( element );
				//grid view
				object.position.x = ( ( i % 5 ) * 300 ) - 800;
				object.position.y = ( - ( Math.floor( i / 5 ) % 5 ) * 300 ) + 800;
				object.position.z = ( Math.floor( i / 25 ) ) * 1000 - 2000;
				scene.add( object );

				// //
				// var properties = { data: thumbnails, object: object }

				// element.properties = properties;
				// image.properties = properties;

				// element.addEventListener( 'click', function ( event ) {

				// event.stopPropagation();

				// 	 var data = this.properties.data;
				// 	 var object = this.properties.object;

				// 	if ( player !== undefined ) {

				// 		player.parentNode.removeChild( player );
				// 		player = undefined;

				// 	}

				// 	player = document.createElement( 'iframe' );
				// 	player.style.position = 'absolute';
				// 	player.style.width = '480px';
				// 	player.style.height = '360px';
				// 	player.style.border = '0px';
				// 	player.src = 'http://coagmento.org/CSpace/thumbnails/' + thumbnail[0];
				// 	this.appendChild( player );

				// });


		}

		// var button = document.getElementById('menu');
		// 	button.addEventListener('click', function ( event ) {
		// 		transform( targets.table, 2000 );
		// 	}, false);

		//console.log(button);

		//
		renderer = new THREE.CSS3DRenderer();
		renderer.setSize( window.innerWidth, window.innerHeight );
		renderer.domElement.style.position = 'absolute';
		document.getElementById( 'container' ).appendChild( renderer.domElement );

		//
		// controls = new THREE.TrackballControls( camera, renderer.domElement );
		// controls.rotateSpeed = 0.5;
		// controls.addEventListener( 'change', render );

		document.body.addEventListener( 'mousewheel', onMouseWheel, false );

		var tween = new TWEEN.Tween( { x: 0, y: 400 } )
	            .to( { x: 400 }, 2000 )
	            .easing( TWEEN.Easing.Elastic.InOut )
	            .onUpdate( function () {

	                container.innerHTML = 'x == ' + Math.round( this.x );
	                container.style.left = this.x + 'px';

	            } )
	            .start();

		//
		window.addEventListener( 'resize', onWindowResize, false );
	}

	// $(document).ready(function() {
 // 		$('.month').click(function() {
	// 	switch ($(this).prop('id')) {
	// 		case "Nov-2009":
	// 			console.log(nov);

	// 			for ( var i = 0; i < nov.length; i ++ ) {
	// 				var thumbnail = nov[i];
	// 				//console.log(thumbnail);
	// 				var element = document.createElement( 'div' );
	// 					element.style.width = '100px';
	// 					element.style.height = '100px';
	// 					element.name = thumbnail[1];

	// 				var time = document.createElement( 'div' );
	// 					time.className = 'date';
	// 					time.textContent = thumbnail[2];
	// 					element.appendChild( time );

	// 				var image = document.createElement( 'img' );
	// 					image.className = 'thumbnail';		
	// 					image.style.position = 'absolute';
	// 					image.style.width = 100;
	// 					image.style.height= 100;
	// 					image.src = 'http://<?php echo $_SERVER['HTTP_HOST']; ?>/CSpace/thumbnails/small/' + thumbnail[0]; //thumbnail[0];
	// 					element.appendChild( image );

	// 					var object = new THREE.CSS3DObject( element );

	// 					object.position.x = ( ( i % 5 ) * 300 ) - 800;
	// 					object.position.y = ( - ( Math.floor( i / 5 ) % 5 ) * 300 ) + 800;
	// 					object.position.z = ( Math.floor( i / 25 ) ) * 1000 - 2000;
	// 					scene.add( object );

	// 					objects.push( object );
	// 					targets.table.push( object );
	// 				}
	// 			break;

	// 		case "Dec-2011":
	// 			for ( var i = 0; i < dec.length; i ++ ) {
	// 				var thumbnail = dec[i];

	// 				var element = document.createElement( 'div' );
	// 					element.style.width = '100px';
	// 					element.style.height = '100px';
	// 					element.name = thumbnail[1];

	// 				var time = document.createElement( 'div' );
	// 					time.className = 'date';
	// 					time.textContent = thumbnail[2];
	// 					element.appendChild( time );

	// 				var image = document.createElement( 'img' );
	// 					image.className = 'thumbnail';		
	// 					image.style.position = 'absolute';
	// 					image.style.width = 100;
	// 					image.style.height= 100;
	// 					image.src = 'http://<?php echo $_SERVER['HTTP_HOST']; ?>/CSpace/thumbnails/small/' + thumbnail[0]; //thumbnail[0];
	// 					element.appendChild( image );

	// 					var object = new THREE.CSS3DObject( element );
	// 					//grid view
	// 					object.position.x = ( ( i % 5 ) * 300 ) - 800;
	// 					object.position.y = ( - ( Math.floor( i / 5 ) % 5 ) * 300 ) + 800;
	// 					object.position.z = ( Math.floor( i / 25 ) ) * 1000 - 2000;
	// 					scene.add( object );

	// 					targets.sphere.push( object );
	// 				}
	// 			break;
	// 		}
	// 	});
	// });


	function transform( targets, duration ) {

		TWEEN.removeAll();

		for ( var i = 0; i < objects.length; i ++ ) {

			var object = objects[ i ];
			console.log(target);
			var target = targets[ i ];

			new TWEEN.Tween( object.position )
				.to( { x: target.position.x, y: target.position.y, z: target.position.z }, Math.random() * duration + duration )
				.easing( TWEEN.Easing.Exponential.InOut )
				.start();

			new TWEEN.Tween( object.rotation )
				.to( { x: target.rotation.x, y: target.rotation.y, z: target.rotation.z }, Math.random() * duration + duration )
				.easing( TWEEN.Easing.Exponential.InOut )
				.start();

		}

		new TWEEN.Tween( this )
			.to( {}, duration * 2 )
			.onUpdate( render )
			.start();

	}

	function move( delta ) {

		for ( var i = 0; i < objects.length; i ++ ) {

			var object = objects[ i ];
			object.position.z += delta;

			if ( object.position.z > 0 ) {

				object.position.z -= 5000;

			} else if ( object.position.z < - 5000 ) {

				object.position.z += 5000;
			}
		}
	}

	function onMouseWheel( event ) {

		move( event.wheelDelta );

	}

	function onWindowResize() {

		camera.aspect = window.innerWidth / window.innerHeight;
		camera.updateProjectionMatrix();

		renderer.setSize( window.innerWidth, window.innerHeight );

	}

	function animate() {

		requestAnimationFrame( animate );

		TWEEN.update();

	}

	function render() {

		renderer.render( scene, camera );

	}

	</script> 
<?
mysql_close($con);
?>
</body> 
</html>