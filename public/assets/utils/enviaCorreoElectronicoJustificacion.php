<?php
//include ("PHPMailer_5.2.0/class.phpmailer.php");
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/rest_api_firma/PHPMailer_5.2.0/class.phpmailer.php';
require_once 'conectar_a_bbdd.php';
$query = "SELECT email_rep, empresa, nif, tipo_tramite, convocatoria FROM pindust_expediente WHERE  id = " . $_POST["id"];

//echo "#".$query."#";

$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
       $correoDestino = $row["email_rep"];
       $solicitante = $row["empresa"];
       $nif = $row["nif"];
       $tipoTramite = $row["tipo_tramite"];
       $convocatoria = $row["convocatoria"];
    }
} else {
    echo "0";
}

$mail = new PHPMailer();
// set mailer to use SMTP
$mail->IsSMTP();

// As this email.php script lives on the same server as our email server
// we are setting the HOST to localhost
//$mail->SMTPSecure = 'tls';
$mail->Host = "localhost";  // specify main and backup server
$mail->CharSet = 'UTF-8';
$mail->XMailer = 'ADR Balears';
$mail->SMTPAuth = true;     // turn on SMTP authentication
// When sending email using PHPMailer, you need to send from a valid email address
// In this case, we setup a test email account with the following credentials:
// email: send_from_PHPMailer@bradm.inmotiontesting.com
// pass: password
$mail->Username = "tramits@tramits.idi.es";  // SMTP username
$mail->Password = "Lvsy2r7[4,4}"; // SMTP password
$mail->Port = 587; //el puerto smtp
$mail->SMTPDebug = 0;
$mail->From = "tramits@tramits.idi.es";
$mail->FromName = "IDI";
// Lo que verá del remitente el destinatario
$mail->SetFrom("noreply@tramits.idi.es","IDI");
// La dirección a la que contestará el destinatario
$mail->AddReplyTo("response@tramits.idi.es","IDI"); 
// Con copia oculta
$mail->AddBCC("ignacio.llado@idi.es", "Servei de Politica Indústrial");
// El destinatario.
$mail->AddAddress($correoDestino, $correoDestino);
$mail->WordWrap = 50;
// set email format to HTML
$mail->IsHTML(true);

$mail->CharSet = 'UTF-8'; 
$mail->Subject = "Justificar xecs de consultoria Illes Balears - IDI";
$mensajeLayout = file_get_contents('contents-justificacion.html');
$mensajeLayout = str_replace("%USUARIOIDI%", $solicitante, $mensajeLayout);
$mensajeLayout = str_replace("%USUARIOMAIL%", $correoDestino, $mensajeLayout);
$mensajeLayout = str_replace("%USUARIOPHONE%", $contactPhone, $mensajeLayout);
$mensajeLayout = str_replace("%USUARIOASUNTO%", $asunto, $mensajeLayout);
$mensajeLayout = str_replace("%USUARIOMENSAJE%", $mensaje, $mensajeLayout);

$mail->msgHTML( $mensajeLayout , __DIR__);

//Replace the plain text body with one created manually
$mail->AltBody = $mensajeLayout;

if(!$mail->Send())
{
	$result = "Message could not be sent.";
	$result .= "Mailer Error: " . $mail->ErrorInfo;
	$mail->ClearAddresses();
	$mail->ClearAttachments(); 
}
else 
{
	$result = "<strong>S'ha enviat el formulari de justificació a la adreça de notificació: " .$correoDestino."</strong>";
}

echo $result;
?>