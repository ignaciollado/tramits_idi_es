<?php namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
 
class ConfiguracionModel extends Model
{
    protected $table = 'pindust_configuracion';
 
    protected $allowedFields = ['id', 'meses_fecha_lim_consultoria', 
    'dias_fecha_lim_justificar', 'mail_registro', 'programa', 'num_BOIB', 
    'num_BOIB_modific', 'respresidente', 'convocatoria_desde', 'convocatoria_hasta', 
    'convocatoria_aviso_ca', 'convocatoria_aviso_es', 
    'updateInterval', 'convocatoria_activa' ];
}