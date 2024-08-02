<?php namespace App\Controllers;

use App\Models\ConfiguracionModel;
use App\Models\ConfiguracionLineaModel;
use App\Models\ExpedientesModel;
		
class Home extends BaseController
{
	public function index()
	{
		$session = session();
		if ($session->has('username')) {
		    echo $session->get('username');
			$request = \Config\Services::request();		
			$serverData = $request->getServer();
			$data['titulo'] = lang('message_lang.titulo');
			echo view('templates/header/header', $data);
			echo view('pages/content');
			echo view('templates/footer/footer', $data);
		} else {
			 return redirect('public/index.php/loginController/login');
		}
	}

	public function ca ()
	{
		$generalConfig = new ConfiguracionModel;
		$data['configuracion'] = $generalConfig->configuracionGeneral(); 

		$language = \Config\Services::language();
		$request = \Config\Services::request();
		$idioma =  $request->uri->getSegment(2); 
		$language->setLocale($idioma); 
		$data['titulo'] = lang('message_lang.titulo');
		$session = session();
		$rol = ($session->get('rol'));
		
		echo view('templates/header/header', $data);

		$modelExp = new ExpedientesModel();
		$where = "tipo_tramite = '" . $rol . "'";
		$data['expedientes'] = $modelExp->orderBy('fecha_completado', 'DESC')
		->where($where)
		->findAll();
		$data['totalExpedientes'] = count($data['expedientes']);
		$data['titulo'] = lang('message_lang.todas_las_solicitudes')." FELIB";
		if ($rol === 'felib') {
			echo view('pages/exped/listado-expediente-felib', $data);
		} else if ($rol === 'adr-isba') {
			echo view('pages/exped/listado-expediente-isba', $data);
		}
		else {
			echo view('pages/content', $data);
		}

		echo view('templates/footer/footer');
	}
	
	public function es ()
	{
		$language = \Config\Services::language();
		$request = \Config\Services::request();
		$idioma =  $request->uri->getSegment(2); 
		$language->setLocale($idioma); 
		$data['titulo'] = lang('message_lang.titulo');

		echo view('templates/header/header', $data);
		echo view('pages/content');
		echo view('templates/footer/footer');
	}
	
	public function expedientes ($page = 'forms/form-solicitud-ayuda')
	{
		$data['titulo'] = lang('message_lang.titulo_exped');
		echo view('templates/header/header', $data);
		echo view('pages/listadoexpedientes');
		echo view('templates/footer/footer');
	}
	
	public function solicitud_ayuda ($page = 'forms/form-solicitud-ayuda')
	{
		helper('form');
		helper('filesystem');
		helper('cookie');
		$language = \Config\Services::language();
		$request = \Config\Services::request();

		if ($request->getLocale()){
			$idioma = $request->getLocale();
		} else {
			$idioma =  $request->uri->getSegment(3);
			$language->setLocale($idioma);
		}

		$modelConfig = new ConfiguracionModel;
		$generalConfig = $modelConfig->configuracionGeneral();
		$lineaConfig = new ConfiguracionLineaModel();
		$data['configuracion'] = $modelConfig->configuracionGeneral();
		$currentYear = $generalConfig['convocatoria'];
		$data['configuracionLinea'] = $lineaConfig->activeConfigurationLineData('XECS', $currentYear);
		$data['idioma'] = $idioma;
		
		$isActiveLineData = $data['configuracionLinea']['activeLineData'];
		$desde = $data['configuracionLinea']['convocatoria_desde'];
		$hasta = $data['configuracionLinea']['convocatoria_hasta'];

		if ( date("Y-m-d")>= $desde && date("Y-m-d")<= $hasta) {
			echo view('templates/header/header_form', $data);
			echo view('pages/forms/form-solicitud-ayuda', $data);
			echo view('templates/footer/footer_form');
		} else {
			$data['aviso'] = $data['configuracionLinea']['convocatoria_aviso_ca'];
			if($isActiveLineData === 'NO') {
				$data['activatedLine'] = "XECS consultoria <br>per a la competitivitat industrial de les Illes Balears <br>en matèria de <br>digitalització, internacionalització, sostenibilitat i gestió avançada<br><br>Linia d'ajuts NO ACTIVA";
			}
			$data['titulo'] = $data['configuracionLinea']['lineaAyuda'];
			echo view('pages/forms/form-solicitud-ayuda-desactivada', $data);
			echo view('templates/footer/footer_form');
		}
	}
	
