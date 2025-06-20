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

    protected $allowedFields    = ['id', 'cnae', 'label', 'label_cas'];

    protected $useTimestamps    = false;
    protected $createdField     = '';
    protected $updatedField     = '';
    protected $deletedField     = '';

    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
}
