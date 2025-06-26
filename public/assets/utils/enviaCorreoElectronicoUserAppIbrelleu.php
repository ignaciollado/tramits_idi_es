<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/rest_api_firma/PHPMailer_5.2.0/class.phpmailer.php';

$url =  $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$items = parse_url( $url);
$data = explode  ("/", $items['query']);

$correoDestino = urldecode($data[0]);
$solicitante = urldecode($data[1]);
$asunto = urldecode($data[2]);
$project = urldecode($data[3]);
$mensaje = urldecode($data[4]);
$mensaje = explode("_", $mensaje);
$domicilio = $mensaje[0];
$cpostal = $mensaje[1];
$poblacion = $mensaje[2];
$pwd = $mensaje[3];
$isla = $mensaje[4];
$perfil = $mensaje[5];

//$projectMail = "mriutord@idi.es";
//$projectMail = "mriutord@adrbalears.caib.es";
$projectMail = "illado@adrbalears.caib.es";

$mail = new PHPMailer();
$response = [];

try {
	// Configuración del servidor
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
$mail->Password = "Lvsy2r7[4,4}*1"; // SMTP password
$mail->Port = 587; //el puerto smtp
$mail->SMTPDebug = 0;
$mail->From = "tramits@tramits.idi.es";
$mail->FromName = "ADR Balears";
// Lo que verá del remitente el destinatario
$mail->SetFrom("noreply@tramits.idi.es","Ibrelleu - ADR Balears");
// La dirección a la que contestará el destinatario
$mail->AddReplyTo("response@tramits.idi.es","Ibrelleu - ADR Balears");

// El destinatario.
$mail->AddAddress($correoDestino, $correoDestino);
$mail->WordWrap = 50;

// set email format to HTML
$mail->IsHTML(true);


$mail->Subject = $asunto;
$mail->AddBCC("illado@adrbalears.caib.es", "Gestió interna ADR Balears");
//$mail->AddBCC("mriutord@adrbalears.caib.es", "Servei Ibrelleu ADR Balears");

$mensajeLayout = file_get_contents('contents-ibrelleu-user-app.html');
$mensajeLayout = str_replace("%SUBJECT%", $asunto, $mensajeLayout);
$mensajeLayout = str_replace("%NAME%", $solicitante, $mensajeLayout);
$mensajeLayout = str_replace("%USUARIO%", $correoDestino, $mensajeLayout);
$mensajeLayout = str_replace("%ADDRESS%", $domicilio, $mensajeLayout);
$mensajeLayout = str_replace("%ZIPCODE%", $cpostal, $mensajeLayout);
$mensajeLayout = str_replace("%TOWN%", $poblacion, $mensajeLayout);
$mensajeLayout = str_replace("%PWD%", $pwd, $mensajeLayout);
$mensajeLayout = str_replace("%ISLAND%", $isla, $mensajeLayout);
$mensajeLayout = str_replace("%USUARIOMAIL%", $correoDestino, $mensajeLayout);
$mensajeLayout = str_replace("%PROFILE%", $perfil, $mensajeLayout);

$mail->msgHTML( $mensajeLayout , __DIR__);

//Replace the plain text body with one created manually
$mail->AltBody = $mensajeLayout;

$mail->send();
    $response['status'] = 'success';
    $response['message'] = 'Message has been sent';
} catch (Exception $e) {
    $response['status'] = 'error';
    $response['message'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

echo json_encode($response);
?>
