<?php

    header( 'content-type: text/html; charset=utf-8' );

    // Fonction pour géolocaliser les bornes

    class pointLocationClass {

        function pointLocation() {
        }

        function pointInPolygon($point, $polygon) {

            // Transform string coordinates into arrays with x and y values
            $point = $this->pointStringToCoordinates($point);
            $vertices = array();
            foreach ($polygon as $vertex) {
                $vertices[] = $this->pointStringToCoordinates($vertex);
            }

            // Check if the point is inside the polygon or on the boundary
            $intersections = 0;
            $vertices_count = count($vertices);

            for ($i=1; $i < $vertices_count; $i++) {
                $vertex1 = $vertices[$i-1];
                $vertex2 = $vertices[$i];
                if ($point['y'] > min($vertex1['y'], $vertex2['y']) and $point['y'] <= max($vertex1['y'], $vertex2['y']) and $point['x'] <= max($vertex1['x'], $vertex2['x']) and $vertex1['y'] != $vertex2['y']) {
                    $xinters = (($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x']);
                    if ($vertex1['x'] == $vertex2['x'] || $point['x'] <= $xinters) {
                        $intersections++;
                    }
                }
            }
            // If the number of edges we passed through is odd, then it's in the polygon.
            $cpt_inside = array();
            if ($intersections % 2 != 0) {
                return "inside";
            }
        }

        function pointStringToCoordinates($pointString) {
            $coordinates = explode(",", $pointString);
            return array("x" => $coordinates[0], "y" => $coordinates[1]);
        }

    }

    // Fin de la foncion : pointInPolygon

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
          nom_q varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
          population double NOT NULL,
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
          site varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
          zone varchar(50) NOT NULL,
          nom_c varchar(50) NOT NULL,
          annee_ins int(4) NOT NULL,
          dispo varchar(50) NOT NULL,
          PRIMARY KEY(`longitude`,`latitude`)
        )";

        if (mysqli_query($mysqli2, $creat_query) && mysqli_query($mysqli2, $creat_query2)) {
            echo "Base de données rafréchie avec succès ! ";
            mysqli_query($mysqli2,"ALTER TABLE `projet_web`.`quartiers`DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci");
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

        // 2-3 Peuplement de la base de données ...
        foreach($data_array_population as $row) {

          $array_to_string = $row['fields']['geo_shape']['coordinates'][0];

          foreach($array_to_string as &$row2) {
              $row2 = array_reverse($row2);
          }

          $array_to_string = json_encode($array_to_string);

          $insert_query = "INSERT INTO `quartiers`(`nom_q`, `population`, `shape_q` , `liste_b`)
                           VALUES ('".$row['fields']['libgq']."',
                                   '".$row['fields']['p11_pop']."',
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

        // Affectation des bornes par quartiers :
        $quartiers = mysqli_query($mysqli2, "SELECT nom_q,shape_q FROM quartiers");
        $bornes = mysqli_query($mysqli2, "SELECT latitude,longitude,site FROM borneswifi");


        $array_points = array();
        while ($points = mysqli_fetch_array($bornes, MYSQLI_ASSOC)) {
            $array_points[] = implode(",",$points);
        }

        $pointLocation = new pointLocationClass();

        while ($qrt = mysqli_fetch_array($quartiers, MYSQLI_ASSOC)) {

          $brn_inside_qrt = array();
          $replace_array = array("["," ","]"); // tableau des caractères à remplacer
          $poly_array= str_replace("], ","];",$qrt['shape_q']); // je remplace tout les , en ;
          $polygon = preg_split("/[;]/",str_replace($replace_array,"",$poly_array));

          foreach($array_points as $key => $point) {
            if($pointLocation->pointInPolygon($point, $polygon) == "inside"){
              $point = explode(",",$point);
              $brn_inside_qrt[] = $point[2];
              mysqli_query($mysqli2, "UPDATE `borneswifi` SET `quartier` = '".$qrt['nom_q']."' WHERE `latitude` = '".$point[0]."' AND `longitude` = '".$point[1]."'");
            }
          }

          $liste_bornes = json_encode($brn_inside_qrt,JSON_UNESCAPED_UNICODE);
          mysqli_query($mysqli2, "UPDATE `quartiers` SET `liste_b` = '".$liste_bornes."' WHERE `nom_q` = '".$qrt['nom_q']."'");
        }
    }
    mysqli_close($mysqli2);
?>
