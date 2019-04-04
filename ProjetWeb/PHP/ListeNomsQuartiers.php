<?php

    if ($mysqli->connect_errno) { // Si il y'a une erreur de connexion alors :
        printf("Échec de la connexion : %s\n", $mysqli->connect_error);
        exit();
    }else { // Si la connexion se passe bien alors :

        $result = mysqli_query($mysqli,"SELECT nom_q FROM quartiers ");

        while ( $row = mysqli_fetch_array($result)) {
            echo '<option value= "'.$row['nom_q'].'" >'.$row['nom_q'].'</option>';
        }
    }
?>
