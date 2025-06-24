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
        'created_at' => 'max_length[255]',
        'tipo_tramite' => 'required|max_length[40]',
        'corresponde_documento' => 'required|max_length[75]',
        'selloDeTiempo' => 'required|max_length[21]',
        'custodiado' => 'in_list[0,1]',
        'fechaCustodiado' => 'valid_date',
        'publicAccessIdCustodiado' => 'max_length[150]',
        'fase_exped' => 'required|max_length[15]',
        'estado' => 'required|max_length[15]',
        'docRequerido' => 'required|in_list[SI,NO]'
    ];
    protected $validationMessages = [
        'id_sol' => [
            'required' => 'El id_sol es obligatorio.',
            'integer' => 'El id_sol puede contener números.'
        ],
        'cifnif_propietario' => [
            'required' => 'El cifnif_propietario es obligatorio.',
            'alpha_numeric' => 'El cifnif_propietario puede contener números y letras.',
            'exact_length' => 'Debe cifnif_propietario tener exactamente 9 dígitos.'
        ],
        'convocatoria' => [
            'required' => 'El año de la convocatoria es obligatorio.',
            'integer' => 'La convocatoria solo puede contener números.',
            'exact_length' => 'Debe tener exactamente 4 dígitos [YYYY].'
        ],
        'name' => [
            'required' => 'El name es obligatorio.',
            'alpha_numeric' => 'El name solo puede contener letras.',
            'max_length' => 'Debe tener como máximo 100 caracteres.'
        ],
        'type' => [
            'required' => 'El type es obligatorio.',
            'alpha_numeric' => 'El type solo puede contener letras.',
            'max_length' => 'Debe tener como máximo 255 caracteres.'
        ],
        'tipo_tramite' => [
            'required' => 'El tipo_tramite es obligatorio.',
            'alpha_numeric' => 'El tipo_tramite solo puede contener letras.',
            'max_length' => 'Debe tener como máximo 40 caracteres.'
        ],
        'corresponde_documento' => [
            'required' => 'El corresponde_documento es obligatorio.',
            'alpha_numeric' => 'El corresponde_documento solo puede contener letras.',
            'max_length' => 'Debe tener como máximo 75 caracteres.'
        ],
        'selloDeTiempo' => [
            'required' => 'El selloDeTiempo es obligatorio.',
            'alpha_numeric' => 'El selloDeTiempo solo puede contener letras [04_11_2024_02_11_31pm|am].',
            'max_length' => 'Debe tener como máximo 21 caracteres.'
        ],
        'fase_exped' => [
            'required' => 'El fase_exped es obligatorio.',
            'alpha_numeric' => 'El fase_exped solo puede contener letras, por defecto debe ser: "Solicitud".',
            'max_length' => 'Debe tener como máximo 15 caracteres.'
        ],
        'estado' => [
            'required' => 'El estado es obligatorio.',
            'alpha_numeric' => 'El estado solo puede contener letras, por defecto debe ser: "Pendent".',
            'max_length' => 'Debe tener como máximo 15 caracteres.'
        ],
        'docRequerido' => [
            'required' => 'El docRequerido es obligatorio.',
            'alpha_numeric' => 'El docRequerido solo puede contener letras, toma un valor de estos dos: "[SI,NO]".'
        ],         
    ];
    protected $skipValidation     = false;
}
