<?php namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
 
class ConfiguracionLineaModel extends Model
{
    
    protected $DBGroup          = 'default';
    protected $table = 'pindust_linea_ayuda';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
 
    protected $allowedFields = ['id', 'codigoSIA', 'convocatoria',
    'num_BOIB', 'num_BOIB_modific', 'lineaAyuda',
    'programa', 'convocatoria_desde', 'convocatoria_hasta',
    'dias_fecha_lim_justificar',  
    'updateInterval', 'convocatoria_aviso_ca', 'convocatoria_aviso_es',
    'activeLineData' ];

    public function activeConfigurationLineData($line) {
        $currentYear = date("Y");
        $convoData = $this->asArray()->where(['convocatoria'=> $currentYear, 'lineaAyuda' => $line])->first();
        if (!$convoData) {
            throw new \Exception('E000');
        }
        return $convoData;
    }

}