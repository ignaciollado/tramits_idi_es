<?php 

namespace App\Models;
use CodeIgniter\Model;

class ApiModel extends Model
{
    protected $table = 'pindust_expediente';
    protected $primaryKey = 'id';
    protected $allowedFields = [
      'idExp', 
      'tipo_solicitante',
      'empresa',
      'nif',
      'telefono_rep', //Teléfono de notificaciones
      'email_rep', //Correo electrónico de notificaciones
      'tipo_tramite',
      'convocatoria',
      'fecha_completado' //0000-00-00 00:00:00
    ];
}