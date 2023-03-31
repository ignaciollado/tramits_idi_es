<?php
require_once 'conectar_a_bbdd.php';
		 
$query = "DELETE FROM pindust_mejora_solicitud WHERE id = " . $_POST["id"];
$result = mysqli_query($conn, $query);
mysqli_close($conn);
echo $result;

?>