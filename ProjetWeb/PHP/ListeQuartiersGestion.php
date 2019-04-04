<?php

    if ($mysqli->connect_errno) { // Si il y'a une erreur de connexion alors :
        printf("Échec de la connexion : %s\n", $mysqli->connect_error);
        exit();
    }else { // Si la connexion se passe bien alors :

        $result = mysqli_query($mysqli,"SELECT nom_q, population, liste_b FROM quartiers ");

        while ( $row = mysqli_fetch_array($result)) {
            echo '<tr>','<td>'.$row['nom_q'].'</td>','<td>'.$row['population'].'</td>','<td>'.$row['liste_b'].'</td>', '<td><a class="badge badge-pill badge-dark" href="#"><i class="fas fa-pencil-alt"></i></a></td>','</tr>';
        }
    }
?>
	
