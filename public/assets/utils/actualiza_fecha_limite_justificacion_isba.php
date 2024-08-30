<?php
require_once 'conectar_a_bbdd.php';
$url =  $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$items = parse_url( $url);
$nuevosParametros = explode  ("/", $items['query']);

$query = "UPDATE pindust_expediente SET fecha_notificacion_resolucion = '" . $nuevosParametros[0] ."', fecha_limite_justificacion = '". $nuevosParametros[1] . "' WHERE  id = " . $nuevosParametros[2];
// echo $query;
$result = mysqli_query($conn, $query);
echo $result;
mysqli_close($conn);

?>