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
		//echo '"HELLO"';
		$q = $_GET['quartier'];
        $result = mysqli_query($mysqli,"SELECT nom_q, population, liste_b FROM quartiers WHERE nom_q ='$q'");
        while ( $row = mysqli_fetch_array($result)) {
			//Generer la variable avec nom du quartier 
			$quartier = $row['nom_q']; // pour l'adaptation du nom de l'url
			$comtpe = json_decode($row['liste_b']);
			$cpt = count($comtpe);
			echo $quartier.','.$row['population'];
        }
    }
?>