<?php namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
 
class ConfiguracionModel extends Model
{
    protected $table = 'pindust_configuracion';
 
    protected $allowedFields = ['id',  
    'respresidente', 'directorGeneralPolInd', 'directorGerenteIDI', 'eMailPresidente',
    'eMailDGeneral', 'eMailDGerente',
    'emisorDIR3',
    'activeGeneralData' ];

    public function configuracionGeneral() {
        return $this->asArray()->where(['activeGeneralData'=> 'SI'])->first();
    }
}