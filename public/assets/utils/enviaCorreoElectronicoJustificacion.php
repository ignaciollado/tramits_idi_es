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
$mail->AddBCC("ignacio.llado@idi.es", "Servei de Politica Industrial");
// El destinatario.
$mail->AddAddress($correoDestino, $correoDestino);
$mail->WordWrap = 50;
// set email format to HTML
$mail->IsHTML(true);
$mail->CharSet = 'UTF-8'; 
$mail->Subject = "Justificar xecs de consultoria Illes Balears - IDI";
$email_message = "<!DOCTYPE html>";

$email_message .= "<!DOCTYPE html>";
$email_message .= "<html lang='es'>";
$email_message .= "  <head>";
$email_message .= "    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
$email_message .= "    <meta name='IDI' content='link to justification form'>";
$email_message .= "    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>";
$email_message .= "    <title>Justificació de la convocatòria de xecs de consultoria indústria Illes Balears - IDI</title>";
$email_message .= "  </head>";
$email_message .= "<body>";
$email_message .= "  <div class='container'>";
$email_message .= "  <table data-toggle='table'>";
$email_message .= "    <tbody>";
$email_message .= "      <tr>";
$email_message .= "        <td>Benvolgut senyor / Benvolguda senyora,";
$email_message .= "          <p>Recordau que a partir de la reunió de tancament teniu 20 dies naturals per realitzar la justificació de la convocatòria de Xecs de consultoria.";
$email_message .= "          Aquí teniu l'enllaç:</p>";
$email_message .= "          <p><a title='Obrir el formulari per fer la justificació dels xecs de consultoria' href = 'https://tramits.idi.es/public/index.php/home/justificacion_cheques/".$_POST["id"]."/".$nif."/".$tipoTramite."/".$convocatoria."/ca'>Formulari de requeriment de justificació</a></p>";
$email_message .= "          <p>Per justificar heu d'accedir a aquest enllaç, pujar la documentació que es sol·licita i signar digitalment el pdf que es genera. Aquest pdf signat l'heu d'enregistrar a través del Registre Electrònic Comú (REC).</p>";
$email_message .= "  <br>";
$email_message .= "          <p>Salutacions,</p>";
$email_message .= "          <p>Equip del servei de Política Industrial</p>";
$email_message .= "<p><strong>Institut d'Innovació Empresarial de les Illes Balears</strong></p>";
$email_message .= "          <p><strong>Conselleria Empresa, Ocupació i Energia</strong></p>";
$email_message .= "        </td>";
$email_message .= "      </tr>";
$email_message .= "    </tbody>";
$email_message .= "  </table>";
$email_message .= "  <br>";
$email_message .= "  <br>";
$email_message .= "  </div>";
$email_message .= "  <br>";
$email_message .= "  <br>";
$email_message .= "  <div class='container'>";
$email_message .= "  <table data-toggle='table'>";
$email_message .= "    <tbody>";
$email_message .= "      <tr>";
$email_message .= "        <td>Apreciado señor / Apreciada señora,";
$email_message .= "          <p>Recuerde que a partir de la reunión de cierre tiene 20 días naturales para realizar la justificación de la convocatoria de Cheques de consultoría.";
$email_message .= "          Aquí tiene el enlace:</p>";
$email_message .= "          <p><a title='Abrir el formulario para hacer la justificación de los cheques de consultoría' href = 'https://tramits.idi.es/public/index.php/home/justificacion_cheques/".$_POST["id"]."/".$nif."/".$tipoTramite."/".$convocatoria."/es'>Formulario de requerimiento de justificación</a></p>";
$email_message .= "          <p>Para justificar tiene que acceder a este enlace, subir la documentación que se solicita y firmar digitalmente el pdf que se genera. Este pdf firmado lo tiene que registrar a través del Registro Electrónico Común (REC).</p>";
$email_message .= "  <br>";
$email_message .= "          <p>Saludos cordiales,</p>";
$email_message .= "          <p>El equipo del servicio de Política Industrial</p>";
$email_message .= "<p><strong>Instituto de Innovación Empresarial de les Illes Balears</strong></p>";
$email_message .= "          <p><strong>Consejería de Empresa, Ocupación y Energía</strong></p>";
$email_message .= "        </td>";
$email_message .= "      </tr>";
$email_message .= "    </tbody>";
$email_message .= "  </table>";
$email_message .= "  <br>";
$email_message .= "  <br>";
$email_message .= "  <br>";
$email_message .= "  </div>";
$email_message .= "</body>";
$email_message .= "<style>";
$email_message .= "  @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');";
$email_message .= "  body,html {font-family:Montserrat;background-color: green;color: white;};";
$email_message .= "  .container {";
$email_message .= "    padding: 1rem;";
$email_message .= "    width: 90%;";
$email_message .= "    }";
$email_message .= "</style>";
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
	$result = "<strong>S'ha enviat el formulari de justificació a la adreça de notificació " .$correoDestino."</strong>";
}


// mysqli_close($conn);
echo $result;
?>