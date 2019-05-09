<?php

    if ($mysqli->connect_errno) { // Si il y'a une erreur de connexion alors :
        printf("Échec de la connexion : %s\n", $mysqli->connect_error);
        exit();
    }else { // Si la connexion se passe bien alors :

        $result = mysqli_query($mysqli,"SELECT latitude, longitude, site, adresse, quartier, nom_c, dispo FROM borneswifi ");
        while ( $row = mysqli_fetch_array($result)) {
			//Generer la variable avec nom du quartier
			$bornes = $row['site']; // pour l'adaptation du nom de l'url
			$bannis = array(' ','-','\'','é','è');//Complète ici tout les mots qui dooivent être remplacé
			$accepte = array('_','_','_','e','e');
			$bornes = str_replace($bannis, $accepte, $row['site']); // on remplace les espaces par des tirets
			$bornes = preg_replace('/[^A-Za-z0-9\-]/', '', $bornes);
			echo 'var '.$bornes.' = L.marker(['.$row['latitude'].','.$row['longitude'].'], {icon: wifiIcon, riseOnHover: true}).bindPopup("<form method=\"post\">\
		    <center><B id=\"nom_borne\">'.$row['site'].'</B></center>\
				<U>Quartier</U> : <span id=\"quartier\">'.$row['quartier'].'</span>\
				<br>\
				<U>Adresse</U> : <span id=\"adresse\">'.$row['adresse'].'</span>\
				<br>\
        <U>Nom connexion</U> : <span id=\"nomC\">'.$row['nom_c'].'</span>\
        <br>\
				<U>Disponibilité</U> : <span id=\"dispo\">'.$row['dispo'].'</span>\
				</br></br>\
				<button class=\"btn-xs btn-dark\" id=\"modifier\" type=\"button\" onclick=\"Modifier()\">Modifier</button>\
        <button class=\"btn-xs btn-dark\" id=\"supprimer\" type=\"button\">Supprimer</button>\
        </br>\
				<button class=\"btn-xs btn-dark\" id=\"sauvegarder\" type=\"button\">Sauvegarder</button>\
				<button class=\"btn-xs btn-dark\" id=\"annuler\" type=\"button\">Annuler</button>\
		</form>");markers.addLayer('.$bornes.'); ';
        }
    }
?>
