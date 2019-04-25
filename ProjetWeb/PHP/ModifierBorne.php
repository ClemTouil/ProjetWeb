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

    if(mysqli_query($mysqli,"UPDATE borneswifi SET dispo = '".$_POST['dispo']."' WHERE adresse = '".$_POST['adresse']."'")){
      echo "success";
    };
  }
  mysqli_close($mysqli);
?>
