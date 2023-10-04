<?php
require_once 'conectar_a_bbdd.php';

$id = mysqli_real_escape_string($conn, $_POST["id"]);

$empresa = mysqli_real_escape_string($conn, $_POST["empresa"]);
$empresa_consultor = mysqli_real_escape_string($conn, $_POST["empresa_consultor"]);
$nif = mysqli_real_escape_string($conn, $_POST["nif"]);
$telefono_rep = mysqli_real_escape_string($conn, $_POST["telefono_rep"]);
$email_rep = mysqli_real_escape_string($conn, $_POST["email_rep"]);
$nom_consultor = mysqli_real_escape_string($conn, $_POST["nom_consultor"]);
$mail_consultor = mysqli_real_escape_string($conn, $_POST["mail_consultor"]);
$tel_consultor = mysqli_real_escape_string($conn, $_POST["tel_consultor"]);
$tecnicoAsignado = mysqli_real_escape_string($conn, $_POST["tecnicoAsignado"]);
$nombre_rep = mysqli_real_escape_string($conn, $_POST["nombre_rep"]);
$nif_rep = mysqli_real_escape_string($conn, $_POST["nif_rep"]);
$situacion_exped = mysqli_real_escape_string($conn, $_POST["situacion_exped"]);
$importeAyuda = mysqli_real_escape_string($conn, $_POST["importeAyuda"]);
$porcentajeConcedido = mysqli_real_escape_string($conn, $_POST["porcentajeConcedido"]);
$cc_datos_bancarios = mysqli_real_escape_string($conn, $_POST["cc_datos_bancarios"]);
$ordenDePago = mysqli_real_escape_string($conn, $_POST["ordenDePago"]);
$fechaEnvioAdministracion = mysqli_real_escape_string($conn, $_POST["fechaEnvioAdministracion"]);
$fecha_de_pago = mysqli_real_escape_string($conn, $_POST["fecha_de_pago"]);

$query = "UPDATE pindust_expediente 
    SET  
    empresa = '" . mb_strtoupper($empresa) . "',
    empresa_consultor = '" . mb_strtoupper($empresa_consultor) . "',
    nif = '" . mb_strtoupper($nif) . "',
    telefono_rep  = '" . $telefono_rep . "',
    email_rep = '" . $email_rep . "',
    nom_consultor = '" . mb_strtoupper($nom_consultor) . "',
    mail_consultor = '" . $mail_consultor . "',
    tel_consultor = '" . $tel_consultor . "',
    tecnicoAsignado = '" . mb_strtoupper($tecnicoAsignado) . "',
    nombre_rep = '" . mb_strtoupper($nombre_rep) . "',
    nif_rep = '" . mb_strtoupper($nif_rep) . "',
    situacion = '" . $situacion_exped . "',
    importeAyuda = '" . $importeAyuda . "',
    porcentajeConcedido = '" . $porcentajeConcedido . "',
    cc_datos_bancarios = '" . $cc_datos_bancarios . "',
    ordenDePago = '" . $ordenDePago . "',
    fechaEnvioAdministracion = '" . $fechaEnvioAdministracion . "',
    fecha_de_pago = '" . $fecha_de_pago . "'

    WHERE  id = " . $id;
$result = mysqli_query($conn, $query);
//echo $query;
mysqli_close($conn);
echo $result;

?>