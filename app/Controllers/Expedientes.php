<?php namespace App\Controllers;
use CodeIgniter\I18n\Time; 
use CodeIgniter\Controller;
use App\Models\ExpedientesModel;
use App\Models\ConsultorModel;
use App\Models\DocumentosModel;
use App\Models\DocumentosTipoModel;
use App\Models\DocumentosJustificacionModel;
use App\Models\MejorasExpedienteModel;
use App\Models\ConfiguracionModel;

class Expedientes extends Controller
{	
	
	public function index()
    {
		$language = \Config\Services::language();
		$language->setLocale('ca');
		$session = session();
		$modelConfig = new ConfiguracionModel();
		$data['configuracion'] = $modelConfig->where('convocatoria_activa', 1)->first();
		$where = "";

		$rol =  $session->get('rol');

		$modelExp = new ExpedientesModel();
		if ($rol == 'admin') {
			if ($session->get('convocatoria_fltr')) {
				$where = "convocatoria = " . $session->get('convocatoria_fltr');
			}
			if ($session->get('programa_fltr')) {
				$where = "tipo_tramite = '" . $session->get('programa_fltr')."'";
			}
			if ($session->get('situacion_fltr')) {
				$where = "tipo_tramite = '" . $session->get('situacion_fltr')."'";
			}
			if ($session->get('textoLibre_fltr')) {
				$where .= " AND (fecha_completado LIKE '".$this->request->getVar('textoLibre_fltr')."%'
										OR idExp LIKE '%".$this->request->getVar('textoLibre_fltr')."%' 
										OR empresa LIKE '%".$this->request->getVar('textoLibre_fltr')."%' 
										OR email_rep LIKE '%".$this->request->getVar('textoLibre_fltr')."%' 
										OR telefono_rep LIKE '%".$this->request->getVar('textoLibre_fltr')."%' 
										OR nom_consultor LIKE '%".$this->request->getVar('textoLibre_fltr')."%' 
										OR situacion  LIKE '%".$this->request->getVar('textoLibre_fltr')."%' )";
			}
			$data['expedientes'] = $modelExp->orderBy('fecha_completado', 'DESC')
					->where($where)
					->findAll();
		} else {
			$where = "tipo_tramite = '" . $rol . "'";
			$data['expedientes'] = $modelExp->orderBy('fecha_completado', 'DESC')
					->where($where)
					->findAll();
		}

