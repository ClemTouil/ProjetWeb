<?php

    if ($mysqli->connect_errno) { // Si il y'a une erreur de connexion alors :
        printf("Échec de la connexion : %s\n", $mysqli->connect_error);
        exit();
    }else { // Si la connexion se passe bien alors :

		$stmt = $mysqli->prepare("INSERT INTO borneswifi VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param('ddsssssis', $latitude, $longitude, $adresse, $quartier, $site, $zone, $nom_c, $annee_ins, $dispo);
		
		if (isset($_POST['latitude']) and isset($_POST['longitude']) and isset($_POST['adresse']) and isset($_POST['quartier'])  and isset($_POST['site'])  and isset($_POST['zone']) and isset($_POST['nom_c']) and isset($_POST['dispo'])){
			
			$latitude = $_POST['latitude'];
			$longitude = $_POST['longitude'];
			$adresse = $_POST['adresse'];
			$quartier = $_POST['quartier'];
			$site = $_POST['site'];
			$zone = $_POST['zone'];
			$nom_c = $_POST['nom_c'];
			$annee_ins = $_POST['annee_ins'];
			$dispo = $_POST['dispo'];
		}
		
		/* Exécution de la requête */
		$stmt->execute();

		echo 'Ajouter une borne a fonctionné'

		/* Fermeture du traitement */
		$stmt->close();
    }
?>						
