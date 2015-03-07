//jquery, button, addeventlisterner test (non-working)
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
	<script src="js/controls/TrackballControls.js"></script>
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
							break;
						case 02:
							$le_month = "Feb";
							break;
						case 03:
							$le_month = "Mar";
							break;
						case 04:
							$le_month = "Apr";
							break;
						case 05:
							$le_month = "May";
							break;
						case 06:
							$le_month = "Jun";
							break;
						case 07:
							$le_month = "Jul";
							break;
						case 08:
							$le_month = "Aug";
							break;
						case 09:
							$le_month = "Sep";
							break;
						case 10:
							$le_month = "Oct";
							break;
						case 11:
							$le_month = "Nov";
							break;
						case 12:
							$le_month = "Dec";
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
							break;
						case 02:
							$le_month = "Feb";
							break;
						case 03:
							$le_month = "Mar";
							break;
						case 04:
							$le_month = "Apr";
							break;
						case 05:
							$le_month = "May";
							break;
						case 06:
							$le_month = "Jun";
							break;
						case 07:
							$le_month = "Jul";
							break;
						case 08:
							$le_month = "Aug";
							break;
						case 09:
							$le_month = "Sep";
							break;
						case 10:
							$le_month = "Oct";
							break;
						case 11:
							$le_month = "Nov";
							break;
						case 12:
							$le_month = "Dec";
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
		$arr[] = array($thumb, $title, $comp_date, $comp_year, $comp_month);
	}
	?>
	</div>

	<script>
	var thumbnails = <?php echo json_encode($arr); ?>, player;

	var janCount = 0;
	var febCount = 0;
	var marCount = 0;
	var aprCount = 0;
	var mayCount = 0;
	var junCount = 0;
	var julCount = 0;
	var augCount = 0;
	var sepCount = 0;
	var octCount = 0;
	var novCount = 0;
	var decCount = 0;

	var year2 = '';
	var yearCount = 0;

	var info = [];
	var count = [];

	for ( var i = 0; i < thumbnails.length; i ++ ) {
		var count = [ janCount, febCount, marCount, aprCount, mayCount, junCount, julCount, augCount, sepCount, octCount, novCount, decCount ];
		var year1 = thumbnails[i][3];
		var month = thumbnails[i][4];

		if (year1 != year2) {
			year2 = year1;
			console.log(count);

			// var total = 0;
			// $.each(arr,function() {
			//     total += this;
			// });

			// var count2 = '';
			// if (total != 0) {
			// 	if (count != count2) {
			// 		count = count2;
			// 	}

			// 	for(var j in count) {
			// 		count[j] - count[i];
			// 	}
			// }

			console.log("This is year:" + year1);
			yearCount+=1;
		}

		switch (month) {
			case '01':
				janCount+=1;
				break;
			case '02':
				febCount+=1;
				break;
			case '03':
				marCount+=1;
				break;
			case '04':
				aprCount+=1;
				break;
			case '05':
				mayCount+=1;
				break;
			case '06':
				junCount+=1;
				break;
			case '07':
				julCount+=1;
				break;
			case '08':
				augCount+=1;
				break;
			case '09':
				sepCount+=1;
				break;
			case '10':
				octCount+=1;
				break;
			case '11':
				novCount+=1;
				break;
			case '12':
				decCount+=1;
				break;
		}
	}
	console.log(count);

	// takes out all zeros in month count array
	for (var month in count) {
		if (month = '0') {
			var pos = count.indexOf(0);
			count.splice(pos,1);
		}
		console.log(count);
	}

	// for (var x = 0; x < count.length; x++) {
	// 	//console.log(count[x]);
	// }

	var a = count[0];
	var b = count[1];
	var c = count[2];
	var d = count[3];
	var e = count[4];

	var objects = [];
	var targets = { table: [], sphere: [], helix: [], grid: [] };

	var camera, scene, renderer;
	var controls;

	init();
	animate();

	function init() {

		camera = new THREE.PerspectiveCamera( 75, window.innerWidth / window.innerHeight, 1, 1000 );
		camera.position.z = 1800;
		//camera.lookAt( object.position );

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

				// var year1 = thumbnails[i][3];
				// var month = thumbnails[i][4];

				// if (year1 != year2) {
				// 	year2 = year1;
				// 	console.log("This is year:" + year1);
				// 	yearCount+=1;
				// }

				// switch (month) {
				// 	case '01':
				// 		console.log("This is an Jan date.");
				// 		janCount+=1;
				// 		count.push(janCount);
				// 		break;
				// 	case '02':
				// 		console.log("This is an Feb date.");
				// 		febCount+=1;
				// 		count.push(febCount);
				// 		break;
				// 	case '03':
				// 		console.log("This is an Mar date.");
				// 		marCount+=1;
				// 		count.push(marCount);
				// 		break;
				// 	case '04':
				// 		console.log("This is an Apr date.");
				// 		aprCount+=1;
				// 		count.push(aprCount);
				// 		break;
				// 	case '05':
				// 		console.log("This is an May date.");
				// 		mayCount+=1;
				// 		count.push(mayCount);
				// 		break;
				// 	case '06':
				// 		console.log("This is an Jun date.");
				// 		junCount+=1;
				// 		count.push(junCount);
				// 		break;
				// 	case '07':
				// 		console.log("This is an Jul date.");
				// 		julCount+=1;
				// 		count.push(julCount);
				// 		break;
				// 	case '08':
				// 		console.log("This is an Aug date.");
				// 		augCount+=1;
				// 		count.push(augCount);
				// 		break;
				// 	case '09':
				// 		console.log("This is a Sep date.");
				// 		sepCount+=1;
				// 		count.push(sepCount);
				// 		break;
				// 	case '10':
				// 		console.log("This is an Oct date.");
				// 		octCount+=1;
				// 		count.push(octCount);
				// 		break;
				// 	case '11':
				// 		console.log("This is an Nov date.");
				// 		novCount+=1;
				// 		count.push(novCount);
				// 		break;
				// 	case '12':
				// 		console.log("This is a Dec date.");
				// 		decCount+=1;
				// 		count.push(decCount);
				// 		break;
				// }

				//logic
				//if jan has 10 elements, feb 5 elements

				// if, else if 12 times for the 12 months
				var num_thumb_x = 5;

				if(i<a) {
					object.position.x = ( ( i % num_thumb_x ) * 300 ) - 800;
					var y_val= 5; //Math.ceil(a/num_thumb_x);
					object.position.y = ( - ( Math.floor( i / num_thumb_x ) % y_val) * 300 ) + 800;
					object.position.z = ( Math.floor( i / a ) ) * 1000 - 2000;
				}

				else if (i>=a && i< (a + b) ) {

					object.position.x = ( ( (i-a) % num_thumb_x ) * 300 ) - 800;
					var y_val= 5;//Math.ceil(b/num_thumb_x);
					object.position.y = ( - ( Math.floor( (i-a) / num_thumb_x ) % y_val) * 300 ) + 800;
					object.position.z = ( Math.floor( (i) / b ) ) * 1000 - 2000;
				}

				// else if (i>=(a+b) && i< (a+b+c)) {
				// 	object.position.x = ( ( i % num_thumb_x ) * 300 ) - 800;
				// 	var y_val= 5; // Math.ceil(c/num_thumb_x);
				// 	object.position.y = ( - ( Math.floor( i / num_thumb_x ) % y_val ) * 300 ) + 800;
				// 	object.position.z = ( Math.floor( i / c ) ) * 1000 - 2000;
				// }

				// else if (i>=(a+b+c) && i<(a+b+c+d)) {
				// 	object.position.x = ( ( i % num_thumb_x ) * 300 ) - 800;
				// 	var y_val= 5; // Math.ceil(d/num_thumb_x);
				// 	object.position.y = ( - ( Math.floor( i / num_thumb_x ) % y_val ) * 300 ) + 800;
				// 	object.position.z = ( Math.floor( i / d ) ) * 1000 - 2000;
				// }

				// else if (i>=(a+b+c+d) && i< (a+b+c+d+e)) {
				// 	object.position.x = ( ( i % num_thumb_x ) * 300 ) - 800;
				// 	var y_val= 5; // Math.ceil(e/num_thumb_x);
				// 	object.position.y = ( - ( Math.floor( i / num_thumb_x ) % y_val ) * 300 ) + 800;
				// 	object.position.z = ( Math.floor( i / e ) ) * 1000 - 2000;
				// };

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

		var button = document.getElementById('menu');
			button.addEventListener('click', function ( event ) {
				transform( targets.table, 2000 );
			}, false);

		//console.log(button);

		//
		renderer = new THREE.CSS3DRenderer();
		renderer.setSize( window.innerWidth, window.innerHeight );
		renderer.domElement.style.position = 'absolute';
		document.getElementById( 'container' ).appendChild( renderer.domElement );

		//
		controls = new THREE.TrackballControls( camera, renderer.domElement );
		controls.rotateSpeed = 0.5;
		controls.addEventListener( 'change', render );

		//
		window.addEventListener( 'resize', onWindowResize, false );
	}

	// $(document).ready(function() {
 // 		$('.month').click(function() {
	// 	switch ($(this).prop('id')) {
	// 		case "Nov-2009":
	// 			//console.log(nov);

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
	// 					//grid view
	// 					object.position.x = ( ( i % 5 ) * 300 ) - 800;
	// 					object.position.y = ( - ( Math.floor( i / 5 ) % 5 ) * 300 ) + 800;
	// 					object.position.z = ( Math.floor( i / 25 ) ) * 1000 - 2000;
	// 					scene.add( object );

	// 					objects.push( object );
	// 					targets.table.push( object );
	// 				}
	// 			break;

	// 		case "Dec-2011":
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
	// 					//grid view
	// 					object.position.x = ( ( i % 5 ) * 300 ) - 800;
	// 					object.position.y = ( - ( Math.floor( i / 5 ) % 5 ) * 300 ) + 800;
	// 					object.position.z = ( Math.floor( i / 25 ) ) * 1000 - 2000;
	// 					scene.add( object );

	// 					objects.push( object );
	// 				}
	// 			break;
	// 		}
	// 	});
	// });


	function transform( targets, duration ) {

		TWEEN.removeAll();

		for ( var i = 0; i < objects.length; i ++ ) {

			var object = objects[ i ];
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



					// new TWEEN.Tween( object.position )
					// 		.to( { y: - 3000 }, 1000 )
					// 		.delay( delay )
					// 		.easing( TWEEN.Easing.Exponential.In )
					// 		.start();

					// new TWEEN.Tween( object )
					// 		.to( {}, 2000 )
					// 		.delay( delay )
					// 		.onComplete( function () {

					// 			scene.remove( this );
					// 			renderer.cameraElement.removeChild( this.element );

					// 			var index = objects.indexOf( this );
					// 			objects.splice( index, 1 );

					// 		} )
					// 		.start();


		// for ( var i = 0; i < thumbnails.length; i ++ ) {

		// 	var thumbnail = thumbnails[ i ];

		// 	var element = document.createElement( 'div' );
		// 		element.style.width = '100px';
		// 		element.style.height = '100px';
		// 		element.name = thumbnail[1];

		// 	var time = document.createElement( 'div' );
		// 		time.className = 'date';
		// 		time.textContent = thumbnail[2];
		// 		element.appendChild( time );

		// 	var image = document.createElement( 'img' );
		// 	// image.addEventListener( 'load', function ( event ) {

		// 	// 	var object = this.properties.object;

		// 	// }, false );

		// 		image.className = 'thumbnail';
		// 		image.style.position = 'absolute';
		// 		image.style.width = 100;
		// 		image.style.height= 100;
		// 		image.src = 'http://<?php echo $_SERVER['HTTP_HOST']; ?>/CSpace/thumbnails/small/' + thumbnail[0]; //thumbnail[0];
		// 		element.appendChild( image );

		// 		var object = new THREE.CSS3DObject( element );
		// 		//grid view
		// 		object.position.x = ( ( i % 5 ) * 300 ) - 800;
		// 		object.position.y = ( - ( Math.floor( i / 5 ) % 5 ) * 300 ) + 800;
		// 		object.position.z = ( Math.floor( i / 25 ) ) * 1000 - 2000;
		// 		scene.add( object );

		// 		//
		// 		var properties = { data: thumbnails, object: object }

		// 		element.properties = properties;
		// 		image.properties = properties;

		// 		element.addEventListener( 'click', function ( event ) {

		// 		event.stopPropagation();

		// 			 var data = this.properties.data;
		// 			 var object = this.properties.object;

		// 			if ( player !== undefined ) {

		// 				player.parentNode.removeChild( player );
		// 				player = undefined;

		// 			}

		// 			player = document.createElement( 'iframe' );
		// 			player.style.position = 'absolute';
		// 			player.style.width = '480px';
		// 			player.style.height = '360px';
		// 			player.style.border = '0px';
		// 			player.src = 'http://coagmento.org/CSpace/thumbnails/' + thumbnail[0];
		// 			this.appendChild( player );

		// 		});


		// }

		// table

		// for ( var i = 0; i < thumbnails.length; i ++ ) {

		// 	var item = table[ i ];
		// 	var object = objects[ i ];

		// 	var object = new THREE.Object3D();
		// 	object.position.x = ( item[ 3 ] * 160 ) - 1540;
		// 	object.position.y = - ( item[ 4 ] * 200 ) + 1100;

		// 	targets.table.push( object );

		// }

		//


	function onWindowResize() {

		camera.aspect = window.innerWidth / window.innerHeight;
		camera.updateProjectionMatrix();

		renderer.setSize( window.innerWidth, window.innerHeight );

	}

	function animate() {

		requestAnimationFrame( animate );
		TWEEN.update();
		controls.update();

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