	public function justificacion_cheques ($id, $nif, $tipoTramite)
	{
		helper('form');
		helper('filesystem');
		helper('cookie');
		$language = \Config\Services::language();
		$request = \Config\Services::request();

		if ($request->getLocale()){
			$idioma = $request->getLocale();
		} else {
			$idioma = $request->uri->getSegment(7);
			$language->setLocale($idioma);
		}
		if ($tipoTramite == 'ADR-ISBA') {
			$titulo  = "Ajuts a les despeses financeres a través de l'aval d'ISBA";
		} else {
			$titulo = "Convocatòria Xecs consultoria - Requeriment";
		}

		$data = [
			'id' => $id,
      'nif' => $nif,
			'tipoTramite' => $tipoTramite,
			'idioma' => $idioma,
			'titulo' => $titulo
		];

		echo view('templates/header/header-form-justificacion', $data);
		echo view('pages/forms/form-justificacion-ayuda',$data);
		echo view('templates/footer/footer_form');
	}

	public function subsanacion_idigital ($page = 'forms/form-subsanacion-idigital')
	{
		helper('form');
		helper('filesystem');

		echo view('templates/header/header_form_requerimiento');
		echo view('pages/forms/form-subsanacion-idigital');
		echo view('templates/footer/footer');
	}	
	
	public function set_lang () 
	{
		helper('cookie');
		$language = \Config\Services::language();
		$request = \Config\Services::request();
		$idioma =  $request->uri->getSegment(3);
		$language->setLocale($idioma);
		service('request')->setLocale($idioma);
		helper('form');
		helper('filesystem');
		$cookie = array(
			'name'   => 'CurrentLanguage',
			'value'  => $idioma,                            
			'expire' => '7200',                                                                                   
			'secure' => TRUE
			);
   	set_cookie($cookie);
		
		$modelConfig = new ConfiguracionModel();
		$lineaConfig = new ConfiguracionLineaModel();
		$generalConfig =  $modelConfig->configuracionGeneral();
		$data['configuracion'] = $modelConfig->configuracionGeneral();
		$currentYear = $generalConfig['convocatoria'];
		$data['configuracionLinea'] = $lineaConfig->activeConfigurationLineData('XECS', $currentYear);
		$data['idioma'] = $idioma; 
		$desde = $data['configuracionLinea']['convocatoria_desde'];
		$hasta = $data['configuracionLinea']['convocatoria_hasta'];
		if ( date("Y-m-d")>= $desde && date("Y-m-d")<= $hasta) {
			echo view('templates/header/header_form', $data);
			echo view('pages/forms/form-solicitud-ayuda', $data);
			echo view('templates/footer/footer_form');
		} else {
			if ($idioma === 'ca') {
				$data['aviso'] = $data['configuracionLinea']['convocatoria_aviso_ca'];
			} else {
				$data['aviso'] = $data['configuracionLinea']['convocatoria_aviso_es'];
			}
			$data['titulo'] = $data['configuracionLinea']['lineaAyuda'];
			echo view('pages/forms/form-solicitud-ayuda-desactivada', $data);
			echo view('templates/footer/footer_form');
		}
	}
	
	public function set_lang_req ()
	{
		$uri = new \CodeIgniter\HTTP\URI();	
		$language = \Config\Services::language();
		$request = \Config\Services::request();
		$idioma =  $request->uri->getSegment(3); 
		$language->setLocale($idioma); 
		helper('form');
		helper('filesystem');
		$data['titulo'] = lang('message_lang.titulo_sol_idigital');
		echo view('templates/header/header_form_requerimiento', $data);
		echo view('pages/forms/form-requerimiento-idigital');
		echo view('templates/footer/footer');
	}

	public function set_lang_justific ($idioma, $id, $nif, $tipoTramite)
	{
		helper('cookie');
		$language = \Config\Services::language();
		$request = \Config\Services::request();
		$idioma =  $request->uri->getSegment(3);
		$language->setLocale($idioma);
		service('request')->setLocale($idioma);
		helper('form');
		helper('filesystem');
		$cookie = array(
			'name'   => 'CurrentLanguage',
			'value'  => $idioma,                            
			'expire' => '7200',                                                                                   
			'secure' => TRUE
			);
   	set_cookie($cookie);
		$data = [
			'idioma' => $idioma,
			'id' => $id,
      'nif' => $nif,
			'tipoTramite' => $tipoTramite,
			'titulo' => "Convocatòria Xecs - Requeriment"
		];

		/* $uri = new \CodeIgniter\HTTP\URI();	 */
		
		$data['titulo'] = lang('message_lang.titulo_sol_idigital');
		echo view('templates/header/header-form-justificacion', $data);
		echo view('pages/forms/form-justificacion-ayuda', $data);
		echo view('templates/footer/footer_form');
	}	
	
