<?php namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class ExpedientesModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pindust_expediente';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
 
    protected $allowedFields = ['id', 'fecha_kick_off', 'fecha_enmienda', 'fecha_completado', 'fecha_limite_consultoria', 'felib_p',
    'fecha_reunion_cierre', 'fecha_limite_justificacion', 'fecha_propuesta_resolucion', 'fecha_propuesta_resolucion_notif', 
    'fecha_resolucion', 'fecha_notificacion_resolucion', 'fecha_requerimiento', 'fecha_requerimiento_notif', 
    'fecha_amp_termino', 'fecha_REC', 'ref_REC', 'empresa', 'nif', 'telefono', 'email', 'domicilio', 'fecha_solicitud', 
    'tipo_tramite', 'convocatoria', 'hay_consultor', 'situacion', 'importeAyuda', 'porcentajeConcedido',
    'canales_comercializacion_empresa', 'sitio_web_empresa', 'video_empresa', 'fecha_creacion_empresa', 'publicar_en_web'];

    public function findExpedienteById($idExp, $convocatoria,$tipoTramite) {
        $expediente = $this->asArray()->where(['idExp'=> $idExp, 'convocatoria'=> $convocatoria, 'tipo_tramite'=> $tipoTramite])->first();
        if (!$expediente) {
            throw new \Exception('E000'); /* Could not find expediente for specified idExp/Convocatoria/tipoTramite */
        }
        return $expediente;
    }

    public function findNumberOfConvocatorias($nif, $tipoTramite, $convocatoria) {  
        if ($tipoTramite == 'Programa III actuacions corporatives' && $convocatoria == '2024' ) {
            $tipoTramite = "Programa III";
        }
        $sql = 'SELECT count(id) as totalConvos FROM pindust_expediente WHERE 
        nif="'.$nif.'" 
        AND situacion="Finalizado"  
        AND convocatoria !='.$convocatoria.' 
        AND tipo_tramite="'.$tipoTramite.'"';
        $query = $this->query($sql);
        $results = $query->getResultArray();

        if (!$results) {
            throw new \Exception('E000'); /* Could not find expediente for specified idExp/Convocatoria/tipoTramite */
        }
        foreach ($results as $row) {
            $totalConvos = $row['totalConvos'];
        }
        $totalConvos = $totalConvos + 1; /* LE SUMA 1 PORQUE SE CUENTA PRIMERA CONVOCATORIA, SEGUNDA CONVO, TERCERA... Y NO CONVOCATORIA CERO */
        return $totalConvos;
    }

    public function updateImporteAyuda ($id, $importe) {
        $data = [
            'importeAyuda'  => $importe,
        ];
        return $this->update($id, $data);
    }

    public function getPublicAccessId ($id) {
        $sql = 'SELECT PublicAccessId FROM pindust_expediente WHERE id="'.$id.'"';
        $query = $this->query($sql); 
        $row = $query->getRow();
        return $row->PublicAccessId;
        if (isset($row)) {
            return $row->PublicAccessId;
        } else {
            return "nada";
        }
    }

    public function getWithZeroIdSol() {
        $sql = "SELECT count(id) as totalZeros FROM pindust_expediente WHERE idExp=0";
        $query = $this->query($sql);
        $row = $query->getRow();
        return $row->totalZeros;
    }

    public function getTotalFelibCityCouncils($program) {
        $sql = "SELECT count(id) as totalCityCouncils FROM pindust_expediente WHERE tipo_tramite = 'felib' AND felib_p LIKE '%".$program."%'";
        $query = $this->query($sql);
        $results = $query->getResultArray();
        if (!$results) {
            //throw new \Exception('E1111'); /* Could not find councils for specified felib_p */
            return 0;
        }
        foreach ($results as $row) {
            $totalSolicitudes = $row['totalCityCouncils'];
        }
        return $totalSolicitudes;
    }

    public function getCityCouncilsList($program) {
        $sql = "SELECT empresa as cityCouncil, responsable_felib, tecnico_felib FROM pindust_expediente WHERE tipo_tramite = 'felib' AND felib_p LIKE '%".$program."%'  order by empresa";
        $query = $this->query($sql);
        $results = $query->getResultArray();
        if (!$results) {
            //throw new \Exception('E1111'); /* Could not find councils for specified felib_p */
            return 0;
        }
        return $results;
    }
}