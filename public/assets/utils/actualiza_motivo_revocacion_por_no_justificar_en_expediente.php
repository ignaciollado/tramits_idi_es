<?php
require_once 'conectar_a_bbdd.php';
$textoRevocacionPorNoJustificar = mysqli_real_escape_string($conn, $_POST["textoRevocacionPorNoJustificar"]);
$query = "UPDATE pindust_expediente SET motivoResolucionRevocacionPorNoJustificar = '" . $textoRevocacionPorNoJustificar . "' WHERE  id = " . $_POST["id"];
/* echo $query; */
$result = mysqli_query($conn, $query);
mysqli_close($conn);
echo $result;
?>