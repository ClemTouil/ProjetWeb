<?php
	
    if ($mysqli->connect_errno) { // Si il y'a une erreur de connexion alors :
        printf("Échec de la connexion : %s\n", $mysqli->connect_error);
        exit();
    }else { // Si la connexion se passe bien alors :

        $result = mysqli_query($mysqli,"SELECT latitude, longitude, site, adresse, quartier, dispo FROM borneswifi ");
        while ( $row = mysqli_fetch_array($result)) {
			//Generer la variable avec nom du quartier 
			$bornes = $row['site']; // pour l'adaptation du nom de l'url
			$bannis = array(' ','-','\'','é','è');//Complète ici tout les mots qui dooivent être remplacé
			$accepte = array('_','_','_','e','e');
			$bornes = str_replace($bannis, $accepte, $row['site']); // on remplace les espaces par des tirets
			$bornes = preg_replace('/[^A-Za-z0-9\-]/', '', $bornes);
            echo 'var '.$bornes.' = L.marker(['.$row['latitude'].','.$row['longitude'].'], {icon: wifiIcon}).bindPopup("Je suis '.$row['site'].'</br>Quartier : '.$row['quartier'].'</br>Adresse : '.$row['adresse'].'</br>Disponibilité : '.$row['dispo'].' ").addTo(map); ';
        }
    }
?>