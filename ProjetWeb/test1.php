<!DOCTYPE html>
<html>
<head>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</head>
<body>
<?php

    define('HOSTNAME','localhost');
    define('DB_USERNAME','root');
    define('DB_PASSWORD','');
    define('DB_NAME','projet_web');

    $mysqli = new mysqli(HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

	?>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script>
window.onload = function () {					
var finals =[];
console.log("longueur du CUL : "+finals.length);
$.ajax({
		url: 'PopulationPerso.php',
		async: false,
		data: 'quartier='+'GRAMONT',
		success: function(response){
				console.log(response);
				var oui = response.split(',');
				//eval(response);
				finals.push({ 'label': oui[0], 'y': parseFloat(oui[1])});
				console.log("longueur du CUL : "+finals.length);
				//listeP.push(response);
				console.log(oui[0]);
				console.log(parseFloat(oui[1]));
			}
		});						
var chart = new CanvasJS.Chart("chartContainer", {
	exportEnabled: true,
	animationEnabled: true,
	title:{
		text: "Nombre d'habitants et de Bornes par Quartiers"
	},
	subtitles: [{
		text: "Click Legend to Hide or Unhide Data Series"
	}], 
	axisX: {
		title: "States"
	},
	axisY: {
		title: "Nombre Habitants",
		titleFontColor: "black",
		lineColor: "#4F81BC",
		labelFontColor: "#4F81BC",
		tickColor: "#4F81BC"
	},
	axisY2: {
		title: "Nombre Bornes",
		titleFontColor: "black",
		lineColor: "#C0504E",
		labelFontColor: "#C0504E",
		tickColor: "#C0504E"
	},
	toolTip: {
		shared: true
	},
	legend: {
		cursor: "pointer",
		itemclick: toggleDataSeries
	},
	data: [{
		type: "column",
		name: "Nombre Habitants",
		showInLegend: true,      
		yValueFormatString: "###0.# ",
		dataPoints: eval(finals),
		
	},
	{
		type: "line",
		name: "Nombre Bornes",
		axisYType: "secondary",
		showInLegend: true,
		yValueFormatString: "## ",
		dataPoints: [
			{ label: "GRAMONT", y: 10},
			{ label: "New Jersey", y: 21 },
			{ label: "Texas", y: 13 },
			{ label: "Oregon", y: 42 },
			{ label: "Montana", y: 13 },
			{ label: "Massachusetts", y: 52 }
		]
	}]
});console.log

//console.log("ICICICI : "+chart.options.data[0]);
console.log("longueur du CUL : "+finals.length);		
chart.render();

function toggleDataSeries(e) {
	if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	} else {
		e.dataSeries.visible = true;
	}
	e.chart.render();
}

}
</script>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
</body>
</html>