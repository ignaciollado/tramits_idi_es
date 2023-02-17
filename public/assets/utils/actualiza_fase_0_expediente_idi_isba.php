<?php
require_once 'conectar_a_bbdd.php';

$id = mysqli_real_escape_string($conn, $_POST["id"]);

$telefono_rep = mysqli_real_escape_string($conn, $_POST["telefono_rep"]);
$email_rep = mysqli_real_escape_string($conn, $_POST["email_rep"]);
$tecnicoAsignado = mysqli_real_escape_string($conn, $_POST["tecnicoAsignado"]);
$situacion_exped = mysqli_real_escape_string($conn, $_POST["situacion_exped"]);

$query = "UPDATE pindust_expediente 
    SET  
    telefono_rep  = '" . $telefono_rep . "',
    email_rep = '" . $email_rep . "',
    tecnicoAsignado = '" . mb_strtoupper($tecnicoAsignado) . "',
    situacion = '" . $situacion_exped . "'

    WHERE  id = " . $id;
$result = mysqli_query($conn, $query);
//echo $query;
mysqli_close($conn);
echo $result;

?>