		$data['titulo'] = lang('message_lang.todas_las_solicitudes');
		echo view('templates/header/header', $data);
	    echo view('pages/exped/listado-expediente', $data);
		echo view('templates/footer/footer');
    }

	public function expedientesPrograma($sort_by = 'tipo_tramite', $sort_order = 'ASC')
    {
		$request = \Config\Services::request();
		$language = \Config\Services::language();
		$language->setLocale('ca');
		$modelExp = new ExpedientesModel();
		$session = session();
		$session->set('programa_fltr', '');
		$session->set('convocatoria_fltr', '');
		$session->set('textoLibre_fltr', '');
		$rol =  $session->get('rol');
		$where = "";

		$programa = str_replace("%20", " ", $request->uri->getSegment(3)); 
		$convocatoria = $request->uri->getSegment(4);
		$session->set('programa_fltr', $programa);

		$where = 'tipo_tramite = "' . $programa . '"'; 
			if ($this->request->getVar('convocatoria_fltr') || $convocatoria) {	
				$where .= ' AND convocatoria = ' . $convocatoria;
				$session->set('convocatoria_fltr', $convocatoria);
			}

		$data['expedientes'] = $modelExp->orderBy('fecha_completado', 'DESC')
				->where($where)
				->findAll();

		$data['titulo'] = "Sol·licituds d'ajuts i/o subvencions filtrades ";	

		$data['sort_by'] = 'fecha_completado';
		$data['sort_order'] = 'DESC';

		echo view('templates/header/header', $data);
		echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
	   	echo view('pages/exped/listado-expediente', $data);
		echo view('templates/footer/footer');	
		}	

	public function filtrarExpedientes($sort_by = 'fecha_completado', $sort_order = 'ASC')
    {
		$language = \Config\Services::language();
		$language->setLocale('ca');
		$modelExp = new ExpedientesModel();
		$session = session();

		if ( $this->request->getVar('programa_fltr' ) =="") {
			$session->set('programa_fltr', '');
		}

		if ( $this->request->getVar('situacion_fltr' ) =="") {
			$session->set('situacion_fltr', '');
		}

		if ( $this->request->getVar('textoLibre_fltr' ) =="") {
			$session->set('textoLibre_fltr', '');
		}

		$rol =  $session->get('rol');
		$where = "";

		switch ($rol) {
		case 'admin':
			if ($this->request->getVar('programa_fltr')) {
				$where = "tipo_tramite = '" . $this->request->getVar('programa_fltr') . "'";
				$session->set('programa_fltr', $this->request->getVar('programa_fltr'));
			}

			if ($this->request->getVar('convocatoria_fltr')) {	
				if ($this->request->getVar('programa_fltr')) {
					$where .= ' AND convocatoria = ' . $this->request->getVar('convocatoria_fltr');	
				} else {
					$where = 'convocatoria = ' . $this->request->getVar('convocatoria_fltr');
				}
				$session->set('convocatoria_fltr', $this->request->getVar('convocatoria_fltr'));
			}

			if ($this->request->getVar('situacion_fltr')) {	
				if ($this->request->getVar('programa_fltr')) {
					$where .= " AND situacion = '" . $this->request->getVar('situacion_fltr') . "'";
				} else if ($this->request->getVar('convocatoria_fltr')) {
					$where .= " AND situacion = '" . $this->request->getVar('situacion_fltr') . "'";
				} else {
					$where = "situacion = '" . $this->request->getVar('situacion_fltr'). "'";
				}
				$session->set('situacion_fltr', $this->request->getVar('situacion_fltr'));
			}			

			if ($this->request->getVar('textoLibre_fltr')) {
				if ($where) {
					$where .= " AND (fecha_completado LIKE '".$this->request->getVar('textoLibre_fltr')."%'
										OR idExp LIKE '%".$this->request->getVar('textoLibre_fltr')."%'
										OR empresa LIKE '%".$this->request->getVar('textoLibre_fltr')."%' 
										OR email_rep LIKE '%".$this->request->getVar('textoLibre_fltr')."%' 
										OR telefono_rep LIKE '%".$this->request->getVar('textoLibre_fltr')."%' 
										OR nom_consultor LIKE '%".$this->request->getVar('textoLibre_fltr')."%' 
										OR situacion  LIKE '%".$this->request->getVar('textoLibre_fltr')."%' )";
				}
				else {
						$where = " tipo_tramite LIKE '%".$this->request->getVar('textoLibre_fltr')."%'
										OR fecha_completado LIKE '".$this->request->getVar('textoLibre_fltr')."%'
										OR idExp LIKE '%".$this->request->getVar('textoLibre_fltr')."%'
										OR convocatoria LIKE '%".$this->request->getVar('textoLibre_fltr')."%'
										OR empresa LIKE '%".$this->request->getVar('textoLibre_fltr')."%' 
										OR email_rep LIKE '%".$this->request->getVar('textoLibre_fltr')."%' 
										OR telefono_rep LIKE '%".$this->request->getVar('textoLibre_fltr')."%' 
										OR nom_consultor LIKE '%".$this->request->getVar('textoLibre_fltr')."%' 
										OR situacion  LIKE '%".$this->request->getVar('textoLibre_fltr')."%' ";				
				}
				
				$session->set('textoLibre_fltr', $this->request->getVar('textoLibre_fltr'));
			}

			if ($this->request->getVar('programa_fltr') || $this->request->getVar('convocatoria_fltr') || $this->request->getVar('textoLibre_fltr')) {
				$data['expedientes'] = $modelExp->orderBy('fecha_completado', 'DESC')
					->where($where)
					->findAll();
			} else {
				$data['expedientes'] = $modelExp->orderBy('fecha_completado', 'DESC')
					->findAll();			
			}
		break;

		default:
			$session->set('programa_fltr', $rol);
			$where = 'tipo_tramite = "' . $rol . '"'; 
			if ($this->request->getVar('convocatoria_fltr')) {	
				$where .= ' AND convocatoria = ' . $this->request->getVar('convocatoria_fltr');
				$session->set('convocatoria_fltr', $this->request->getVar('convocatoria_fltr'));
			}

			if ($this->request->getVar('situacion_fltr')) {	
			 	if ($this->request->getVar('convocatoria_fltr')) {
					$where .= " AND situacion = '" . $this->request->getVar('situacion_fltr') . "'";
				} else {
					$where = "situacion = '" . $this->request->getVar('situacion_fltr'). "'";
				}
				$session->set('situacion_fltr', $this->request->getVar('situacion_fltr'));
			}				

			if ($this->request->getVar('textoLibre_fltr')) {
				$where .= " AND (empresa LIKE '%".$this->request->getVar('textoLibre_fltr')."%' 
									OR fecha_completado LIKE '%".$this->request->getVar('textoLibre_fltr')."%'
									OR idExp LIKE '%".$this->request->getVar('textoLibre_fltr')."%'
									OR email_rep LIKE '%".$this->request->getVar('textoLibre_fltr')."%' 
									OR telefono_rep LIKE '%".$this->request->getVar('textoLibre_fltr')."%' 
									OR nom_consultor LIKE '%".$this->request->getVar('textoLibre_fltr')."%' 
									OR situacion  LIKE '%".$this->request->getVar('textoLibre_fltr')."%' )";
				$session->set('textoLibre_fltr', $this->request->getVar('textoLibre_fltr'));
			}			
			
			$data['expedientes'] = $modelExp->orderBy('fecha_completado', 'DESC')
				->where($where)
				->findAll();
		}

		//echo $where;
		if (!$this->request->getVar('programa_fltr') && !$this->request->getVar('convocatoria_fltr') && !$this->request->getVar('textoLibre_fltr')) {
			$data['titulo'] = "Totes les sol·licituds";
		} else {
			$data['titulo'] = "Sol·licituds filtrades ";
		}
		$data['sort_by'] = 'fecha_completado';
		$data['sort_order'] = 'DESC';

		echo view('templates/header/header', $data);
		echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
	  echo view('pages/exped/listado-expediente', $data);
		echo view('templates/footer/footer');
	}
	
	function ordenarExpedientes($sort_by = 'fecha_REC', $sort_order = 'ASC') 
	{
		$modelExp = new ExpedientesModel();
        $data['expedientes'] = $modelExp->orderBy($sort_by, $sort_order)->findAll();
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;
        
		$data['titulo'] = lang('message_lang.todas_las_solicitudes');
		echo view('templates/header/header', $data);
		echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
	    echo view('pages/exped/listado-expediente', $data);
		echo view('templates/footer/footer');
	}
	
  public function create()
    {
		$data = [];
		echo view('templates/header/header', $data);	
        echo view('pages/exped/create-expediente');
		echo view('templates/footer/footer');	
    }
 
  public function store()
    {
        helper(['form', 'url']);
        $modelExp = new ExpedientesModel();
        $data = [
            'empresa' => $this->request->getVar('empresa'),
            'email'  => $this->request->getVar('email'),
            ];
        $save = $modelExp->insert($data);
        return redirect()->to( base_url('public/index.php/users') );
    }
 
  public function edit($id)
	{
		helper('filesystem');
		helper(['form', 'url']); 
		$language = \Config\Services::language();

		$idioma = 'ca';
		$language->setLocale($idioma);

		$modelConfig = new ConfiguracionModel();

		$data['configuracion'] = $modelConfig->where('convocatoria_activa', 1)->first();		
		$data['importeAyuda'] = $data['configuracion']['programa'];
    $data['abrirPanel'] = 0;
		
		$modelExp = new ExpedientesModel();
		$modelDocumentos = new DocumentosModel();
		$modelJustificacion = new DocumentosJustificacionModel();
		$modelMejorasSolicitud = new MejorasExpedienteModel();

		$db = \Config\Database::connect();

		$qry = "SELECT * FROM pindust_configuracion WHERE (convocatoria_activa = 1)";
		$query = $db->query($qry);
		$data['config_fechas_limite'] = $query->getResult();

		//-----------------------------------Comprueba si ya hay algún documento de justificación-------------------

		$data['totalDocsJustifPlan'] = $modelJustificacion->checkIfDocumentoJustificacion('file_PlanTransformacionDigital', $id);
		$data['totalDocsJustifFact'] = $modelJustificacion->checkIfDocumentoJustificacion('file_FactTransformacionDigital', $id);
		$data['totalDocsJustifPagos'] = $modelJustificacion->checkIfDocumentoJustificacion('file_PagosTransformacionDigital', $id);

		//-----------------------------Obtiene el detalle del Expediente----------------------------------------------
		
		$data['expedientes'] = $modelExp->where('id', $id)->first();
		
		$idExp =  $data['expedientes']['idExp'];
		$convocatoria = $data['expedientes']['convocatoria'];
		$tipo_tramite = $data['expedientes']['tipo_tramite'];
		$solicitante = mb_strtoupper ($data['expedientes']['empresa']);
		$nifcif = strtoupper($data['expedientes']['nif']);

		$data['totalConvocatorias'] = $modelExp->findNumberOfConvocatorias($nifcif, $tipo_tramite);

		$data['titulo'] = "Expedient: " . $idExp ."/". $convocatoria. " (".$tipo_tramite.") - ".$solicitante." - ".$nifcif;

		/* ----Busca si ya tenemos alguno de los documentos en el IDI y que en la solicitud lo han marcado como SI lo tenemos---- */
		if ($data['expedientes']['memoriaTecnicaEnIDI']) {
			$modelDocumentos->findIfDocumentIsInIDI($id, $nifcif, 'file_memoriaTecnica', $tipo_tramite, $convocatoria );
		}
		if ($data['expedientes']['altaRETA_docAcredEnIDI']) {
			$modelDocumentos->findIfDocumentIsInIDI($id, $nifcif, 'file_altaAutonomos', $tipo_tramite, $convocatoria );
		}
		if ($data['expedientes']['certificadoIAEEnIDI']) {
			$modelDocumentos->findIfDocumentIsInIDI($id, $nifcif, 'file_certificadoIAE', $tipo_tramite, $convocatoria );
		}
		if ($data['expedientes']['copiaNIFSociedadEnIDI']) {
			$modelDocumentos->findIfDocumentIsInIDI($id, $nifcif, 'file_nifEmpresa', $tipo_tramite, $convocatoria );
		}
		if ($data['expedientes']['pJuridicaDocAcreditativaEnIDI']) {
			$modelDocumentos->findIfDocumentIsInIDI($id, $nifcif, 'file_document_acred_como_repres', $tipo_tramite, $convocatoria );
		}
		/* --------------------------------------------------------------- */
		
		/* SELECCIONA TODOS LOS DOCUMENTOS ASOCIADOS AL EXPEDIENTE */
		$qry = "SELECT * FROM pindust_documentos WHERE (fase_exped = '') AND id_sol = " . $id;
		$query = $db->query($qry);
		$data['documentos'] = $query->getResult();
		/* ---------------------------------------------------------------- */

		/* Los documentos de la justificación por PLAN, FASCTURA, PAGOS */
		$data['documentosJustifPlan'] = $modelJustificacion->listDocumentosJustificacion('file_PlanTransformacionDigital', $id);
		$data['documentosJustifFact'] = $modelJustificacion->listDocumentosJustificacion('file_FactTransformacionDigital', $id);
		$data['documentosJustifPagos'] = $modelJustificacion->listDocumentosJustificacion('file_PagosTransformacionDigital', $id);
		
		$qry = "SELECT * FROM pindust_documentos WHERE (fase_exped <> '') AND id_sol = " . $id;  //Todos los documentos del expediente pertenecientes a cualquier fase
		$query = $db->query($qry);
		$data['documentosExpediente'] = $query->getResult();

		/* Lista de las MEJORAS de la solicitud */
		$data['mejorasSolicitud'] = $modelMejorasSolicitud->selectAllMejorasExpediente($id);
		$data['ultimaMejoraSolicitud'] = $modelMejorasSolicitud->selectLastMejorasExpediente($id);

		/* Muestra la vista */
		echo view('templates/header/header', $data);
		echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);	
		if ( $tipo_tramite === 'ILS') {
			echo view('pages/exped/edita-expediente-ils', $data);
		} else if ( $tipo_tramite === 'IDI-ISBA') {
			echo view('pages/exped/edita-expediente-idi-isba', $data);
		} else {
			echo view('pages/exped/edita-expediente', $data);
		}
		echo view('templates/footer/footer');
	}
	
  public function do_upload($id = null, $nif = null, $tipo_tramite = null, $convocatoria = null, $tipoJustDoc = null, $faseExped = null)
  {
		helper('filesystem');
		helper(['form', 'url']); 
		$request = \Config\Services::request();
		
		$data['abrirPanel'] = 3;
		$modelExp = new ExpedientesModel();
		$modelCons = new ConsultorModel();		
			
		$db = \Config\Database::connect();
		$documentosJustif = $db->table('pindust_documentos_justificacion');
		$docsExpediente = $db->table('pindust_documentos');                      // Renombrar con una etiqueta más genérica
		date_default_timezone_set("Europe/Madrid");
		$selloTiempo = date("d_m_Y_h_i_sa");
		$id_sol =  $request->uri->getSegment(3);
		$nif =  $request->uri->getSegment(4);
		$tipo_tramite = str_replace("%20"," ",$tipo_tramite);
		// Sube el plan
		if($tipoJustDoc == "plan")
				{
				$documentosfile = $this->request->getFiles();
				foreach($documentosfile['file_PlanTransformacionDigital'] as $plan)
				{
				if ($plan->isValid() && ! $plan->hasMoved())
					{
					// $newName = $plan->getRandomName();
					$plan->move(WRITEPATH.'documentos/'.$nif.'/justificacion/'.$selloTiempo.'/', str_replace(" ","_",$plan->getName()));
					$data_file = [
					'name' =>  str_replace(" ","_",$plan->getName()),
					'type' => $plan->getClientMimeType(),
					'cifnif_propietario' => $nif,
					'tipo_tramite' => $tipo_tramite." ".$convocatoria,
					'corresponde_documento' => 'file_PlanTransformacionDigital',
					'datetime_uploaded' => time(),
					'convocatoria' => $convocatoria,
					'created_at'  => $plan->getTempName(),
					'selloDeTiempo'  => $selloTiempo,
					'id_sol'         => $id_sol
					];
					$save = $documentosJustif->insert($data_file);
					}
				}
			}
				
		// Sube las facturas
		if($tipoJustDoc == "factura")
				{
				$documentosfile = $this->request->getFiles();
				foreach($documentosfile['file_FactTransformacionDigital'] as $factura)
				{
				if ($factura->isValid() && ! $factura->hasMoved())
					{
					// $newName = $factura->getRandomName();
					$factura->move(WRITEPATH.'documentos/'.$nif.'/justificacion/'.$selloTiempo.'/', str_replace(" ","_",$factura->getName()));
					$data_file = [
					'name' => str_replace(" ","_",$factura->getName()),
					'type' => $factura->getClientMimeType(),
					'cifnif_propietario' => $nif,
					'tipo_tramite' => $tipo_tramite." ".$convocatoria,
					'corresponde_documento' => 'file_FactTransformacionDigital',
					'datetime_uploaded' => time(),
					'convocatoria' => $convocatoria,
					'created_at'  => $factura->getTempName(),
					'selloDeTiempo'  => $selloTiempo,
					'id_sol'         => $id_sol
					];
					$save = $documentosJustif->insert($data_file);
					}
				}
			}
				
		// Sube los pagos
		if($tipoJustDoc == "pagos")
				{
				$documentosfile = $this->request->getFiles();
				foreach($documentosfile['file_PagosTransformacionDigital'] as $pagos)
				{
				if ($pagos->isValid() && ! $pagos->hasMoved())
					{
					// $newName = $pagos->getRandomName();
					$pagos->move(WRITEPATH.'documentos/'.$nif.'/justificacion/'.$selloTiempo.'/', str_replace(" ","_",$pagos->getName()));
					$data_file = [
					'name' => str_replace(" ","_",$pagos->getName()),
					'type' => $pagos->getClientMimeType(),
					'cifnif_propietario' => $nif,
					'tipo_tramite' => $tipo_tramite." ".$convocatoria,
					'corresponde_documento' => 'file_PagosTransformacionDigital',
					'datetime_uploaded' => time(),
					'convocatoria' => $convocatoria,
					'created_at'  => $pagos->getTempName(),
					'selloDeTiempo'  => $selloTiempo,
					'id_sol'         => $id_sol
					];
					$save = $documentosJustif->insert($data_file);
					}
				}
			}
				
		// Sube los documentos según la fase del expediente
		if($faseExped == "Solicitud" || $faseExped == "Validacion" || $faseExped == "Ejecucion" || $faseExped == "Justificacion" || $faseExped == "Desestimiento" || $faseExped == "Adhesion" || $faseExped == "Seguimient" || $faseExped == "Renovacion")
				{
				$documentosfile = $this->request->getFiles();
				foreach($documentosfile['file_faseExped'.$faseExped] as $resguardo)
					{
					$fileName = $resguardo->getName();
					$fullPath = WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/';
					if ($resguardo->isValid() && ! $resguardo->hasMoved())
						{
						// $newName = $resguardo->getRandomName();
						$resguardo->move($fullPath, str_replace(" ","_",$fileName));
						$data_file = [
						'name' 						=> str_replace(" ","_",$fileName),
						'type' 						=> $resguardo->getClientMimeType(),
						'cifnif_propietario' 		=> $nif,
						'tipo_tramite' 				=> $tipo_tramite,
						'corresponde_documento' 	=> 'file_faseExped'.$tipo_tramite,
						'datetime_uploaded' 		=> time(),
						'convocatoria' 				=> $convocatoria,
						'created_at' 				=> $resguardo->getTempName(),
						'selloDeTiempo' 			=> $selloTiempo,
						'id_sol'         			=> $id_sol,
						'fase_exped'				=> $faseExped,
						'docRequerido'			=> 'NO'
						];
						$save = $docsExpediente->insert($data_file);
						}
						if ($resguardo->guessExtension() === 'zip') {
							$numRegDistribucioCAIB = substr($fileName,0,-4);
							$fileZip = new \ZipArchive();
							if ($fileZip->open($fullPath.$fileName)===TRUE) {
								for ($x = 0; $x <= $fileZip->count(); $x++) {
									$fileZip->renameName($fileZip->getNameIndex($x), str_ireplace(" ","",$fileZip->getNameIndex($x)));
									$fileZipContent = $fileZip->statIndex($x);
									$data_file = [
										'name' 						=> $fileZipContent['name'],
										'type' 						=> 'application/pdf',
										'cifnif_propietario' 		=> $nif,
										'tipo_tramite' 				=> $tipo_tramite,
										'corresponde_documento' 	=> 'file_faseExped'.$tipo_tramite,
										'datetime_uploaded' 		=> time(),
										'convocatoria' 				=> $convocatoria,
										'created_at' 				=> $resguardo->getTempName(),
										'selloDeTiempo' 			=> $selloTiempo,
										'id_sol'         			=> $id_sol,
										'fase_exped'				=> $faseExped
										];
									$save = $docsExpediente->insert($data_file); //Inserto el archivo en bbdd
									$fileZip->extractTo($fullPath, $fileZipContent['name']); //Descomprimo el archivo en el servidor
							  	}
								$fileZip->close();
							}
							// Actualizo el campo referencia REC a partir del nombre del archivo zip.
							// Según la fase:
							//Solicitud
							//Justificacion
							//Desestimiento
								switch ($faseExped) {
									case "Solicitud":
										//Compruebo si el campo Referència REC justificació ya tiene un valor.
										$query = $db->query("SELECT ref_REC FROM pindust_expediente WHERE id = ".$id); 
										$row = $query->getRow();
										// si no lo tiene lo actualizo 
										if (strlen($row->ref_REC) == 0) {
											$sql = 'UPDATE pindust_expediente SET ref_REC="'. $numRegDistribucioCAIB .'" WHERE id =' . $id;
										} else {
											$sql = 'UPDATE pindust_expediente SET ref_REC_enmienda="'. $numRegDistribucioCAIB .'" WHERE id =' . $id;
										}
										break;
									case "Justificacion":
										//Compruebo si el campo Referència REC justificació ya tiene un valor.
										$query = $db->query("SELECT ref_REC_justificacion FROM pindust_expediente WHERE id = ".$id); 
										$row = $query->getRow();
										// si no lo tiene lo actualizo 
										if (strlen($row->ref_REC_justificacion) == 0) {
											$sql = 'UPDATE pindust_expediente SET ref_REC_justificacion="'. $numRegDistribucioCAIB .'" WHERE id =' . $id;
										} else {
											$sql = 'UPDATE pindust_expediente SET ref_REC_requerimiento_justificacion="'. $numRegDistribucioCAIB .'" WHERE id =' . $id;
										}
										break;
									case "Desestimiento":
										$sql = 'UPDATE pindust_expediente SET ref_REC_desestimiento="'. $numRegDistribucioCAIB .'" WHERE id =' . $id;
										break;
								}
								if ($db->simpleQuery($sql)) {
									echo "Success!";
								} else {
									echo "Query failed!";
								}
						}
					}
				$data['resguardoREC_subido'] = true;
				}
				
			$data['expedientes'] = $modelExp->where('id', $id)->first();
			$convocatoria = $data['expedientes']['convocatoria'];
			$tipo_tramite = $data['expedientes']['tipo_tramite'];
			$solicitante = strtoupper($data['expedientes']['empresa']);
			$nifcif = strtoupper($data['expedientes']['nif']);
			$idExp =  $data['expedientes']['idExp'];
			$data['consultor'] = $modelCons->where('id_sol', $id)->first();	
			$qry = "SELECT * FROM pindust_documentos WHERE (fase_exped = '') AND id_sol = " . $id;

			$query = $db->query($qry);
			$data['documentos'] = $query->getResult();	
			
			$qry = "SELECT * FROM pindust_documentos_justificacion WHERE (corresponde_documento = 'file_PlanTransformacionDigital' AND id_sol = " . $id . ")";
			$query = $db->query($qry);
			$data['documentosJustifPlan'] = $query->getResult();
			$query = $db->query("SELECT COUNT(id) AS totalDocsJustifPlan FROM pindust_documentos_justificacion WHERE (corresponde_documento = 'file_PlanTransformacionDigital' AND id_sol = $id)");
		
			foreach ($query->getResult('array') as $row)
			{
			$data['totalDocsJustifPlan'] = $row['totalDocsJustifPlan'];
			}
		
		$qry = "SELECT * FROM pindust_documentos_justificacion WHERE (corresponde_documento = 'file_FactTransformacionDigital' AND id_sol = " . $id . ")";
		$query = $db->query($qry);
		$data['documentosJustifFact'] = $query->getResult();			
		$query = $db->query("SELECT COUNT(id) AS totalDocsJustifFact FROM pindust_documentos_justificacion WHERE (corresponde_documento = 'file_FactTransformacionDigital' AND id_sol = $id)");
		foreach ($query->getResult('array') as $row)
			{
			$data['totalDocsJustifFact'] = $row['totalDocsJustifFact'];
			}			

		$qry = "SELECT * FROM pindust_documentos_justificacion WHERE (corresponde_documento = 'file_PagosTransformacionDigital' AND id_sol = " . $id . ")";
		$query = $db->query($qry);
		$data['documentosJustifPagos'] = $query->getResult();		
		$query = $db->query("SELECT COUNT(id) AS totalDocsJustifPagos FROM pindust_documentos_justificacion WHERE (corresponde_documento = 'file_PagosTransformacionDigital' AND id_sol = $id)");
		foreach ($query->getResult('array') as $row)
			{
			$data['totalDocsJustifPagos'] = $row['totalDocsJustifPagos'];
			}
		$data['titulo']  = "Expedient: " . $idExp ."/". $convocatoria. " (".$tipo_tramite.") - ".$solicitante." - ".$nifcif;
		return redirect()->to(base_url("/public/index.php/expedientes/edit/".$id));
  }

  public function do_justificacion_upload($id, $nif, $tipo_tramite, $convocatoria, $idioma)
    {
			helper('filesystem');
			helper(['form', 'url']); 
			helper('cookie');
			$language = \Config\Services::language();
			$language->setLocale($idioma);

			set_cookie('pindust_id',$id,'3600');
			set_cookie('nif', $nif,'3600');
			set_cookie('tipoTramite', $tipo_tramite,'3600');
			set_cookie('convocatoria', $convocatoria,'3600');
			set_cookie('idioma', $idioma,'3600');

			$db = \Config\Database::connect();
			$documentosJustif = $db->table('pindust_documentos_justificacion');
			date_default_timezone_set("Europe/Madrid");
			$selloTiempo = date("d_m_Y_h_i_sa");
			$tipo_tramite = str_replace("%20", " ", $tipo_tramite);

			// Sube el plan
			$documentosfile = $this->request->getFiles();
			foreach($documentosfile['file_PlanTransformacionDigital'] as $plan)
				{
				if ($plan->isValid() && ! $plan->hasMoved())
					{
					$newName = $plan->getRandomName();
					$plan->move(WRITEPATH.'documentos/'.$nif.'/justificacion/'.$selloTiempo.'/', $newName);
					$data_file = [
					'name' =>  $newName,					
					'type' => $plan->getClientMimeType(),
					'cifnif_propietario' => $nif,
					'tipo_tramite' => $tipo_tramite, //$tipo_tramite[0]." ".$tipo_tramite[1],
					'corresponde_documento' => 'file_PlanTransformacionDigital',
					'datetime_uploaded' => time(),
					'convocatoria' => $convocatoria,
					'created_at'  => $plan->getTempName(),
					'selloDeTiempo'  => $selloTiempo,
					'id_sol'         => $id
					];
					$save = $documentosJustif->insert($data_file);
					$last_insert_id = $save->connID->insert_id;
					}
				}
				/* if ($tipo_tramite == "Programa I" || $tipo_tramite == 'Programa iDigital 20') { */

				// Sube las facturas
				$documentosfile = $this->request->getFiles();
				foreach($documentosfile['file_FactTransformacionDigital'] as $factura)
					{
					if ($factura->isValid() && ! $factura->hasMoved())
						{
						$newName = $factura->getRandomName();
						$factura->move(WRITEPATH.'documentos/'.$nif.'/justificacion/'.$selloTiempo.'/', $newName);
						$data_file = [
						'name' => $newName,
						'type' => $factura->getClientMimeType(),
						'cifnif_propietario' => $nif,
						'tipo_tramite' => $tipo_tramite, //$tipo_tramite[0]." ".$tipo_tramite[1],
						'corresponde_documento' => 'file_FactTransformacionDigital',
						'datetime_uploaded' => time(),
						'convocatoria' => $convocatoria,
						'created_at'  => $factura->getTempName(),
						'selloDeTiempo'  => $selloTiempo,
						'id_sol'         => $id
						];
						$save = $documentosJustif->insert($data_file);
						$last_insert_id = $save->connID->insert_id;
						}
					}
				
				// Sube los pagos
				$documentosfile = $this->request->getFiles();
				foreach($documentosfile['file_PagosTransformacionDigital'] as $pagos)
					{
					if ($pagos->isValid() && ! $pagos->hasMoved())
						{
						$newName = $pagos->getRandomName();
						$pagos->move(WRITEPATH.'documentos/'.$nif.'/justificacion/'.$selloTiempo.'/', $newName);
						$data_file = [
						'name' => $newName,
						'type' => $pagos->getClientMimeType(),
						'cifnif_propietario' => $nif,
						'tipo_tramite' => $tipo_tramite, //$tipo_tramite[0]." ".$tipo_tramite[1],
						'corresponde_documento' => 'file_PagosTransformacionDigital',
						'datetime_uploaded' => time(),
						'convocatoria' => $convocatoria,
						'created_at'  => $pagos->getTempName(),
						'selloDeTiempo'  => $selloTiempo,
						'id_sol'         => $id
						];
						$save = $documentosJustif->insert($data_file);
						$last_insert_id = $save->connID->insert_id;
						}
					}	
					/* } */
					/* ------------------ actualiza el estado del expediente a 'pendienteRECJustificar' ---------------*/
					$sql = 'UPDATE pindust_expediente SET situacion="pendienteRECJustificar" WHERE id =' . $id;
					$db->simpleQuery($sql);
					/*-------------------------------------------------------------------------------------------------*/
		
				$data['titulo'] = "Expedient: " . $id ." / ". $tipo_tramite[1];
				$query = $db->query("SELECT * FROM pindust_expediente WHERE id =" . $id);
				$expediente = $query->getResult();
				foreach($expediente as $exped_item):
					$data['telefono_not'] = $exped_item->telefono_rep;
					$data['email_not'] = $exped_item->email_rep;
					$data['nif'] = $exped_item->nif;
				endforeach;
				$data['selloTiempo'] = $selloTiempo;
				$data['id'] = $id;
				echo view('templates/header/header_form_requerimiento_resultado', $data);
				echo view('pages/forms/documento-justificacion-ayuda', $data);
				echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
				echo view('pages/forms/rest_api_firma/envia-a-firma-justificacion', $data);		
				echo view('templates/footer/footer');
    }
		
	public function update()
	{
		helper(['form', 'url']);
		helper('date');
		$modelExp = new ExpedientesModel();
		$db = \Config\Database::connect();
		$builder = $db->table('pindust_expediente');
        $id = $this->request->getVar('id');

		$fechacompletado = $this->request->getVar('fecha_solicitud');
		$fechaREC = date('Y-m-d H:i:s',strtotime(str_replace("/","-",$this->request->getVar('fecha_REC')))); 
		//$fechaEnmienda = date('Y-m-d H:i:s',strtotime(str_replace("/","-",$this->request->getVar('fecha_enmienda'))));
		$fechaEnmienda = date('Y-m-d H:i:s',strtotime(str_replace("/","-",$this->request->getVar('fecha_REC_enmienda'))));
		if (strlen($fechaREC >0) && $fechaREC != '1970-01-01 01:00:00' && $fechaEnmienda != '0000-00-00 00:00:00') {
		if ($fechaREC > $fechacompletado) {
				$fechacompletado = $fechaREC;
			}
		}
		if (strlen($fechaEnmienda >0) && $fechaEnmienda != '1970-01-01 01:00:00' && $fechaEnmienda != '0000-00-00 00:00:00' && $fechaEnmienda != '1969-12-31 18:00:00') {
		if ($fechaEnmienda > $fechacompletado) {
				$fechacompletado = $fechaEnmienda;
			}
			else {
				$fechacompletado = $fechaREC;
			}
		}
        $data = [
			'fecha_completado' => $fechacompletado,
			'fecha_kick_off' => $this->request->getVar('fecha_kick_off'),
			'fecha_REC' => $fechaREC,
			'fecha_REC_enmienda' => date('Y-m-d H:i:s',strtotime(str_replace("/","-",$this->request->getVar('fecha_REC_enmienda')))),
			'fecha_REC_amp_termino' => date('Y-m-d H:i:s',strtotime(str_replace("/","-",$this->request->getVar('fecha_REC_amp_termino')))),
			'fecha_REC_justificacion' => date('Y-m-d H:i:s',strtotime(str_replace("/","-",$this->request->getVar('fecha_REC_justificacion')))),
			'fecha_REC_requerimiento_justificacion' => date('Y-m-d H:i:s',strtotime(str_replace("/","-",$this->request->getVar('fecha_REC_requerimiento_justificacion')))),
			'fecha_REC_desestimiento' => date('Y-m-d H:i:s',strtotime(str_replace("/","-",$this->request->getVar('fecha_REC_desestimiento')))),
			'fecha_limite_consultoria' => $this->request->getVar('fecha_limite_consultoria'),
			'fecha_reunion_cierre' => $this->request->getVar('fecha_reunion_cierre'),
			'fecha_limite_justificacion' => $this->request->getVar('fecha_limite_justificacion'),
			'fecha_max_desp_ampliacion' => $this->request->getVar('fecha_max_desp_ampliacion'),
			'fecha_propuesta_resolucion' => $this->request->getVar('fecha_propuesta_resolucion'),
			'fecha_propuesta_resolucion_notif' => $this->request->getVar('fecha_propuesta_resolucion_notif'),
			'fecha_resolucion' => $this->request->getVar('fecha_resolucion'),
			'fecha_notificacion_resolucion' => $this->request->getVar('fecha_notificacion_resolucion'),
			'fecha_requerimiento' => $this->request->getVar('fecha_requerimiento'),
			'fecha_requerimiento_notif' => $this->request->getVar('fecha_requerimiento_notif'),
			'fecha_firma_requerimiento_justificacion' => $this->request->getVar('fecha_firma_requerimiento_justificacion'),
			'fecha_firma_resolucion_desestimiento' => $this->request->getVar('fecha_firma_resolucion_desestimiento'),
			'fecha_notificacion_desestimiento' => $this->request->getVar('fecha_notificacion_desestimiento'),
			'fecha_de_pago' => $this->request->getVar('fecha_de_pago'),

			'fecha_infor_fav_desf' => $this->request->getVar('fecha_infor_fav_desf'),
			'fecha_amp_termino' => $this->request->getVar('fecha_amp_termino'),
			'fecha_res_liquidacion' => $this->request->getVar('fecha_res_liquidacion'),
			'fecha_not_liquidacion' => $this->request->getVar('fecha_not_liquidacion'),

			'ref_REC' => $this->request->getVar('ref_REC'),
			'ref_REC_enmienda' => $this->request->getVar('ref_REC_enmienda'),
			'ref_REC_amp_termino' => $this->request->getVar('ref_REC_amp_termino'),
			'ref_REC_justificacion' => $this->request->getVar('ref_REC_justificacion'),
			'ref_REC_requerimiento_justificacion' => $this->request->getVar('ref_REC_requerimiento_justificacion'),
			'ref_REC_desestimiento' => $this->request->getVar('ref_REC_desestimiento'),

			'situacion' => $this->request->getVar('situacion_exped'),
			'empresa' => $this->request->getVar('empresa'),
			'nif' => $this->request->getVar('nif'),
			//'domicilio' => $this->request->getVar('domicilio'),
			//'cpostal' => $this->request->getVar('cpostal'),
			//'telefono' => $this->request->getVar('telefono'),		
			'nombre_rep' => $this->request->getVar('nombre_rep'),
			'nif_rep' => $this->request->getVar('nif_rep'),
			'domicilio_rep' => $this->request->getVar('domicilio_rep'),
			'telefono_rep' => $this->request->getVar('telefono_rep'),
			'email_rep' => $this->request->getVar('email_rep'),
			'nom_consultor' => $this->request->getVar('nom_consultor'),
			'tel_consultor' => $this->request->getVar('tel_consultor'),
			'mail_consultor' => $this->request->getVar('mail_consultor'),
            'importeAyuda' => $this->request->getVar('importeAyuda'),
            'porcentajeConcedido' => $this->request->getVar('porcentajeConcedido'),
            'motivoDenegacion' => $this->request->getVar('motivoDenegacion'),
			'motivoRequerimiento' => $this->request->getVar('motivoRequerimiento'),
			'tecnicoAsignado' => $this->request->getVar('tecnicoAsignado')				
			];
       	$builder->where('id', $id);
		$save_exped = $builder->update($data);
		//var_dump($data);
        $data['expedientes'] = $modelExp->orderBy('id', 'DESC')->findAll();
		$data['titulo'] = lang('message_lang.todas_las_solicitudes');
		echo view('templates/header/header', $data);
		//echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
	    echo view('pages/exped/listado-expediente', $data);
		echo view('templates/footer/footer');
	}
	
	public function delete($id = null)
    {
			$modelExp = new ExpedientesModel();
			$data['user'] = $modelExp->where('id', $id)->delete();
			echo view('templates/header/header', $data);      
			echo redirect()->to( base_url('public/index.php/users') );
			echo view('templates/footer/footer');			
    }
	
  public function configurador_update()
    {
      helper(['form', 'url']);
			$db      = \Config\Database::connect();
			$builder = $db->table('pindust_configuracion');
			$tipo_tramite = "";
      $data = [
			'dias_res_den' => $this->request->getVar('dias_res_den'),
			'dias_not_def' => $this->request->getVar('dias_not_def'),
			'dias_resp_def_usu' => $this->request->getVar('dias_resp_def_usu'),
			'dias_prop_res' => $this->request->getVar('dias_prop_res'),
			'dias_resol_just' => $this->request->getVar('dias_resol_just'),
			'dias_resp_just_usu' => $this->request->getVar('dias_resp_just_usu'),
			'mail_registro' => $this->request->getVar('mail_registro'),
			'tipo_tramite' => $this->request->getVar('tipo_tramite'),
            ];
      $builder->where('tipo_tramite', $tipo_tramite);
			$save = $builder->update($data);
			echo "<pre><code>Dades actualitzades...</code></pre>";
    } 	
	
	public function muestradocumento ()
	{
		$this->response->setHeader('Cache-Control', 'private');
		$request = \Config\Services::request();
		$file =  $request->uri->getSegment(3); 
		$nifcif =  $request->uri->getSegment(4);
		$selloDeTiempo = $request->uri->getSegment(5);
		$tipoMIME =  $request->uri->getSegment(6).'/'.$request->uri->getSegment(7);
		$esJustificacion =  $request->uri->getSegment(8);
		echo $esJustificacion;
		switch ($tipoMIME)
			{
			case "image/jpeg":
				$this->response->setHeader('Content-type', 'image/jpeg');
			break;
			
			case "application/pdf":
				$this->response->setHeader('Content-type', 'application/pdf');
			break;
			
			case "application/octet-stream":
				$this->response->setHeader('Content-type', 'application/octet-stream');
			break;

			case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
				$this->response->setHeader('Content-type', 'application/octet-stream');
			break;
			
			case "image/png":
				$this->response->setHeader('Content-type', 'image/png');
			break;

			case "image/webp":
				$this->response->setHeader('Content-type', 'image/webp');
			break;

			}

		if ($esJustificacion != "justificacion") {
			echo file_get_contents(WRITEPATH.'documentos/'.$nifcif.'/'.$selloDeTiempo.'/'.$file);
		} 
		else
		{
			echo file_get_contents(WRITEPATH.'documentos/'.$nifcif.'/justificacion/'.$selloDeTiempo.'/'.$file);
		}
		
	}

	public function muestrainforme ()
	{
		$this->response->setHeader('Cache-Control', 'private');
		$request = \Config\Services::request();
		$id =  $request->uri->getSegment(3);
		$convocatoria = $request->uri->getSegment(4);
		$programa = str_replace("%20"," ", $request->uri->getSegment(5));
		$nifcif = mb_strtoupper ($request->uri->getSegment(6));

		$documento = $request->uri->getSegment(7);
		$db = \Config\Database::connect();

		$query = $db->query("SELECT * FROM pindust_documentos_generados WHERE id_sol=".$id." AND convocatoria='".$convocatoria."' AND corresponde_documento='".$documento."'");
		foreach ($query->getResult() as $row)
			{
    		$file = $row->name;
    		$nifcif = $row->cifnif_propietario;
			}

		$query = $db->query("SELECT * FROM pindust_expediente WHERE id=".$id);
		foreach ($query->getResult() as $row)
			{
    		$idExp = $row->idExp;
			$convocatoria = $row->convocatoria;
			}

		if ($convocatoria>=2022) {	// a partir del 2022 hemos cambiado el nombre de los modelos de documento a IDEXP_CONVO_NOMMODELO.pdf
			$file = str_replace("doc_" ,$idExp."_".$convocatoria."_" ,$file);
		}

		$this->response->setHeader('Content-type', 'application/pdf');
		echo file_get_contents(WRITEPATH.'documentos/'.$nifcif.'/informes/'.$file);
	}

	public function generainforme ()
	{
	    date_default_timezone_set("Europe/Madrid");
	    $selloDeTiempo = date("d_m_Y_h_i_sa");
	    $db = \Config\Database::connect();
		$builder = $db->table('pindust_expediente');
		$this->response->setHeader('Cache-Control', 'private');
		$request = \Config\Services::request();
		$id_sol =  $request->uri->getSegment(3);
		$convocatoria = $request->uri->getSegment(4);
		
		$data['id'] =  $id_sol;
		$data['convocatoria'] = $convocatoria;
		$data['programa'] = str_replace("%20"," ", $request->uri->getSegment(5));
		$data['nifcif'] = mb_strtoupper ($request->uri->getSegment(6));
		$data['byCEOSigned'] = false;
		$tipoDocumento = $request->uri->getSegment(7);

		$query = $builder->select('idExp')->where('id', $id_sol)->get()->getResult();

		foreach ($query as $row) {
			$idExp = $row->idExp;
		}

		$nombreDocumento = $tipoDocumento.".pdf";
		if ($convocatoria>=2022) {	// a partir del 2022 hemos cambiado el nombre de los modelos de documento a IDEXP_CONVO_NOMMODELO.pdf
			$data['nombreDocumento'] = str_replace("doc_" ,$idExp."_".$convocatoria."_" ,$nombreDocumento);
		}
		$documentos = $db->table('pindust_documentos_generados');
		$documentos->where('id_sol', $id_sol);
		$documentos->where('corresponde_documento', $tipoDocumento);
		$documentos->where('convocatoria', $convocatoria);
		$documentos->delete();

		$data_file = [
		    'id_sol' => $request->uri->getSegment(3),
		    'name' =>  $tipoDocumento.".pdf",
		    'type' => 'application/pdf',
		    'cifnif_propietario' => $request->uri->getSegment(6),
		    'tipo_tramite' => str_replace("%20"," ", $request->uri->getSegment(5)),
		    'corresponde_documento' => $tipoDocumento,
		    'datetime_uploaded' => time(),
		    'convocatoria' => $request->uri->getSegment(4),
		    'created_at'  => WRITEPATH.'documentos/'.$data['nifcif'].'/informes/'.$selloDeTiempo.'/'. $tipoDocumento.".pdf",
		    'selloDeTiempo'  => $selloDeTiempo
		];
		
		$save = $documentos->insert($data_file);
		$last_insert_id = $db->insertID();
		$data['last_insert_id'] = $last_insert_id;
		$dir = WRITEPATH.'documentos/'.$request->uri->getSegment(6).'/informes/';

		if (!is_dir($dir)){
		    mkdir($dir, 0775);
		}
		echo view('templates/header/header', $data);
		switch ($tipoDocumento)
			{
				case "doc_informe_favorable_con_requerimiento":  //va a VIAFIRMA DOC 1
			        $data_infor = [
			        	'doc_informe_favorable_con_requerimiento' => $last_insert_id
					];
			        $builder->where('id', $request->uri->getSegment(3));
			        $save_exped = $builder->update($data_infor);
					$data_footer = [
						'tipoDoc' => "  Informe favorable amb requeriment",
						'conVIAFIRMA' => true
					];
					echo view('pages/forms/modDocs/pdf/plt-informe-favorable-con-requerimiento', $data);
					echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
					echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
					echo view('pages/forms/go-back-footer', $data_footer);
			        break;

				case "doc_informe_favorable_sin_requerimiento":  //va a VIAFIRMA DOC 2
					$data_infor = [
						'doc_informe_favorable_sin_requerimiento' => $last_insert_id
					];
					$builder->where('id', $request->uri->getSegment(3));
					$save_exped = $builder->update($data_infor);
					$data_footer = [
						'tipoDoc' => "  Informe favorable sense requeriment",
						'conVIAFIRMA' => true
					];
					echo view('pages/forms/modDocs/pdf/plt-informe-favorable-sin-requerimiento', $data);
					echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
					echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
					echo view('pages/forms/go-back-footer', $data_footer);
					break;

				case "doc_requeriment":  //va a VIAFIRMA DOC 3
					$data_infor = [
						'doc_requeriment' => $last_insert_id
					];
					$builder->where('id', $request->uri->getSegment(3));
					$save_exped = $builder->update($data_infor);
					$data_footer = [
						'tipoDoc' => " El requeriment",
						'conVIAFIRMA' => true
					];
					echo view('pages/forms/modDocs/pdf/plt-requerimiento', $data);
					echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
					echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
					echo view('pages/forms/go-back-footer', $data_footer);
					break;					

				case "doc_informe_desfavorable_sin_requerimiento":  //va a VIAFIRMA DOC 4
			        $data_infor = [
			        	'doc_informe_desfavorable_sin_requerimiento' => $last_insert_id
					];
			        $builder->where('id', $request->uri->getSegment(3));
			        $save_exped = $builder->update($data_infor);
					$data_footer = [
						'tipoDoc' => " Informe desfavorable sense requeriment",
						'conVIAFIRMA' => true
					];
			        echo view('pages/forms/modDocs/pdf/plt-informe-desfavorable-sin-requerimiento', $data);
					echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
					echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
					echo view('pages/forms/go-back-footer', $data_footer);
			        break;
				
				case "doc_informe_desfavorable_con_requerimiento":  //va a VIAFIRMA DOC 5
					$data_infor = [
						'doc_informe_desfavorable_con_requerimiento' => $last_insert_id
					];
					$builder->where('id', $request->uri->getSegment(3));
					$save_exped = $builder->update($data_infor);
					$data_footer = [
						'tipoDoc' => " Informe desfavorable amb requeriment",
						'conVIAFIRMA' => true
					];
					echo view('pages/forms/modDocs/pdf/plt-informe-desfavorable-con-requerimiento', $data);
					echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
					echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
					echo view('pages/forms/go-back-footer', $data_footer);
					break;
				
				case "doc_prop_res_denegacion_con_req": //CON VIAFIRMA DOC 7 - A DIRECT. GERENTE IDI
					$data_infor = [
						'doc_prop_res_denegacion_con_req' => $last_insert_id
					];
					$builder->where('id', $request->uri->getSegment(3));
					$save_exped = $builder->update($data_infor);
					$data['byCEOSigned'] = false;
					$data_footer = [
						'tipoDoc' => "Proposta resolució denegació ajut amb requeriment",
						'conVIAFIRMA' => false
					];
					echo " <h4>Proposta de resolució de denegació ajut amb requeriment</h4>";
					echo view('pages/forms/modDocs/pdf/plt-propuesta-resolucion-denegacion-con-requerimiento', $data);
					echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
					echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
					echo view('pages/forms/go-back-footer', $data_footer);
					break;

				case "doc_prop_res_denegacion_sin_req": //CON VIAFIRMA DOC 8 - A DIRECT. GERENTE IDI
					$data_infor = [
						'doc_prop_res_denegacion_sin_req' => $last_insert_id
					];
					$builder->where('id', $request->uri->getSegment(3));
					$save_exped = $builder->update($data_infor);
					$data['byCEOSigned'] = false;
					$data_footer = [
						'tipoDoc' => " Proposta resolució denegació ajut sense requeriment",
						'conVIAFIRMA' => false
					];
					echo "<h4>Proposta resolució denegació ajut sense requeriment</h4>";
					echo view('pages/forms/modDocs/pdf/plt-propuesta-resolucion-denegacion-sin-requerimiento', $data);
					echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
					echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
					echo view('pages/forms/go-back-footer', $data_footer);
					break;

				case "doc_prop_res_conces_sin_req": //CON VIAFIRMA DOC 9 - A DIRECT. GERENTE IDI
					$data_infor = [
						'doc_prop_res_conces_sin_req' => $last_insert_id
					];
					$builder->where('id', $request->uri->getSegment(3));
					$save_exped = $builder->update($data_infor);
					$data['byCEOSigned'] = false;
					$data_footer = [
						'tipoDoc' => " Proposta resolució concessió ajut sense requeriment",
						'conVIAFIRMA' => false
					];
					echo "<h4>Proposta de resolució concessió ajut sense requeriment</h4>";
					echo view('pages/forms/modDocs/pdf/plt-propuesta-resolucion-concesion-sin-requerimiento', $data);
					echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
					echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
					echo view('pages/forms/go-back-footer', $data_footer);
					break;

				case "doc_prop_res_conces_con_req":  //CON VIAFIRMA DOC 10 - A DIRECT. GERENTE IDI
						$data_infor = [
							'doc_prop_res_conces_con_req' => $last_insert_id
						];
						$builder->where('id', $request->uri->getSegment(3));
						$save_exped = $builder->update($data_infor);
						$data['byCEOSigned'] = false;
						$data_footer = [
							'tipoDoc' => " Proposta resolució concessió ajut amb requeriment",
							'conVIAFIRMA' => false
						];
						echo "<h4>Proposta de resolució concessió ajut amb requeriment</h4>";
						echo view('pages/forms/modDocs/pdf/plt-propuesta-resolucion-concesion-con-requerimiento', $data);
						echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
						echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);						
						echo view('pages/forms/go-back-footer', $data_footer);
						break;					

				case "doc_res_conces_sin_req": //SIN VIAFIRMA DOC 11
					$data_infor = [
						'doc_res_conces_sin_req' => $last_insert_id
					];
					$builder->where('id', $request->uri->getSegment(3));
					$save_exped = $builder->update($data_infor);
					$data_footer = [
						'tipoDoc' => " Resolució de concessió",
						'conVIAFIRMA' => false
					];
					echo view('pages/forms/modDocs/pdf/plt-resolucion-concesion', $data);
					echo view('pages/forms/go-back-footer', $data_footer);
					break;
					
				case "doc_res_denegacion_con_req": //SIN VIAFIRMA DOC 12,
					$data_infor = [
						'doc_res_denegacion_con_req' => $last_insert_id
					];
					$builder->where('id', $request->uri->getSegment(3));
					$save_exped = $builder->update($data_infor);
					$data_footer = [
						'tipoDoc' => " Resolució denegació amb requeriment",
						'conVIAFIRMA' => false
					];
					echo view('pages/forms/modDocs/pdf/plt-resolucion-denegacion-con-requerimiento', $data);
					echo view('pages/forms/go-back-footer', $data_footer);
					break;
					
				case "doc_res_denegacion_sin_req": //SIN VIAFIRMA DOC 13
					$data_infor = [
						'doc_res_denegacion_sin_req' => $last_insert_id
					];
					$builder->where('id', $request->uri->getSegment(3));
					$save_exped = $builder->update($data_infor);
					$data_footer = [
						'tipoDoc' => " Resolució denegació sense requeriment",
						'conVIAFIRMA' => false
					];
					echo view('pages/forms/modDocs/pdf/plt-resolucion-denegacion-sin-requerimiento', $data);
					echo view('pages/forms/go-back-footer', $data_footer);
					break;	
			
				case "doc_res_desestimiento_por_renuncia": //SIN VIAFIRMA DOC 14
					$data_infor = [
						'doc_res_desestimiento_por_renuncia' => $last_insert_id
					];
					$builder->where('id', $request->uri->getSegment(3));
					$save_exped = $builder->update($data_infor);
					$data_footer = [
						'tipoDoc' => " Resolució desistiment per renúncia",
						'conVIAFIRMA' => false
					];
					echo view('pages/forms/modDocs/pdf/plt-resolucion-desestimiento-por-renuncia', $data);
					echo view('pages/forms/go-back-footer', $data_footer);
					break;

				case "doc_res_conces_con_req": //SIN VIAFIRMA DOC 17
						$data_infor = [
							'doc_res_conces_con_req' => $last_insert_id
						];
						$builder->where('id', $request->uri->getSegment(3));
						$save_exped = $builder->update($data_infor);
						$data_footer = [
							'tipoDoc' => " Resolució concessió amb requeriment",					
							'conVIAFIRMA' => false
						];
						echo view('pages/forms/modDocs/pdf/plt-resolucion-concesion-con-requerimiento', $data);
						echo view('pages/forms/go-back-footer', $data_footer);
						break;					

				case "doc_inicio_requerimiento_subsanacion": //CON VIAFIRMA DOC 18
						$data_infor = [
							'doc_inicio_requerimiento_subsanacion' => $last_insert_id
						];
						$builder->where('id', $request->uri->getSegment(3));
						$save_exped = $builder->update($data_infor);
						$data_footer = [
							'tipoDoc' => " Informe inici requeriment d'esmena",
							'conVIAFIRMA' => true
						];
						echo view('pages/forms/modDocs/pdf/plt-inicio-requerimiento-subsanacion', $data);
						echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
						echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
						echo view('pages/forms/go-back-footer', $data_footer);
						break;

				case "doc_requerimiento_subsanacion": //CON VIAFIRMA DOC 19 - DIRECT. GERENTE IDI
						$data_infor = [
							'doc_requerimiento_subsanacion' => $last_insert_id
						];
						$builder->where('id', $request->uri->getSegment(3));
						$save_exped = $builder->update($data_infor);
						$data['byCEOSigned'] = false;
						$data_footer = [
							'tipoDoc' => " Requeriment d'esmena",
							'conVIAFIRMA' => false
						];
						echo "<h4>Requeriment d'esmena</h4>";
						echo view('pages/forms/modDocs/pdf/plt-requerimiento-subsanacion', $data);
						echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
						echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
						echo view('pages/forms/go-back-footer', $data_footer);
						break;

				case "doc_informe_sobre_la_subsanacion": //va a VIAFIRMA DOC 20
						$data_infor = [
							'doc_informe_sobre_la_subsanacion' => $last_insert_id
						];
						$builder->where('id', $request->uri->getSegment(3));
						$save_exped = $builder->update($data_infor);
						$data_footer = [
							'tipoDoc' => " Informe sobre l'esmena de la documentació de justificació",
							'conVIAFIRMA' => true
						];
						echo view('pages/forms/modDocs/pdf/plt-informe-subsanacion-docum-justificacion', $data);
						echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
						echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
						echo view('pages/forms/go-back-footer', $data_footer);
						break;	

				case "doc_res_desestimiento_por_no_enmendar": //SIN VIAFIRMA DOC 21
					$data_infor = [
						'doc_res_desestimiento_por_no_enmendar' => $last_insert_id
					];
					$builder->where('id', $request->uri->getSegment(3));
					$save_exped = $builder->update($data_infor);
					$data_footer = [
						'tipoDoc' => " Resolució desistiment per no esmenar",
						'conVIAFIRMA' => false
					];
					echo view('pages/forms/modDocs/pdf/plt-resolucion-desestimiento-por-no-enmendar', $data);
					echo view('pages/forms/go-back-footer', $data_footer);
					break;

					
				case "doc_acta_kickoff": //CON VIAFIRMA DOC 15
					$data_infor = [
						'doc_acta_kickoff' => $last_insert_id
					];
					$builder->where('id', $request->uri->getSegment(3));
					$save_exped = $builder->update($data_infor);
					$data_footer = [
						'tipoDoc' => " Acta Kick off",
						'conVIAFIRMA' => false
					];
					echo view('pages/forms/modDocs/pdf/plt-acta-kickoff', $data);
					echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
					echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
					echo view('pages/forms/go-back-footer', $data_footer);
					break;	

				case "doc_acuerdo_amp_term_act_sub": //SIN VIAFIRMA DOC 16
					$data_infor = [
						'doc_acuerdo_amp_term_act_sub' => $last_insert_id
					];
					$builder->where('id', $request->uri->getSegment(3));
					$save_exped = $builder->update($data_infor);
					$data_footer = [
						'tipoDoc' => " Acord ampliació termino activitat subvencionable",
						'conVIAFIRMA' => false
					];
					echo view('pages/forms/modDocs/pdf/plt-resolucion-ampliacion-plazo-actividad-subvencionable', $data);
					echo view('pages/forms/go-back-footer', $data_footer);
					break;

				case "doc_acta_de_cierre": //CON VIAFIRMA DOC 17
					$data_infor = [
						'doc_acta_de_cierre' => $last_insert_id
					];
					$builder->where('id', $request->uri->getSegment(3));
					$save_exped = $builder->update($data_infor);
					$data_footer = [
						'tipoDoc' => " Acta de tancament",
						'conVIAFIRMA' => true
					];
					echo view('pages/forms/modDocs/pdf/plt-acta-de-cierre', $data);
					echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
					echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
					echo view('pages/forms/go-back-footer', $data_footer);
					break;

				case "doc_acuerdo_confidencialidad": //CON VIAFIRMA DOC 18
					$data_infor = [
						'doc_acuerdo_confidencialidad' => $last_insert_id
					];
					$builder->where('id', $request->uri->getSegment(3));
					$save_exped = $builder->update($data_infor);
					$data_footer = [
						'tipoDoc' => " Acord de confidencialitat",
						'conVIAFIRMA' => true
					];
					echo view('pages/forms/modDocs/pdf/plt-acuerdo-de-confidencialidad', $data);
					echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
					echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
					echo view('pages/forms/go-back-footer', $data_footer);
					break;

				case "doc_informe_de_liquidacion": //CON VIAFIRMA DOC 19
					$data_infor = [
						'doc_informe_de_liquidacion' => $last_insert_id
					];
					$builder->where('id', $request->uri->getSegment(3));
					$save_exped = $builder->update($data_infor);
					$data_footer = [
						'tipoDoc' => " Informe de liquidació",
						'conVIAFIRMA' => false
					];
					echo view('pages/forms/modDocs/pdf/plt-informe-de-liquidacion', $data);
					echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
					echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
					echo view('pages/forms/go-back-footer', $data_footer);
					break;
				}
		echo view('templates/footer/footer');
	}

	public function generainformeILS ()
	{
		date_default_timezone_set("Europe/Madrid");
	  $selloDeTiempo = date("d_m_Y_h_i_sa");
	  $db = \Config\Database::connect();
		$builder = $db->table('pindust_expediente');
		$this->response->setHeader('Cache-Control', 'private');
		$request = \Config\Services::request();
		$id_sol =  $request->uri->getSegment(3);
		$convocatoria = $request->uri->getSegment(4);
		
		$data['id'] =  $id_sol;
		$data['convocatoria'] = $convocatoria;
		$data['programa'] = str_replace("%20"," ", $request->uri->getSegment(5));
		$data['nifcif'] = mb_strtoupper ($request->uri->getSegment(6));
		$tipoDocumento = $request->uri->getSegment(7);

		$query = $builder->select('idExp')->where('id', $id_sol)->get()->getResult();

		foreach ($query as $row) {
			$idExp = $row->idExp;
		}

		$nombreDocumento = $tipoDocumento.".pdf";
		if ($convocatoria>=2022) {	// a partir del 2022 hemos cambiado el nombre de los modelos de documento a IDEXP_CONVO_NOMMODELO.pdf
			$data['nombreDocumento'] = str_replace("doc_" ,$idExp."_".$convocatoria."_" ,$nombreDocumento);
		}
		$documentos = $db->table('pindust_documentos_generados');
		$documentos->where('id_sol', $id_sol);
		$documentos->where('corresponde_documento', $tipoDocumento);
		$documentos->where('convocatoria', $convocatoria);
		$documentos->delete();

		$data_file = [
		    'id_sol' => $request->uri->getSegment(3),
		    'name' =>  $tipoDocumento.".pdf",
		    'type' => 'application/pdf',
		    'cifnif_propietario' => $request->uri->getSegment(6),
		    'tipo_tramite' => str_replace("%20"," ", $request->uri->getSegment(5)),
		    'corresponde_documento' => $tipoDocumento,
		    'datetime_uploaded' => time(),
		    'convocatoria' => $request->uri->getSegment(4),
		    'created_at'  => WRITEPATH.'documentos/'.$data['nifcif'].'/informes/'.$selloDeTiempo.'/'. $tipoDocumento.".pdf",
		    'selloDeTiempo'  => $selloDeTiempo
		];
		
		$save = $documentos->insert($data_file);
		$last_insert_id = $db->insertID();
		//$last_insert_id = $save->connID->insert_id;
		$data['last_insert_id'] = $last_insert_id;
		$dir = WRITEPATH.'documentos/'.$request->uri->getSegment(6).'/informes/';

		if (!is_dir($dir)){
		    mkdir($dir, 0775);
		}
		echo view('templates/header/header', $data);
		switch ($tipoDocumento)
			{
				case "doc_requeriment_ils": //va a VIAFIRMA DOC 1
					$data_infor = [
						'doc_requeriment_ils' => $last_insert_id
					];
					$builder->where('id', $request->uri->getSegment(3));
					$save_exped = $builder->update($data_infor);
					$data_footer = [
						'tipoDoc' => " El requeriment ILS",
						'conVIAFIRMA' => true
					];
					echo view('pages/forms/modDocs/ILS/pdf/plt-requerimiento-ils', $data);
					echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
					echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
					echo view('pages/forms/go-back-footer', $data_footer);
					break;

				case "doc_res_desestimiento_por_no_enmendar_ils": //SIN VIAFIRMA DOC 2
					$data_infor = [
						'doc_res_desestimiento_por_no_enmendar_ils' => $last_insert_id
					];
					$builder->where('id', $request->uri->getSegment(3));
					$save_exped = $builder->update($data_infor);
					$data_footer = [
						'tipoDoc' => " El desistiment per no esmenar ILS",
						'conVIAFIRMA' => false
					];
					echo view('pages/forms/modDocs/ILS/pdf/plt-resolucion-desestimiento-por-no-enmendar-ils', $data);
					/* 					echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
					echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data); */
					echo view('pages/forms/go-back-footer', $data_footer);
					break;
					
				case "doc_informe_favorable_con_requerimiento_ils": //va a VIAFIRMA DOC 3
					$data_infor = [
						'doc_informe_favorable_con_requerimiento_ils' => $last_insert_id
					];
					$builder->where('id', $request->uri->getSegment(3));
					$save_exped = $builder->update($data_infor);
					$data_footer = [
						'tipoDoc' => " Informe favorable amb requeriment ILS",
						'conVIAFIRMA' => true
					];
					echo view('pages/forms/modDocs/ILS/pdf/plt-informe-favorable-con-requerimiento-ils', $data);
					echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
					echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
					echo view('pages/forms/go-back-footer', $data_footer);
					break;

				case "doc_informe_favorable_sin_requerimiento_ils": //va a VIAFIRMA DOC 4
					$data_infor = [
						'doc_informe_favorable_con_requerimiento_ils' => $last_insert_id
					];
					$builder->where('id', $request->uri->getSegment(3));
					$save_exped = $builder->update($data_infor);
					$data_footer = [
						'tipoDoc' => " Informe favorable sense requeriment ILS",
						'conVIAFIRMA' => true
					];
					echo view('pages/forms/modDocs/ILS/pdf/plt-informe-favorable-sin-requerimiento-ils', $data);
					echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
					echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
					echo view('pages/forms/go-back-footer', $data_footer);
					break;

				case "doc_informe_desfavorable_con_requerimiento_ils": //va a VIAFIRMA DOC 5
					$data_infor = [
						'doc_informe_desfavorable_con_requerimiento_ils' => $last_insert_id
					];
					$builder->where('id', $request->uri->getSegment(3));
					$save_exped = $builder->update($data_infor);
					$data_footer = [
						'tipoDoc' => " Informe desfavorable amb requeriment ILS",
						'conVIAFIRMA' => true
					];
					echo view('pages/forms/modDocs/ILS/pdf/plt-informe-desfavorable-con-requerimiento-ils', $data);
					echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
					echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
					echo view('pages/forms/go-back-footer', $data_footer);
					break;

				case "doc_res_denegacion_con_req_ils": //SIN VIAFIRMA DOC 6
					$data_infor = [
						'doc_res_denegacion_con_req_ils' => $last_insert_id
					];
					$builder->where('id', $request->uri->getSegment(3));
					$save_exped = $builder->update($data_infor);
					$data_footer = [
						'tipoDoc' => " Resolució denegació amb requeriment ILS",
						'conVIAFIRMA' => false
					];
					echo view('pages/forms/modDocs/ILS/pdf/plt-resolucion-denegacion-con-requerimiento-ils', $data);
					/* 					echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
					echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data); */
					echo view('pages/forms/go-back-footer', $data_footer);
					break;
					
				case "doc_resolucion_concesion_adhesion_ils":  //SIN VIAFIRMA DOC 7
					$data_infor = [
						'doc_res_concesion_adhesion_sin_req_ils' => $last_insert_id
					];
					$builder->where('id', $request->uri->getSegment(3));
					$save_exped = $builder->update($data_infor);
					$data_footer = [
						'tipoDoc' => " Resolució concesió adhesió ILS",
						'conVIAFIRMA' => false
					];
					echo view('pages/forms/modDocs/ILS/pdf/plt-resolucion-concesion-adhesion-ils', $data);
					/* 					echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
					echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data); */
					echo view('pages/forms/go-back-footer', $data_footer);
					break;

					case "doc_resolucion_concesion_adhesion_con_req_ils":  //va a VIAFIRMA DOC 8
						$data_infor = [
							'doc_res_concesion_adhesion_con_req_ils' => $last_insert_id
						];
						$builder->where('id', $request->uri->getSegment(3));
						$save_exped = $builder->update($data_infor);
						$data_footer = [
							'tipoDoc' => " Resolució concesió adhesió amb requeriment ILS",
							'conVIAFIRMA' => false
						];
						echo view('pages/forms/modDocs/ILS/pdf/plt-resolucion-concesion-adhesion-con-req-ils', $data);
						/* 						echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
						echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data); */
						echo view('pages/forms/go-back-footer', $data_footer);
						break;						

			}
	}

	public function muestrasolicitudfirmada ()
	{
	    //$uri = new \CodeIgniter\HTTP\URI();
	    $request = \Config\Services::request();
	    $data = [
	        'PublicAccessId' => $request->uri->getSegment(3),
	    ];
	    echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
	    echo view('pages/forms/rest_api_firma/ver-solicitud-firmada', $data);
	}
	
	public function muestrasolicitud ()
	{
	    //$uri = new \CodeIgniter\HTTP\URI();
	    $request = \Config\Services::request();
	    $data = [
	        'PublicAccessId' => $request->uri->getSegment(3),
	    ];
	    echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
	    echo view('pages/forms/rest_api_firma/ver-solicitud', $data);
	}
	
	public function muestrasolicitudrechazada ()
	{
	    //$uri = new \CodeIgniter\HTTP\URI();
	    $request = \Config\Services::request();
	    $data['titulo'] = lang('message_lang.titulo');
	    $data['PublicAccessId'] = $request->uri->getSegment(3);
	    echo view('templates/header/header', $data);
	    echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
	    echo view('pages/forms/rest_api_firma/obtiene-datos-solicitud', $data);
	    echo view('templates/footer/footer');
	}
	
	public function justificacion ()
	{
		$data = [];
		echo view('templates/header/header', $data);		
		echo view('pages/exped/justificador', $data);
		echo view('templates/footer/footer');		
	}

	public function generaExcel () 
	{
		$modelExp = new ExpedientesModel();
		$request = \Config\Services::request();
		$language = \Config\Services::language();
		$language->setLocale('ca');
		$session = session();
		$where = "";

		if ($session->get('programa_fltr')) {
			$where = "tipo_tramite = '" . $session->get('programa_fltr') . "'";
		}

		if ($session->get('convocatoria_fltr')) {
			if ($session->get('programa_fltr')) {
				$where .= ' AND convocatoria = ' . $session->get('convocatoria_fltr');	
			} else {
				$where = 'convocatoria = ' . $session->get('convocatoria_fltr');
			}
		}

		//$where .= " AND situacion='justificado'";

		$data['expedientes'] = $modelExp->orderBy('fecha_completado', 'DESC')
				->where($where)
				->findAll();

		$data['titulo'] = "Sol·licituds d'ajuts i/o subvencions per al control dels auditors ";
		
		//echo view('templates/header/header', $data);
		echo view('pages/exped/genera-expediente-excel', $data);
		//echo view('templates/footer/footer');
	}

	public function do_datos_empresa_ils_upload( $id, $nif, $idioma, $convocatoria )
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
				'titulo' => "Dades de l'empresa per publicar a la web ILS"
			];

		$db = \Config\Database::connect();
		$documentos = $db->table('pindust_documentos');
		date_default_timezone_set("Europe/Madrid");
		$selloTiempo = date("d_m_Y_h_i_sa");
		$tipo_tramite = 'ILS';

		// Sube el logo de la empresa
		$documentosfile = $this->request->getFiles();
		foreach($documentosfile['file_logotipoEmpresaIls'] as $lotogtipo)
				{
					if ($lotogtipo->isValid() && ! $lotogtipo->hasMoved())
					{
						$newName = $lotogtipo->getRandomName();
						$lotogtipo->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $newName);
						$data_file = [
							'name' => $newName,
							'type' => $lotogtipo->getClientMimeType(),
							'cifnif_propietario' => $nif,
							'tipo_tramite' => $tipo_tramite, //$tipo_tramite[0]." ".$tipo_tramite[1],
							'corresponde_documento' => 'file_logotipoEmpresaIls',
							'datetime_uploaded' => time(),
							'convocatoria' 		=> $convocatoria,
							'created_at'  		=> $lotogtipo->getTempName(),
							'selloDeTiempo'  	=> $selloTiempo,
							'docRequerido' 		=> 'NO',
							'id_sol'         	=> $id
						];
						$save = $documentos->insert($data_file);
						$last_insert_id = $save->connID->insert_id;
					}
				}
		/* ------------------ actualiza el estado del expediente a 'pendienteRECJustificar' ---------------*/
		$sql = "UPDATE pindust_expediente 
		
			SET file_logotipoEmpresaIls = 'SI',
					sitio_web_empresa = '".$this->request->getVar('sitio_web_empresa')."',
					video_empresa = '".$this->request->getVar('video_empresa')."',
					canales_comercializacion_empresa = '".$this->request->getVar('canales_comercializacion_empresa')."',
					fecha_creacion_empresa = '".$this->request->getVar('fecha_creacion_empresa')."'

			WHERE id =" . $id;
		$db->simpleQuery($sql);
		/*-------------------------------------------------------------------------------------------------*/
	
		$data['titulo'] = "Expedient: " . $id ." / ". $tipo_tramite[1];
		$query = $db->query("SELECT * FROM pindust_expediente WHERE id =" . $id);
		$expediente = $query->getResult();
		foreach($expediente as $exped_item):
			$data['telefono_not'] = $exped_item->telefono_rep;
			$data['email_not'] = $exped_item->email_rep;
			$data['nif'] = $exped_item->nif;
		endforeach;
		$data['selloTiempo'] = $selloTiempo;
		$data['id'] = $id;
		echo view('templates/header/header_form_ils', $data);
		echo view('templates/header/header_form_requerimiento_resultado_ils', $data);	
		echo view('templates/footer/footer_form');
	}

	public function do_doc_informe_resumen_upload( $id, $nif, $idioma, $convocatoria )
	{

		/* Puede ocurrir que la empresa, al solicitar la adhesión a ILs, nos haya enviado un Informe resumen
		 que no sea válido. Entonces, se lo solicitamos nuevamente. */

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
				'titulo' => "Informe resum de la petjada de carboni per adherir-se a ILS"
			];

		$db = \Config\Database::connect();
		$documentos = $db->table('pindust_documentos');
		date_default_timezone_set("Europe/Madrid");
		$selloTiempo = date("d_m_Y_h_i_sa");
		$tipo_tramite = 'ILS';

		// Sube el itinerario formativo de la empresa
		$documentosfile = $this->request->getFiles();
		foreach($documentosfile['file_informeResumenIls'] as $lotogtipo)
				{
					if ($lotogtipo->isValid() && ! $lotogtipo->hasMoved())
					{
						$newName = $lotogtipo->getRandomName();
						$lotogtipo->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $newName);
						$data_file = [
							'name' => $newName,
							'type' => $lotogtipo->getClientMimeType(),
							'cifnif_propietario' => $nif,
							'tipo_tramite' => $tipo_tramite, //$tipo_tramite[0]." ".$tipo_tramite[1],
							'corresponde_documento' => 'file_informeResumenIls',
							'datetime_uploaded' => time(),
							'convocatoria' 		=> $convocatoria,
							'created_at'  		=> $lotogtipo->getTempName(),
							'selloDeTiempo'  	=> $selloTiempo,
							'docRequerido' 		=> 'SI',
							'id_sol'         	=> $id
						];
						$save = $documentos->insert($data_file);
						$last_insert_id = $save->connID->insert_id;
					}
				}
		/* ------------------ actualiza el estado del expediente a 'file_informeInventarioIls a cargado SI' ---------------*/
		$sql = "UPDATE pindust_expediente 
		
			SET file_informeResumenIls = 'SI' WHERE id =" . $id;
		$db->simpleQuery($sql);
		/*-------------------------------------------------------------------------------------------------*/
	
		$data['titulo'] = "Expedient: " . $id ." / ". $tipo_tramite[1];
		$query = $db->query("SELECT * FROM pindust_expediente WHERE id =" . $id);
		$expediente = $query->getResult();
		foreach($expediente as $exped_item):
			$data['telefono_not'] = $exped_item->telefono_rep;
			$data['email_not'] = $exped_item->email_rep;
			$data['nif'] = $exped_item->nif;
		endforeach;
		$data['selloTiempo'] = $selloTiempo;
		$data['id'] = $id;
		echo view('templates/header/header_form_ils', $data);
		echo view('templates/header/header_form_requerimiento_resultado_ils', $data);	
		echo view('templates/footer/footer_form');
	}

	public function do_doc_compromiso_reduccion_upload( $id, $nif, $idioma, $convocatoria )
	{

		/* Puede ocurrir que la empresa, al solicitar la adhesión a ILs, nos haya enviado un Informe resumen
		 que no sea válido. Entonces, se lo solicitamos nuevamente. */

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
				'titulo' => "Compromís de reducció de les emissions de gasos d'efecte hivernacle per adherir-se a ILS"
			];

		$db = \Config\Database::connect();
		$documentos = $db->table('pindust_documentos');
		date_default_timezone_set("Europe/Madrid");
		$selloTiempo = date("d_m_Y_h_i_sa");
		$tipo_tramite = 'ILS';

		// Sube el itinerario formativo de la empresa
		$documentosfile = $this->request->getFiles();
		foreach($documentosfile['file_modeloEjemploIls'] as $lotogtipo)
				{
					if ($lotogtipo->isValid() && ! $lotogtipo->hasMoved())
					{
						$newName = $lotogtipo->getRandomName();
						$lotogtipo->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $newName);
						$data_file = [
							'name' => $newName,
							'type' => $lotogtipo->getClientMimeType(),
							'cifnif_propietario' => $nif,
							'tipo_tramite' => $tipo_tramite, //$tipo_tramite[0]." ".$tipo_tramite[1],
							'corresponde_documento' => 'file_modeloEjemploIls',
							'datetime_uploaded' => time(),
							'convocatoria' 		=> $convocatoria,
							'created_at'  		=> $lotogtipo->getTempName(),
							'selloDeTiempo'  	=> $selloTiempo,
							'docRequerido' 		=> 'SI',
							'id_sol'         	=> $id
						];
						$save = $documentos->insert($data_file);
						$last_insert_id = $save->connID->insert_id;
					}
				}
		/* ------------------ actualiza el estado del expediente a 'file_informeInventarioIls a cargado SI' ---------------*/
		$sql = "UPDATE pindust_expediente 
		
			SET file_modeloEjemploIls = 'SI' WHERE id =" . $id;
		$db->simpleQuery($sql);
		/*-------------------------------------------------------------------------------------------------*/
	
		$data['titulo'] = "Expedient: " . $id ." / ". $tipo_tramite[1];
		$query = $db->query("SELECT * FROM pindust_expediente WHERE id =" . $id);
		$expediente = $query->getResult();
		foreach($expediente as $exped_item):
			$data['telefono_not'] = $exped_item->telefono_rep;
			$data['email_not'] = $exped_item->email_rep;
			$data['nif'] = $exped_item->nif;
		endforeach;
		$data['selloTiempo'] = $selloTiempo;
		$data['id'] = $id;
		echo view('templates/header/header_form_ils', $data);
		echo view('templates/header/header_form_requerimiento_resultado_ils', $data);	
		echo view('templates/footer/footer_form');
	}

	public function do_doc_itinerario_formativo_upload( $id, $nif, $idioma, $convocatoria )
	{

		/* Puede ocurrir que la empresa, al solicitar la adhesión a ILs, nos haya enviado un documento 
				de itinerario formativo que no sea válido. Entonces, se lo solicitamos nuevamente. */

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
				'titulo' => "Itinerari Formatiu per adherir-se a ILS"
			];

		$db = \Config\Database::connect();
		$documentos = $db->table('pindust_documentos');
		date_default_timezone_set("Europe/Madrid");
		$selloTiempo = date("d_m_Y_h_i_sa");
		$tipo_tramite = 'ILS';

		// Sube el itinerario formativo de la empresa
		$documentosfile = $this->request->getFiles();
		foreach($documentosfile['file_certificado_itinerario_formativo'] as $lotogtipo)
				{
					if ($lotogtipo->isValid() && ! $lotogtipo->hasMoved())
					{
						$newName = $lotogtipo->getRandomName();
						$lotogtipo->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $newName);
						$data_file = [
							'name' => $newName,
							'type' => $lotogtipo->getClientMimeType(),
							'cifnif_propietario' => $nif,
							'tipo_tramite' => $tipo_tramite, //$tipo_tramite[0]." ".$tipo_tramite[1],
							'corresponde_documento' => 'file_certificado_itinerario_formativo',
							'datetime_uploaded' => time(),
							'convocatoria' 		=> $convocatoria,
							'created_at'  		=> $lotogtipo->getTempName(),
							'selloDeTiempo'  	=> $selloTiempo,
							'docRequerido' 		=> 'SI',
							'id_sol'         	=> $id
						];
						$save = $documentos->insert($data_file);
						$last_insert_id = $save->connID->insert_id;
					}
				}
		/* ------------------ actualiza el estado del expediente a 'file_certificado_itinerario_formativo a cargado SI' ---------------*/
		$sql = "UPDATE pindust_expediente 
		
			SET file_certificado_itinerario_formativo = 'SI' WHERE id =" . $id;
		$db->simpleQuery($sql);
		/*-------------------------------------------------------------------------------------------------*/
	
		$data['titulo'] = "Expedient: " . $id ." / ". $tipo_tramite[1];
		$query = $db->query("SELECT * FROM pindust_expediente WHERE id =" . $id);
		$expediente = $query->getResult();
		foreach($expediente as $exped_item):
			$data['telefono_not'] = $exped_item->telefono_rep;
			$data['email_not'] = $exped_item->email_rep;
			$data['nif'] = $exped_item->nif;
		endforeach;
		$data['selloTiempo'] = $selloTiempo;
		$data['id'] = $id;
		echo view('templates/header/header_form_ils', $data);
		echo view('templates/header/header_form_requerimiento_resultado_ils', $data);	
		echo view('templates/footer/footer_form');
	}

	public function do_doc_informe_gei_upload( $id, $nif, $idioma, $convocatoria )
	{

		/* Puede ocurrir que la empresa, al solicitar la adhesión a ILs, nos haya enviado un informe GEI
		 que no sea válido. Entonces, se lo solicitamos nuevamente. */

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
				'titulo' => "Informe GEI per adherir-se a ILS"
			];

		$db = \Config\Database::connect();
		$documentos = $db->table('pindust_documentos');
		date_default_timezone_set("Europe/Madrid");
		$selloTiempo = date("d_m_Y_h_i_sa");
		$tipo_tramite = 'ILS';

		// Sube el itinerario formativo de la empresa
		$documentosfile = $this->request->getFiles();
		foreach($documentosfile['file_informeInventarioIls'] as $lotogtipo)
				{
					if ($lotogtipo->isValid() && ! $lotogtipo->hasMoved())
					{
						$newName = $lotogtipo->getRandomName();
						$lotogtipo->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $newName);
						$data_file = [
							'name' => $newName,
							'type' => $lotogtipo->getClientMimeType(),
							'cifnif_propietario' => $nif,
							'tipo_tramite' => $tipo_tramite, //$tipo_tramite[0]." ".$tipo_tramite[1],
							'corresponde_documento' => 'file_informeInventarioIls',
							'datetime_uploaded' => time(),
							'convocatoria' 		=> $convocatoria,
							'created_at'  		=> $lotogtipo->getTempName(),
							'selloDeTiempo'  	=> $selloTiempo,
							'docRequerido' 		=> 'SI',
							'id_sol'         	=> $id
						];
						$save = $documentos->insert($data_file);
						$last_insert_id = $save->connID->insert_id;
					}
				}
		/* ------------------ actualiza el estado del expediente a 'file_informeInventarioIls a cargado SI' ---------------*/
		$sql = "UPDATE pindust_expediente 
		
			SET file_informeInventarioIls = 'SI' WHERE id =" . $id;
		$db->simpleQuery($sql);
		/*-------------------------------------------------------------------------------------------------*/
	
		$data['titulo'] = "Expedient: " . $id ." / ". $tipo_tramite[1];
		$query = $db->query("SELECT * FROM pindust_expediente WHERE id =" . $id);
		$expediente = $query->getResult();
		foreach($expediente as $exped_item):
			$data['telefono_not'] = $exped_item->telefono_rep;
			$data['email_not'] = $exped_item->email_rep;
			$data['nif'] = $exped_item->nif;
		endforeach;
		$data['selloTiempo'] = $selloTiempo;
		$data['id'] = $id;
		echo view('templates/header/header_form_ils', $data);
		echo view('templates/header/header_form_requerimiento_resultado_ils', $data);	
		echo view('templates/footer/footer_form');
	}

	public function do_doc_escritura_empresa_upload( $id, $nif, $idioma, $convocatoria )
	{

		/* Puede ocurrir que la empresa, al solicitar la adhesión a ILs, nos haya enviado una Escritura de la Empresa
		 que no sea válido. Entonces, se lo solicitamos nuevamente. */

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
				'titulo' => "Escriptura Empresa per adherir-se a ILS"
			];

		$db = \Config\Database::connect();
		$documentos = $db->table('pindust_documentos');
		date_default_timezone_set("Europe/Madrid");
		$selloTiempo = date("d_m_Y_h_i_sa");
		$tipo_tramite = 'ILS';

		// Sube el itinerario formativo de la empresa
		$documentosfile = $this->request->getFiles();
		foreach($documentosfile['file_escritura_empresa'] as $lotogtipo)
				{
					if ($lotogtipo->isValid() && ! $lotogtipo->hasMoved())
					{
						$newName = $lotogtipo->getRandomName();
						$lotogtipo->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $newName);
						$data_file = [
							'name' => $newName,
							'type' => $lotogtipo->getClientMimeType(),
							'cifnif_propietario' => $nif,
							'tipo_tramite' => $tipo_tramite, //$tipo_tramite[0]." ".$tipo_tramite[1],
							'corresponde_documento' => 'file_escritura_empresa',
							'datetime_uploaded' => time(),
							'convocatoria' 		=> $convocatoria,
							'created_at'  		=> $lotogtipo->getTempName(),
							'selloDeTiempo'  	=> $selloTiempo,
							'docRequerido' 		=> 'SI',
							'id_sol'         	=> $id
						];
						$save = $documentos->insert($data_file);
						$last_insert_id = $save->connID->insert_id;
					}
				}
		/* ------------------ actualiza el estado del expediente a 'file_informeInventarioIls a cargado SI' ---------------*/
		$sql = "UPDATE pindust_expediente 
		
			SET file_escritura_empresa = 'SI' WHERE id =" . $id;
		$db->simpleQuery($sql);
		/*-------------------------------------------------------------------------------------------------*/
	
		$data['titulo'] = "Expedient: " . $id ." / ". $tipo_tramite[1];
		$query = $db->query("SELECT * FROM pindust_expediente WHERE id =" . $id);
		$expediente = $query->getResult();
		foreach($expediente as $exped_item):
			$data['telefono_not'] = $exped_item->telefono_rep;
			$data['email_not'] = $exped_item->email_rep;
			$data['nif'] = $exped_item->nif;
		endforeach;
		$data['selloTiempo'] = $selloTiempo;
		$data['id'] = $id;
		echo view('templates/header/header_form_ils', $data);
		echo view('templates/header/header_form_requerimiento_resultado_ils', $data);	
		echo view('templates/footer/footer_form');
	}

	public function do_doc_certificado_iae_upload( $id, $nif, $idioma, $convocatoria )
	{

		/* Puede ocurrir que la empresa, al solicitar la adhesión a ILs, nos haya enviado un Certificado IAE
		 que no sea válido. Entonces, se lo solicitamos nuevamente. */

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
				'titulo' => "Certificat IAE per adherir-se a ILS"
			];

		$db = \Config\Database::connect();
		$documentos = $db->table('pindust_documentos');
		date_default_timezone_set("Europe/Madrid");
		$selloTiempo = date("d_m_Y_h_i_sa");
		$tipo_tramite = 'ILS';

		// Sube el itinerario formativo de la empresa
		$documentosfile = $this->request->getFiles();
		foreach($documentosfile['file_certificadoIAE'] as $lotogtipo)
				{
					if ($lotogtipo->isValid() && ! $lotogtipo->hasMoved())
					{
						$newName = $lotogtipo->getRandomName();
						$lotogtipo->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $newName);
						$data_file = [
							'name' => $newName,
							'type' => $lotogtipo->getClientMimeType(),
							'cifnif_propietario' => $nif,
							'tipo_tramite' => $tipo_tramite, //$tipo_tramite[0]." ".$tipo_tramite[1],
							'corresponde_documento' => 'file_certificadoIAE',
							'datetime_uploaded' => time(),
							'convocatoria' 		=> $convocatoria,
							'created_at'  		=> $lotogtipo->getTempName(),
							'selloDeTiempo'  	=> $selloTiempo,
							'docRequerido' 		=> 'SI',
							'id_sol'         	=> $id
						];
						$save = $documentos->insert($data_file);
						$last_insert_id = $save->connID->insert_id;
					}
				}
		/* ------------------ actualiza el estado del expediente a 'file_informeInventarioIls a cargado SI' ---------------*/
		$sql = "UPDATE pindust_expediente 
		
			SET file_certificadoIAE = 'SI' WHERE id =" . $id;
		$db->simpleQuery($sql);
		/*-------------------------------------------------------------------------------------------------*/
	
		$data['titulo'] = "Expedient: " . $id ." / ". $tipo_tramite[1];
		$query = $db->query("SELECT * FROM pindust_expediente WHERE id =" . $id);
		$expediente = $query->getResult();
		foreach($expediente as $exped_item):
			$data['telefono_not'] = $exped_item->telefono_rep;
			$data['email_not'] = $exped_item->email_rep;
			$data['nif'] = $exped_item->nif;
		endforeach;
		$data['selloTiempo'] = $selloTiempo;
		$data['id'] = $id;
		echo view('templates/header/header_form_ils', $data);
		echo view('templates/header/header_form_requerimiento_resultado_ils', $data);	
		echo view('templates/footer/footer_form');
	}
}