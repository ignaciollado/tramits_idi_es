<?php 
namespace App\Models;
use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $DBGroup  = 'default';
    protected $table = 'userTramits';
    protected $allowedFields = ['id', 'user_name', 'password', 'full_name', 'servicio', 'rol', 'googleID', 'lastLogin'];        
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';

        public function updateLastLogin($eMail) {
                $convocatoria = '';
                $line = '';
                if ($eMail) {
                        $convoData = $this->asArray()->where(['convocatoria'=> $convocatoria, 'lineaAyuda' => $line])->first();
                } else  {
                    throw new \Exception('E000');
                }
                return $convoData;
        }    
        
        public function getLastLogin($eMail) {
                $lastLogin = $this->find($eMail);
                return $lastLogin;
        }
}