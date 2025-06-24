<?php

namespace App\Models;

use CodeIgniter\Model;

class PindustActividadesCNAEModel extends Model
{
    protected $table            = 'actividadesCNAE';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = false; // Ya que el campo `id` no está definido como AUTO_INCREMENT

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = ['id', 'cnae', 'label', 'label_cas', 
        'created_at',
        'updated_at',
        'deleted_at'];

    protected $useTimestamps = true; // Para habilitar el manejo automático de timestamps
    protected $createdField = 'created_at'; // Campo para la fecha de creación
    protected $updatedField = 'updated_at'; // Campo para la fecha de actualización
    protected $deletedField     = '';

    protected $validationRules      = [
        'cnae' =>  'required|string',
        'label' => 'string',
        'label_cas' => 'required|string',
    ];
    protected $validationMessages   = [
        'cnae' => [
            'required' => 'El campo cnae es obligatorio.',
            'string' => 'El campo cnae debe ser un string.',
            'exact_length' => 'Debe ser de 4 dígitos',
        ],
        'label' => [
            'string' => 'El campo label debe ser un string.'
        ],
        'label_cas' => [
            'required' => 'El campo label_cas es obligatorio.',
            'string' => 'El campo label_cas debe ser un string.'
        ],
    ];
    protected $skipValidation       = false;
}
