<?php
require_once 'conectar_a_bbdd.php';

$id = mysqli_real_escape_string($conn, $_POST["id"]);
$fecha_solicitud = mysqli_real_escape_string($conn, $_POST["fecha_solicitud"]);
$fecha_completado = mysqli_real_escape_string($conn, $_POST["fecha_completado"]);
$fecha_REC = mysqli_real_escape_string($conn, $_POST["fecha_REC"]);
$ref_REC = mysqli_real_escape_string($conn, $_POST["ref_REC"]);
$fecha_REC_enmienda = mysqli_real_escape_string($conn, $_POST["fecha_REC_enmienda"]);
$ref_REC_enmienda = mysqli_real_escape_string($conn, $_POST["ref_REC_enmienda"]);
$fecha_requerimiento = mysqli_real_escape_string($conn, $_POST["fecha_requerimiento"]);
$fecha_requerimiento_notif = mysqli_real_escape_string($conn, $_POST["fecha_requerimiento_notif"]);
$fecha_maxima_enmienda  = mysqli_real_escape_string($conn, $_POST["fecha_maxima_enmienda"]);

/* Si hay / entonces convertir De 21/11/2021 08:00:00 a 2021-11-21 08:00:00 */

if (strpos($fecha_REC, "/") > 0) {
    $fecha_REC = explode(" ", $fecha_REC);
    $hora_REC = $fecha_REC[1];
    $fecha_fecha_REC = $fecha_REC[0];
    $fecha_fecha_REC = explode("/", $fecha_fecha_REC);
    $fecha_REC = $fecha_fecha_REC[2]."-".$fecha_fecha_REC[1]."-".$fecha_fecha_REC[0] ." ".$hora_REC;
}
if (strpos($fecha_REC_enmienda, "/") > 0) {
    $fecha_REC_enmienda = explode(" ", $fecha_REC_enmienda);
    $hora_REC_enmienda = $fecha_REC_enmienda[1];
    $fecha_fecha_REC_enmienda = $fecha_REC_enmienda[0];
    $fecha_fecha_REC_enmienda = explode("/", $fecha_fecha_REC_enmienda);
    $fecha_REC_enmienda = $fecha_fecha_REC_enmienda[2]."-".$fecha_fecha_REC_enmienda[1]."-".$fecha_fecha_REC_enmienda[0] ." ".$hora_REC_enmienda;
}

if ( strlen($fecha_REC) != 0) {
    $date_REC = date_format(date_create($fecha_REC), "Y-m-d H:i:s");
} else {
    $date_REC = "";
}

if ( strlen($fecha_REC_enmienda) != 0) {
    $date_REC_enmienda = date_format(date_create($fecha_REC_enmienda), "Y-m-d H:i:s");
} else {
    $date_REC_enmienda = "";
}

if ( strlen($fecha_maxima_enmienda) != 0) {
    $date_maxima_enmienda = date_format(date_create($fecha_maxima_enmienda), "Y-m-d H:i:s");
} else {
    $date_maxima_enmienda = "";
}

if ( strlen($date_REC_enmienda) != 0 && $date_REC_enmienda > $fecha_completado) {
    $fecha_completado = $date_REC_enmienda;
} elseif ( strlen($date_REC) != 0  && $date_REC > $fecha_completado) {
    $fecha_completado = $date_REC;
}

$query = "UPDATE pindust_expediente 
    SET  
    fecha_REC = '" .$date_REC ."',
    ref_REC = '" . mb_strtoupper($ref_REC) ."',
    fecha_REC_enmienda = '" . $date_REC_enmienda ."',
    ref_REC_enmienda = '" . mb_strtoupper($ref_REC_enmienda) ."',
    fecha_completado = '" . $fecha_completado ."',
    fecha_requerimiento = '" . $fecha_requerimiento ."',
    fecha_requerimiento_notif = '" . $fecha_requerimiento_notif ."',
    fecha_maxima_enmienda = '" . $date_maxima_enmienda ."'
    WHERE  id = " . $id;

/* echo $query;  */
$result = mysqli_query($conn, $query);
mysqli_close($conn);
echo $result;
?>