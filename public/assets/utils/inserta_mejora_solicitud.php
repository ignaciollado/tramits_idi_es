<?php
require_once 'conectar_a_bbdd.php';

$url =  $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$items = parse_url( $url);
$nuevosParametros = explode  ("/", $items['query']);
$nuevosParametros = explode  ("&", $nuevosParametros[0]);

$idSol = explode  ("=", $nuevosParametros[0])[1];
$fechaRecMejora = str_replace("T"," ",explode  ("=", $nuevosParametros[1])[1]);
$refRecMejora = explode  ("=", $nuevosParametros[2])[1];

$sql = 'INSERT INTO pindust_mejora_solicitud (id_sol, fecha_rec_mejora, ref_rec_mejora)
VALUES ('.$idSol.',"'.$fechaRecMejora.'","'.strtoupper($refRecMejora).'")';
$result = mysqli_query($conn, $sql);

if ($result) {
  $sql = 'UPDATE pindust_expediente SET fecha_completado="'.$fechaRecMejora.'" WHERE id =' .$idSol;
  $result = mysqli_query($conn, $sql);
  echo $result;
}

mysqli_close($conn);

?>