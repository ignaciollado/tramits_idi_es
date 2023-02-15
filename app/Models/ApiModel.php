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
      'nif'
    ];
}