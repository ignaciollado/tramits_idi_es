<?php
require_once 'conectar_a_bbdd.php';

$url =  $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$items = parse_url( $url);
$itemsArray = explode  ("/", $items['query']);
$totalAyuda = 0;

$convocatoria = str_replace("%22", "'", $itemsArray[0]);
$tipoTramite = str_replace("%22", "'", $itemsArray[1]);
$tipoTramite = str_replace("%20", " ", $tipoTramite);
$query = 'SELECT * FROM pindust_expediente WHERE (situacion="Finalizado") AND '.$tipoTramite.' AND '.$convocatoria;
/* echo $query; */
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
       /* $totalAyuda += $row["importeAyuda"] * ($row["porcentajeConcedido"]/100); */
       $totalAyuda += $row["importeAyuda"];
    }
}

echo mysqli_num_rows($result);
mysqli_close($conn);
?>