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
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

	
	
	
	
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
	
	<div id="HighFiveCrew">
	
			<div id='map'></div>
			
			<div>
				<div id="chart_div" ></div>

				<div id="graphe_menu">
					<a href="#"  id="borne" class="btn btn-dark" >Bornes</a>
					<a href="#"  id="pop" class="btn btn-dark" >Population</a>
					<a href="#"  id="borneetpop" class="btn btn-dark" >Bornes/Population</a>
				</div>
				
			</div>
	</div>
		

	<script>
	//GRAPHIQUE
	google.charts.load('current', {packages: ['corechart', 'bar', 'line']});
	google.charts.setOnLoadCallback(drawGeneralChart);
	

	function drawGeneralChart() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Quartiers');
      data.addColumn('number', 'Nombre Habitants');
      data.addColumn('number', 'Nombre Bornes Wi-Fi');

      data.addRows([
		<?php include('PHP/GraphiqueGeneral.php'); ?>
      ]);

      var options = {
		title: 'Nombre d\'habitants et de Bornes par Quartiers',
		seriesType : 'bars',
		legend: { position: 'bottom' },
        series: {
          0: {axis: 'Nombre Habitants', targetAxisIndex: 0},
          1: {axis: 'Nombre Bornes Wi-Fi', targetAxisIndex: 1, type: 'line'}
        },
        hAxis: {
          title: 'Quartiers',
		  textPosition: 'none',
          viewWindow: {
            min: [7, 30, 0],
            max: [17, 30, 0]
          }
		 }
      };

      var GeneralChart = new google.visualization.ComboChart(document.getElementById('chart_div'));
	  
	    function selectHandler() {
          var selectedItem = GeneralChart.getSelection()[0];
          if (selectedItem) {
            var quartier = data.getValue(selectedItem.row, 0);
            //var nombreb = data.getValue(selectedItem.row, 2);
            var nombrepop = data.getValue(selectedItem.row, 1);
            alert('The user selected ' + nombrepop);
          }
        }

      google.visualization.events.addListener(GeneralChart, 'select', selectHandler);
      GeneralChart.draw(data, options);
    }
	
	$(document).ready(function(){
    //On button click, load new data
		$("#borne").click(function(){
        
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Quartiers');
      data.addColumn('number', 'Nombre Bornes');

      data.addRows([
		<?php include('PHP/GraphiqueBorne.php'); ?>
      ]);

      var options = {
		title: 'Nombre de Bornes par Quartiers',
		legend: { position: 'bottom' },
		lineWidth: 4,
		colors: ['red'],
        hAxis: {
          title: 'Quartiers',
		  textPosition: 'none',
          viewWindow: {
            min: [7, 30, 0],
            max: [17, 30, 0]
          }
		 }
      };

      var BorneChart = new google.visualization.LineChart(document.getElementById('chart_div'));
	  
	    function selectHandler() {
          var selectedItem = BorneChart.getSelection()[0];
          if (selectedItem) {
            var quartier = data.getValue(selectedItem.row, 0);
            //var nombreb = data.getValue(selectedItem.row, 2);
            //var nombrepop = data.getValue(selectedItem.row, 1);
            alert('The user selected ' + quartier);
          }
        }

      google.visualization.events.addListener(BorneChart, 'select', selectHandler);
      BorneChart.draw(data, options);
    
    
		});
		
		$("#borneetpop").click(function(){
			var data = new google.visualization.DataTable();
			data.addColumn('string', 'Quartiers');
			data.addColumn('number', 'Nombre Habitants');
			data.addColumn('number', 'Nombre Bornes Wi-Fi');

			data.addRows([
				<?php include('PHP/GraphiqueGeneral.php'); ?>
			]);

			var options = {
				title: 'Nombre d\'habitants et de Bornes par Quartiers',
				seriesType : 'bars',
				legend: { position: 'bottom' },
				series: {
					0: {axis: 'Nombre Habitants', targetAxisIndex: 0},
					1: {axis: 'Nombre Bornes Wi-Fi', targetAxisIndex: 1, type: 'line'}
				},
				hAxis: {
					title: 'Quartiers',
					textPosition: 'none',
					viewWindow: {
						min: [7, 30, 0],
						max: [17, 30, 0]
					}
				}
			};

			var GeneralChart = new google.visualization.ComboChart(document.getElementById('chart_div'));
	  
			function selectHandler() {
				var selectedItem = GeneralChart.getSelection()[0];
				if (selectedItem) {
					var quartier = data.getValue(selectedItem.row, 0);
					//var nombreb = data.getValue(selectedItem.row, 2);
					var nombrepop = data.getValue(selectedItem.row, 1);
					alert('The user selected ' + nombrepop);
				}
			}

			google.visualization.events.addListener(GeneralChart, 'select', selectHandler);
			GeneralChart.draw(data, options);
	  
		});

		$("#pop").click(function(){
			var data = new google.visualization.DataTable();
			data.addColumn('string', 'Quartiers');
			data.addColumn('number', 'Nombre Habitants');

			data.addRows([
				<?php include('PHP/GraphiquePopulation.php'); ?>
			]);

      var options = {
		title: 'Nombre d\'habitants par Quartiers',
		legend: { position: 'bottom' },
		lineWidth: 4,
        hAxis: {
          title: 'Quartiers',
		  textPosition: 'none',
          viewWindow: {
            min: [7, 30, 0],
            max: [17, 30, 0]
          }
		 }
      };

      var PopChart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
	  
	    function selectHandler() {
          var selectedItem = PopChart.getSelection()[0];
          if (selectedItem) {
            var quartier = data.getValue(selectedItem.row, 0);
            //var nombreb = data.getValue(selectedItem.row, 2);
            //var nombrepop = data.getValue(selectedItem.row, 1);
            alert('The user selected ' + quartier);
          }
        }

      google.visualization.events.addListener(PopChart, 'select', selectHandler);
      PopChart.draw(data, options);
	  
		});		
	
	});
	
	
	
	
	
	
	
	//MAP
		var map = L.map('map',{
			center: [43.600000,1.433333],
			zoom: 12
		});

		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
			maxZoom: 22,
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
	
	//Récuperer longitudes latitudes sur le click
	var popup = L.popup();

	function onMapClick(e) {
		popup
			.setLatLng(e.latlng)
			.setContent("You clicked the map at " + e.latlng.toString())
			.openOn(map);
	}

	map.on('click', onMapClick);
	
	//Ajouter Légende quartiers 

	   
	var legend = L.control({position: 'bottomleft'});
       legend.onAdd = function (map) {

       var div = L.DomUtil.create('div', 'info legend');
       labels = ['<strong>Nombre habitants</strong>'],
	   couleurs = ['yellow','orange','red'],
       categories = ['0 - 5.000','5.000 - 10.000','10.000+'];

       for (var i = 0; i < categories.length; i++) {

               div.innerHTML += 
               labels.push(
                   '<i style="background:' + couleurs[i] + '">       </i> ' +
               (categories[i] ? categories[i] : '+'));

           }
           div.innerHTML = labels.join('<br>');
       return div;
       };
	   //FAIT UN JOLI CARRE
       legend.addTo(map); 
	   
	   
	</script>



</body>
</html>