<?php
 $totalExpedientes = 0;
require_once 'conectar_a_bbdd.php';
$url =  $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$items = parse_url( $url);
$itemsArray = explode  ("/", $items['query']);

$convocatoria = str_replace("%22", "'", $itemsArray[0]);
$tipoTramite = str_replace("%22", "'", $itemsArray[1]);
$tipoTramite = str_replace("%20", " ", $tipoTramite);
$situacion = str_replace("%22", "'", $itemsArray[2]);

if ($tipoTramite == "tipo_tramite='ILS'") {
    $query = 'SELECT count(id) AS totalExpedientes FROM pindust_expediente WHERE ' .$situacion. ' AND '.$tipoTramite;
} else {
    $query = 'SELECT count(id) AS totalExpedientes FROM pindust_expediente WHERE ' .$situacion. ' AND '.$tipoTramite.' AND '.$convocatoria;
}
$result = mysqli_query($conn, $query);
/* echo $query; */
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
       $totalExpedientes = $row["totalExpedientes"];
    }
}
if (is_null($totalExpedientes)){$totalExpedientes=0;}
echo $totalExpedientes;
mysqli_close($conn);
?>