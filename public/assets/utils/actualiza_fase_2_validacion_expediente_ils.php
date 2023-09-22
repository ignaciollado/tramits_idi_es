<?php
require_once 'conectar_a_bbdd.php';

$id = mysqli_real_escape_string($conn, $_POST["id"]); 
$fecha_infor_fav = mysqli_real_escape_string($conn, $_POST["fecha_infor_fav"]);
$fecha_infor_desf = mysqli_real_escape_string($conn, $_POST["fecha_infor_desf"]);
$fecha_resolucion = mysqli_real_escape_string($conn, $_POST["fecha_resolucion"]);
$fecha_notificacion_resolucion = mysqli_real_escape_string($conn, $_POST["fecha_notificacion_resolucion"]);

$query = "UPDATE pindust_expediente SET fecha_infor_fav = '" . $fecha_infor_fav ."', fecha_infor_desf = '" . $fecha_infor_desf ."',
fecha_resolucion = '" . $fecha_resolucion ."', fecha_notificacion_resolucion = '" . $fecha_notificacion_resolucion ."' WHERE  id = " . $id;

$result = mysqli_query($conn, $query);
echo $result;

mysqli_close($conn);
?>