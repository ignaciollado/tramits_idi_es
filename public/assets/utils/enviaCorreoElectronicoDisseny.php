<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/rest_api_firma/PHPMailer_5.2.0/class.phpmailer.php';

$url =  $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$items = parse_url( $url);
$data = explode  ("/", $items['query']);

$correoDestino = urldecode($data[0]);
$solicitante = urldecode($data[1]);
$contactPhone = urldecode($data[2]);
$asunto = urldecode($data[3]);
$mensaje = urldecode($data[4]);
$project = urldecode($data[5]);
$caibAgency = urldecode($data[6]);
$workType = urldecode($data[7]);


$projectMail = "lmatas@idi.es";

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
$mail->FromName = "ADR Balears";
// Lo que verá del remitente el destinatario
$mail->SetFrom("noreply@tramits.idi.es","ADR Balears");
// La dirección a la que contestará el destinatario
$mail->AddReplyTo("response@tramits.idi.es","ADR Balears"); 

// El destinatario.
$mail->AddAddress($correoDestino, $correoDestino);
$mail->WordWrap = 50;

// set email format to HTML
$mail->IsHTML(true);

$mensajeLayout = file_get_contents('contents-disseny.html');
$mail->Subject = $asunto; /* "Nuevo mensaje desde ADR Balears"; */
$mail->AddBCC("illado@idi.caib.es", "Departament de disseny");
$mail->AddBCC($projectMail, $project);

$mensajeLayout = str_replace("%ORGANISMOCAIB%", $caibAgency, $mensajeLayout);
$mensajeLayout = str_replace("%TIPOTAREA%", $workType, $mensajeLayout);
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
		$result = "Missatge enviat correctament a la adreça " .$correoDestino;
	}

echo $result;
?>