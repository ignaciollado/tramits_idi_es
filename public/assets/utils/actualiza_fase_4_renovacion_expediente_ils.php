<?php
require_once 'conectar_a_bbdd.php';

$id = mysqli_real_escape_string($conn, $_POST["id"]); 
$fecha_completado = mysqli_real_escape_string($conn, $_POST["fecha_completado"]);
$fecha_renovacion = mysqli_real_escape_string($conn, $_POST["fecha_renovacion"]); // Data renovació
$fecha_infor_fav_renov = mysqli_real_escape_string($conn, $_POST["fecha_infor_fav_renov"]); // Data informe favorable
$fecha_infor_desf_renov = mysqli_real_escape_string($conn, $_POST["fecha_infor_desf_renov"]); // Data informe desfavorable
$fecha_REC_enmienda_renov = mysqli_real_escape_string($conn, $_POST["fecha_REC_enmienda_renov"]); // Data REC enmienda
$fecha_REC_justificacion_renov	= mysqli_real_escape_string($conn, $_POST["fecha_REC_justificacion_renov"]); //Data REC justificació renovació
$ref_REC_justificacion_renov = mysqli_real_escape_string($conn, $_POST["ref_REC_justificacion_renov"]); // Ref REC justificació renovació
$fecha_resolucion_renov = mysqli_real_escape_string($conn, $_POST["fecha_resolucion_renov"]); // Data resolució renovació
$fecha_notificacion_renov = mysqli_real_escape_string($conn, $_POST["fecha_notificacion_renov"]); // Data notificació renovació
$fecha_res_revocacion_marca = mysqli_real_escape_string($conn, $_POST["fecha_res_revocacion_marca"]); // Data resolució revocació

/* Si hay / entonces convertir De 21/11/2021 08:00:00 a 2021-11-21 08:00:00 */
if (strpos($fecha_REC_enmienda_renov, "/") > 0) {
    $fecha_REC_enmienda_renov = explode(" ", $fecha_REC_enmienda_renov);
    $hora_REC_justificacion = $fecha_REC_enmienda_renov[1];
    $fecha_fecha_REC_justificacion = $fecha_REC_enmienda_renov[0];
    $fecha_fecha_REC_justificacion = explode("/", $fecha_fecha_REC_justificacion);
    $fecha_REC_enmienda_renov = $fecha_fecha_REC_justificacion[2]."-".$fecha_fecha_REC_justificacion[1]."-".$fecha_fecha_REC_justificacion[0] ." ".$hora_REC_justificacion;
}
if (strpos($fecha_REC_justificacion_renov, "/") > 0) {
    $fecha_REC_justificacion_renov = explode(" ", $fecha_REC_justificacion_renov);
    $hora_REC_requerimiento_justificacion = $fecha_REC_justificacion_renov[1];
    $fecha_fecha_REC_requerimiento_justificacion = $fecha_REC_justificacion_renov[0];
    $fecha_fecha_REC_requerimiento_justificacion = explode("/", $fecha_fecha_REC_requerimiento_justificacion);
    $fecha_REC_justificacion_renov = $fecha_fecha_REC_requerimiento_justificacion[2]."-".$fecha_fecha_REC_requerimiento_justificacion[1]."-".$fecha_fecha_REC_requerimiento_justificacion[0] ." ".$hora_REC_requerimiento_justificacion;
}

if ( strlen($fecha_REC_enmienda_renov) != 0) {
    $date_REC_enmienda_renov = date_format(date_create($fecha_REC_enmienda_renov), "Y-m-d H:i:s");
} else {
    $date_REC_enmienda_renov = "";
}

if ( strlen($fecha_REC_justificacion_renov) != 0) {
    $date_REC_justificacion_renov = date_format(date_create($fecha_REC_justificacion_renov), "Y-m-d H:i:s");
} else {
    $date_REC_justificacion_renov = "";
}

if ( (strlen($date_REC_justificacion_renov) != 0) && ($date_REC_justificacion_renov > $fecha_completado)) {
    $fecha_completado = $date_REC_justificacion_renov;
} elseif ( (strlen($date_REC_enmienda_renov) != 0)  && ($date_REC_enmienda_renov > $fecha_completado)) {
    $fecha_completado = $date_REC_enmienda_renov;
}

$query = "UPDATE pindust_expediente 
    SET
    fecha_completado = '" . $fecha_completado ."',
    fecha_renovacion = '" . $fecha_renovacion ."',
    fecha_infor_fav_renov = '" . $fecha_infor_fav_renov ."',
    fecha_infor_desf_renov = '" . $fecha_infor_desf_renov ."',    
    fecha_REC_enmienda_renov = '" . $date_REC_enmienda_renov ."',
    fecha_REC_justificacion_renov = '" . $date_REC_justificacion_renov ."',
    ref_REC_justificacion_renov = '" . mb_strtoupper($ref_REC_justificacion_renov) ."',
    fecha_resolucion_renov = '" . $fecha_resolucion_renov ."',
    fecha_notificacion_renov = '" . $fecha_notificacion_renov ."',
    fecha_res_revocacion_marca = '" . $fecha_res_revocacion_marca ."'

    WHERE  id = " . $id;

$result = mysqli_query($conn, $query);
mysqli_close($conn);
echo $result;

?>