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

    if( mysqli_query($mysqli,
      "INSERT INTO
        bornesWifi (latitude, longitude,
                    adresse, quartier,
                    site, zone, nom_c,
                     annee_ins, dispo)

      VALUES ('".$_POST['lat']."','".$_POST['long']."',
              '".$_POST['adresse']."','".$_POST['quartier']."',
              '".$_POST['namebor']."','".$_POST['emission']."',
              '".$_POST['nameco']."','".$_POST['annee']."',
              '".$_POST['dispo']."')")
      )
    {
      echo "success";
    }
  }
  mysqli_close($mysqli);
?>
