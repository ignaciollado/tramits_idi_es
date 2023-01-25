<?php namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
 
class NotificacionDocumentosModel extends Model
{
    protected $table = 'pindust_documentos_notificacion';
 
    protected $allowedFields = ['id', 'id_doc', 'dateTimeNotified', 'notifiedTo'];
}