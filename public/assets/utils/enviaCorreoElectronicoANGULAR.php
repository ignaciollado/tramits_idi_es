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

switch ($project) {
	case 'Ibemprėnjove':
		$projectMail = "agelabert@idi.es";
		break;
	case 'Ibemprėn':
		$projectMail = "smartinez@idi.es";
		break;
	case 'Ibtalent':
		$projectMail = "pjimenez@idi.es";
		break;
	case 'Ibgestió xecs':
		$projectMail = "cmunoz@idi.es";
		break;
	case 'Ibdigitalització xecs':
		$projectMail = "cmunoz@idi.es";
		break;
	case 'Emblemàtics Balears':
		$projectMail = "icomerc@idi.es";
		break;
	case "Ibcomerç a l'escola":
		$projectMail = "icomerc@idi.es";
		break;
	case "Pà d'aquí":
		$projectMail = "icomerc@idi.es";
		break;
	case 'Industria Local Sostenible':
		$projectMail = "pjordi@idi.es";
		break;
	case 'Ibsostenibilitat xecs':
		$projectMail = "pjordi@idi.es";
		break;
	case 'Ibavals industria':
		$projectMail = "pjordi@idi.es";
		break;
	case 'Ibexposa producte local':
		$projectMail = "agenovart@idi.es";
		break;
	case 'Ibrelleu':
		$projectMail = "mriutord@idi.es";
		break;
	case 'LOOP':
		$projectMail = "csantandreu@idi.es";
		break;
	case 'Ibexporta xecs':
		$projectMail = "bpino@idi.es";
		break;
	case 'Ibexporta Orientacio':
		$projectMail = "bpino@idi.es";
		break;
	case 'Invest In Balearics':
		$projectMail = "bpino@idi.es";
		break;		
	case 'Palma International Boatshow':
		$projectMail = "info@pibspalma.com";
		break;
	case 'Comunicació':
		$projectMail = "info@idi.es";
		break;	
	default:
		$projectMail = "info@idi.es";
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

if ($project == 'Industria Local Sostenible') {
	$mensajeLayout = file_get_contents('contents-ils.html');	
	$mail->Subject = "Mensaje desde APP Sostenibilitat";
	$mail->AddBCC("illado@idi.caib.es", "Gestió interna ADR Balears");
} elseif ($project == 'Invest In Balearics') {
	$mensajeLayout = file_get_contents('contents-invest-in-balearics.html');	
	$mail->Subject = "Mensaje desde Invest In Balearics";
	$mail->AddBCC("illado@idi.caib.es", "Gestió interna ADR Balears");
} else {
	$mensajeLayout = file_get_contents('contents.html');
	$mail->Subject = $asunto; /* "Nuevo mensaje desde ADR Balears"; */
	/* $mail->AddBCC("info@idi.es", "Servei de comunicació"); */
	$mail->AddBCC($projectMail, $project);

}

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