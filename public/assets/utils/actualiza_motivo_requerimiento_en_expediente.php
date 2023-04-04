<?php
require_once 'conectar_a_bbdd.php';
$textoMotivoReq = mysqli_real_escape_string($conn, $_POST["textoMotivoReq"]);
$query = "UPDATE pindust_expediente SET motivoRequerimiento = '" . $textoMotivoReq . "' WHERE  id = " . $_POST["id"];
/* echo $query; */
$result = mysqli_query($conn, $query);
mysqli_close($conn);
echo $result;
?>