<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;

class MailController extends ResourceController
{
    use ResponseTrait;

    protected $format = 'json';

    public function index()
    {
        return $this->respond([
            'message' => 'Hola Mundo desde MailController de RAGE!!!'
        ]);
    }

    public function sendMail()
{
    $mail = new PHPMailer(true);

    try {
        // Obtener datos del cuerpo de la petición
        $data = $this->request->getJSON(true);

        $to      = $data['to']      ?? null;
        $name    = $data['name']    ?? '';
        $subject = $data['subject'] ?? 'Sin asunto';
        $message = $data['message'] ?? '';

        if (!$to || !$message) {
            return $this->response->setJSON(['message' => 'Faltan campos obligatorios: "to" y "message".']);
        }

        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'localhost';
        $mail->CharSet    = 'UTF-8';
        $mail->XMailer    = 'ADR Balears';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'tramits@tramits.idi.es';
        $mail->Password   = 'Lvsy2r7[4,4}*1';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->SMTPDebug  = 0;

        // Remitente y destinatario
        $mail->setFrom('noreply@tramits.idi.es', 'Ibrelleu - ADR Balears');
        $mail->addAddress($to, $name);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->AltBody = strip_tags($message);

        $mail->send();

        return $this->response
            ->setHeader('Access-Control-Allow-Origin', '*')
            ->setJSON(['message' => 'Correo enviado correctamente'])
            ->setStatusCode(200);

    } catch (Exception $e) {
        return $this->response
            ->setHeader('Access-Control-Allow-Origin', '*')
            ->setJSON(['error' => 'Error al enviar el correo: ' . $mail->ErrorInfo])
            ->setStatusCode(500);
    }
}


    public function options()
    {
        return $this->response
            ->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->setHeader('Access-Control-Allow-Headers', 'Authorization, Content-Type')
            ->setStatusCode(204);
    }
}