	public function dec_resp_consul($page = 'forms/form-dec-resp-consultor-idigital')
	{
		helper('form');
		helper('filesystem');
		$data['titulo'] = $data['titulo'] = lang('message_lang.titulo_sol_idigital_consul');		
		echo view('templates/header/header_dec_resp_cons', $data);
		echo view('pages/forms/form-dec-resp-consultor-ayuda');
		echo view('templates/footer/footer');
	}

	public function set_lang_pindust_form_consul ()
	{
		$uri = new \CodeIgniter\HTTP\URI();	
		$language = \Config\Services::language();
		$request = \Config\Services::request();
		$idioma =  $request->uri->getSegment(3); 
		$language->setLocale($idioma); 
		helper('form');
		helper('filesystem');
		$data['titulo'] = lang('message_lang.titulo_sol_idigital_consul');
		echo view('templates/header/header_dec_resp_cons', $data);
		echo view('pages/forms/form-dec-resp-consultor-idigital');
		echo view('templates/footer/footer');
	}
	//--------------------------------------------------------------------

	public function solicitud_adhesion_ils($page = 'forms/form-adhesion-ils')
	{
		helper('form');
		helper('filesystem');
		helper('cookie');
		$language = \Config\Services::language();
		$language->setLocale('ca'); 
		$cookie = array(
			'name'   => 'CurrentLanguage',
			'value'  => 'ca',                            
			'expire' => '7200',                                                                                   
			'secure' => true
			);
   		set_cookie($cookie);
		
		echo view('templates/header/header_form_adhesion_ils');
		echo view('pages/forms/form-adhesion-ils');
	}

	public function solicitud_adhesion_felib($page = 'forms/form-adhesion-felib')
	{
		helper('form');
		helper('filesystem');
		helper('cookie');
		$request = \Config\Services::request();
		$idioma =  $request->uri->getSegment(3);
		if (!$idioma) {
			$idioma = 'ca';
		}
		$language = \Config\Services::language();
		$language->setLocale($idioma); 
		$cookie = array(
			'name'   => 'CurrentLanguage',
			'value'  => $idioma,                            
			'expire' => '7200',                                                                                   
			'secure' => true
			);
   		set_cookie($cookie);
		echo view('templates/header/header_form_felib');
		echo view('pages/forms/form-adhesion-felib');
	}

	public function solicitud_adhesion_ils_es($page = 'forms/form-adhesion-ils')
	{
		helper('form');
		helper('filesystem');
		helper('cookie');
		$language = \Config\Services::language();
		$language->setLocale('es'); 
		$cookie = array(
			'name'   => 'CurrentLanguage',
			'value'  => 'es',                            
			'expire' => '7200',                                                                                   
			'secure' => true
			);
   		set_cookie($cookie);

		echo view('templates/header/header_form_adhesion_ils');
		echo view('pages/forms/form-adhesion-ils');
	}

