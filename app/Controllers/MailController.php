<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class MailController extends ResourceController
{
    use ResponseTrait;
   // protected $modelName = 'App\Models\ContactModel';
    protected $format    = 'json';

    public function index() {
      return $this->respond(
        [
          'message' => 'Hola Mundo desde MailController de RAGE!!!'
        ]);
    }

    public function sendMail() {
      return $this->respond(
        [
          'message' => 'Enviando correo electrónico...'
        ]
        );
    }


    public function options()
    {
        return $this->response
            ->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->setHeader('Access-Control-Allow-Headers', 'Authorization, Content-Type')
            ->setStatusCode(204); // No Content
    }
    
}
