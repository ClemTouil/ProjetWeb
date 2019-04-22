<?php
    if ($mysqli->connect_errno) { // Si il y'a une erreur de connexion alors :
        printf("Échec de la connexion : %s\n", $mysqli->connect_error);
        exit();
    }else { // Si la connexion se passe bien alors :

        $result = mysqli_query($mysqli,"SELECT nom_q, liste_b FROM quartiers ");
        while ( $row = mysqli_fetch_array($result)) {
			//Generer la variable avec nom du quartier 
			$quartier = $row['nom_q']; // pour l'adaptation du nom de l'url
			$comtpe = json_decode($row['liste_b']);
			$cpt = count($comtpe);
            echo '[\''.$quartier.'\','.$cpt.'],';
        }
    }
?>