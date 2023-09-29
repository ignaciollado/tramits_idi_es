<?php
require_once 'conectar_a_bbdd.php';

$query = "SELECT * FROM pindust_documentos WHERE id = " . $_POST["id"];
$result = mysqli_query($conn, $query);
	if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
               $filename = $row["name"];
			   $path = $row["created_at"];
            }
	} else {
        echo "0 results";
    }
		 
$query = "DELETE FROM pindust_documentos WHERE id = " . $_POST["id"];
echo $query;
$result = mysqli_query($conn, $query);
mysqli_close($conn);
echo $result;
return unlink ( $path.$filename );

?>