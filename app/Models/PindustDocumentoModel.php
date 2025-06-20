<?php

namespace App\Models;

use CodeIgniter\Model;

class PindustDocumentoModel extends Model
{
    protected $table = 'pindust_documentos';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id_sol',
        'cifnif_propietario',
        'convocatoria',
        'name',
        'type',
        'created_at',
        'tipo_tramite',
        'corresponde_documento',
        'datetime_uploaded',
        'selloDeTiempo',
        'custodiado',
        'fechaCustodiado',
        'publicAccessIdCustodiado',
        'fase_exped',
        'estado',
        'docRequerido'
    ];

    protected $useTimestamps = false; // Ya que se usa un campo timestamp personalizado
    protected $returnType = 'array';

    // Puedes definir reglas de validación si lo deseas
    protected $validationRules = [
        'id_sol' => 'required|integer',
        'cifnif_propietario' => 'required|max_length[50]',
        'convocatoria' => 'required|max_length[50]',
        'name' => 'required|max_length[100]',
        'type' => 'required|max_length[255]',
        'created_at' => 'required|max_length[255]',
        'tipo_tramite' => 'required|max_length[40]',
        'corresponde_documento' => 'required|max_length[75]',
        'selloDeTiempo' => 'required|max_length[150]',
        'custodiado' => 'required|in_list[0,1]',
        'fechaCustodiado' => 'required|valid_date',
        'publicAccessIdCustodiado' => 'max_length[150]',
        'fase_exped' => 'required|max_length[15]',
        'estado' => 'required|max_length[15]',
        'docRequerido' => 'required|in_list[SI,NO]'
    ];
}
