<?php
//include ("PHPMailer_5.2.0/class.phpmailer.php");
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/rest_api_firma/PHPMailer_5.2.0/class.phpmailer.php';
/* require_once 'conectar_a_bbdd.php';
$query = "SELECT email_rep, empresa, nif, tipo_tramite, convocatoria FROM pindust_expediente WHERE  id = " . $_POST["id"]; */

$url =  $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$items = parse_url( $url);
$nuevosParametros = explode  ("/", $items['query']);


$correoDestino = urldecode($nuevosParametros[0]);
$solicitante = urldecode($nuevosParametros[1]);
$contactPhone = urldecode($nuevosParametros[2]);
$asunto = urldecode($nuevosParametros[3]);
$mensaje = urldecode($nuevosParametros[4]);

$mail = new PHPMailer();
// set mailer to use SMTP
$mail->IsSMTP();

// As this email.php script lives on the same server as our email server
// we are setting the HOST to localhost
$mail->SMTPSecure = 'tls';
$mail->Host = "smtp.gmail.com";  // specify main and backup server
$mail->CharSet = 'UTF-8';  // para la correcta codificación de acentos y otros caracteres extendidos
$mail->XMailer = 'idi.es';
$mail->SMTPAuth = true;     // turn on SMTP authentication
// When sending email using PHPMailer, you need to send from a valid email address
// In this case, we setup a test email account with the following credentials:
// email: send_from_PHPMailer@bradm.inmotiontesting.com
// pass: password
$mail->Username = "tramits@tramits.idi.es";  // SMTP username
$mail->Password = "yVcgQ9$8#32="; // SMTP password
$mail->Port = 587; //el puerto smtp
$mail->SMTPDebug = 0;
$mail->From = "tramits@tramits.idi.es";
$mail->FromName = "IDI";
// Lo que verá del remitente el destinatario
$mail->SetFrom("noreply@tramits.idi.es","IDI");
// La dirección a la que contestará el destinatario
$mail->AddReplyTo("response@tramits.idi.es","IDI"); 

// Con copia oculta
$mail->AddBCC("info@idi.es", "Servei de comucicació de l'IDI");

// El destinatario.
$mail->AddAddress($correoDestino, $correoDestino);
$mail->WordWrap = 50;

// set email format to HTML
$mail->IsHTML(true);

$mail->Subject = "Contacte des-de la web - IDI";
$mensajeLayout = file_get_contents('contents.html');
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
	$result = "<strong>Missatge enviat correctament a la adreça: " .$correoDestino."</strong>";
}


// mysqli_close($conn);
return $result;
?>