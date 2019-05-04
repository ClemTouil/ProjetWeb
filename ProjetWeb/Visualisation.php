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
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
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

    $mysqli = new mysqli(HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

		include('PHP/refreshDataBase.php');

	?>

	<header id="entete">
		</br>	
		<i id ="img"class="fas fa-wifi">  Bornes Wi-Fi à Toulouse</i>
		</br>
		</br>
	</header>

	<form>
	  <input type="text" name="search" placeholder="Search..">
	</form>
	


	<div id="HighFiveCrew">
			<div id ="putain">
				<a href="#"  id="reset" class="btn btn-dark" >Vue d'ensemble</a>
			</div>
			<div id="graphe_menu">
					<a href="#"  id="borne" class="btn btn-dark" >Bornes</a>
					<a href="#"  id="pop" class="btn btn-dark" >Population</a>
					<a href="#"  id="borneetpop" class="btn btn-dark" >Bornes/Population</a>
			</div>
			<div id='map'></div>
			<div>
				
				<div id="chart_divB"  class="chart" ></div>
				<div id="chart_divG"  class="chart" ></div>
				<div id="chart_divP" class="chart" ></div>
				<div id="chart_divL" class="chart" ></div>


			</div>
	</div> 
	 	<!-- Fenêtre modale -->
	<div id="theLayer" style="position:absolute;width:250px;left:100;top:3%;visibility:hidden">
		<table border="0" width="250" bgcolor="black" cellspacing="0" cellpadding="5">
		<tr><td width="100%">
		<table border="0" width="100%" cellspacing="0" cellpadding="0" height="36">

		<!-- Barre pour le titre -->

		<tr><td id="titleBar" style="cursor:move" width="100%">

		<font face="Verdana" size="2" color="white"><b>Liste Quartiers</b></font>

		<td style="cursor:hand" valign="top"><a href="#" onClick="hideMe();return false"><font color=#ffffff size=2 face=arial  style="text-decoration:none">X</font></a>
		</td></tr>


		<!-- Texte dans la fenêtre -->
		<tr><td width="100%" bgcolor="#FFFFFF" style="padding:4px" colspan="2">
		<font id="quartiersemplacement"face="Verdana" size="2" color="#000080">
		<ul id="listeQuartiers" style="list-style-type:none;">

		</ul>
		<button href="hideMe()"  id="loadgraph" class="btn btn-dark">Tout supprimer</button>
		</font>
		</td></tr></table> 
		</td></tr></table>
	</div>



	<script>
			//Make the DIV element draggagle:
	dragElement(document.getElementById("theLayer"));

	function dragElement(elmnt) {
	  var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
	  if (document.getElementById(elmnt.id + "header")) {
		/* if present, the header is where you move the DIV from:*/
		document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
	  } else {
		/* otherwise, move the DIV from anywhere inside the DIV:*/
		elmnt.onmousedown = dragMouseDown;
	  }

	  function dragMouseDown(e) {
		e = e || window.event;
		e.preventDefault();
		// get the mouse cursor position at startup:
		pos3 = e.clientX;
		pos4 = e.clientY;
		document.onmouseup = closeDragElement;
		// call a function whenever the cursor moves:
		document.onmousemove = elementDrag;
	  }

	  function elementDrag(e) {
		e = e || window.event;
		e.preventDefault();
		// calculate the new cursor position:
		pos1 = pos3 - e.clientX;
		pos2 = pos4 - e.clientY;
		pos3 = e.clientX;
		pos4 = e.clientY;
		// set the element's new position:
		elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
		elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
	  }

	  function closeDragElement() {
		/* stop moving when mouse button is released:*/
		document.onmouseup = null;
		document.onmousemove = null;
	  }
	}

	function hideMe(){
		theLayer.style.visibility="hidden";

	}

	function showMe(){
		theLayer.style.visibility="visible";

	}




	
	

	
	
	
	
	
	
	
	
	
	//GRAPHIQUE
	google.charts.load('current', {packages: ['corechart', 'bar', 'line']});
	google.charts.setOnLoadCallback(drawGeneralChart);


	function drawGeneralChart() {
	//GENERAL CHART
      var dataG = new google.visualization.DataTable();
      dataG.addColumn('string', 'Quartiers');
      dataG.addColumn('number', 'Nombre Habitants');
      dataG.addColumn('number', 'Nombre Bornes Wi-Fi');

      dataG.addRows([
		<?php include('PHP/GraphiqueGeneral.php'); ?>
      ]);

      var options = {
		title: 'Nombre d\'habitants et de Bornes par Quartiers',
		seriesType : 'bars',
		legend: { position: 'bottom' },
        series: {
          0: {axis: 'a', targetAxisIndex: 0},
          1: {axis: 'b', targetAxisIndex: 1, type: 'line'}
        },
        hAxis: {
          title: 'Quartiers',
		  textPosition: 'none',
          viewWindow: {
            min: [7, 30, 0],
            max: [17, 30, 0]
          }
		 },
		 tooltip : { trigger : 'both' }
      };

      GeneralChart = new google.visualization.ComboChart(document.getElementById('chart_divG'));

			function selectHandlerG() {
				try{
					var selectedItem = GeneralChart.getSelection()[0];
					console.log(selectedItem);
					if (selectedItem) {
						var quartier = dataG.getValue(selectedItem.row, 0);
						var nombreh = dataG.getValue(selectedItem.row, 1);
						quartier = quartier.split(' ').join('_');
						quartier = quartier.split('\'').join('_');
						quartier = quartier.split('-').join('_');
						var zoom = eval(quartier);
						zoom.setStyle({color: '#666',opacity: 0.9,weight: 7});
						zoom.openTooltip();
						liste_quartiers_noirs.push([quartier,nombreh]);
						map.fitBounds(zoom.getBounds());

					};
				}catch(err){
					console.log(err.message);
				};
			};

			function onmouseoverHandlerG(e) {
				try {
					GeneralChart.setSelection([]);
					var quartier = dataG.getValue(e.row, 0);
					var nombreh = dataG.getValue(e.row, 1);
					quartier = quartier.split(' ').join('_');
					quartier = quartier.split('\'').join('_');
					quartier = quartier.split('-').join('_');
					liste_quartiers_noirs.push([quartier,nombreh]);
					var surligne = eval(quartier);
					surligne.setStyle({color: '#666',opacity: 0.9,weight: 7});
					surligne.openTooltip();
				}catch(err){
					console.log(err.message);
				};

			};

			function onmouseoutHandlerG(e) {
				try{
					var quartier = dataG.getValue(e.row, 0);
					var nombreh = dataG.getValue(e.row, 1);
					quartier = quartier.split(' ').join('_');
					quartier = quartier.split('\'').join('_');
					quartier = quartier.split('-').join('_');
					liste_quartiers_noirs.push([quartier,nombreh]);
					var p_surligne = eval(quartier);
					p_surligne.setStyle({color: '#666',opacity: 0.9,weight: 2});
					p_surligne.closeTooltip();
				}catch(err){
					console.log(err.message);
				};
			};

      google.visualization.events.addListener(GeneralChart, 'select', selectHandlerG);
	  google.visualization.events.addListener(GeneralChart, 'onmouseover', onmouseoverHandlerG);
	  google.visualization.events.addListener(GeneralChart, 'onmouseout', onmouseoutHandlerG);
      GeneralChart.draw(dataG, options);


	//BORNE CHART
      var dataB = new google.visualization.DataTable();
      dataB.addColumn('string', 'Quartiers');
      dataB.addColumn('number', 'Nombre Bornes');

      dataB.addRows([
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
		 },
		 tooltip : { trigger : 'both' }
      };

      BorneChart = new google.visualization.LineChart(document.getElementById('chart_divB'));

	    function selectHandlerB() {
			try{
          var selectedItem = BorneChart.getSelection()[0];
          if (selectedItem) {
			markers.clearLayers();//enleve toutes les bornes
            var quartier = dataB.getValue(selectedItem.row, 0);
			$.ajax({
				url: 'PHP/Bornes_Dans_Quartier.php',
				data: 'quart='+quartier,
				success: function(response){
					eval(response);
				}
			});
			markers.addTo(map);
			var var_quartier = quartier.split(' ').join('_');
			var_quartier = var_quartier.split('\'').join('_');
			var_quartier = var_quartier.split('-').join('_');
			var zoom = eval(var_quartier);
			zoom.setStyle({color: '#666',opacity: 0.9,weight: 7});
			zoom.openTooltip();
			//liste_quartiers_noirs.push([quartier,nombreh]);
			map.fitBounds(zoom.getBounds());

			}
			}catch(err){
				console.log(err.message);
			}
        }
	    function onmouseoverHandlerB(e) {
			try {
				BorneChart.setSelection([]);
				var quartier = dataB.getValue(e.row, 0);
				markers.clearLayers();//enleve toutes les bornes
				//var nombreh = dataB.getValue(e.row, 1);
				$.ajax({
					url: 'PHP/Bornes_Dans_Quartier.php',
					data: 'quart='+quartier,
					success: function(response){
						eval(response);
					}
				});
				markers.addTo(map);

			}
			catch(err){
			  console.log(err.message);
		  }

        }	

	  var containerB = document.getElementById('chart_divB');
	  containerB.style.display = 'block';

	  google.visualization.events.addListener(BorneChart, 'ready', function () { containerB.style.display = 'none';});
      google.visualization.events.addListener(BorneChart, 'select', selectHandlerB);
	  google.visualization.events.addListener(BorneChart, 'onmouseover', onmouseoverHandlerB);
	  //google.visualization.events.addListener(BorneChart, 'onmouseout', onmouseoutHandler);
      BorneChart.draw(dataB, options);

	  //POPULATION CHART

			var dataP = new google.visualization.DataTable();
			dataP.addColumn('string', 'Quartiers');
			dataP.addColumn('number', 'Nombre Habitants');

			dataP.addRows([
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
		 },
		 tooltip : { trigger : 'both' }
      };

      PopChart = new google.visualization.ColumnChart(document.getElementById('chart_divP'));

	    function selectHandlerP() {
			try{
			var selectedItem = PopChart.getSelection()[0];
			if (selectedItem) {
				var quartier = dataP.getValue(selectedItem.row, 0);
				var nombreh = dataP.getValue(selectedItem.row, 1);
				quartier = quartier.split(' ').join('_');
				quartier = quartier.split('\'').join('_');
				quartier = quartier.split('-').join('_');
				liste_quartiers_noirs.push([quartier,nombreh]);
				var epais = eval(quartier);
				epais.setStyle({color: '#666', fillColor: 'grey',opacity: 0.9,weight: 7});
				epais.openPopup();
				map.fitBounds(epais.getBounds());
				//MyFunctionAjoutList();
          }
			}catch(err){
				console.log(err.message);
			};
		};

	    function onmouseoverHandlerP(e) {
			try {
				PopChart.setSelection([]);
				var quartier = dataP.getValue(e.row, 0);
				var nombreh = dataP.getValue(e.row, 1);
				quartier = quartier.split(' ').join('_');
				quartier = quartier.split('\'').join('_');
				quartier = quartier.split('-').join('_');
				liste_quartiers_noirs.push([quartier,nombreh]);
				var epais = eval(quartier);
				epais.setStyle({color: '#666',opacity: 0.9,weight: 7});
				epais.openPopup();
          }catch(err){
			  console.log(err.message);
		  };

        };

		function onmouseoutHandlerP(e) {
			try{
				var quartier = dataP.getValue(e.row, 0);
				var nombreh = dataP.getValue(e.row, 1);
				quartier = quartier.split(' ').join('_');
				quartier = quartier.split('\'').join('_');
				quartier = quartier.split('-').join('_');
				liste_quartiers_noirs.push([quartier,nombreh]);
				var epais = eval(quartier);
				epais.setStyle({color: '#666',opacity: 0.9,weight: 2});
				epais.closePopup();
          }catch(err){
			  console.log(err.message);
		  };
        };

	  var containerP = document.getElementById('chart_divP');
	  containerP.style.display = 'block';

	  google.visualization.events.addListener(PopChart, 'ready', function () { containerP.style.display = 'none';});
      google.visualization.events.addListener(PopChart, 'select', selectHandlerP);
	  google.visualization.events.addListener(PopChart, 'onmouseover', onmouseoverHandlerP);
	  google.visualization.events.addListener(PopChart, 'onmouseout', onmouseoutHandlerP);
      PopChart.draw(dataP, options);
    };


	$(document).ready(function(){
		liste_quartiers_noirs = [];
		//console.log(liste_quartiers_noirs);
    //On button click, load new data
		$("#reset").click(function(){

			//remettre les quartiers en couleurs
			for(var i = 0; i<liste_quartiers_noirs.length; i++){
				nomqua = eval(liste_quartiers_noirs[i][0]);
				nombrehab = liste_quartiers_noirs[i][1];
				if(nombrehab<=5000){
					nomqua.setStyle({fillColor: 'yellow',weight: 2,opacity: 1,color: "#666",dashArray: "3",fillOpacity: 0.7});
				}
				else if(nombrehab<=10000){
					nomqua.setStyle({fillColor: 'orange',weight: 2,opacity: 1,color: "#666",dashArray: "3",fillOpacity: 0.7});

				}
				else{
					nomqua.setStyle({fillColor: 'red',weight: 2,opacity: 1,color: "#666",dashArray: "3",fillOpacity: 0.7});
				}
				try{nomqua.closePopup();}catch(err){console.log(err.message)};
				try{nomqua.closeTooltip();}catch(err){console.log(err.message)};
			};

			//remettre toutes les bornes
			markers.clearLayers();//enleve toutes les bornes
			<?php include('PHP/Creation_Points_Bornes.php'); ?>
			markers.addTo(map);


			//recentrer la carte
			map.flyTo([43.600000,1.433333],12);
		});

		$("#borne").click(function(){
			var borne = document.getElementById("chart_divB");
			var pop = document.getElementById("chart_divP");
			var gen = document.getElementById("chart_divG");
			var perso = document.getElementById("chart_divL");
			gen.style.display = "none";
			pop.style.display = "none";
			borne.style.display = "inline";
			perso.style.display = "none";
		});

		$("#borneetpop").click(function(){

			var borne = document.getElementById("chart_divB");
			var pop = document.getElementById("chart_divP");
			var gen = document.getElementById("chart_divG");
			var perso = document.getElementById("chart_divL");
			gen.style.display = "inline";
			pop.style.display = "none";
			borne.style.display = "none";
			perso.style.display = "none";
		
		});

		$("#pop").click(function(){

	  		var borne = document.getElementById("chart_divB");
			var pop = document.getElementById("chart_divP");
			var gen = document.getElementById("chart_divG");
			var perso = document.getElementById("chart_divL");
			gen.style.display = "none";
			pop.style.display = "inline";
			borne.style.display = "none";
			perso.style.display = "none";
		});		
		//SUPPRIME TOUT LES QUARTIERS DE LA LISTE BRO
		$("#loadgraph").click(function(){ 		
			//var liste = document.getElementById("listeQuartiers");
			$("#listeQuartiers").empty();
			Display_Loadgraph();
			hideMe();
			//var items = liste.getElementsByTagName("li");

		});
	});


	//MAP
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
	var markers = L.layerGroup();
	<?php include('PHP/Creation_Points_Bornes.php'); ?>
	markers.addTo(map);

	//Creer Polygone
	<?php include('PHP/Creation_Polygones_Quartiers.php'); ?>;


	//Désactive le zoom sur le double Click
	map.doubleClickZoom.disable();

	//popup sur un r-clik
	function pop(e){
		var lat = e.latlng.lat;
		var long = e.latlng.lng;
		var createborne = L.popup();
			createborne
				.setLatLng(e.latlng)
				.setContent("<form id=\"ajoutBorne\" method=\"post\"><center><B>Ajouter une borne</B></center></br>Latitude : <input type=\"text\" name=\"lat\" value=\""+lat+"\"></br></br>Longitude : <input type=\"text\" name=\"long\" value=\""+long+"\"></br><input type=\"hidden\" name=\"quartier\"></br>Nom de la borne : <input type=\"text\" name=\"namebor\"> \<br><br>Année d\'installation : <input type=\"text\" name=\"annee\" value=\"2019\" readonly><br><br>Zone d\'émission : <select name=\"emission\"><option value=\"interieur\">intérieur</option> <option value=\"exterieur\">extérieur</option></select> <br><br>Nom de connexion : <input type=\"text\" name=\"nameco\"><br><br>Disponibilité : <select name=\"dispo\"><option value=\"24h/24h (avec garantie)\">24h/24h (avec garantie)</option> <option value=\"24h/24h (sans garantie)\">24h/24h (sans garantie)</option></select> <br><br>Adresse : <input type=\"text\" name=\"adresse\"><br><br><button class=\"btn-xs btn-dark\" id=\"soumettre\" type=\"button\">Valider</button></form>")
				.openOn(map);

		}
	function onMapClick(e) {
		pop(e);
	}

		map.on('contextmenu  ', onMapClick);

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
		   div.innerHTML += labels.push();
           div.innerHTML = labels.join('<br>');
       return div;
       };
       legend.addTo(map);

		//FONCTION POUR GERER LES BOUTONS DANS POPUP BORNES
		function Modifier(){
			var mod= document.getElementById("modifier");
			var sauv= document.getElementById("sauvegarder");
			var anu= document.getElementById("annuler");

			mod.style.visibility="hidden";
			sauv.style.visibility="visible";
			anu.style.visibility="visible";
			
			// var site = document.getElementById("site");
			// var texts = document.getElementById("site").innerHTML;
			// site.innerHTML ="<input type=\"text\" id=\"site_brn\" value='"+texts+"'></input>";

			var dispo = document.getElementById("dispo");
			var textd = document.getElementById("dispo").innerHTML;
			dispo.innerHTML="<input type=\"text\" id=\"dispo_brn\" value='"+textd+"'></input>";

			var nomC = document.getElementById("nomC");
			var text2 = document.getElementById("nomC").innerHTML;
			nomC.innerHTML="<input type=\"text\" id=\"nom_c\" value='"+text2+"'></input>";

			}

		function Annuler(){
			var mod= document.getElementById("modifier");
			var sauv= document.getElementById("sauvegarder");
			var anu= document.getElementById("annuler");
			
			// var site = document.getElementById("site");
			// var texts = document.getElementById("site_brn").value;
			// site.innerHTML=texts;			
			
			var dispo = document.getElementById("dispo");
			var nomC = document.getElementById("nomC");
			var text = document.getElementById("dispo_brn").value;
			var text2 = document.getElementById("nomC").value;
			dispo.innerHTML=text;
			nomC.innerHTML=text2;

			mod.style.visibility="visible";
			sauv.style.visibility="hidden";
			anu.style.visibility="hidden";

			}
			
			

		//FONCTION AJOUT QUARTIER DANS LISTE POUR CHART
		
		function MonsterReborn(){
						var borne = document.getElementById("chart_divB");
			var pop = document.getElementById("chart_divP");
			var gen = document.getElementById("chart_divG");
			var perso = document.getElementById("chart_divL");
			gen.style.display = "none";
			pop.style.display = "none";
			borne.style.display = "none";
			perso.style.display = "inline";
				
			
			
			var dataL = new google.visualization.DataTable();
			dataL.addColumn('string', 'Quartiers');
			dataL.addColumn('number', 'Nombre Habitants');
			dataL.addColumn('number', 'Nombre Bornes Wi-Fi');
			
			var liste = document.getElementById("listeQuartiers");
			var items = liste.getElementsByTagName("li");

			//var quart = issou.split('<');
			//console.log(quart[0].trim());
			
			var donnees = [];
			//dataL.addRows(items.length);
			//console.log(items.length);
			var count = 0;
			for (var i=0; i < items.length; i++){
				//console.log("i zen:"+i);
				var str = items[i].innerHTML.split('<');
				var q = str[0].trim();				
				$.ajax({
					 url: 'PHP/GraphiquePerso.php',
					 async: false,
					 data: 'quartier='+q,
					 success: function(response){
						var str = response.split(',');
						donnees.push([str[0],parseFloat(str[1]),parseFloat(str[2])]);
						 //console.log(str);
						 //console.log(str[0]);
						 //console.log(parseFloat(str[1]));
						 //console.log(parseFloat(str[2]));


						}
				});
			}
			//console.log("datas :"+donnees);
			dataL.addRows(donnees);
				
			var options = {
				title: 'Nombre d\'habitants et de Bornes par Quartiers',
				seriesType : 'bars',
				legend: { position: 'bottom' },
				series: {
					0: {axis: 'a', targetAxisIndex: 0},
					1: {axis: 'b', targetAxisIndex: 1, type: 'line'}
				},	
				hAxis: {
				title: 'Quartiers',
				textPosition: 'none',
				viewWindow: {
					min: [7, 30, 0],
					max: [17, 30, 0]
					}
				},
				tooltip : { trigger : 'both' }
			};
			
			PersoChart = new google.visualization.ComboChart(document.getElementById('chart_divL'));
			//console.log(dataL);
						function selectHandlerMR() {
							try{
								var selectedItem = PersoChart.getSelection()[0];
								console.log(selectedItem);
								if (selectedItem) {
									var quartier = dataL.getValue(selectedItem.row, 0);
									var nombreh = dataL.getValue(selectedItem.row, 1);
									quartier = quartier.split(' ').join('_');
									quartier = quartier.split('\'').join('_');
									quartier = quartier.split('-').join('_');
									var zoom = eval(quartier);
									zoom.setStyle({color: '#666',opacity: 0.9,weight: 7});
									zoom.openTooltip();
									liste_quartiers_noirs.push([quartier,nombreh]);
									map.fitBounds(zoom.getBounds());

								};
							}catch(err){
								console.log(err.message);
							};
						};

						function onmouseoverHandlerMR(e) {
							try {
								PersoChart.setSelection([]);
								var quartier = dataL.getValue(e.row, 0);
								var nombreh = dataL.getValue(e.row, 1);
								quartier = quartier.split(' ').join('_');
								quartier = quartier.split('\'').join('_');
								quartier = quartier.split('-').join('_');
								liste_quartiers_noirs.push([quartier,nombreh]);
								var surligne = eval(quartier);
								surligne.setStyle({color: '#666',opacity: 0.9,weight: 7});
								surligne.openTooltip();
							}catch(err){
								console.log(err.message);
							};

						};

						function onmouseoutHandlerMR(e) {
							try{
								var quartier = dataL.getValue(e.row, 0);
								var nombreh = dataL.getValue(e.row, 1);
								quartier = quartier.split(' ').join('_');
								quartier = quartier.split('\'').join('_');
								quartier = quartier.split('-').join('_');
								liste_quartiers_noirs.push([quartier,nombreh]);
								var p_surligne = eval(quartier);
								p_surligne.setStyle({color: '#666',opacity: 0.9,weight: 2});
								p_surligne.closeTooltip();
							}catch(err){
								console.log(err.message);
							};
						};

			google.visualization.events.addListener(PersoChart, 'select', selectHandlerMR);
			google.visualization.events.addListener(PersoChart, 'onmouseover', onmouseoverHandlerMR);
			google.visualization.events.addListener(PersoChart, 'onmouseout', onmouseoutHandlerMR);
			PersoChart.draw(dataL, options);		
			
		};
		
		function MyFunctionAjoutList(){ 
		
			var newQuartier= document.getElementById("quartiername").text;
			var liste = document.getElementById("listeQuartiers");
			var dejaLa = false;
			try{
				var items = liste.getElementsByTagName("li");
				for (var i=0; i < items.length; i++) {
					var str = items[i].innerHTML; 
					var table = str.split('<'); 
					if(newQuartier == table[0].trim()){
						dejaLa = true;
					};
				};
				if (!dejaLa){
					var li = document.createElement("li");
					var cross = document.createElement("i");
					cross.setAttribute("class", "fas fa-times");
					cross.setAttribute("onclick", "Supprimer_Quartiers_Liste(\""+newQuartier+"\")");
					li.appendChild(document.createTextNode(newQuartier+" "));
					li.appendChild(cross);
					li.setAttribute("id", newQuartier);
					//document.getElementById("listeQuartiers").append("<li>"+newQuartier+"<i class=\"fas fa-times\"></i></li>");
					liste.appendChild(li);
					Display_Loadgraph();					
				}
			}catch(err){
				console.log(err.message);
			};
			};
			
		function Display_Loadgraph(){
			var br = document.getElementsByClassName("br");
			var btn = document.getElementById("loadgraph");
			var liste = document.getElementById("listeQuartiers");
			var items = liste.getElementsByTagName("li");
			if(items.length == 0){
				liste.style.display = "none";
				btn.style.display = "none";
				document.getElementById("borneetpop").click();
				for (var i=0; i < br.length; i++) {
					br[i].style.display = "none";
				}	
			}
			else{
				//PARTIE AFFICHAGE LISTE 
				showMe();
				liste.style.display = "inline";
				btn.style.display = "inline";
				for (var i=0; i < br.length; i++) {
					br[i].style.display = "inline";
				}
				MonsterReborn();
			}
		};
		Display_Loadgraph();
		
		function Supprimer_Quartiers_Liste(newQuartier){
			
			var liste = document.getElementById("listeQuartiers");
			var quartier = document.getElementById(newQuartier);
			liste.removeChild(quartier);
			Display_Loadgraph();			
			
		};
	</script>

	</script>
	<script type="text/javascript" src="JS/ajaxGraph.js"></script>
	<script type="text/javascript" src="JS/ajaxModifBorne.js"></script>
	<script type="text/javascript" src="JS/ajaxAjoutBorne.js"></script>


</body>
</html>
