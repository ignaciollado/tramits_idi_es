<?php 
namespace App\Models;
use CodeIgniter\Model;

class LoginModel extends Model
{
        protected $table = 'userTramits';
        protected $allowedFields = ['id', 'user_name', 'password', 'full_name', 'servicio', 'rol', 'googleID', 'lastLogin'];        
}