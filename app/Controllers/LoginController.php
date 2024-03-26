<?php
namespace App\Controllers;
use App\Models\LoginModel;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;

define("REST_API_URL", "https://www.googleapis.com/oauth2/v3/certs");
require_once '../vendor/autoload.php';
use Firebase\JWT\JWT;

class LoginController extends Controller
{
    private $login = '' ;
    public function __construct(){
        $this->login = new LoginModel();
    }
    
    // show the login form
  public function index() {
		$session = \Config\Services::session();
		if($session->get('logged_in')) {
			$data['titulo'] = lang('message_lang.titulo');
			echo view('templates/header/header', $data);
			echo view('pages/content');
			echo view('templates/footer/footer', $data);	
		}else{
			$session = session();  
			$session->setFlashdata('msg', '<strong>iTramits</strong><br>');
			$data['titulo'] = lang('message_lang.titulo');
			echo view('templates/header/header-login', $data);		
			echo view('pages/login/login-view');		
		}
    }      

  // check user if exist or not
    public function login($googleToken = null) {
		$db = \Config\Database::connect();
		$request = \Config\Services::request();
		$googleToken =  $request->uri->getSegment(3);
		$avatar = "";
		//echo "Estoy en el controlador, y tengo este token: <br><br>".$googleToken."<br><br>";
		
		if ($googleToken) { // El token JWT tiene tres partes: header, payload y signature)
			list($header, $payload, $signature) = explode(".", json_encode($googleToken, true));
			//echo "HEADER:<br>".base64_decode ($header)."<br><br>";
			//echo "SIGNATURE:<br>".base64_decode ($signature)."<br><br>";
			//0echo "<strong>PAYLOAD:</strong><br>".base64_decode ($payload)."<br><br>";//.json_encode(base64_decode ($payload));
	 		$obj_php = json_decode(base64_decode ($payload)); // Es la parte payload del JWT (JSon Web Token enviado desde GSuite)
			$hd = $obj_php->hd;
			$aud = $obj_php->aud; // The value of the aud parameter is the integration record and the company, separated by a semicolon.
			$iss = $obj_php->iss;
			$googleSub = $obj_php->sub; // The value of the sub parameter is the role and entity of the user, separated by a semicolon. For example, 1111;10.
		 	$avatar = $obj_php->picture;
			$iat = $obj_php->iat; // The value of the iat parameter represents when the token was issued. The value of the parameter is in seconds, since January 1, 1970.
		 	$exp =  $obj_php->exp; // The value of the exp parameter represents the number of seconds since January 1, 1970, until the token’s expiration.
			$user =  $obj_php->name;
			$jti = $obj_php->jti; // The value of the jti parameter is the token ID, which is unique for every token.
			$uMail = $obj_php->email;

			//echo "<br><br>".$uMail."<br>".$googleSub."<br>".$aud." - ".$iss." - ".$hd." - ".$exp." - ".$user. " - ".$iat. " - >>>". $googleSub."<<<";
			/* return; */

			if ( $aud != '317070054037-t1thp3bfgcsskpuok1f0e12ja6hcbus5.apps.googleusercontent.com' && $aud != '317070054037-71vr46416dlhb63auo5tv0vg16557cin.apps.googleusercontent.com' ) {
				return;
			}
			if ( $iss != 'accounts.google.com') {
				return;
			}
			
			$currentTime = new Time('now');
			$tokenExpired = $currentTime->isAfter(gmdate("Y-m-d\TH:i:s\Z", $exp)); //es después $currentTime que $exp?

			// echo ("<br><br>Ahora: ".$currentTime." exp: ".gmdate("Y-m-d H:i:s", $exp)." iat: ".gmdate("Y-m-d H:i:s", $iat));
			if ($tokenExpired) {
				return;
			}

			if ( $hd != 'idi.es') {
				return;
			}			
		}
	
		/* if ($googleSub) { */
		if ($uMail) {
			//$query = $db->query('SELECT * FROM userTramits WHERE googleID ="'.$googleSub.'"');
			$query = $db->query('SELECT * FROM userTramits WHERE user_name ="'.$uMail.'"');
		} else {
			$query = $db->query('SELECT * FROM userTramits WHERE user_name ="'.$this->request->getVar('user_id').'" AND password ="'.md5($this->request->getVar('password')).'"');
		}

		$results = $query->getResult();
		
		foreach ($results as $row)
			{
			$id = $row->id;
			$username = $row->user_name;
			$email = $username;
			$full_name = $row->full_name;
			$rol = $row->rol;
			$servicio = $row->servicio;
			$telefono = $row->telefono;
			$lastLogin = $row->lastLogin;
			}
		$rows = count($results);

		$session = session();
    if($rows == 1){
			$data = [
			'id'				=> $id,
			'username'  => 	$username,
			'email'     => 	$email,
			'full_name' => 	$full_name,
			'servicio'	=>	$servicio,
			'rol'				=>	$rol,
			'telefono'  =>  $telefono,
			'logged_in' => TRUE,
			'avatar' 		=> $avatar,
			'googleSub'  => $googleSub,
			'lastLogin'  => $lastLogin,
			];
			$session->set($data);
			$data['titulo'] = lang('message_lang.titulo');
			return redirect()->to('/public/index.php/home/ca');
    }else{
			$session = session();
      $session->setFlashdata('msg', 'Disculpi, usuari i/o clau incorrecte/s<br>');
			echo view('templates/header/header-login');
			echo view('pages/login/login-view');
			echo view('templates/footer/footer');	
    } 
	 }
	
	public function content() {
		$data['titulo'] = lang('message_lang.titulo');
		echo view('templates/header/header', $data);
		echo view('pages/content');
		echo view('templates/footer/footer', $data);			
		}

	public function logout() {
        $session = session();
        $session->destroy();
        return redirect()->to('/public');
    	}

	public function loginGoogle() {
		echo view ('pages/login/loginGoogle');
	}

}