<?php
require_once 'conectar_a_bbdd.php';
$textoMotivoInforme = mysqli_real_escape_string($conn, $_POST["textoMotivoInforme"]);
$propuestaTecnicoSobreSubsanacion = mysqli_real_escape_string($conn, $_POST["propuestaTecnicoSobreSubsanacion"]);

$query = "UPDATE pindust_expediente SET motivoSobreSubsanacion = '" . $textoMotivoInforme ."', 
propuestaTecnicoSobreSubsanacion = '" . $propuestaTecnicoSobreSubsanacion . "' WHERE  id = " . $_POST["id"];

$result = mysqli_query($conn, $query);
//mysqli_close($conn);
echo $result;
?>