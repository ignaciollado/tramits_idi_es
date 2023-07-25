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
$mail->XMailer = 'IDI';
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
$mail->AddBCC("ignacio.llado@idi.es", "Servei de Política Industrial");
// El destinatario.
$mail->AddAddress($correoDestino, $correoDestino);
$mail->WordWrap = 50;
// set email format to HTML
$mail->IsHTML(true);
$mail->CharSet = 'UTF-8'; 
$mail->Subject = "Justificar xecs de consultoria Illes Balears - IDI";
$email_message = "<!DOCTYPE html>";
$email_message .= "<html lang='es'>";
$email_message .= "<html>";
$email_message .= "<head>";
$email_message .= "<meta charset = 'utf-8'>";
$email_message .= "<meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>";
$email_message .= "<title>Justificació de la convocatòria de xecs de consultoria indústria Illes Balears - IDI</title>";
$email_message .= "</head>";
$email_message .= "<body>";
$email_message .= "<div class='container'>";
$email_message .= "<table data-toggle='table'";
$email_message .= "<tbody>";
$email_message .= "<tr style='width:100%;text-align:left;'>Benvolgut senyor / Benvolguda senyora,<td style='font-size: 14px;'>";
$email_message .= "<div>Recordau que a partir de la reunió de tancament teniu 20 dies naturals per realitzar la justificació de la convocatòria de Xecs de consultoria.
Aquí teniu l'enllaç:</div>";
$email_message .= "<div><a title='Obrir el formulari per fer la justificació dels xecs de consultoria' href = 'https://tramits.idi.es/public/index.php/home/justificacion_cheques/".$_POST["id"]."/".$nif."/".$tipoTramite."/".$convocatoria."/ca'>Formulari de requeriment de justificació</a></div>";
$email_message .= "<div>Per justificar heu d'accedir a aquest enllaç, pujar la documentació que es sol·licita i signar digitalment el pdf que es genera. Aquest pdf signat l'heu d'enregistrar a través del Registre Electrònic Comú (REC).</div>";
$email_message .= "<br><div>Salutacions,</div>";
$email_message .= "<div>Equip del servei de Política Industrial de l'IDI</div></td></tr>";
$email_message .= "<tr style='width:100%;text-align:left;'><td></td></tr>";
$email_message .= "<tr style='width:100%;text-align:left;'><td></td></tr>";
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
	$result = "<strong>S'he enviat un formulari de justificació a la adreça de notificació " .$correoDestino."</strong>";
}


// mysqli_close($conn);
echo $result;
?>