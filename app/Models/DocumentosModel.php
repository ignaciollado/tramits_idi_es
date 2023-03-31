<?php namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
 
class DocumentosModel extends Model
{
    protected $table = 'pindust_documentos';
 
    protected $allowedFields = ['id', 'cifnif_propietario', 'convocatoria', 'name', 'type', 
                                    'created_at', 'tipo_tramite', 'corresponde_documento', 
                                    'datetime_uploaded', 'selloDeTiempo', 'id_sol'];

    public function findIfDocumentIsInIDI($idExp, $nif, $correspondeDocumento, $tipoTramite, $convocatoria ) {
        date_default_timezone_set("Europe/Madrid");
		$selloTiempo = date("d_m_Y_h_i_sa");

        $sql = 'SELECT * FROM pindust_documentos WHERE cifnif_propietario = "'.$nif.'" AND corresponde_documento = "'.$correspondeDocumento.'" ORDER By id DESC limit 1'; /* AND tipo_tramite = "'.$tipoTramite.'"'; */
        $query = $this->query($sql);
        foreach ($query->getResultArray() as $row) {
            $registro =
            $idExp.",'".
            $row['cifnif_propietario']."','".
            date("Y")."','".
            $row['name']."','".
            $row['type']."','".
            $row['created_at']."','".
            $tipoTramite."','".
            $row['corresponde_documento']."','".$selloTiempo."'";
        }

        if (!$query->getResultArray()) {
            return 'D000 '.$correspondeDocumento."<br>"; /* No documents for this nif and type in IDI */
        }

        return $this->duplicateRegisterIfSaysDocumentInIDI($registro, $idExp, $tipoTramite, $convocatoria, $correspondeDocumento); /* Yes documents for this nif and type in IDI */
    }

    public function duplicateRegisterIfSaysDocumentInIDI($registro, $id, $tipoTramite, $convocatoria, $correspondeDocumento) {
        $totalDocumentos = 0;
        //$sql = 'SELECT count(id) as totalDocumentos FROM pindust_documentos WHERE id_sol='.$id.' AND tipo_tramite ="'.$tipoTramite.'" AND convocatoria ="'.$convocatoria.'" AND corresponde_documento ="'.$correspondeDocumento.'"';
        /* Cada vez comprueba que el documento no haya sido ya creado (esta función se llama cada vez que se entra en la vista EDICIÓN) */
        $sql = 'SELECT count(id) as totalDocumentos FROM pindust_documentos WHERE id_sol='.$id.' AND convocatoria ="'.$convocatoria.'" AND corresponde_documento ="'.$correspondeDocumento.'"';
        $query  = $this->query($sql);
        foreach ($query->getResult('array') as $row) {
            $totalDocumentos = $row['totalDocumentos'];
        }
        if ($totalDocumentos == 0) {
            $sql = 'INSERT INTO pindust_documentos (id_sol, cifnif_propietario, convocatoria, name, type, created_at, tipo_tramite, corresponde_documento, selloDeTiempo)
                VALUES ('.$registro.')';
            $query = $this->query($sql);
        }
    }
}