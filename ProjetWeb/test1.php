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
			echo 'var '.$bornes.' = L.marker(['.$row['latitude'].','.$row['longitude'].'], {icon: wifiIcon}).bindPopup("<form method=\"post\" action=\"ModifierBorne.php\">\
		<center><B>'.$row['site'].'</B></center>\
				<U>Quartier</U> : '.$row['quartier'].'\
				<br>\
				<U>Adresse</U> : '.$row['adresse'].'\
				<br>\
				<U>Disponibilité</U> : '.$row['dispo'].'\
				</br>\
				<button class=\"btn-xs btn-dark\" id=\"modifier\" type=\"button\" onclick=\"MyFunction1()\">Modifier</button>\
				<button class=\"btn-xs btn-dark\" id=\"sauvegarder\" type=\"submit\" onclick=\"MyFunction2()\">Sauvegarder</button>\
				<button class=\"btn-xs btn-dark\" id=\"annuler\" type=\"button\" onclick=\"MyFunction3()\">Annuler</button>\
		</form>").addTo(map); ';
        }
    }
?>