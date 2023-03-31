<?php
require_once 'conectar_a_bbdd.php';

$url =  $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$items = parse_url( $url);
$nuevosParametros = explode  ("/", $items['query']);

$sql = "UPDATE pindust_expediente SET ordenDePago = '" . $nuevosParametros[0] ."' WHERE  id = " . $nuevosParametros[1];

$result = mysqli_query($conn, $sql);
echo $result;
mysqli_close($conn);

?>