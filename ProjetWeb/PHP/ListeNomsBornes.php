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

      $term = $_GET['term'];
      $result = mysqli_query($mysqli,"SELECT site FROM borneswifi WHERE site LIKE '$term%' ");

      $array = array();
      while ($row = mysqli_fetch_array($result)) {
          array_push($array, $row['site']);
      }
      echo json_encode($array);
    }
    mysqli_close($mysqli);
?>