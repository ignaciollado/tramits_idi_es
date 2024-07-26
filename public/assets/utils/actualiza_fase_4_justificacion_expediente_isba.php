<?php
require_once 'conectar_a_bbdd.php';

$id = mysqli_real_escape_string($conn, $_POST["id"]); 
$fecha_res_liquidacion = mysqli_real_escape_string($conn, $_POST["fecha_res_liquidacion"]);
$fecha_limite_justificacion = mysqli_real_escape_string($conn, $_POST["fecha_limite_justificacion"]);
$fecha_not_res_pago = mysqli_real_escape_string($conn, $_POST["fecha_not_res_pago"]);
$fecha_firma_requerimiento_justificacion = mysqli_real_escape_string($conn, $_POST["fecha_firma_requerimiento_justificacion"]);
$fecha_not_req_just = mysqli_real_escape_string($conn, $_POST["fecha_not_req_just"]);
$fecha_REC_requerimiento_justificacion = mysqli_real_escape_string($conn, $_POST["fecha_REC_requerimiento_justificacion"]);
$ref_REC_requerimiento_justificacion = mysqli_real_escape_string($conn, $_POST["ref_REC_requerimiento_justificacion"]);
$fecha_propuesta_rev = mysqli_real_escape_string($conn, $_POST["fecha_propuesta_rev"]);
$fecha_resolucion_rev = mysqli_real_escape_string($conn, $_POST["fecha_resolucion_rev"]);

/* Si hay / entonces convertir De 21/11/2021 08:00:00 a 2021-11-21 08:00:00 */
if (strpos($fecha_res_liquidacion, "/") > 0) {
    $fecha_res_liquidacion = explode(" ", $fecha_res_liquidacion);
    $hora_REC_justificacion = $fecha_res_liquidacion[1];
    $fecha_fecha_res_liquidacion = $fecha_res_liquidacion[0];
    $fecha_fecha_res_liquidacion = explode("/", $fecha_fecha_res_liquidacion);
    $fecha_res_liquidacion = $fecha_fecha_res_liquidacion[2]."-".$fecha_fecha_res_liquidacion[1]."-".$fecha_fecha_res_liquidacion[0] ." ".$hora_REC_justificacion;
}
if (strpos($fecha_REC_requerimiento_justificacion, "/") > 0) {
    $fecha_REC_requerimiento_justificacion = explode(" ", $fecha_REC_requerimiento_justificacion);
    $hora_REC_requerimiento_justificacion = $fecha_REC_requerimiento_justificacion[1];
    $fecha_fecha_REC_requerimiento_justificacion = $fecha_REC_requerimiento_justificacion[0];
    $fecha_fecha_REC_requerimiento_justificacion = explode("/", $fecha_fecha_REC_requerimiento_justificacion);
    $fecha_REC_requerimiento_justificacion = $fecha_fecha_REC_requerimiento_justificacion[2]."-".$fecha_fecha_REC_requerimiento_justificacion[1]."-".$fecha_fecha_REC_requerimiento_justificacion[0] ." ".$hora_REC_requerimiento_justificacion;
}

if ( strlen($fecha_limite_justificacion) != 0) {
    $fecha_limite_justificacion = date_format(date_create($fecha_limite_justificacion), "Y-m-d H:i:s");
} else {
    $fecha_limite_justificacion = "";
}

if ( strlen($fecha_REC_requerimiento_justificacion) != 0) {
    $date_REC_requerimiento_justificacion = date_format(date_create($fecha_REC_requerimiento_justificacion), "Y-m-d H:i:s");
} else {
    $date_REC_requerimiento_justificacion = "";
}

if ( (strlen($date_REC_requerimiento_justificacion) != 0) && ($date_REC_requerimiento_justificacion > $fecha_completado)) {
    $fecha_completado = $date_REC_requerimiento_justificacion;
} elseif ( (strlen($date_REC_justificacion) != 0)  && ($date_REC_justificacion > $fecha_completado)) {
    $fecha_completado = $date_REC_justificacion;
}

$query = "UPDATE pindust_expediente 
    SET  
    fecha_res_liquidacion = '" . $fecha_res_liquidacion ."',
    fecha_limite_justificacion = '" . mb_strtoupper($fecha_limite_justificacion) ."',
    fecha_not_res_pago  = '" . $fecha_not_res_pago  ."',
    fecha_firma_requerimiento_justificacion = '" . $fecha_firma_requerimiento_justificacion ."',
    fecha_not_req_just = '" . $fecha_not_req_just ."',
    fecha_REC_requerimiento_justificacion = '" . $date_REC_requerimiento_justificacion ."',
    ref_REC_requerimiento_justificacion = '" . mb_strtoupper($ref_REC_requerimiento_justificacion) ."',
    fecha_propuesta_rev = '" . $fecha_propuesta_rev . "',
    fecha_resolucion_rev = '" . $fecha_resolucion_rev . "' 
    WHERE  id = " . $id;

$result = mysqli_query($conn, $query);
mysqli_close($conn);
echo $result;

?>