<?php

namespace App\Models;

use CodeIgniter\Model;

class MejorasExpedienteModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pindust_mejora_solicitud';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_sol', 'fecha_rec_mejora', 'ref_rec_mejora'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function selectAllMejorasExpediente($idExp) {
        $sql = 'SELECT * FROM pindust_mejora_solicitud WHERE id_sol='.$idExp;
        $query = $this->query($sql);
        return $query->getResultArray();
    }

    public function selectLastMejorasExpediente($idExp) {
        $sql = 'SELECT * FROM pindust_mejora_solicitud WHERE id_sol='.$idExp.' ORDER by id DESC LIMIT 1';
        $query = $this->query($sql);
        $results = $query->getResultArray();

        foreach ($results as $row) {
            $lastMejora = $row['id']."##".$row['id_sol']."##".$row['fecha_rec_mejora']."##".$row['ref_rec_mejora'];
        }
        return $lastMejora;
    }

    public function addMejoraExpediente($idsol, $fecha_rec_mejora,$ref_rec_mejora) {
        $sql = 'INSERT INTO pindust_mejora_solicitud (id_sol, fecha_rec_mejora, ref_rec_mejora)
        VALUES ('.$idsol.','.$fecha_rec_mejora.',"'.$ref_rec_mejora.'")';
        $query = $this->query($sql);
        return $query;
    }

    public function deleteMejoraExpediente($id) {
        $sql = 'DELETE * FROM pindust_mejora_solicitud WHERE id=' . $id;
        $query = $this->query($sql);
        return $query;
    }

}
