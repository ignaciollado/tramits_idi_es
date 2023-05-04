<?php
require_once 'conectar_a_bbdd.php';
$textoMotivoRevocacion = mysqli_real_escape_string($conn, $_POST["textoMotivoRevocacion"]);
$query = "UPDATE pindust_expediente SET motivoResolucionRevocacionPorNoJustificar = '" . $textoMotivoRevocacion . "' WHERE  id = " . $_POST["id"];
/* echo $query; */
$result = mysqli_query($conn, $query);
mysqli_close($conn);
echo $result;
?>