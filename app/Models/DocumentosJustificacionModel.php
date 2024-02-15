<?php namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
 
class DocumentosJustificacionModel extends Model
{
    protected $table = 'pindust_documentos_justificacion';
 
    protected $allowedFields = ['id', 'cifnif_propietario', 'convocatoria', 'name', 'type', 'created_at', 
    'tipo_tramite', 'corresponde_documento', 'datetime_uploaded', 'selloDeTiempo', 'id_sol'];


    public function checkIfDocumentoJustificacion($correspondeDocumento, $idSol) {

        $sql = "SELECT COUNT(id) AS totalDocsJustifPlan FROM pindust_documentos_justificacion WHERE (corresponde_documento = '$correspondeDocumento' AND id_sol = $idSol)";
        $query = $this->query($sql);

        foreach ($query->getResult('array') as $row)
		{
			$result = $row['totalDocsJustifPlan'];
		}

        return $result;

    }

    public function listDocumentosJustificacion($correspondeDocumento, $idSol) {

        $qry = "SELECT * FROM pindust_documentos_justificacion WHERE (corresponde_documento = '$correspondeDocumento' AND id_sol = $idSol )";
		$query = $this->query($qry);

		return $query->getResult();
	
    }

    public function getPublicAccessId ($id) {
        $sql = 'SELECT publicAccessIdjustificado FROM pindust_expediente WHERE id="'.$id.'"';
        $query = $this->query($sql); 
        $row = $query->getRow();

        return $row->publicAccessIdjustificado;
        if (isset($row)) {
            return $row->publicAccessIdjustificado;
        } else {
            return "nada";
        }
    }

}