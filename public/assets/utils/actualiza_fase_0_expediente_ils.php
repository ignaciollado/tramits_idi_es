<?php
require_once 'conectar_a_bbdd.php';

$id = mysqli_real_escape_string($conn, $_POST["id"]);

$empresa = mysqli_real_escape_string($conn, $_POST["empresa"]);
$publicar_en_web = mysqli_real_escape_string($conn, $_POST["publicar_en_web"]);
$telefono_rep = mysqli_real_escape_string($conn, $_POST["telefono_rep"]);
$email_rep = mysqli_real_escape_string($conn, $_POST["email_rep"]);
$nombre_rep = mysqli_real_escape_string($conn, $_POST["nombre_rep"]);
$nif_rep = mysqli_real_escape_string($conn, $_POST["nif_rep"]);
$tecnicoAsignado = mysqli_real_escape_string($conn, $_POST["tecnicoAsignado"]);
$situacion_exped = mysqli_real_escape_string($conn, $_POST["situacion_exped"]);
$sitio_web_empresa = mysqli_real_escape_string($conn, $_POST["sitio_web_empresa"]);

$query = "UPDATE pindust_expediente 
    SET  
    empresa = '" . mb_strtoupper($empresa) . "',
    publicar_en_web = " . $publicar_en_web . ",
    telefono_rep  = '" . $telefono_rep . "',
    email_rep = '" . $email_rep . "',
    nombre_rep = '" . mb_strtoupper($nombre_rep) . "',
    nif_rep = '" . mb_strtoupper($nif_rep) . "',
    tecnicoAsignado = '" . mb_strtoupper($tecnicoAsignado) . "',
    situacion = '" . $situacion_exped . "',
    sitio_web_empresa = '" . $sitio_web_empresa . "'

    WHERE  id = " . $id;
$result = mysqli_query($conn, $query);
//echo $query;
mysqli_close($conn);
echo $result;

?>