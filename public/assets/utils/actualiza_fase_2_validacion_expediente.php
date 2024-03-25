<?php
require_once 'conectar_a_bbdd.php';

$id = mysqli_real_escape_string($conn, $_POST["id"]);

$fecha_infor_fav_desf = mysqli_real_escape_string($conn, $_POST["fecha_infor_fav_desf"]);
$fecha_firma_propuesta_resolucion_prov = mysqli_real_escape_string($conn, $_POST["fecha_firma_propuesta_resolucion_prov"]);
$fecha_not_propuesta_resolucion_prov = mysqli_real_escape_string($conn, $_POST["fecha_not_propuesta_resolucion_prov"]);
$fecha_firma_propuesta_resolucion_def = mysqli_real_escape_string($conn, $_POST["fecha_firma_propuesta_resolucion_def"]);
$fecha_not_propuesta_resolucion_def = mysqli_real_escape_string($conn, $_POST["fecha_not_propuesta_resolucion_def"]);
$fecha_firma_res = mysqli_real_escape_string($conn, $_POST["fecha_firma_res"]);
$fecha_notificacion_resolucion = mysqli_real_escape_string($conn, $_POST["fecha_notificacion_resolucion"]);

$query = "UPDATE pindust_expediente 
    SET  
    fecha_infor_fav_desf = '" . $fecha_infor_fav_desf ."', 
    fecha_firma_propuesta_resolucion_prov = '" . $fecha_firma_propuesta_resolucion_prov ."', 
    fecha_not_propuesta_resolucion_prov = '" . $fecha_not_propuesta_resolucion_prov ."', 
    fecha_firma_propuesta_resolucion_def = '" . $fecha_firma_propuesta_resolucion_def ."', 
    fecha_not_propuesta_resolucion_def = '" . $fecha_not_propuesta_resolucion_def ."', 
    fecha_firma_res = '" . $fecha_firma_res ."',
    fecha_notificacion_resolucion = '" . $fecha_notificacion_resolucion ."'
    WHERE  id = " . $id;

$result = mysqli_query($conn, $query);
mysqli_close($conn);
echo $result;

?>