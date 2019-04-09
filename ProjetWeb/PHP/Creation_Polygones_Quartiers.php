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

        $result = mysqli_query($mysqli,"SELECT nom_q, shape_q, population FROM quartiers ");
        while ( $row = mysqli_fetch_array($result)) {
			//Generer la variable avec nom du quartier 
			$quartier = $row['nom_q']; // pour l'adaptation du nom de l'url
			$bannis = array(' ','-','\'');//Complète ici tout les mots qui dooivent être remplacé
			$accepte = array('_','_','_');
			$quartier = str_replace($bannis, $accepte, $row['nom_q']); // on remplace les espaces par des tirets
            echo 'var '.$quartier.' = L.polygon('.$row['shape_q'].',{fillColor: '.nombreHabitants($row['population']).',weight: 2,opacity: 1,color: "white",dashArray: "3",fillOpacity: 0.7}).addTo(map); ';
        }
    }
?>