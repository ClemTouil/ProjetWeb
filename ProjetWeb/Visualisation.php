<!DOCTYPE html>
<html>
<head>
	
	<title>Visualisation</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link type="text/css" rel="stylesheet" href="CSS/visualisation.css">
	<link type="text/css" rel="stylesheet" href="CSS/map.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
		integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
		crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
		integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
		crossorigin=""></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<!-- <script type="text/javascript" src="javescript.js"></script> -->

	
	
	
	
	</head>
<body id="fond">

<?php
    define('HOSTNAME','localhost');
    define('DB_USERNAME','root');
    define('DB_PASSWORD','');
    define('DB_NAME','projet_web');

    $mysqli = new mysqli(HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_NAME); ?>

	<header id="entete">
		</br>
		</br>
		</br>
		<div id="bouton_menu">
			<a href="Visualisation.php" role="button" class="btn btn-light" >Visualisation</a>
			<a href="Gestion.php" role="button" class="btn btn-light" >Gestion</a>
		</div>
	</header>
		
	<form>
	  <input type="text" name="search" placeholder="Search..">
	</form>

	<div id='map'></div>

	<script>
		var map = L.map('map',{
			center: [43.600000,1.433333],
			zoom: 12
		});

		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
			maxZoom: 14,
			minZoom: 11
		}).addTo(map);

		//Génerer Icones
		var icon = L.Icon.extend({
			options: {	
			iconSize:     [15, 15]
		}
	});
	
	//Creer Bornes
	var wifiIcon = new icon({iconUrl: 'http://pngimg.com/uploads/wifi/wifi_PNG62360.png'});
	
	<?php include('PHP/Creation_Points_Bornes.php'); ?>
	
	//Creer Polygone
	<?php include('PHP/Creation_Polygones_Quartiers.php'); ?>;
	
	var legende = L.control({position: 'bottomright'});

	legende.onAdd = function (map) {

		var div = L.DomUtil.create('div', 'info legend');
        grades = ["0-5000","5000-10000","10000+"];
		couleurs = ["yellow","orange","red"];
        labels = ["Nombre Habtitants"];
		
		div.innerHTML += '<h2>'+labels[0]+'</h2>';
    // loop through our density intervals and generate a label with a colored square for each interval
		for (var i = 0; i < grades.length; i++) {
        div.innerHTML +=
            '<i style="background:' + couleurs[i] + '"></i> ' +
            grades[i] + '</br>';
    };

    return div;
};

legende.addTo(map);
	
	//Récuperer longitudes latitudes sur le click
	var popup = L.popup();

	function onMapClick(e) {
		popup
			.setLatLng(e.latlng)
			.setContent("You clicked the map at " + e.latlng.toString())
			.openOn(map);
	}

	map.on('click', onMapClick);
	</script>



</body>