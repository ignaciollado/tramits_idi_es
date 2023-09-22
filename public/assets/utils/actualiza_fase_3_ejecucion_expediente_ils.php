<?php
require_once 'conectar_a_bbdd.php';

$id = mysqli_real_escape_string($conn, $_POST["id"]);
$fecha_adhesion_ils = mysqli_real_escape_string($conn, $_POST["fecha_adhesion_ils"]);
$fecha_seguimiento_adhesion_ils = mysqli_real_escape_string($conn, $_POST["fecha_seguimiento_adhesion_ils"]);
$fecha_limite_presentacion = mysqli_real_escape_string($conn, $_POST["fecha_limite_presentacion"]);
$fecha_rec_informe_seguimiento = mysqli_real_escape_string($conn, $_POST["fecha_rec_informe_seguimiento"]);
$ref_REC_informe_seguimiento = mysqli_real_escape_string($conn, $_POST["ref_REC_informe_seguimiento"]);

$query = "UPDATE pindust_expediente 
    SET  
    fecha_adhesion_ils = '" . $fecha_adhesion_ils ."', 
    fecha_seguimiento_adhesion_ils = '" . $fecha_seguimiento_adhesion_ils ."', 
    fecha_limite_presentacion = '" . $fecha_limite_presentacion ."', 
    fecha_rec_informe_seguimiento = '" . $fecha_rec_informe_seguimiento ."', 
    ref_REC_informe_seguimiento = '" . $ref_REC_informe_seguimiento ."'

    WHERE  id = " . $id;
/* echo $query; */
$result = mysqli_query($conn, $query);
mysqli_close($conn);
echo $result;

?>