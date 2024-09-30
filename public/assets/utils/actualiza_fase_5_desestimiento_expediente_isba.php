<?php
require_once 'conectar_a_bbdd.php';

$id = mysqli_real_escape_string($conn, $_POST["id"]); 
$fecha_REC_desestimiento = mysqli_real_escape_string($conn, $_POST["fecha_REC_desestimiento"]);
$ref_REC_desestimiento = mysqli_real_escape_string($conn, $_POST["ref_REC_desestimiento"]);
$fecha_firma_resolucion_desestimiento = mysqli_real_escape_string($conn, $_POST["fecha_firma_resolucion_desestimiento"]);
$fecha_notificacion_desestimiento = mysqli_real_escape_string($conn, $_POST["fecha_notificacion_desestimiento"]);
$fecha_propuesta_rev = mysqli_real_escape_string($conn, $_POST["fecha_propuesta_rev"]);
$fecha_resolucion_rev = mysqli_real_escape_string($conn, $_POST["fecha_resolucion_rev"]);

if (strpos($fecha_REC_desestimiento, "/") > 0) {
  $fecha_REC_desestimiento = explode(" ", $fecha_REC_desestimiento);
  $hora_REC_requerimiento_justificacion = $fecha_REC_desestimiento[1];
  $fecha_fecha_REC_desestimiento = $fecha_REC_desestimiento[0];
  $fecha_fecha_REC_desestimiento = explode("/", $fecha_fecha_REC_desestimiento);
  $fecha_REC_desestimiento = $fecha_fecha_REC_desestimiento[2]."-".$fecha_fecha_REC_desestimiento[1]."-".$fecha_fecha_REC_desestimiento[0] ." ".$hora_REC_requerimiento_justificacion;
}

if ( strlen($fecha_limite_justificacion) != 0) {
  $fecha_limite_justificacion = date_format(date_create($fecha_limite_justificacion), "Y-m-d H:i:s");
} else {
  $fecha_limite_justificacion = "";
}

if ( strlen($fecha_REC_desestimiento) != 0) {
  $date_REC_requerimiento_justificacion = date_format(date_create($fecha_REC_desestimiento), "Y-m-d H:i:s");
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
    fecha_REC_desestimiento = '" . $date_REC_requerimiento_justificacion ."',
    ref_REC_desestimiento = '" . mb_strtoupper($ref_REC_desestimiento) ."',
    fecha_firma_resolucion_desestimiento = '" . $fecha_firma_resolucion_desestimiento . "',
    fecha_notificacion_desestimiento = '" . $fecha_notificacion_desestimiento . "',
    fecha_propuesta_rev = '" . $fecha_propuesta_rev . "',
    fecha_resolucion_rev = '" . $fecha_resolucion_rev . "' 
    WHERE  id = " . $id;

$result = mysqli_query($conn, $query);
mysqli_close($conn);
echo $result;

?>