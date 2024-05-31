<?php
//include ("PHPMailer_5.2.0/class.phpmailer.php");
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/Views/pages/forms/rest_api_firma/PHPMailer_5.2.0/class.phpmailer.php';
require_once 'conectar_a_bbdd.php';

$id_doc = $_POST["id_doc"];
$query = "SELECT email_rep, empresa, nif, tipo_tramite, convocatoria FROM pindust_expediente WHERE  id = " . $_POST["id"];

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
$mail->XMailer = 'IDI';
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
$mail->AddBCC("ignacio.llado@idi.es", "Servei de Política Industrial");
// El destinatario.
$mail->AddAddress($correoDestino, $correoDestino);
$mail->WordWrap = 50;
// set email format to HTML
$mail->IsHTML(true);
$mail->CharSet = 'UTF-8'; 
$mail->Subject = "Solicitam emissions de gasos efecte hivernacle - ILS";
$email_message = "<!DOCTYPE html>";
$email_message .= "<html lang='es'>";
$email_message .= "<html>";
$email_message .= "<head>";
$email_message .= "<meta charset = 'utf-8'>";
$email_message .= "<meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>";
$email_message .= "<title>Adhesió al programa Industria Local Sostenible Illes Balears - IDI</title>";
$email_message .= "</head>";
$email_message .= "<body>";
$email_message .= "<div class='container'>";
$email_message .= "<table data-toggle='table'";
$email_message .= "<tbody>";
$email_message .= "<tr style='width:100%;text-align:left;'><td style='font-size: 14px;'>";
$email_message .= "<div>Benvolgut senyor / Benvolguda senyora,</div>";
$email_message .= "<br><div>Per poder completar la vostra adhesió al programa Indústria Local Sostenible (ILS) necessitam el Compromís de reducció de les emissions de gasos d'efecte hivernacle. 
<br><br>Per a això, us demanam que ens faceu arribar aquest informe a través del següent formulari:</div>";
$email_message .= "<div><a title='Obrir el formulari per fer-nos arribar el Compromís de reducció de les emissions de gasos d´efecte hivernacle' href = 'https://tramits.idi.es/public/index.php/home/compromiso_reduccion_ils/".$_POST["id"]."/".$nif."/".$tipoTramite."/".$convocatoria."/ca'>Formulari de requeriment de el Compromís de reducció de les emissions de gasos d'efecte hivernacle</a></div>";

    $email_message .= "<br><div>Pilar Jordi Amorós</div>";
    $email_message .= "<br><div>Cap de Servei de Política Industrial</div>";
    $email_message .= "<div><strong>Institut d'Innovació Empresarial de les Illes Balears</strong></div>";
    $email_message .= "<div><strong>Conselleria Empresa, Ocupació i Energia</strong></div>";
    $email_message .= "<div>Telèfon 971 176161 + 62891</div>";
    $email_message .= "<div>Plaça de Son Castelló, 1</div>";
    $email_message .= "<div>07009 Palma</div></td></tr>";
    $email_message .= "<tr style='width:100%;text-align:left;'><td>www.idi.es</td></tr>";
$email_message .= "</tbody>";
$email_message .= "</table>";
$email_message .= "<br>";
$email_message .= "<br>";
$email_message .= "<br>";	
$email_message .= $firma;
$email_message .= $notalegal;
$email_message .= "</div>";
$email_message .= "</body>";
$email_message .= "</html>";

$mail->Body    = $email_message;
$mail->AltBody = $email_message;

if(!$mail->Send())
{
	$result = "Message could not be sent.";
	$result .= "Mailer Error: " . $mail->ErrorInfo;
	$mail->ClearAddresses();
	$mail->ClearAttachments(); 
}
else 
{
    $query = "INSERT INTO pindust_documentos_notificacion (id_doc, notifiedTo)
    VALUES ($id_doc, '$correoDestino')";

    $result = mysqli_query($conn, $query);

	$result = "<strong>Sol·licitud del Compromís de reducció de les emissions de gasos enviada a la adreça de notificació " .$correoDestino."</strong>";
}


// mysqli_close($conn);
echo $result;
?>