	public function solicitud_linea_idi_isba($page = 'forms/linea-idi-isba', $idioma='ca') {
		helper('form');
		helper('filesystem');
		helper('cookie');
		$request = \Config\Services::request();
		$idioma =  $request->uri->getSegment(3);
		if (!$idioma) {
			$idioma = 'ca';
		}
		$language = \Config\Services::language();
		$language->setLocale($idioma); 
		$cookie = array(
			'name'   => 'CurrentLanguage',
			'value'  => $idioma,                            
			'expire' => '7200',                                                                                   
			'secure' => true
			);
   		set_cookie($cookie);

		$generalConfig = new ConfiguracionModel;
		$lineaConfig = new ConfiguracionLineaModel();
		
		$data['configuracion'] = $generalConfig->configuracionGeneral();
		$data['configuracionLinea'] = $lineaConfig->activeConfigurationLineData('ADR-ISBA',	2024 );
		  
		$isActiveLineData = $data['configuracionLinea']['activeLineData'];
		$desde = $data['configuracionLinea']['convocatoria_desde'];
		$hasta = $data['configuracionLinea']['convocatoria_hasta'];
   
		if ( date("Y-m-d")>= $desde && date("Y-m-d")<= $hasta) {
			echo view('templates/header/header_form_linea_idi_isba');
			echo view('pages/forms/form-linea-idi-isba');
			echo view('templates/footer/footer_form');
		} else {
			if ($idioma === 'ca') {
				$data['aviso'] = $data['configuracionLinea']['convocatoria_aviso_ca'];
				if($isActiveLineData === 'NO') {
					$data['activatedLine'] = "ADR Balears-ISBA<br><br>Linia d'ajuts NO ACTIVA";
				}
			} else {
				$data['aviso'] = $data['configuracionLinea']['convocatoria_aviso_es'];
				if($isActiveLineData === 'NO') {
					$data['activatedLine'] = "ADR Balears-ISBA<br><br>Linea de ayudas NO ACTIVA";
				}
			}
			$data['titulo'] = "ADR Balears - ISBA";
			echo view('pages/forms/form-solicitud-ayuda-desactivada', $data);
			echo view('templates/footer/footer_form');
		}
		
	}

	public function datos_empresa_ils( $id )
	{
		helper('form');
		helper('filesystem');
		helper('cookie');
		
		$language = \Config\Services::language();
		$language->setLocale('ca'); 
		$cookie = array(
			'name'   => 'CurrentLanguage',
			'value'  => 'ca',                            
			'expire' => '7200',                                                                                   
			'secure' => true
			);
   		set_cookie($cookie);
		$data = [
				'id' => $id,
				'idioma' => 'ca',
				'titulo' => "Dades adicionals de l'empresa per publicar a la web de ILS"
			];
		echo view('templates/header/header_form_ils', $data);
		echo view('pages/forms/form-datos-empresa-ils', $data);
		echo view('templates/footer/footer_form');
	}

	public function datos_empresa_ils_es( $id )
	{
		helper('form');
		helper('filesystem');
		helper('cookie');
		$language = \Config\Services::language();
		$language->setLocale('es'); 
		$cookie = array(
			'name'   => 'CurrentLanguage',
			'value'  => 'es',                            
			'expire' => '7200',                                                                                   
			'secure' => true
			);
   		set_cookie($cookie);
		$data = [
			'id' => $id,
			'idioma' => 'es',
			'titulo' => "Datos de la empresa para publicar en la web ILS"
		];
		echo view('templates/header/header_form_ils', $data);
		echo view('pages/forms/form-datos-empresa-ils', $data);
		echo view('templates/footer/footer_form');
	}

	public function escritura_empresa_ils( $id )
	{
		helper('form');
		helper('filesystem');
		helper('cookie');
		
		$language = \Config\Services::language();
		$language->setLocale('ca'); 
		$cookie = array(
			'name'   => 'CurrentLanguage',
			'value'  => 'ca',                            
			'expire' => '7200',                                                                                   
			'secure' => true
			);
   		set_cookie($cookie);
		$data = [
				'id' => $id,
				'idioma' => 'ca',
				'titulo' => "Sol·licitud del document Escriptura de l´empresa per a ILS"
			];
		echo view('templates/header/header_form_ils', $data);
		echo view('pages/forms/form-documento-escritura-empresa-ils', $data);
		echo view('templates/footer/footer_form');
	}

	public function informe_resum_ils( $id )
	{
		helper('form');
		helper('filesystem');
		helper('cookie');
		
		$language = \Config\Services::language();
		$language->setLocale('ca'); 
		$cookie = array(
			'name'   => 'CurrentLanguage',
			'value'  => 'ca',                            
			'expire' => '7200',                                                                                   
			'secure' => true
			);
   		set_cookie($cookie);
		$data = [
				'id' => $id,
				'idioma' => 'ca',
				'titulo' => "Sol·licitud del document Informe resum de la petjada de carboni per a ILS"
			];
		echo view('templates/header/header_form_ils', $data);
		echo view('pages/forms/form-documento-informe-resum-ils', $data);
		echo view('templates/footer/footer_form');
	}

