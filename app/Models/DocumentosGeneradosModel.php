<?php namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
 
class DocumentosGeneradosModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pindust_documentos_generados';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'id_sol', 'cifnif_propietario', 'convocatoria', 'name', 'type', 'created_at', 
    'tipo_tramite', 'corresponde_documento', 'datetime_uploaded', 'selloDeTiempo'];

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

    public function documentosGeneradosPorExpedYTipo($idExp, $convocatoria, $nombreDocumento) {
        $sql = "SELECT * FROM pindust_documentos_generados WHERE name = '$nombreDocumento'
                AND id_sol = $idExp AND convocatoria = '$convocatoria'";      
        $query = $this->query($sql);

        $row = $query->getRow();
        return $row;
    }
}