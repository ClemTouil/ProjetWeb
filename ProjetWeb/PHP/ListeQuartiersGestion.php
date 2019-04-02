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

        $result = mysqli_query($mysqli,"SELECT nom_q, population, liste_b FROM quartiers ");

        while ( $row = mysqli_fetch_array($result)) {
            echo '<tr>';
			echo '<td>'.$row['nom_q'].'</td>';
			echo '<td>'.$row['population'].'</td>';
			echo '<td>'.$row['liste_b'].'</td>'; //a revoir car je pense que le mieux serait d'avoir le nombre de bornes par quartiers 
			echo '<td><a class="badge badge-pill badge-dark" href="#"><i class="fas fa-pencil-alt"></i></a></td>'	//souci possible pour ajouter bouton modifier
			echo '</tr>';
        }
    }
?>
							