	public function compromiso_reduccion_ils( $id )
	{
		helper('form');
		helper('filesystem');
		helper('cookie');
		
		$language = \Config\Services::language();
		$language->setLocale('ca'); 
		$cookie = array(
			'name'   => 'CurrentLanguage',
			'value'  => 'ca',                            
			'expire' => '7200',                                                                                   
			'secure' => true
			);
   		set_cookie($cookie);
		$data = [
				'id' => $id,
				'idioma' => 'ca',
				'titulo' => "Sol·licitud del document  Compromís de reducció de les emissions de gasos d'efecte hivernacle per a ILS"
			];
		echo view('templates/header/header_form_ils', $data);
		echo view('pages/forms/form-documento-compromiso-reduccion-ils', $data);
		echo view('templates/footer/footer_form');
	}

	public function certificado_IAE_ils( $id )
	{
		helper('form');
		helper('filesystem');
		helper('cookie');
		
		$language = \Config\Services::language();
		$language->setLocale('ca'); 
		$cookie = array(
			'name'   => 'CurrentLanguage',
			'value'  => 'ca',                            
			'expire' => '7200',                                                                                   
			'secure' => true
			);
   		set_cookie($cookie);
		$data = [
				'id' => $id,
				'idioma' => 'ca',
				'titulo' => "Sol·licitud del document Certificat d'alta d'IAE per a ILS"
			];
		echo view('templates/header/header_form_ils', $data);
		echo view('pages/forms/form-documento-certificado-iae-ils', $data);
		echo view('templates/footer/footer_form');
	}

	public function itinerario_formativo_ils( $id )
	{
		helper('form');
		helper('filesystem');
		helper('cookie');
		
		$language = \Config\Services::language();
		$language->setLocale('ca'); 
		$cookie = array(
			'name'   => 'CurrentLanguage',
			'value'  => 'ca',                            
			'expire' => '7200',                                                                                   
			'secure' => true
			);
   		set_cookie($cookie);
		$data = [
				'id' => $id,
				'idioma' => 'ca',
				'titulo' => "Sol·licitud del document ITINERARI FORMATIU per a ILS"
			];
		echo view('templates/header/header_form_ils', $data);
		echo view('pages/forms/form-documento-itinerario-formativo-ils', $data);
		echo view('templates/footer/footer_form');
	}

	public function informe_GEH_ils( $id )
	{
		helper('form');
		helper('filesystem');
		helper('cookie');
		
		$language = \Config\Services::language();
		$language->setLocale('ca'); 
		$cookie = array(
			'name'   => 'CurrentLanguage',
			'value'  => 'ca',                            
			'expire' => '7200',                                                                                   
			'secure' => true
			);
   		set_cookie($cookie);
		$data = [
				'id' => $id,
				'idioma' => 'ca',
				'titulo' => "Sol·licitud del document INFORME GEI per a ILS"
			];
		echo view('templates/header/header_form_ils', $data);
		echo view('pages/forms/form-documento-informe-gei-ils', $data);
		echo view('templates/footer/footer_form');
	}

	public function empresas_adheridas_ils () 
	{
		helper('cookie');
		$language = \Config\Services::language();
		$db = \Config\Database::connect();
		$language->setLocale('es');

		$sql = "SELECT pindust_expediente.id, empresa, nif, domicilio, canales_comercializacion_empresa, sitio_web_empresa, video_empresa, fecha_creacion_empresa, 
				name, pindust_documentos.selloDeTiempo, type

				FROM pindust_expediente
				INNER JOIN pindust_documentos
				ON pindust_expediente.id = pindust_documentos.id_sol WHERE publicar_en_web = 1 AND corresponde_documento = 'file_logotipoEmpresaIls';";

		$query = $db->query($sql);
		$data['empresas'] = $query->getResult();

		echo view('pages/forms/lista-empresas-ils', $data);
	}		

	public function empresas_adheridas_ils_detail ( $id ) 
	{
		helper('cookie');
		$language = \Config\Services::language();
		$db = \Config\Database::connect();
		$language->setLocale('es');

		$sql = "SELECT empresa, nif, domicilio, canales_comercializacion_empresa, sitio_web_empresa, video_empresa, localidad, telefono, fecha_creacion_empresa, 
			name, pindust_documentos.selloDeTiempo, type

			FROM pindust_expediente
			INNER JOIN pindust_documentos
			ON pindust_expediente.id = pindust_documentos.id_sol WHERE pindust_expediente.id = ".$id." AND corresponde_documento = 'file_logotipoEmpresaIls';";

		$query = $db->query($sql);
		$data['empresas'] = $query->getResult();

		echo view('pages/forms/detail-empresa-ils', $data);
	}
}