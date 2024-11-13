<?php
 $totalExpedientes = 0;
require_once 'conectar_a_bbdd.php';
$url =  $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$items = parse_url( $url);
$itemsArray = explode("/", $items['query']);

$tipo_tramite = $itemsArray[0];
$tipo_tramite = str_replace("%27%27", "'", $tipo_tramite);

$query = 'SELECT count(id) AS totalExpedientes FROM pindust_expediente WHERE ' .$tipo_tramite;
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
       $totalExpedientes = $row["totalExpedientes"];
    }
}
if (is_null($totalExpedientes)){$totalExpedientes=0;}
echo $totalExpedientes;
mysqli_close($conn);
?>