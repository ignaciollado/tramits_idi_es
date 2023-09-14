<?php namespace App\Controllers;
 
use CodeIgniter\Controller;
use App\Models\ConfiguracionModel;

class Configuracion extends Controller
{	
    public function configurador_edit()
    {
		$language = \Config\Services::language();
		$language->setLocale('ca');
		$modelConfig = new ConfiguracionModel();
		$db = \Config\Database::connect();
		$data['configuracion'] = $modelConfig->where('convocatoria_activa', 1)->first();
		$data['titulo'] = "Configuració del gestor d'ajuts i de subvencions";
		echo view('templates/header/header', $data);	
        echo view('pages/exped/configurador-gestor');
		echo view('templates/footer/footer');	
    }  
	
    public function configurador_update()
    {
        helper(['form', 'url']);
		$db      = \Config\Database::connect();
		$builder = $db->table('pindust_configuracion');
        $data = [
			'respresidente' => $this->request->getVar('respresidente'),
			'directorGeneralPolInd' => $this->request->getVar('directorGeneralPolInd'),
			'directorGerenteIDI' => $this->request->getVar('directorGerenteIDI'),
			'eMailPresidente' => $this->request->getVar('eMailPresidente'),
			'eMailDGeneral' => $this->request->getVar('eMailDGeneral'),
			'eMailDGerente' => $this->request->getVar('eMailDGerente'),
            'convocatoria_aviso_es' => $this->request->getVar('convocatoria_aviso_es'),
            'convocatoria_aviso_ca' => $this->request->getVar('convocatoria_aviso_ca'),
            'convocatoria_activa' => 1,
			'emisorDIR3' => $this->request->getVar('emisorDIR3')
            	];
 
        $builder->where('id', $this->request->getVar('id'));
		$save = $builder->update($data);
		
		
		$modelConfig = new ConfiguracionModel();
		$db = \Config\Database::connect();
		$data['configuracion'] = $modelConfig->where('convocatoria_activa', 1)->first();		
		$data['titulo'] = "Configuració actualitzada !!";
		echo view('templates/header/header', $data);	
        echo view('pages/exped/resultado-accion', $data);
		echo view('templates/footer/footer');	
    } 	
	
	public function muestradocumento ()
	{
		$this->response->setHeader('Cache-Control', 'private');

		$uri = new \CodeIgniter\HTTP\URI();
		$request = \Config\Services::request();
		$file =  $request->uri->getSegment(3); 
		$nifcif =  $request->uri->getSegment(4);
		$selloDeTiempo =  $request->uri->getSegment(5);
		$tipoMIME =  $request->uri->getSegment(6).'/'.$request->uri->getSegment(7);

		switch ($tipoMIME)
			{
			case "image/jpeg":
				$this->response->setHeader('Content-type', 'image/jpeg');
			break;
			
			case "application/pdf":
				$this->response->setHeader('Content-type', 'application/pdf');
			break;
			
			case "image/png":
				$this->response->setHeader('Content-type', 'image/png');
			break;
			}
			
		echo file_get_contents(WRITEPATH.'documentos/'.$nifcif.'/'.$selloDeTiempo.'/'.$file);
	}
	
	public function muestradocumentofirmado ()
	{
		$uri = new \CodeIgniter\HTTP\URI();
		$request = \Config\Services::request();
		$data = [
            'PublicAccessId' => $request->uri->getSegment(3),
            ];
		// echo "---" . $request->uri->getSegment(3) . "---";
		echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
		echo view('pages/forms/rest_api_firma/ver-documento-firmado', $data);
	}
	
	public function muestrapeticion ()
	{
		$uri = new \CodeIgniter\HTTP\URI();
		$request = \Config\Services::request();
		$data = [
            'PublicAccessId' => $request->uri->getSegment(3),
            ];
		// echo "---" . $request->uri->getSegment(3) . "---";
		echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
		echo view('pages/forms/rest_api_firma/obtiene-datos-peticion', $data);
	}	
}