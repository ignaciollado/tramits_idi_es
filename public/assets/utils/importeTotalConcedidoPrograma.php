<?php
 $totalConcedido = 0;
require_once 'conectar_a_bbdd.php';
$url =  $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$items = parse_url( $url);
$itemsArray = explode  ("/", $items['query']);

$convocatoria = str_replace("%22", "'", $itemsArray[0]);
$tipoTramite = str_replace("%22", "'", $itemsArray[1]);
$tipoTramite = str_replace("%20", " ", $tipoTramite);
$query = 'SELECT SUM(importeAyuda) AS importeconcedido FROM pindust_expediente WHERE (situacion="Finalizado") AND '.$tipoTramite.' AND '.$convocatoria;
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
       $totalConcedido = $row["importeconcedido"];
    }
}
if (is_null($totalConcedido)){$totalConcedido=0;}
echo $totalConcedido;
mysqli_close($conn);
?>