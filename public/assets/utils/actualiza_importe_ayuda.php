<?php
require_once 'conectar_a_bbdd.php';
$url =  $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$items = parse_url( $url);
$nuevosParametros = explode  ("/", $items['query']);

$programa = str_replace("%20", " ", $nuevosParametros[0]);
$porcentajeConcedido = $nuevosParametros[1];

$query = "SELECT programa FROM pindust_configuracion WHERE  convocatoria_activa = 1";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
       $importeAyuda = $row["programa"];
    }
}
$importeAyuda = explode(',', $importeAyuda);

//------------------------------- Busco el importe de la ayuda correspondiente al programa y la convocatoria ------------------------------
foreach($importeAyuda as $x => $x_value) {  
	if ( str_replace("'","",explode("=>",$x_value)[0]) === $programa){
			$programaImporteAyuda = str_replace("'","",explode("=>",$x_value)[1]);
			break;
		}
	}

$importeAyudaConcedida = $programaImporteAyuda * ($porcentajeConcedido/100);
$query = "UPDATE pindust_expediente SET importeAyuda = '" . $importeAyudaConcedida ."', porcentajeConcedido = '". $nuevosParametros[1] . "' WHERE  id = " . $nuevosParametros[2];
$result = mysqli_query($conn, $query);
echo $importeAyudaConcedida;
mysqli_close($conn);

?>