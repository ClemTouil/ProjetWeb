<?php

    define('HOSTNAME','localhost');
    define('DB_USERNAME','root');
    define('DB_PASSWORD','');
    define('DB_NAME','projet_web');

    $mysqli = new mysqli(HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($mysqli->connect_errno) { // Si il y'a une erreur de connexion alors :
        printf("Échec de la connexion : %s\n", $mysqli->connect_error);
        exit();
    }else { // Si la connexion se passe bien alors :

        $result = mysqli_query($mysqli,"SELECT quartier, adresse, site, nom_c, dispo, zone, annee_ins FROM borneswifi ");

        while ( $row = mysqli_fetch_array($result)) {
            echo '<tr>';
			echo '<td>'.$row['quartier'].'</td>'; //à faire
			echo '<td>'.$row['adresse'].'</td>';
			echo '<td>'.$row['site'].'</td>';
			echo '<td>'.$row['nom_c'].'</td>';
			echo '<td>'.$row['dispo'].'</td>';  
			echo '<td>'.$row['zone'].'</td>';  
			echo '<td>'.$row['annee_ins'].'</td>';  
			echo '<td><a class="badge badge-pill badge-dark" href="#"><i class="fas fa-pencil-alt"></i></a></td>'	//souci possible pour ajouter bouton modifier
			echo '</tr>';
        }
    }
?>						