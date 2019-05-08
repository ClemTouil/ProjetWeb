<?php
	
	function nombreHabitants($nombre) {
		if($nombre<=5000){
			return "'yellow'";
		}
		else if($nombre<=10000){
			return "'orange'";
		}
		else{
			return "'red'";
		}	
	}
	

    if ($mysqli->connect_errno) { // Si il y'a une erreur de connexion alors :
        printf("Échec de la connexion : %s\n", $mysqli->connect_error);
        exit();
    }else { // Si la connexion se passe bien alors :
		$numero_ligne = 0;
        $result = mysqli_query($mysqli,"SELECT nom_q, shape_q, population, liste_b FROM quartiers ");
        while ( $row = mysqli_fetch_array($result)) {
			//Generer la variable avec nom du quartier 
			$quartier = $row['nom_q']; // pour l'adaptation du nom de l'url
			$comtpe = json_decode($row['liste_b']);
			$cpt = count($comtpe);
			$bannis = array(' ','-','\'');//Complète ici tout les mots qui dooivent être remplacé
			$accepte = array('_','_','_');
			$quartier = str_replace($bannis, $accepte, $row['nom_q']); // on remplace les espaces par des tirets
            echo 'var '.$quartier.' = L.polygon('.$row['shape_q'].',{fillColor: '.nombreHabitants($row['population']).',weight: 2,opacity: 1,color: "#666",dashArray: "3",fillOpacity: 0.7}).bindPopup("<center><B><a id=\"quartiername\">'.$row['nom_q'].'</a></B></center>\
				<U>Population</U> : '.$row['population'].'\
				<br>\
				<U>Nombre de bornes</U> : '.$cpt.'\
				</br></br>\
				<button class=\"btn-xs btn-dark\" id=\"adlist\" onclick=\"MyFunctionAjoutList()\">Ajouter à la  liste</button>\
				").bindTooltip("'.$row['nom_q'].'<div id=\"numero_ligne\" style=\"display: none\">'.$numero_ligne.'</div>",{permanent: false, direction:"center",interactive: true, opacity: 0.8}).addTo(map);'.$quartier.'.on(\'mouseover\', function() { '.$quartier.'.setStyle({fillColor: '.nombreHabitants($row['population']).',weight: 5,opacity: 1,color: "#666",dashArray: " ",fillOpacity: 0.7, riseOnHover: true});var num = document.getElementById("numero_ligne").innerHTML;var borne = document.getElementById("chart_divB");var pop = document.getElementById("chart_divP");var gen = document.getElementById("chart_divG");if(gen.style.display == "inline"){GeneralChart.setSelection([{ row: num, column: 1 }])}else if(borne.style.display == "inline"){BorneChart.setSelection([{ row: num, column: 1 }])}else if(pop.style.display == "inline"){PopChart.setSelection([{ row: num, column: 1 }])}else{GeneralChart.setSelection([{ row: num, column: 1 }])}; });'.$quartier.'.on(\'mouseout\', function() { '.$quartier.'.setStyle({fillColor: '.nombreHabitants($row['population']).',weight: 2,opacity: 1,color: "#666",dashArray: "3",fillOpacity: 0.7})}); ';
				$numero_ligne = $numero_ligne + 1;
        }
    }
?>