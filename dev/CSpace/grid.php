//WORKING
//PHP - retrieved thumbnails each gets inputted into array
//JS - json_encode retrieves PHP array, converts to JS array

<html>
<head>
	<title>Coagmento 3D</title>
	<style>

	html, body {
		height: 100%;
	}

	body {
		background-color: #000;
		margin: 0;
		font-family: Arial;
		overflow: hidden;
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

	</style>
</head>
<body>
	<script src="js/three.min.js"></script>
	<script src="js/controls/TrackballControls.js"></script>
	<script src="js/renderers/CSS3DRenderer.js"></script>

	<div id="container"></div>

	<?php
	// Connecting to database
	require_once("connect.php");
	$userID=2;

	$getPage="SELECT * FROM pages,thumbnails WHERE thumbnails.thumbnailID=pages.thumbnailID AND pages.userID=".$userID." AND pages.projectID='8'";
	$pageResult = mysql_query($getPage) or die(" ". mysql_error());
	?>

	<div id="gallery">

	  	<?
	  	$arr = array();

	  	while($line = mysql_fetch_array($pageResult)) {
			$thumb = $line['fileName'];
			$title = $line['title'];

		$url = "http://".$_SERVER['HTTP_HOST']."/CSpace/thumbnails/small/".$thumb."";

		$arr[] = $url;

		}
		?>

	</div>

	<script>
	var thumbnails = <?php echo json_encode($arr ); ?>;

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

			var element = document.createElement( 'img' );
			element.className = 'thumbnail';
			element.width = 100;
			element.height= 100;
			element.src = thumbnail;

			var object = new THREE.CSS3DObject( element );
			//grid view
			object.position.x = ( ( i % 5 ) * 300 ) - 800;
			object.position.y = ( - ( Math.floor( i / 5 ) % 5 ) * 300 ) + 800;
			object.position.z = ( Math.floor( i / 25 ) ) * 1000 - 2000;
			scene.add( object );

		}

		//
		renderer = new THREE.CSS3DRenderer();
		renderer.setSize( window.innerWidth, window.innerHeight );
		renderer.domElement.style.position = 'absolute';
		document.getElementById( 'container' ).appendChild( renderer.domElement );

		//
		controls = new THREE.TrackballControls( camera, renderer.domElement );
		controls.rotateSpeed = 0.5;
		controls.addEventListener( 'change', render );

		window.addEventListener( 'resize', onWindowResize, false );
	}

	function onWindowResize() {

		camera.aspect = window.innerWidth / window.innerHeight;
		camera.updateProjectionMatrix();

		renderer.setSize( window.innerWidth, window.innerHeight );

	}

	function animate() {

		requestAnimationFrame( animate );
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
