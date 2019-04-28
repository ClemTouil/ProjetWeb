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

$quartiers = mysqli_query($mysqli, "SELECT nom_q,shape_q FROM quartiers");
$bornes = mysqli_query($mysqli, "SELECT latitude,longitude,site FROM borneswifi");


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
      mysqli_query($mysqli, "UPDATE `borneswifi` SET `quartier` = '".$qrt['nom_q']."' WHERE `latitude` = '".$point[0]."' AND `longitude` = '".$point[1]."'");
    }
  }

  $liste_bornes = json_encode($brn_inside_qrt,JSON_UNESCAPED_UNICODE);
  mysqli_query($mysqli, "UPDATE `quartiers` SET `liste_b` = '".$liste_bornes."' WHERE `nom_q` = '".$qrt['nom_q']."'");
}
?>
