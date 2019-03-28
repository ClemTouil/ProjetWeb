<?php

    define('HOSTNAME','localhost');
    define('DB_USERNAME','root');
    define('DB_PASSWORD','');

    $mysqli = new mysqli(HOSTNAME, DB_USERNAME, DB_PASSWORD);
    $nombd = "projet_web";

    if ($mysqli->connect_errno) {
        printf("Échec de la connexion : %s\n", $mysqli->connect_error);
        exit();
    }else {

        // Supression de la base de données si elle existe.
        $mysqli->query("DROP DATABASE IF EXISTS projet_web");

        // Creation de la base de données si elle n'existe pas
        $mysqli->query("CREATE DATABASE IF NOT EXISTS projet_web");

        // Connection shutdown
        mysqli_close($mysqli);
    }

    $mysqli2 = new mysqli(HOSTNAME, DB_USERNAME, DB_PASSWORD, $nombd);

    if ($mysqli2->connect_errno) {
        printf("Échec de la connexion : %s\n", $mysqli2->connect_error);
        exit();
    } else {
        // Création des tables... BORNES_WIFI, POPULATION_TLS
        $creat_query =
        " CREATE TABLE `quartiers` (
          nom_q varchar(255) NOT NULL,
          population double NOT NULL,
          code_p int(5) NOT NULL,
          shape_q json DEFAULT NULL,
          liste_b json DEFAULT NULL,
          PRIMARY KEY(`nom_q`)
        )";

        $creat_query2 =
        " CREATE TABLE `bornesWifi` (
          latitude double NOT NULL,
          longitude double NOT NULL,
          adresse varchar(50) NOT NULL,
          quartier varchar(50) NULL,
          site varchar(50) NOT NULL,
          zone varchar(50) NOT NULL,
          nom_c varchar(50) NOT NULL,
          annee_ins int(4) NOT NULL,
          dispo varchar(50) NOT NULL,
          PRIMARY KEY(`longitude`,`latitude`)
        )";

        if (mysqli_query($mysqli2, $creat_query) && mysqli_query($mysqli2, $creat_query2)) {
            echo "Base de données rafréchie avec succès ! ";
        } else {
            echo "Error lors d'implémentation de la base de donnnées ! " . mysqli_error($mysqli2);
        }

        // II- Peuplement de la base de données :

        // 2-1 Récupération des données JSON :
        $json_data_population = file_get_contents('..\BDD\population_toulouse.json');
        $json_data_bornes = file_get_contents('..\BDD\bornes_wifi.json');

        // 2-2 Tronsformation des données Json en Tableaux PHP
        $data_array_population = json_decode($json_data_population, true);
        $data_array_bornes = json_decode($json_data_bornes, true);

        //var_dump($data_array_population);

        // 2-3 Peuplement de la base de données ...
        foreach($data_array_population as $row) {

          $array_to_string = json_encode($row['fields']['geo_shape']['coordinates']);

          $insert_query = "INSERT INTO `quartiers`(`nom_q`, `population`, `code_p`, `shape_q` , `liste_b`)
                           VALUES ('".$row['fields']['libgq']."',
                                   '".$row['fields']['p11_pop']."',
                                   31000,
                                   '$array_to_string',
                                   NULL)";

          mysqli_query($mysqli2, $insert_query);
        }

        foreach($data_array_bornes as $row) {
          $insert_query2 = "INSERT INTO `borneswifi`(`latitude`, `longitude`, `adresse`, `quartier`, `site`, `zone`, `nom_c`, `annee_ins`, `dispo`)
                            VALUES ('".$row['fields']['geo_point_2d'][0]."',
                                    '".$row['fields']['geo_point_2d'][1]."',
                                    '".$row['fields']['adresse']."',
                                    NULL,
                                    '".$row['fields']['site']."',
                                    '".$row['fields']['zone_emission']."',
                                    '".$row['fields']['nom_connexion']."',
                                    '".$row['fields']['annee_installation']."',
                                    '".$row['fields']['disponibilite']."')";

          mysqli_query($mysqli2, $insert_query2);
        }
    }
?>
