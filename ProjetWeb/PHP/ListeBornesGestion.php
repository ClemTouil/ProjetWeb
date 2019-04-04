<?php

    if ($mysqli->connect_errno) { // Si il y'a une erreur de connexion alors :
        printf("Échec de la connexion : %s\n", $mysqli->connect_error);
        exit();
    }else { // Si la connexion se passe bien alors :

        $result = mysqli_query($mysqli,"SELECT quartier, adresse, site, nom_c, dispo, zone, annee_ins FROM borneswifi ");

        while ( $row = mysqli_fetch_array($result)) {
            echo '<tr>','<td>'.$row['quartier'].'</td>', '<td>'.$row['adresse'].'</td>', '<td>'.$row['site'].'</td>','<td>'.$row['nom_c'].'</td>','<td>'.$row['dispo'].'</td>',  '<td>'.$row['zone'].'</td>', '<td>'.$row['annee_ins'].'</td>',  '<td><a class="badge badge-pill badge-dark" href="#">Modifier</a></td>','</tr>';
        }
    }
?>						