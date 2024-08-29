<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;
use CodeIgniter\Controller;
use App\Models\ExpedientesModel;
use App\Models\ConsultorModel;
use App\Models\DocumentosModel;
use App\Models\DocumentosTipoModel;
use App\Models\DocumentosJustificacionModel;
use App\Models\MejorasExpedienteModel;
use App\Models\ConfiguracionModel;
use App\Models\ConfiguracionLineaModel;

class Expedientes extends Controller
{

	public function index()
	{
		$language = \Config\Services::language();
		$language->setLocale('ca');
		$session = session();
		$lineaConfig = new ConfiguracionLineaModel();
		$datoslineaConvo = $lineaConfig->configuracionGeneral('XECS');
		$where = "convocatoria = ".$datoslineaConvo['convocatoria'];
		$session->set('convocatoria_fltr', $datoslineaConvo['convocatoria']);
		$rol =  $session->get('rol');
		if ($rol !== 'felib') {
			$where .= " AND tipo_tramite <> 'FELIB'";
		}
		$modelExp = new ExpedientesModel();
		if ($rol == 'admin') {
			if ($session->get('programa_fltr')) {
				$where = "tipo_tramite = '" . $session->get('programa_fltr') . "'";
			}
			if ($session->get('situacion_fltr')) {
				$where = "situacion = '" . $session->get('situacion_fltr') . "'";
				$where .= " AND tipo_tramite <> 'FELIB'";
			}
			if ($session->get('textoLibre_fltr')) {
				$where .= " AND (fecha_completado LIKE '" . $this->request->getVar('textoLibre_fltr') . "%'
										OR idExp LIKE '%" . $this->request->getVar('textoLibre_fltr') . "%' 
										OR empresa LIKE '%" . $this->request->getVar('textoLibre_fltr') . "%' 
										OR email_rep LIKE '%" . $this->request->getVar('textoLibre_fltr') . "%' 
										OR telefono_rep LIKE '%" . $this->request->getVar('textoLibre_fltr') . "%' 
										OR nom_consultor LIKE '%" . $this->request->getVar('textoLibre_fltr') . "%' 
										OR situacion  LIKE '%" . $this->request->getVar('textoLibre_fltr') . "%' )";
				$where .= " AND tipo_tramite <> 'FELIB'";									
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

		$data['totalExpedientes'] = count($data['expedientes']);
		$data['titulo'] = lang('message_lang.todas_las_solicitudes')." ".$datoslineaConvo['convocatoria'];
		echo view('templates/header/header', $data);
		
		if ($rol !== 'felib') {
			echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
			echo view('pages/exped/listado-expediente', $data);
		} else {
			echo view('pages/exped/listado-expediente-felib', $data);
		}
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

		$data['totalExpedientes'] = count($data['expedientes']);

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

		if ($this->request->getVar('programa_fltr') == "") {
			$session->set('programa_fltr', '');
		}

		if ($this->request->getVar('situacion_fltr') == "") {
			$session->set('situacion_fltr', '');
		}

		if ($this->request->getVar('textoLibre_fltr') == "") {
			$session->set('textoLibre_fltr', '');
		}

		$currentYear = date("Y");

		$rol =  $session->get('rol');
		$where = "";

		switch ($rol) {
			case 'admin':
				if ($this->request->getVar('convocatoria_fltr')) {
					$where = 'convocatoria = ' . $this->request->getVar('convocatoria_fltr');
					$where .= " AND tipo_tramite <> 'FELIB'";
					$session->set('convocatoria_fltr', $this->request->getVar('convocatoria_fltr')); 
				} else {
					$where = 'convocatoria = ' . $currentYear; 
					$session->set('convocatoria_fltr',  $currentYear);
				}

				if ($this->request->getVar('programa_fltr')) {
					$where = "tipo_tramite = '" . $this->request->getVar('programa_fltr') . "'";
					$session->set('programa_fltr', $this->request->getVar('programa_fltr'));
				}

				if ($this->request->getVar('situacion_fltr')) {
					if ($this->request->getVar('programa_fltr')) {
						$where .= " AND situacion = '" . $this->request->getVar('situacion_fltr') . "'";
					} else if ($this->request->getVar('convocatoria_fltr')) {
						$where .= " AND situacion = '" . $this->request->getVar('situacion_fltr') . "'";
					} else {
						$where = "situacion = '" . $this->request->getVar('situacion_fltr') . "'";
					}
					$session->set('situacion_fltr', $this->request->getVar('situacion_fltr'));
				}

				if ($this->request->getVar('textoLibre_fltr')) {
					if ($where) {
						$where .= " AND (fecha_completado LIKE '" . $this->request->getVar('textoLibre_fltr') . "%'
										OR idExp LIKE '%" . $this->request->getVar('textoLibre_fltr') . "%'
										OR empresa LIKE '%" . $this->request->getVar('textoLibre_fltr') . "%' 
										OR email_rep LIKE '%" . $this->request->getVar('textoLibre_fltr') . "%' 
										OR telefono_rep LIKE '%" . $this->request->getVar('textoLibre_fltr') . "%' 
										OR nom_consultor LIKE '%" . $this->request->getVar('textoLibre_fltr') . "%' 
										OR situacion  LIKE '%" . $this->request->getVar('textoLibre_fltr') . "%' )";
					} else {
						$where = " tipo_tramite LIKE '%" . $this->request->getVar('textoLibre_fltr') . "%'
										OR fecha_completado LIKE '" . $this->request->getVar('textoLibre_fltr') . "%'
										OR idExp LIKE '%" . $this->request->getVar('textoLibre_fltr') . "%'
										
										OR empresa LIKE '%" . $this->request->getVar('textoLibre_fltr') . "%' 
										OR email_rep LIKE '%" . $this->request->getVar('textoLibre_fltr') . "%' 
										OR telefono_rep LIKE '%" . $this->request->getVar('textoLibre_fltr') . "%' 
										OR nom_consultor LIKE '%" . $this->request->getVar('textoLibre_fltr') . "%' 
										OR situacion  LIKE '%" . $this->request->getVar('textoLibre_fltr') . "%' ";
					}
					$session->set('textoLibre_fltr', $this->request->getVar('textoLibre_fltr'));
				}

				if ($this->request->getVar('programa_fltr') || $this->request->getVar('convocatoria_fltr') || $this->request->getVar('textoLibre_fltr')) {
					$data['expedientes'] = $modelExp->orderBy('fecha_completado', 'DESC')
					->where($where)
					->findAll();
				} else {
					$data['expedientes'] = $modelExp->orderBy('fecha_completado', 'DESC')
					->where($where)
					->findAll();
				}
				break;

			default:
				$session->set('programa_fltr', $rol);
				$where = 'tipo_tramite = "' . $rol . '"';
				if ($this->request->getVar('convocatoria_fltr')) {
					$where .= ' AND convocatoria = ' . $this->request->getVar('convocatoria_fltr');
					$session->set('convocatoria_fltr', $this->request->getVar('convocatoria_fltr'));
				} else {
					$where = 'convocatoria = ' . $currentYear; //$this->request->getVar('convocatoria_fltr');
					$session->set('convocatoria_fltr', $currentYear);
				}
				$session->set('convocatoria_fltr', $this->request->getVar('convocatoria_fltr'));

				if ($this->request->getVar('situacion_fltr')) {
					if ($this->request->getVar('convocatoria_fltr')) {
						$where .= " AND situacion = '" . $this->request->getVar('situacion_fltr') . "'";
					} else {
						$where = "situacion = '" . $this->request->getVar('situacion_fltr') . "'";
					}
					$session->set('situacion_fltr', $this->request->getVar('situacion_fltr'));
				}

				if ($this->request->getVar('textoLibre_fltr')) {
					$where .= " AND (empresa LIKE '%" . $this->request->getVar('textoLibre_fltr') . "%' 
									OR fecha_completado LIKE '%" . $this->request->getVar('textoLibre_fltr') . "%'
									OR idExp LIKE '%" . $this->request->getVar('textoLibre_fltr') . "%'
									OR email_rep LIKE '%" . $this->request->getVar('textoLibre_fltr') . "%' 
									OR telefono_rep LIKE '%" . $this->request->getVar('textoLibre_fltr') . "%' 
									OR nom_consultor LIKE '%" . $this->request->getVar('textoLibre_fltr') . "%' 
									OR situacion  LIKE '%" . $this->request->getVar('textoLibre_fltr') . "%' )";
					$session->set('textoLibre_fltr', $this->request->getVar('textoLibre_fltr'));
				}

				$data['expedientes'] = $modelExp->orderBy('fecha_completado', 'DESC')
					->where($where)
					->findAll();
		}

		if (!$this->request->getVar('programa_fltr') && !$this->request->getVar('convocatoria_fltr') && !$this->request->getVar('textoLibre_fltr')) {
			$data['titulo'] = "Totes les sol·licituds";
		} else {
			$data['titulo'] = "Sol·licituds filtrades ";
		}
		$data['sort_by'] = 'fecha_completado';
		$data['sort_order'] = 'DESC';

		$data['totalExpedientes'] = count($data['expedientes']);

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
		return redirect()->to(base_url('public/index.php/users'));
	}

	public function edit($id)
	{
		helper('filesystem');
		helper(['form', 'url']);
		$language = \Config\Services::language();

		$idioma = 'ca';
		$language->setLocale($idioma);

		$modelConfig = new ConfiguracionModel();
		$modelConfigLinea = new ConfiguracionLineaModel();

		$data['configuracion'] = $modelConfig->configuracionGeneral(); 
		$data['abrirPanel'] = 0;

		$modelExp = new ExpedientesModel();
		$modelDocumentos = new DocumentosModel();
		$modelJustificacion = new DocumentosJustificacionModel();
		$modelMejorasSolicitud = new MejorasExpedienteModel();

		$db = \Config\Database::connect();

		//----------------------------------- Comprueba si ya hay algún documento de justificación --------------------

		$data['totalDocsJustifPlan'] = $modelJustificacion->checkIfDocumentoJustificacion('file_PlanTransformacionDigital', $id);
		$data['totalDocsJustifFact'] = $modelJustificacion->checkIfDocumentoJustificacion('file_FactTransformacionDigital', $id);
		$data['totalDocsJustifPagos'] = $modelJustificacion->checkIfDocumentoJustificacion('file_PagosTransformacionDigital', $id);

		//-----------------------------Obtiene el detalle del Expediente-----------------------------------------------

		$data['expedientes'] = $modelExp->where('id', $id)->first();
		$idExp = $data['expedientes']['idExp'];
		$convocatoria = $data['expedientes']['convocatoria'];
		$tipo_tramite = $data['expedientes']['tipo_tramite'];
		$solicitante = mb_strtoupper($data['expedientes']['empresa']);
		$nifcif = strtoupper($data['expedientes']['nif']);

		if ($tipo_tramite == 'Programa IV' || $tipo_tramite == 'Programa III actuacions corporatives' || $tipo_tramite == 'Programa III actuacions producte' || $tipo_tramite == 'Programa III' || $tipo_tramite == 'Programa II' || $tipo_tramite == 'Programa I') {
			$data['configuracionLinea'] = $modelConfigLinea->activeConfigurationLineData('XECS', $convocatoria);
		} else {
			$data['configuracionLinea'] = $modelConfigLinea->activeConfigurationLineData($tipo_tramite, $convocatoria);
		}
		$data['importeAyuda'] = $data['configuracionLinea']['programa'];

		$data['totalConvocatorias'] = $modelExp->findNumberOfConvocatorias($nifcif, $tipo_tramite, $convocatoria);

		$data['titulo'] = "Expedient: " . $idExp . "/" . $convocatoria . " (" . $tipo_tramite . ") - " . $solicitante . " - " . $nifcif;

		/* ----Comprueba si ya tenemos alguno de los documentos en el IDI y que en la solicitud lo han marcado como SI lo tenemos---- */
		if ($data['expedientes']['memoriaTecnicaEnIDI']) {
			$modelDocumentos->findIfDocumentIsInIDI($id, $nifcif, 'file_memoriaTecnica', $tipo_tramite, $convocatoria);
		}
		if ($data['expedientes']['altaRETA_docAcredEnIDI']) {
			$modelDocumentos->findIfDocumentIsInIDI($id, $nifcif, 'file_altaAutonomos', $tipo_tramite, $convocatoria);
		}
		if ($data['expedientes']['certificadoIAEEnIDI']) {
			$modelDocumentos->findIfDocumentIsInIDI($id, $nifcif, 'file_certificadoIAE', $tipo_tramite, $convocatoria);
		}
		if ($data['expedientes']['copiaNIFSociedadEnIDI']) {
			$modelDocumentos->findIfDocumentIsInIDI($id, $nifcif, 'file_nifEmpresa', $tipo_tramite, $convocatoria);
		}
		if ($data['expedientes']['pJuridicaDocAcreditativaEnIDI']) {
			$modelDocumentos->findIfDocumentIsInIDI($id, $nifcif, 'file_document_acred_como_repres', $tipo_tramite, $convocatoria);
		}
		/* --------------------------------------------------------------- */

		/* SELECCIONA TODOS LOS DOCUMENTOS ASOCIADOS AL EXPEDIENTE */
		/* 		$qry = "SELECT * FROM pindust_documentos WHERE (fase_exped = '') AND id_sol = " . $id;
		$query = $db->query($qry);
		$data['documentos'] = $query->getResult(); */
		/* ---------------------------------------------------------------- */

		/* Los documentos de la justificación por PLAN, FASCTURA, PAGOS */
		$data['documentosJustifPlan'] = $modelJustificacion->listDocumentosJustificacion('file_PlanTransformacionDigital', $id);
		$data['documentosJustifFact'] = $modelJustificacion->listDocumentosJustificacion('file_FactTransformacionDigital', $id);
		$data['documentosJustifPagos'] = $modelJustificacion->listDocumentosJustificacion('file_PagosTransformacionDigital', $id);

		/* Todos los documentos de un expediente en la pestaña DETALL */
		$data['documentosDetalle'] = $modelDocumentos->allExpedienteDocuments($id, 'detalle');

		/* Todos los documentos de un expediente EN EL RESTO DE PESTAÑAS */
		$data['documentos'] = $modelDocumentos->allExpedienteDocuments($id, ''); 

		/* Lista de las MEJORAS de la solicitud */
		$data['mejorasSolicitud'] = $modelMejorasSolicitud->selectAllMejorasExpediente($id);
		$data['ultimaMejoraSolicitud'] = $modelMejorasSolicitud->selectLastMejorasExpediente($id);

		/* Muestra la vista */
		echo view('templates/header/header', $data);
		echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);

		if ($tipo_tramite === 'ILS') {
			echo view('pages/exped/edita-expediente-ils', $data);
		} else if ($tipo_tramite === 'ADR-ISBA') {
			echo view('pages/exped/edita-expediente-idi-isba', $data);
		} else if ($tipo_tramite === 'FELIB') {
			echo view('pages/exped/edita-expediente-felib', $data);		
		} else {
			echo view('pages/exped/edita-expediente', $data);
		}
		echo view('templates/footer/footer');
	}

	public function do_upload($id = null, $nif = null, $tipo_tramite = null, $convocatoria = null, $tipoJustDoc = null, $faseExped = null)
	{
		/* /public/index.php/expedientes/do_upload/'.$expedientes['id'].'/'.strtoupper($expedientes['nif']).'/'.str_replace("%20"," ",$expedientes['tipo_tramite']).'/'.$expedientes['convocatoria'].'/fase/Solicitud') */
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
		$tipo_tramite = $request->uri->getSegment(5);
		$tipo_tramite = str_replace("%20", " ", $tipo_tramite);
		$faseExped = $request->uri->getSegment(8);

		/* 	$tipoJustDoc = $request->uri->getSegment(5); */


		// Sube el plan
		if ($tipoJustDoc == "plan") {
			$documentosfile = $this->request->getFiles();
			foreach ($documentosfile['file_PlanTransformacionDigital'] as $plan) {
				if ($plan->isValid() && !$plan->hasMoved()) {
					// $newName = $plan->getRandomName();
					$plan->move(WRITEPATH . 'documentos/' . $nif . '/justificacion/' . $selloTiempo . '/', str_replace(" ", "_", $plan->getName()));
					$data_file = [
						'name' =>  str_replace(" ", "_", $plan->getName()),
						'type' => $plan->getClientMimeType(),
						'cifnif_propietario' => $nif,
						'tipo_tramite' => $tipo_tramite . " " . $convocatoria,
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
		if ($tipoJustDoc == "factura") {
			$documentosfile = $this->request->getFiles();
			foreach ($documentosfile['file_FactTransformacionDigital'] as $factura) {
				if ($factura->isValid() && !$factura->hasMoved()) {
					// $newName = $factura->getRandomName();
					$factura->move(WRITEPATH . 'documentos/' . $nif . '/justificacion/' . $selloTiempo . '/', str_replace(" ", "_", $factura->getName()));
					$data_file = [
						'name' => str_replace(" ", "_", $factura->getName()),
						'type' => $factura->getClientMimeType(),
						'cifnif_propietario' => $nif,
						'tipo_tramite' => $tipo_tramite . " " . $convocatoria,
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
		if ($tipoJustDoc == "pagos") {
			$documentosfile = $this->request->getFiles();
			foreach ($documentosfile['file_PagosTransformacionDigital'] as $pagos) {
				if ($pagos->isValid() && !$pagos->hasMoved()) {
					// $newName = $pagos->getRandomName();
					$pagos->move(WRITEPATH . 'documentos/' . $nif . '/justificacion/' . $selloTiempo . '/', str_replace(" ", "_", $pagos->getName()));
					$data_file = [
						'name' => str_replace(" ", "_", $pagos->getName()),
						'type' => $pagos->getClientMimeType(),
						'cifnif_propietario' => $nif,
						'tipo_tramite' => $tipo_tramite . " " . $convocatoria,
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

		// Sube documentos en fase Detalle
		if ($faseExped == "DetalleRequerido" || $faseExped == "DetalleNoRequerido") {
			$documentosFile = $this->request->getFiles();
			foreach ($documentosFile['file_faseExped' . $faseExped] as $nuevoDocumento) {
				$fileName = $nuevoDocumento->getName();
				$fullPath = WRITEPATH . 'documentos/' . $nif . '/' . $selloTiempo . '/';

				if ($faseExped == 'DetalleRequerido') {
					$esDocRequerido = 'SI';
				}
				if ($faseExped == 'DetalleNoRequerido') {
					$esDocRequerido = 'NO';
				}
				if ($nuevoDocumento->isValid() && !$nuevoDocumento->hasMoved()) {
					// $newName = $nuevoDocumento->getRandomName();
					$nuevoDocumento->move($fullPath, str_replace(" ", "_", $fileName));
					$data_file = [
						'name' 						=> str_replace(" ", "_", $fileName),
						'type' 						=> $nuevoDocumento->getClientMimeType(),
						'cifnif_propietario' 		=> $nif,
						'tipo_tramite' 				=> $tipo_tramite,
						'corresponde_documento' 	=> 'file_faseExped' . $faseExped,
						'datetime_uploaded' 		=> time(),
						'convocatoria' 				=> $convocatoria,
						'created_at' 				=> $nuevoDocumento->getTempName(),
						'selloDeTiempo' 			=> $selloTiempo,
						'id_sol'         			=> $id_sol,
						'fase_exped'				=> '',
						'docRequerido'			=> $esDocRequerido
					];
					$save = $docsExpediente->insert($data_file);
				}
			}
			$data['resguardoREC_subido'] = true;
		}

		// Sube los documentos según la fase del expediente, excepto en fase Detalle
		if ($faseExped == "Solicitud" || $faseExped == "Validacion" || $faseExped == "Ejecucion" || $faseExped == "Justificacion" || $faseExped == "Desestimiento" || $faseExped == "Adhesion" || $faseExped == "Seguimient" || $faseExped == "Renovacion") {
			$documentosFile = $this->request->getFiles();
			foreach ($documentosFile['file_faseExped' . $faseExped] as $resguardo) {
				$fileName = $resguardo->getName();
				$fullPath = WRITEPATH . 'documentos/' . $nif . '/' . $selloTiempo . '/';
				if ($resguardo->isValid() && !$resguardo->hasMoved()) {
					// $newName = $resguardo->getRandomName();
					$resguardo->move($fullPath, str_replace(" ", "_", $fileName));
					$data_file = [
						'name' 								=> str_replace(" ", "_", $fileName),
						'type' 								=> $resguardo->getClientMimeType(),
						'cifnif_propietario' 	=> $nif,
						'tipo_tramite' 				=> $tipo_tramite,
						'corresponde_documento' 	=> 'file_faseExped' . $faseExped,
						'datetime_uploaded' 	=> time(),
						'convocatoria' 				=> $convocatoria,
						'created_at' 					=> $resguardo->getTempName(),
						'selloDeTiempo' 			=> $selloTiempo,
						'id_sol'         			=> $id_sol,
						'fase_exped'					=> $faseExped,
						'docRequerido'				=> 'NO'
					];
					$save = $docsExpediente->insert($data_file);
				}
				if ($resguardo->guessExtension() === 'zip') {
					$numRegDistribucioCAIB = substr($fileName, 0, -4);
					$fileZip = new \ZipArchive();
					if ($fileZip->open($fullPath . $fileName) === TRUE) {
						for ($x = 0; $x <= $fileZip->count(); $x++) {
							$fileZip->renameName($fileZip->getNameIndex($x), str_ireplace(" ", "", $fileZip->getNameIndex($x)));
							$fileZipContent = $fileZip->statIndex($x);
							$data_file = [
								'name' 						=> $fileZipContent['name'],
								'type' 						=> 'application/pdf',
								'cifnif_propietario' 		=> $nif,
								'tipo_tramite' 				=> $tipo_tramite,
								'corresponde_documento' 	=> 'file_faseExped' . $tipo_tramite,
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
							$query = $db->query("SELECT ref_REC FROM pindust_expediente WHERE id = " . $id);
							$row = $query->getRow();
							// si no lo tiene lo actualizo 
							if (strlen($row->ref_REC) == 0) {
								$sql = 'UPDATE pindust_expediente SET ref_REC="' . $numRegDistribucioCAIB . '" WHERE id =' . $id;
							} else {
								$sql = 'UPDATE pindust_expediente SET ref_REC_enmienda="' . $numRegDistribucioCAIB . '" WHERE id =' . $id;
							}
							break;
						case "Justificacion":
							//Compruebo si el campo Referència REC justificació ya tiene un valor.
							$query = $db->query("SELECT ref_REC_justificacion FROM pindust_expediente WHERE id = " . $id);
							$row = $query->getRow();
							// si no lo tiene lo actualizo 
							if (strlen($row->ref_REC_justificacion) == 0) {
								$sql = 'UPDATE pindust_expediente SET ref_REC_justificacion="' . $numRegDistribucioCAIB . '" WHERE id =' . $id;
							} else {
								$sql = 'UPDATE pindust_expediente SET ref_REC_requerimiento_justificacion="' . $numRegDistribucioCAIB . '" WHERE id =' . $id;
							}
							break;
						case "Desestimiento":
							$sql = 'UPDATE pindust_expediente SET ref_REC_desestimiento="' . $numRegDistribucioCAIB . '" WHERE id =' . $id;
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

		foreach ($query->getResult('array') as $row) {
			$data['totalDocsJustifPlan'] = $row['totalDocsJustifPlan'];
		}

		$qry = "SELECT * FROM pindust_documentos_justificacion WHERE (corresponde_documento = 'file_FactTransformacionDigital' AND id_sol = " . $id . ")";
		$query = $db->query($qry);
		$data['documentosJustifFact'] = $query->getResult();
		$query = $db->query("SELECT COUNT(id) AS totalDocsJustifFact FROM pindust_documentos_justificacion WHERE (corresponde_documento = 'file_FactTransformacionDigital' AND id_sol = $id)");
		foreach ($query->getResult('array') as $row) {
			$data['totalDocsJustifFact'] = $row['totalDocsJustifFact'];
		}

		$qry = "SELECT * FROM pindust_documentos_justificacion WHERE (corresponde_documento = 'file_PagosTransformacionDigital' AND id_sol = " . $id . ")";
		$query = $db->query($qry);
		$data['documentosJustifPagos'] = $query->getResult();
		$query = $db->query("SELECT COUNT(id) AS totalDocsJustifPagos FROM pindust_documentos_justificacion WHERE (corresponde_documento = 'file_PagosTransformacionDigital' AND id_sol = $id)");
		foreach ($query->getResult('array') as $row) {
			$data['totalDocsJustifPagos'] = $row['totalDocsJustifPagos'];
		}
		$data['titulo']  = "Expedient: " . $idExp . "/" . $convocatoria . " (" . $tipo_tramite . ") - " . $solicitante . " - " . $nifcif;
		return redirect()->to(base_url("/public/index.php/expedientes/edit/" . $id));
	}

	public function do_justificacion_upload($id, $nif, $tipo_tramite, $convocatoria, $idioma)
	{
		helper('filesystem');
		helper(['form', 'url']);
		helper('cookie');
		$language = \Config\Services::language();
		$language->setLocale($idioma);
		set_cookie('pindust_id', $id, '3600');
		set_cookie('nif', $nif, '3600');
		set_cookie('tipoTramite', $tipo_tramite, '3600');
		set_cookie('convocatoria', $convocatoria, '3600');
		set_cookie('idioma', $idioma, '3600');

		$db = \Config\Database::connect();
		$documentosJustif = $db->table('pindust_documentos_justificacion');
		date_default_timezone_set("Europe/Madrid");
		$selloTiempo = date("d_m_Y_h_i_sa");
		$tipo_tramite = str_replace("%20", " ", $tipo_tramite);

		$listaEnumerativaDeGastos = $this->request->getVar('invoice-lines');
		$totalEnvoiceLines = $this->request->getVar(('total-invoice-lines'));

		// Sube el plan
		$documentosfile = $this->request->getFiles();
		foreach ($documentosfile['file_PlanTransformacionDigital'] as $plan) {
			if ($plan->isValid() && !$plan->hasMoved()) {
				$newName = $plan->getRandomName();
				$plan->move(WRITEPATH . 'documentos/' . $nif . '/justificacion/' . $selloTiempo . '/', $newName);
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
				$data ['id_sol'] = $id;
			}
		}

		// Sube las facturas
		$documentosfile = $this->request->getFiles(); 
		foreach ($documentosfile['file_FactTransformacionDigital'] as $factura) {
			if ($factura->isValid() && !$factura->hasMoved()) {
				$newName = $factura->getRandomName();
				$factura->move(WRITEPATH . 'documentos/' . $nif . '/justificacion/' . $selloTiempo . '/', $newName);
				$data_file = [
					'name' => $newName,
					'type' => $factura->getClientMimeType(),
					'cifnif_propietario' => $nif,
					'tipo_tramite' => $tipo_tramite, //$tipo_tramite[0]." ".$tipo_tramite[1],
					'corresponde_documento' => 'file_FactTransformacionDigital',
					'listaEnumerativaDeGastos' => $listaEnumerativaDeGastos,
					'importeTotalJustificado' => $totalEnvoiceLines,
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
		foreach ($documentosfile['file_PagosTransformacionDigital'] as $pagos) {
			if ($pagos->isValid() && !$pagos->hasMoved()) {
				$newName = $pagos->getRandomName();
				$pagos->move(WRITEPATH . 'documentos/' . $nif . '/justificacion/' . $selloTiempo . '/', $newName);
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
		
		/* ------------------ actualiza el estado del expediente a 'pendienteRECJustificar' ---------------*/
		$sql = 'UPDATE pindust_expediente SET situacion="pendienteRECJustificar" WHERE id =' . $id;
		$db->simpleQuery($sql);
		/*-------------------------------------------------------------------------------------------------*/

		$data['titulo'] = "Expedient: " . $id . " / " . $tipo_tramite[1];
		$query = $db->query("SELECT * FROM pindust_expediente WHERE id =" . $id);
		$expediente = $query->getResult();
		foreach ($expediente as $exped_item) :
			$data['telefono_not'] = $exped_item->telefono_rep;
			$data['email_not'] = $exped_item->email_rep;
			$data['nif'] = $exped_item->nif;
		endforeach;
		$data['selloTiempo'] = $selloTiempo;
		$data['id'] = $id;
		$data['memoriaEconomicaJustificativa'] = $listaEnumerativaDeGastos;
		$data['importeTotalJustificado'] = $totalEnvoiceLines;
		echo view('templates/header/header_form_requerimiento_resultado', $data);
		echo view('pages/forms/documento-justificacion-ayuda', $data);
		echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
		echo view('pages/forms/rest_api_firma/envia-a-firma-justificacion', $data);
		echo view('templates/footer/footer');
	}

	public function do_justificacion_upload_isba($id, $nif, $tipo_tramite, $convocatoria, $idioma)
	{
		helper('filesystem');
		helper(['form', 'url']);
		helper('cookie');
		$language = \Config\Services::language();
		$language->setLocale($idioma);
		set_cookie('pindust_id', $id, '3600');
		set_cookie('nif', $nif, '3600');
		set_cookie('tipoTramite', $tipo_tramite, '3600');
		set_cookie('convocatoria', $convocatoria, '3600');
		set_cookie('idioma', $idioma, '3600');

		$db = \Config\Database::connect();
		$documentosJustif = $db->table('pindust_documentos_justificacion');
		date_default_timezone_set("Europe/Madrid");
		$selloTiempo = date("d_m_Y_h_i_sa");
		$tipo_tramite = str_replace("%20", " ", $tipo_tramite);

		$listaEnumerativaDeGastos = $this->request->getVar('invoice-lines');
		$totalEnvoiceLines = $this->request->getVar(('total-invoice-lines'));

		// Sube el file_DeclRespAplicadoFondoIsba
		$documentosfile = $this->request->getFiles();
		foreach ($documentosfile['file_DeclRespAplicadoFondoIsba'] as $decRespAplicFondo) {
			if ($decRespAplicFondo->isValid() && !$decRespAplicFondo->hasMoved()) {
				$newName = $decRespAplicFondo->getRandomName();
				$decRespAplicFondo->move(WRITEPATH . 'documentos/' . $nif . '/justificacion/' . $selloTiempo . '/', $newName);
				$data_file = [
					'name' =>  $newName,
					'type' => $decRespAplicFondo->getClientMimeType(),
					'cifnif_propietario' => $nif,
					'tipo_tramite' => $tipo_tramite, //$tipo_tramite[0]." ".$tipo_tramite[1],
					'corresponde_documento' => 'file_DeclRespAplicadoFondoIsba',
					'datetime_uploaded' => time(),
					'convocatoria' => $convocatoria,
					'created_at'  => $decRespAplicFondo->getTempName(),
					'selloDeTiempo'  => $selloTiempo,
					'id_sol'         => $id
				];
				$save = $documentosJustif->insert($data_file);
				$last_insert_id = $save->connID->insert_id;
				$data ['id_sol'] = $id;
			}
		}
		// Sube las file_MemoriaActividadesIsba
		$documentosfile = $this->request->getFiles(); 
		foreach ($documentosfile['file_MemoriaActividadesIsba'] as $memoriaActiv) {
			if ($memoriaActiv->isValid() && !$memoriaActiv->hasMoved()) {
				$newName = $memoriaActiv->getRandomName();
				$memoriaActiv->move(WRITEPATH . 'documentos/' . $nif . '/justificacion/' . $selloTiempo . '/', $newName);
				$data_file = [
					'name' => $newName,
					'type' => $memoriaActiv->getClientMimeType(),
					'cifnif_propietario' => $nif,
					'tipo_tramite' => $tipo_tramite, //$tipo_tramite[0]." ".$tipo_tramite[1],
					'corresponde_documento' => 'file_MemoriaActividadesIsba',
					'listaEnumerativaDeGastos' => $listaEnumerativaDeGastos,
					'importeTotalJustificado' => $totalEnvoiceLines,
					'datetime_uploaded' => time(),
					'convocatoria' => $convocatoria,
					'created_at'  => $memoriaActiv->getTempName(),
					'selloDeTiempo'  => $selloTiempo,
					'id_sol'         => $id
				];
				$save = $documentosJustif->insert($data_file);
				$last_insert_id = $save->connID->insert_id;
			}
		}
		// Sube los file_FacturasEmitidasIsba
		$documentosfile = $this->request->getFiles();
		foreach ($documentosfile['file_FacturasEmitidasIsba'] as $factEmitidas) {
			if ($factEmitidas->isValid() && !$factEmitidas->hasMoved()) {
				$newName = $factEmitidas->getRandomName();
				$factEmitidas->move(WRITEPATH . 'documentos/' . $nif . '/justificacion/' . $selloTiempo . '/', $newName);
				$data_file = [
					'name' => $newName,
					'type' => $factEmitidas->getClientMimeType(),
					'cifnif_propietario' => $nif,
					'tipo_tramite' => $tipo_tramite, //$tipo_tramite[0]." ".$tipo_tramite[1],
					'corresponde_documento' => 'file_FacturasEmitidasIsba',
					'datetime_uploaded' => time(),
					'convocatoria' => $convocatoria,
					'created_at'  => $factEmitidas->getTempName(),
					'selloDeTiempo'  => $selloTiempo,
					'id_sol'         => $id
				];
				$save = $documentosJustif->insert($data_file);
				$last_insert_id = $save->connID->insert_id;
			}
		}
		// Sube los file_JustificantesPagoIsba
		$documentosfile = $this->request->getFiles();
		foreach ($documentosfile['file_JustificantesPagoIsba'] as $justifPago) {
			if ($justifPago->isValid() && !$justifPago->hasMoved()) {
				$newName = $justifPago->getRandomName();
				$justifPago->move(WRITEPATH . 'documentos/' . $nif . '/justificacion/' . $selloTiempo . '/', $newName);
				$data_file = [
					'name' => $newName,
					'type' => $justifPago->getClientMimeType(),
					'cifnif_propietario' => $nif,
					'tipo_tramite' => $tipo_tramite, //$tipo_tramite[0]." ".$tipo_tramite[1],
					'corresponde_documento' => 'file_JustificantesPagoIsba',
					'datetime_uploaded' => time(),
					'convocatoria' => $convocatoria,
					'created_at'  => $justifPago->getTempName(),
					'selloDeTiempo'  => $selloTiempo,
					'id_sol'         => $id
				];
				$save = $documentosJustif->insert($data_file);
				$last_insert_id = $save->connID->insert_id;
			}
		}
		/* ------------------ actualiza el estado del expediente a 'pendienteRECJustificar' ---------------*/
		$sql = 'UPDATE pindust_expediente SET situacion="pendienteRECJustificar" WHERE id =' . $id;
		$db->simpleQuery($sql);
		/*-------------------------------------------------------------------------------------------------*/

		$data['titulo'] = "Expedient: " . $id . " / " . $tipo_tramite[1];
		$query = $db->query("SELECT * FROM pindust_expediente WHERE id =" . $id);
		$expediente = $query->getResult();
		foreach ($expediente as $exped_item) :
			$data['telefono_not'] = $exped_item->telefono_rep;
			$data['email_not'] = $exped_item->email_rep;
			$data['nif'] = $exped_item->nif;
		endforeach;
		$data['selloTiempo'] = $selloTiempo;
		$data['id'] = $id;
		$data['memoriaEconomicaJustificativa'] = $listaEnumerativaDeGastos;
		$data['importeTotalJustificado'] = $totalEnvoiceLines;
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
		$fechaREC = date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $this->request->getVar('fecha_REC'))));
		$fechaEnmienda = date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $this->request->getVar('fecha_REC_enmienda'))));
		if (strlen($fechaREC > 0) && $fechaREC != '1970-01-01 01:00:00' && $fechaEnmienda != '0000-00-00 00:00:00') {
			if ($fechaREC > $fechacompletado) {
				$fechacompletado = $fechaREC;
			}
		}
		if (strlen($fechaEnmienda > 0) && $fechaEnmienda != '1970-01-01 01:00:00' && $fechaEnmienda != '0000-00-00 00:00:00' && $fechaEnmienda != '1969-12-31 18:00:00') {
			if ($fechaEnmienda > $fechacompletado) {
				$fechacompletado = $fechaEnmienda;
			} else {
				$fechacompletado = $fechaREC;
			}
		}
		$data = [
			'fecha_completado' => $fechacompletado,
			'fecha_kick_off' => $this->request->getVar('fecha_kick_off'),
			'fecha_REC' => $fechaREC,
			'fecha_REC_enmienda' => date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $this->request->getVar('fecha_REC_enmienda')))),
			'fecha_REC_amp_termino' => date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $this->request->getVar('fecha_REC_amp_termino')))),
			'fecha_REC_justificacion' => date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $this->request->getVar('fecha_REC_justificacion')))),
			'fecha_REC_requerimiento_justificacion' => date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $this->request->getVar('fecha_REC_requerimiento_justificacion')))),
			'fecha_REC_desestimiento' => date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $this->request->getVar('fecha_REC_desestimiento')))),
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
		echo redirect()->to(base_url('public/index.php/users'));
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

	public function muestradocumento()
	{
		$this->response->setHeader('Cache-Control', 'private');
		$request = \Config\Services::request();
		$file =  $request->uri->getSegment(3);
		$nifcif =  $request->uri->getSegment(4);
		$selloDeTiempo = $request->uri->getSegment(5);
		$tipoMIME =  $request->uri->getSegment(6) . '/' . $request->uri->getSegment(7);
		$esJustificacion =  $request->uri->getSegment(8);
		echo $esJustificacion;
		switch ($tipoMIME) {
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
			echo file_get_contents(WRITEPATH . 'documentos/' . $nifcif . '/' . $selloDeTiempo . '/' . $file);
		} else {
			echo file_get_contents(WRITEPATH . 'documentos/' . $nifcif . '/justificacion/' . $selloDeTiempo . '/' . $file);
		}
	}

	public function muestrainforme()
	{
		$this->response->setHeader('Cache-Control', 'private');
		$request = \Config\Services::request();
		$id =  $request->uri->getSegment(3);
		$convocatoria = $request->uri->getSegment(4);
		$programa = str_replace("%20", " ", $request->uri->getSegment(5));
		$nifcif = mb_strtoupper($request->uri->getSegment(6));

		$documento = $request->uri->getSegment(7);
		$db = \Config\Database::connect();

		$query = $db->query("SELECT * FROM pindust_documentos_generados WHERE id_sol=" . $id . 
						" AND convocatoria='" . $convocatoria . "' AND corresponde_documento='" . $documento . "'");
		foreach ($query->getResult() as $row) {
			$file = $row->name;
			$nifcif = $row->cifnif_propietario;
		}

		$query = $db->query("SELECT * FROM pindust_expediente WHERE id=" . $id);
		foreach ($query->getResult() as $row) {
			$idExp = $row->idExp;
			$convocatoria = $row->convocatoria;
		}

		if ($convocatoria >= 2022) {	// a partir del 2022 hemos cambiado el nombre de los modelos de documento a IDEXP_CONVO_NOMMODELO.pdf
			$file = str_replace("doc_", $idExp . "_" . $convocatoria . "_", $file);
		}
		/* 		echo WRITEPATH . 'documentos/' . $nifcif . '/informes/' . $file;
		return; */
		$this->response->setHeader('Content-type', 'application/pdf');
		echo file_get_contents(WRITEPATH . 'documentos/' . $nifcif . '/informes/' . $file);
	}

	public function generainforme()
	{
		date_default_timezone_set("Europe/Madrid");
		$selloDeTiempo = date("d_m_Y_h_i_sa");
		$db = \Config\Database::connect();
		$builder = $db->table('pindust_expediente');

		$modelMejorasSolicitud = new MejorasExpedienteModel();

		$this->response->setHeader('Cache-Control', 'private');
		$request = \Config\Services::request();
		$id_sol =  $request->uri->getSegment(3);
		$convocatoria = $request->uri->getSegment(4);

		$data['id'] =  $id_sol;
		$data['convocatoria'] = $convocatoria;
		$data['programa'] = str_replace("%20", " ", $request->uri->getSegment(5));
		$data['nifcif'] = mb_strtoupper($request->uri->getSegment(6));
		$data['byCEOSigned'] = false;
		$tipoDocumento = $request->uri->getSegment(7);

		$query = $builder->select('idExp')->where('id', $id_sol)->get()->getResult();
		foreach ($query as $row) {
			$idExp = $row->idExp;
		}

		$nombreDocumento = $tipoDocumento . ".pdf";
		if ($convocatoria >= 2022) {	// a partir del 2022 hemos cambiado el nombre de los modelos de documento a IDEXP_CONVO_NOMMODELO.pdf
			$data['nombreDocumento'] = str_replace("doc_", $idExp . "_" . $convocatoria . "_", $nombreDocumento);
		}
		$documentos = $db->table('pindust_documentos_generados');
		$documentos->where('id_sol', $id_sol);
		$documentos->where('corresponde_documento', $tipoDocumento);
		$documentos->where('convocatoria', $convocatoria);
		$documentos->delete();

		/* Lista de las MEJORAS de la solicitud */
		$ultimaMejora = $modelMejorasSolicitud->selectLastMejorasExpediente($id_sol);
		$data['ultimaMejora'] = explode("##", $ultimaMejora);

		$data_file = [
			'id_sol' => $request->uri->getSegment(3),
			'name' =>  $tipoDocumento . ".pdf",
			'type' => 'application/pdf',
			'cifnif_propietario' => $data['nifcif'],
			'tipo_tramite' => str_replace("%20", " ", $request->uri->getSegment(5)),
			'corresponde_documento' => $tipoDocumento,
			'datetime_uploaded' => time(),
			'convocatoria' => $request->uri->getSegment(4),
			'created_at'  => WRITEPATH . 'documentos/' . $data['nifcif'] . '/informes/' . $selloDeTiempo . '/' . $tipoDocumento . ".pdf",
			'selloDeTiempo'  => $selloDeTiempo
		];

		$documentos->insert($data_file);
		$last_insert_id = $db->insertID();
		$data['last_insert_id'] = $last_insert_id;
		$dir = WRITEPATH . 'documentos/' . $data['nifcif'] . '/informes/';

		if (!is_dir($dir)) {
			mkdir($dir, 0775, true);
		}

		echo view('templates/header/header', $data);
		switch ($tipoDocumento) {
			case "doc_requeriment":  														// DOC 1 - CON VIAFIRMA. A TÉCNICO
				$data_infor = [
					'doc_requeriment' => $last_insert_id
				];
				$builder->where('id', $request->uri->getSegment(3));
				$builder->update($data_infor);
				$data['byCEOSigned'] = false;
				$data_footer = [
					'tipoDoc' => " El requeriment",
					'conVIAFIRMA' => true
				];
				echo "<h4>El requeriment</h4>";
				echo view('pages/forms/modDocs/pdf/plt-requerimiento', $data);
				echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
				echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
				echo view('pages/forms/go-back-footer', $data_footer);
				break;
				
			case "doc_res_desestimiento_por_no_enmendar": 			// DOC 2 - CON VIAFIRMA. A GERENCIA
				$data_infor = [
					'doc_res_desestimiento_por_no_enmendar' => $last_insert_id
				];
				$builder->where('id', $request->uri->getSegment(3));
				$builder->update($data_infor);

				$data['byCEOSigned'] = true;
				$data_footer = [
					'tipoDoc' => " Resolució desistiment per no esmenar",
					'conVIAFIRMA' => true
				];
				echo "<h4>Resolució desistiment per no esmenar</h4>";
				echo view('pages/forms/modDocs/pdf/plt-resolucion-desestimiento-por-no-enmendar', $data);
				echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
				echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
				echo view('pages/forms/go-back-footer', $data_footer);
				break;		

			case "doc_informe_favorable_con_requerimiento":  		// DOC 3 - CON VIAFIRMA. A TÉCNICO
				$data_infor = [
					'doc_informe_favorable_con_requerimiento' => $last_insert_id
				];
				$builder->where('id', $request->uri->getSegment(3));
				$builder->update($data_infor);
				$data['byCEOSigned'] = false;
				$data_footer = [
					'tipoDoc' => " Informe favorable amb requeriment",
					'conVIAFIRMA' => true
				];
				echo "<h4>Informe favorable amb requeriment</h4>";
				echo view('pages/forms/modDocs/pdf/plt-informe-favorable-con-requerimiento', $data);
				echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
				echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
				echo view('pages/forms/go-back-footer', $data_footer);
				break;

			case "doc_informe_favorable_sin_requerimiento":  		// DOC 4 - CON VIAFIRMA. A TÉCNICO
				$data_infor = [
					'doc_informe_favorable_sin_requerimiento' => $last_insert_id
				];
				$builder->where('id', $request->uri->getSegment(3));
				$builder->update($data_infor);
				$data['byCEOSigned'] = false;
				$data_footer = [
					'tipoDoc' => " Informe favorable sense requeriment",
					'conVIAFIRMA' => true
				];
				echo "<h4>Informe favorable sense requeriment</h4>";
				echo view('pages/forms/modDocs/pdf/plt-informe-favorable-sin-requerimiento', $data);
				echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
				echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
				echo view('pages/forms/go-back-footer', $data_footer);
				break;

			case "doc_informe_desfavorable_sin_requerimiento":  // DOC 5 - CON VIAFIRMA. A TÉCNICO
				$data_infor = [
					'doc_informe_desfavorable_sin_requerimiento' => $last_insert_id
				];
				$builder->where('id', $request->uri->getSegment(3));
				$builder->update($data_infor);
				$data['byCEOSigned'] = false;
				$data_footer = [
					'tipoDoc' => " Informe desfavorable sense requeriment",
					'conVIAFIRMA' => true
				];
				echo "<h4>Informe desfavorable sense requeriment</h4>";
				echo view('pages/forms/modDocs/pdf/plt-informe-desfavorable-sin-requerimiento', $data);
				echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
				echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
				echo view('pages/forms/go-back-footer', $data_footer);
				break;

			case "doc_informe_desfavorable_con_requerimiento":  // DOC 6 - CON VIAFIRMA. A TÉCNICO
				$data_infor = [
					'doc_informe_desfavorable_con_requerimiento' => $last_insert_id
				];
				$builder->where('id', $request->uri->getSegment(3));
				$builder->update($data_infor);
				$data['byCEOSigned'] = false;
				$data_footer = [
					'tipoDoc' => " Informe desfavorable amb requeriment",
					'conVIAFIRMA' => true
				];
				echo "<h4>Informe desfavorable amb requeriment</h4>";
				echo view('pages/forms/modDocs/pdf/plt-informe-desfavorable-con-requerimiento', $data);
				echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
				echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
				echo view('pages/forms/go-back-footer', $data_footer);
				break;

			case "doc_prop_res_provisional_favorable_sin_req":  // DOC 7 - CON VIAFIRMA. A GERENCIA
				$data_infor = [
					'doc_prop_res_provisional_favorable_sin_req' => $last_insert_id
				];
				$builder->where('id', $request->uri->getSegment(3));
				$builder->update($data_infor);
				$data['byCEOSigned'] = true;
				$data_footer = [
					'tipoDoc' => "<h4>Proposta de resolució PROVISIONAL favorable sense requeriment</h4>",
					'conVIAFIRMA' => true
				];
				echo "<h4>Proposta de resolució PROVISIONAL favorable sense requeriment</h4>";
				echo view('pages/forms/modDocs/pdf/plt-propuesta-resolucion-provisional-favorable-sin-requerimiento', $data);
				echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
				echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
				echo view('pages/forms/go-back-footer', $data_footer);
				break;
			case "doc_prop_res_provisional_favorable_con_req": 	// DOC 8 - CON VIAFIRMA. A GERENCIA
				$data_infor = [
					'doc_prop_res_provisional_favorable_con_req' => $last_insert_id
				];
				$builder->where('id', $request->uri->getSegment(3));
				$builder->update($data_infor);
				$data['byCEOSigned'] = true;
				$data_footer = [
					'tipoDoc' => " Proposta de resolució PROVISIONAL favorable amb requeriment",
					'conVIAFIRMA' => true
				];
				echo "<h4>Proposta de resolució PROVISIONAL favorable amb requeriment</h4>";
				echo view('pages/forms/modDocs/pdf/plt-propuesta-resolucion-provisional-favorable-con-requerimiento', $data);
				echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
				echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
				echo view('pages/forms/go-back-footer', $data_footer);
				break;
			case "doc_prop_res_prov_desf_sin_req":  						// DOC 9 - CON VIAFIRMA. A GERENCIA
				$data_infor = [
					'doc_prop_res_prov_desf_sin_req' => $last_insert_id
				];
				$builder->where('id', $request->uri->getSegment(3));
				$builder->update($data_infor);
				$data['byCEOSigned'] = true;
				$data_footer = [
					'tipoDoc' => " Proposta de resolució provisional desfavorable sense requeriment",
					'conVIAFIRMA' => true
				];
				echo "<h4>Proposta de resolució provisional desfavorable sense requeriment</h4>";
				echo view('pages/forms/modDocs/pdf/plt-propuesta-resolucion-provisional-desfavorable-sin-requerimiento', $data);
				echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
				echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
				echo view('pages/forms/go-back-footer', $data_footer);
				break;
			case "doc_prop_res_prov_desf_con_req": 							// DOC 10 - CON VIAFIRMA. A GERENCIA
				$data_infor = [
					'doc_prop_res_prov_desf_con_req' => $last_insert_id
				];
				$builder->where('id', $request->uri->getSegment(3));
				$builder->update($data_infor);
				$data['byCEOSigned'] = true;
				$data_footer = [
					'tipoDoc' => " Proposta de resolució provisional desfavorable amb requeriment",
					'conVIAFIRMA' => true
				];
				echo "<h4>Proposta de resolució provisional desfavorable amb requeriment</h4>";
				echo view('pages/forms/modDocs/pdf/plt-propuesta-resolucion-provisional-desfavorable-con-requerimiento', $data);
				echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
				echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
				echo view('pages/forms/go-back-footer', $data_footer);
				break;

			case "doc_prop_res_def_favorable_sin_req": 					// DOC 11 - CON VIAFIRMA. A GERENCIA o DIRECCIÓN GENERAL
				$data_infor = [
					'doc_prop_res_def_favorable_sin_req' => $last_insert_id
				];
				$builder->where('id', $request->uri->getSegment(3));
				$builder->update($data_infor);
				$data['byCEOSigned'] = true;
				$data_footer = [
					'tipoDoc' => " Proposta de resolució definitiva favorable sense requeriment",
					'conVIAFIRMA' => false
				];
				echo "<h4>Proposta de resolució definitiva favorable sense requeriment</h4>";
				echo view('pages/forms/modDocs/pdf/plt-propuesta-resolucion-definitiva-favorable-sin-requerimiento', $data);
				echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
				echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
				echo view('pages/forms/go-back-footer', $data_footer);
				break;

			case "doc_prop_res_def_favorable_con_req": 					// DOC 12 - CON VIAFIRMA. A GERENCIA o DIRECCIÓN GENERAL
				$data_infor = [
					'doc_prop_res_def_favorable_con_req' => $last_insert_id
				];
				$builder->where('id', $request->uri->getSegment(3));
				$builder->update($data_infor);
				$data['byCEOSigned'] = true;
				$data_footer = [
					'tipoDoc' => " Proposta de resolució definitiva favorable amb requeriment",
					'conVIAFIRMA' => false
				];
				echo "<h4>Proposta de resolució definitiva favorable amb requeriment</h4>";
				echo view('pages/forms/modDocs/pdf/plt-propuesta-resolucion-definitiva-favorable-con-requerimiento', $data);
				echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
				echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
				echo view('pages/forms/go-back-footer', $data_footer);
				break;
			case "doc_prop_res_def_desfavorable_sin_req": 			// DOC 13 - CON VIAFIRMA. A GERENCIA o DIRECCIÓN GENERAL
					$data_infor = [
						'doc_prop_res_def_desfavorable_sin_req' => $last_insert_id
					];
					$builder->where('id', $request->uri->getSegment(3));
					$builder->update($data_infor);
					$data['byCEOSigned'] = true;
					$data_footer = [
						'tipoDoc' => " Proposta de resolució definitiva desfavorable sense requeriment",
						'conVIAFIRMA' => false
					];
					echo "<h4>Proposta de resolució definitiva desfavorable sense requeriment</h4>";
					echo view('pages/forms/modDocs/pdf/plt-propuesta-resolucion-definitiva-desfavorable-sin-requerimiento', $data);
					echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
					echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
					echo view('pages/forms/go-back-footer', $data_footer);
					break;
			case "doc_prop_res_def_desfavorable_con_req": 			// DOC 14 - CON VIAFIRMA. A GERENCIA o DIRECCIÓN GENERAL
						$data_infor = [
							'doc_prop_res_def_desfavorable_con_req' => $last_insert_id
						];
						$builder->where('id', $request->uri->getSegment(3));
						$builder->update($data_infor);
						$data['byCEOSigned'] = true;
						$data_footer = [
							'tipoDoc' => " Proposta de resolució definitiva desfavorable amb requeriment",
							'conVIAFIRMA' => false
						];
						echo "<h4>Proposta de resolució definitiva desfavorable amb requeriment</h4>";
						echo view('pages/forms/modDocs/pdf/plt-propuesta-resolucion-definitiva-desfavorable-con-requerimiento', $data);
						echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
						echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
						echo view('pages/forms/go-back-footer', $data_footer);
						break;					
			case "doc_res_concesion_favorable_con_req": 			  // DOC 15 - CON VIAFIRMA. A GERENCIA o DIRECCIÓN GENERAL
							$data_infor = [
								'doc_res_concesion_favorable_con_req' => $last_insert_id
							];
							$builder->where('id', $request->uri->getSegment(3));
							$builder->update($data_infor);
							$data['byCEOSigned'] = true;
							$data_footer = [
								'tipoDoc' => " Resolució de concessió favorable amb requeriment",
								'conVIAFIRMA' => false
							];
							echo "<h4>Resolució de concessió favorable amb requeriment</h4>";
							echo view('pages/forms/modDocs/pdf/plt-resolucion-concesion-favorable-con-requerimiento', $data);
							echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
							echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
							echo view('pages/forms/go-back-footer', $data_footer);
							break;				
			case "doc_res_concesion_favorable_sin_req": 			  // DOC 16 - CON VIAFIRMA. A GERENCIA o DIRECCIÓN GENERAL
								$data_infor = [
									'doc_res_concesion_favorable_sin_req' => $last_insert_id
								];
								$builder->where('id', $request->uri->getSegment(3));
								$builder->update($data_infor);
								$data['byCEOSigned'] = true;
								$data_footer = [
									'tipoDoc' => " Resolució de concessió favorable sense requeriment",
									'conVIAFIRMA' => false
								];
								echo "<h4>Resolució de concessió favorable sense requeriment</h4>";
								echo view('pages/forms/modDocs/pdf/plt-resolucion-concesion-favorable-sin-requerimiento', $data);
								echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
								echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
								echo view('pages/forms/go-back-footer', $data_footer);
								break;				
			case "doc_res_denegacion_con_req": 			  					// DOC 17 - CON VIAFIRMA. A GERENCIA o DIRECCIÓN GENERAL
							$data_infor = [
									'doc_res_denegacion_con_req' => $last_insert_id
							];
							$builder->where('id', $request->uri->getSegment(3));
							$builder->update($data_infor);
							$data['byCEOSigned'] = true;
							$data_footer = [
								'tipoDoc' => " Resolució de denegació amb requeriment",
								'conVIAFIRMA' => false
							];
							echo "<h4>Resolució de denegació amb requeriment</h4>";
							echo view('pages/forms/modDocs/pdf/plt-resolucion-denegacion-con-requerimiento', $data);
							echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
							echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
							echo view('pages/forms/go-back-footer', $data_footer);
							break;
			case "doc_res_denegacion_sin_req": 			  					// DOC 18 - CON VIAFIRMA. A GERENCIA o DIRECCIÓN GENERAL
								$data_infor = [
										'doc_res_denegacion_sin_req' => $last_insert_id
								];
								$builder->where('id', $request->uri->getSegment(3));
								$builder->update($data_infor);
								$data['byCEOSigned'] = true;
								$data_footer = [
									'tipoDoc' => " Resolució de denegació sense requeriment",
									'conVIAFIRMA' => false
								];
								echo "<h4>Resolució de denegació sense requeriment</h4>";
								echo view('pages/forms/modDocs/pdf/plt-resolucion-denegacion-sin-requerimiento', $data);
								echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
								echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
								echo view('pages/forms/go-back-footer', $data_footer);
								break;												
			case "doc_acta_kickoff": 														// DOC 19 - CON VIAFIRMA DOC xxx A TÉCNICO
				$data_infor = [
					'doc_acta_kickoff' => $last_insert_id
				];
				$builder->where('id', $request->uri->getSegment(3));
				$builder->update($data_infor);
				$data['byCEOSigned'] = false;
				$data_footer = [
					'tipoDoc' => " Acta de Kick off",
					'conVIAFIRMA' => false
				];
				echo "<h4>Acta de Kick off</h4>";
				echo view('pages/forms/modDocs/pdf/plt-acta-kickoff', $data);
				echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
				echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
				echo view('pages/forms/go-back-footer', $data_footer);
				break;

			case "doc_acta_de_cierre": 													// DOC 20 - CON VIAFIRMA DOC xxx A TÉCNICO
				$data_infor = [
					'doc_acta_de_cierre' => $last_insert_id
				];
				$builder->where('id', $request->uri->getSegment(3));
				$builder->update($data_infor);
				$data['byCEOSigned'] = false;
				$data_footer = [
					'tipoDoc' => " Acta de tancament",
					'conVIAFIRMA' => true
				];
				echo "<h4>Acta de tancament</h4>";
				echo view('pages/forms/modDocs/pdf/plt-acta-de-cierre', $data);
				echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
				echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
				echo view('pages/forms/go-back-footer', $data_footer);
				break;
			case "doc_res_pago_sin_req": 			  					// DOC 27 - CON VIAFIRMA. A GERENCIA o DIRECCIÓN GENERAL
					$data_infor = [
							'doc_res_pago_sin_req' => $last_insert_id
					];
					$builder->where('id', $request->uri->getSegment(3));
					$builder->update($data_infor);
					$data['byCEOSigned'] = true;
					$data_footer = [
						'tipoDoc' => " Resolució de pagament sense requeriment",
						'conVIAFIRMA' => false
					];
					echo "<h4>Resolució de pagament sense requeriment</h4>";
					echo view('pages/forms/modDocs/pdf/plt-resolucion-pago-sin-requerimiento', $data);
					echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
					echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
					echo view('pages/forms/go-back-footer', $data_footer);
					break;													
			
				case "doc_res_conces_sin_req": //SIN VIAFIRMA DOC 17 A DIRECTOR GENERAL
				$data_infor = [
					'doc_res_conces_sin_req' => $last_insert_id
				];
				$builder->where('id', $request->uri->getSegment(3));
				$builder->update($data_infor);
				$data['byCEOSigned'] = false;
				$data_footer = [
					'tipoDoc' => " Resolució de concessió sense requeriment",
					'conVIAFIRMA' => false
				];
				echo "<h4>Resolució de concessió sense requeriment</h4>";
				echo view('pages/forms/modDocs/pdf/plt-resolucion-concesion', $data);
				echo view('pages/forms/go-back-footer', $data_footer);
				break;

			case "doc_inicio_requerimiento_justificacion": //CON VIAFIRMA DOC 18 A TÉCNICO
				$data_infor = [
					'doc_inicio_requerimiento_justificacion' => $last_insert_id
				];
				$builder->where('id', $request->uri->getSegment(3));
				$builder->update($data_infor);
				$data['byCEOSigned'] = false;
				$data_footer = [
					'tipoDoc' => " Informe inici requeriment justificació",
					'conVIAFIRMA' => true
				];
				echo "<h4>Informe inici requeriment justificació</h4>";
				echo view('pages/forms/modDocs/pdf/plt-inicio-requerimiento-justificacion', $data);
				echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
				echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
				echo view('pages/forms/go-back-footer', $data_footer);
				break;

			case "doc_requerimiento_justificacion": //CON VIAFIRMA DOC 19 - A GERENTE
				$data_infor = [
					'doc_requerimiento_justificacion' => $last_insert_id
				];
				$builder->where('id', $request->uri->getSegment(3));
				$builder->update($data_infor);
				$data['byCEOSigned'] = true;
				$data_footer = [
					'tipoDoc' => " Requeriment d'esmena justificació",
					'conVIAFIRMA' => true
				];
				echo "<h4>Requeriment d'esmena justificació</h4>";
				echo view('pages/forms/modDocs/pdf/plt-requerimiento-justificacion', $data);
				echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
				echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
				echo view('pages/forms/go-back-footer', $data_footer);
				break;

			case "doc_informe_sobre_la_subsanacion": //CON VIAFIRMA DOC 20 A TÉCNICO
				$data_infor = [
					'doc_informe_sobre_la_subsanacion' => $last_insert_id
				];
				$builder->where('id', $request->uri->getSegment(3));
				$builder->update($data_infor);
				$data['byCEOSigned'] = false;
				$data_footer = [
					'tipoDoc' => " Informe post esmena justificació",
					'conVIAFIRMA' => true
				];
				echo "<h4>Informe post esmena justificació</h4>";
				echo view('pages/forms/modDocs/pdf/plt-informe-subsanacion-docum-justificacion', $data);
				echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
				echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
				echo view('pages/forms/go-back-footer', $data_footer);
				break;

			case "doc_resolucion_concesion_con_req_20b": //SIN VIAFIRMA DOC 20b A DIRECTOR GENERAL
				$data_infor = [
					'doc_resolucion_concesion_con_req_20b' => $last_insert_id
				];
				$builder->where('id', $request->uri->getSegment(3));
				$builder->update($data_infor);
				$data['byCEOSigned'] = false;
				$data_footer = [
					'tipoDoc' => " Resolució de concesió amb requeriment (20b)",
					'conVIAFIRMA' => false
				];
				echo "<h4>Resolució de concesió amb requeriment</h4>";
				echo view('pages/forms/modDocs/pdf/plt-resolucion-concesion-con-requerimiento', $data);
				echo view('pages/forms/go-back-footer', $data_footer);
				break;

			case "doc_res_desestimiento_por_renuncia": //SIN VIAFIRMA DOC 22 A DIRECTOR GENERAL
				$data_infor = [
					'doc_res_desestimiento_por_renuncia' => $last_insert_id
				];
				$builder->where('id', $request->uri->getSegment(3));
				$builder->update($data_infor);
				$data['byCEOSigned'] = false;
				$data_footer = [
					'tipoDoc' => " Resolució desistiment per renúncia",
					'conVIAFIRMA' => false
				];
				echo "<h4>Resolució desistiment per renúncia</h4>";
				echo view('pages/forms/modDocs/pdf/plt-resolucion-desestimiento-por-renuncia', $data);
				echo view('pages/forms/go-back-footer', $data_footer);
				break;

			case "doc_prop_res_revocacion_por_no_justificar": //CON VIAFIRMA DOC 23 A GERENTE
				$data_infor = [
					'doc_prop_res_revocacion_por_no_justificar' => $last_insert_id
				];
				$builder->where('id', $request->uri->getSegment(3));
				$builder->update($data_infor);
				$data['byCEOSigned'] = true;
				$data_footer = [
					'tipoDoc' => " Proposta de resolució de revocació per no justificar",
					'conVIAFIRMA' => true
				];
				echo "<h4>Proposta resolució revocació per no justificar</h4>";
				echo view('pages/forms/modDocs/pdf/plt-propuesta-resolucion-revocacion-por-no-justificar', $data);
				echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
				echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
				echo view('pages/forms/go-back-footer', $data_footer);
				break;

			case "doc_res_revocacion_por_no_justificar": //SIN VIAFIRMA DOC 24 A DIRECTOR GENERAL
				$data_infor = [
					'doc_res_revocacion_por_no_justificar' => $last_insert_id
				];
				$builder->where('id', $request->uri->getSegment(3));
				$builder->update($data_infor);
				$data['byCEOSigned'] = false;
				$data_footer = [
					'tipoDoc' => " Resolució revocació per no justificar",
					'conVIAFIRMA' => false
				];
				echo "<h4>Resolució revocació per no justificar</h4>";
				echo view('pages/forms/modDocs/pdf/plt-resolucion-revocacion-por-no-justificar', $data);
				echo view('pages/forms/go-back-footer', $data_footer);
				break;
	
		}
		echo view('templates/footer/footer');
	}

	public function generainformeILS()
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
		$data['programa'] = str_replace("%20", " ", $request->uri->getSegment(5));
		$data['nifcif'] = mb_strtoupper($request->uri->getSegment(6));
		$tipoDocumento = $request->uri->getSegment(7);

		$query = $builder->select('idExp')->where('id', $id_sol)->get()->getResult();

		foreach ($query as $row) {
			$idExp = $row->idExp;
		}

		$nombreDocumento = $tipoDocumento . ".pdf";
		if ($convocatoria >= 2022) {	// a partir del 2022 hemos cambiado el nombre de los modelos de documento a IDEXP_CONVO_NOMMODELO.pdf
			$data['nombreDocumento'] = str_replace("doc_", $idExp . "_" . $convocatoria . "_", $nombreDocumento);
		}
		$documentos = $db->table('pindust_documentos_generados');
		$documentos->where('id_sol', $id_sol);
		$documentos->where('corresponde_documento', $tipoDocumento);
		$documentos->where('convocatoria', $convocatoria);
		$documentos->delete();

		$data_file = [
			'id_sol' => $request->uri->getSegment(3),
			'name' =>  $tipoDocumento . ".pdf",
			'type' => 'application/pdf',
			'cifnif_propietario' => $request->uri->getSegment(6),
			'tipo_tramite' => str_replace("%20", " ", $request->uri->getSegment(5)),
			'corresponde_documento' => $tipoDocumento,
			'datetime_uploaded' => time(),
			'convocatoria' => $request->uri->getSegment(4),
			'created_at'  => WRITEPATH . 'documentos/' . $data['nifcif'] . '/informes/' . $selloDeTiempo . '/' . $tipoDocumento . ".pdf",
			'selloDeTiempo'  => $selloDeTiempo
		];

		$save = $documentos->insert($data_file);
		$last_insert_id = $db->insertID();
		//$last_insert_id = $save->connID->insert_id;
		$data['last_insert_id'] = $last_insert_id;
		$dir = WRITEPATH . 'documentos/' . $request->uri->getSegment(6) . '/informes/';

		if (!is_dir($dir)) {
			mkdir($dir, 0775);
		}
		echo view('templates/header/header', $data);
		switch ($tipoDocumento) {
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
				echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
				echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
				echo view('pages/forms/go-back-footer', $data_footer);
				break;
		}
	}

	public function generainformeIDI_ISBA()
	{
		date_default_timezone_set("Europe/Madrid");
		$selloDeTiempo = date("d_m_Y_h_i_sa");
		$db = \Config\Database::connect();
		$builder = $db->table('pindust_expediente');
		$this->response->setHeader('Cache-Control', 'private');
		$request = \Config\Services::request();
		$id_sol =  $request->uri->getSegment(3);
		$convocatoria = $request->uri->getSegment(4);

		$data['id'] = $id_sol;
		$data['convocatoria'] = $convocatoria;
		$data['programa'] = str_replace("%20", " ", $request->uri->getSegment(5));
		$data['nifcif'] = mb_strtoupper($request->uri->getSegment(6));
		$data['byCEOSigned'] = false;
		$tipoDocumento = $request->uri->getSegment(7);

		$query = $builder->select('idExp')->where('id', $id_sol)->get()->getResult();
		foreach ($query as $row) {
			$idExp = $row->idExp;
		}

		$nombreDocumento = $tipoDocumento . ".pdf";
	
		$data['nombreDocumento'] = str_replace("doc_", $idExp . "_" . $convocatoria . "_", $nombreDocumento);

		$documentos = $db->table('pindust_documentos_generados');
		$documentos->where('id_sol', $id_sol);
		$documentos->where('corresponde_documento', $tipoDocumento);
		$documentos->where('convocatoria', $convocatoria);
		$documentos->delete();

		$data_file = [
			'id_sol' => $request->uri->getSegment(3),
			'name' =>  $tipoDocumento . ".pdf",
			'type' => 'application/pdf',
			'cifnif_propietario' => $request->uri->getSegment(6),
			'tipo_tramite' => str_replace("%20", " ", $request->uri->getSegment(5)),
			'corresponde_documento' => $tipoDocumento,
			'datetime_uploaded' => time(),
			'convocatoria' => $request->uri->getSegment(4),
			'created_at'  => WRITEPATH . 'documentos/' . $data['nifcif'] . '/informes/' . $selloDeTiempo . '/' . $tipoDocumento . ".pdf",
			'selloDeTiempo'  => $selloDeTiempo
		];

		$documentos->insert($data_file);
		$last_insert_id = $db->insertID();
		$data['last_insert_id'] = $last_insert_id;
		$dir = WRITEPATH . 'documentos/' . $request->uri->getSegment(6) . '/informes/';

		if (!is_dir($dir)) {
			mkdir($dir, 0775, true);
		}

		echo view('templates/header/header', $data);
		switch ($tipoDocumento) {
			case "doc_requeriment_adr_isba":  													//VIAFIRMA DOC 1
				$data_infor = [
					'doc_requeriment_adr_isba' => $last_insert_id
				];
				$builder->where('id', $request->uri->getSegment(3));
				$builder->update($data_infor);

				$data['byCEOSigned'] = false;
				$data_footer = [
					'tipoDoc' => " El requeriment",
					'conVIAFIRMA' => true
				];
				echo view('pages/forms/modDocs/IDI-ISBA/pdf/plt-requerimiento-adr-isba', $data);
				echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
				echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
				echo view('pages/forms/go-back-footer', $data_footer);
				break;
				
			case "doc_res_desestimiento_por_no_enmendar_adr_isba":  		//VIAFIRMA DOC 2
				$data_infor = [
					'doc_res_desestimiento_por_no_enmendar_adr_isba' => $last_insert_id
				];
				$builder->where('id', $request->uri->getSegment(3));
				$builder->update($data_infor);

				$data['byCEOSigned'] = false;
				$data_footer = [
					'tipoDoc' => " Resolució desistiment per no esmenar",
					'conVIAFIRMA' => false
				];
				echo view('pages/forms/modDocs/IDI-ISBA/pdf/plt-resolucion-desestimiento-por-no-enmendar-adr-isba', $data);
				echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
				echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
				echo view('pages/forms/go-back-footer', $data_footer);
				break;
			case "doc_informe_favorable_sin_requerimiento_adr_isba":		//VIAFIRMA DOC 3
					$data_infor = [
						'doc_informe_favorable_sin_requerimiento_adr_isba' => $last_insert_id
					];
					$builder->where('id', $request->uri->getSegment(3));
					$builder->update($data_infor);
	
					$data['byCEOSigned'] = false;
					$data_footer = [
						'tipoDoc' => " Informe favorable sense requeriment",
						'conVIAFIRMA' => false
					];
					echo view('pages/forms/modDocs/IDI-ISBA/pdf/plt-informe-favorable-sin-requerimiento-adr-isba', $data);
					echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
					echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
					echo view('pages/forms/go-back-footer', $data_footer);
					break;
			case "doc_informe_favorable_con_requerimiento_adr_isba":		//VIAFIRMA DOC 4
						$data_infor = [
							'doc_informe_favorable_con_requerimiento_adr_isba' => $last_insert_id
						];
						$builder->where('id', $request->uri->getSegment(3));
						$builder->update($data_infor);
		
						$data['byCEOSigned'] = false;
						$data_footer = [
							'tipoDoc' => " Informe favorable amb requeriment",
							'conVIAFIRMA' => false
						];
						echo view('pages/forms/modDocs/IDI-ISBA/pdf/plt-informe-favorable-con-requerimiento-adr-isba', $data);
						echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
						echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
						echo view('pages/forms/go-back-footer', $data_footer);
						break;							
			case "doc_prop_res_provisional_adr_isba": 									//VIAFIRMA DOC 5
				$data_infor = [
					'doc_prop_res_provisional_adr_isba' => $last_insert_id
				];
				$builder->where('id', $request->uri->getSegment(3));
				$builder->update($data_infor);
	
				$data['byCEOSigned'] = false;
				$data_footer = [
					'tipoDoc' => " Proposta resolució provisional",
					'conVIAFIRMA' => false
				];
				echo view('pages/forms/modDocs/IDI-ISBA/pdf/plt-propuesta-resolucion-provisional-adr-isba', $data);
				echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
				echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
				echo view('pages/forms/go-back-footer', $data_footer);
				break;
			case "doc_prop_res_provisional_con_requerimiento_adr_isba": //VIAFIRMA DOC 6
					$data_infor = [
						'doc_prop_res_provisional_con_requerimiento_adr_isba' => $last_insert_id
					];
					$builder->where('id', $request->uri->getSegment(3));
					$builder->update($data_infor);
		
					$data['byCEOSigned'] = false;
					$data_footer = [
						'tipoDoc' => " Proposta resolució provisional amb requeriment",
						'conVIAFIRMA' => false
					];
					echo view('pages/forms/modDocs/IDI-ISBA/pdf/plt-propuesta-resolucion-provisional-con-requerimiento-adr-isba', $data);
					echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
					echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
					echo view('pages/forms/go-back-footer', $data_footer);
					break;				
			case "doc_prop_res_definitiva_adr_isba": 										//VIAFIRMA DOC 7
				$data_infor = [
					'doc_prop_res_definitiva_adr_isba' => $last_insert_id
				];
				$builder->where('id', $request->uri->getSegment(3));
				$builder->update($data_infor);
	
				$data['byCEOSigned'] = false;
				$data_footer = [
					'tipoDoc' => " Proposta resolució definitiva",
					'conVIAFIRMA' => false
				];
				echo view('pages/forms/modDocs/IDI-ISBA/pdf/plt-propuesta-resolucion-definitiva-adr-isba', $data);
				echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
				echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
				echo view('pages/forms/go-back-footer', $data_footer);
				break;
			case "doc_prop_res_definitiva_con_requerimiento_adr_isba": 	//VIAFIRMA DOC 8
					$data_infor = [
						'doc_prop_res_definitiva_con_requerimiento_adr_isba' => $last_insert_id
					];
					$builder->where('id', $request->uri->getSegment(3));
					$builder->update($data_infor);
		
					$data['byCEOSigned'] = false;
					$data_footer = [
						'tipoDoc' => " Proposta resolució definitiva amb requeriment",
						'conVIAFIRMA' => false
					];
					echo view('pages/forms/modDocs/IDI-ISBA/pdf/plt-propuesta-resolucion-definitiva-con-requerimiento-adr-isba', $data);
					echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
					echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
					echo view('pages/forms/go-back-footer', $data_footer);
					break;				

			case "doc_res_concesion_adr_isba": 													//VIAFIRMA DOC 9
				$data_infor = [
					'doc_res_concesion_adr_isba' => $last_insert_id
				];
				$builder->where('id', $request->uri->getSegment(3));
				$builder->update($data_infor);
				
				$data['byCEOSigned'] = false;
				$data_footer = [
					'tipoDoc' => " Resolució de concessió",
					'conVIAFIRMA' => false
				];
				echo view('pages/forms/modDocs/IDI-ISBA/pdf/plt-resolucion-concesion-adr-isba', $data);
				echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
				echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
				echo view('pages/forms/go-back-footer', $data_footer);
				break;
			case "doc_res_concesion_con_requerimiento_adr_isba": 				//VIAFIRMA DOC 10
					$data_infor = [
						'doc_res_concesion_con_requerimiento_adr_isba' => $last_insert_id
					];
					$builder->where('id', $request->uri->getSegment(3));
					$builder->update($data_infor);
					
					$data['byCEOSigned'] = false;
					$data_footer = [
						'tipoDoc' => " Resolució de concessió amb requeriment",
						'conVIAFIRMA' => false
					];
					echo view('pages/forms/modDocs/IDI-ISBA/pdf/plt-resolucion-concesion-con-requerimiento-adr-isba', $data);
					echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
					echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
					echo view('pages/forms/go-back-footer', $data_footer);
					break;				
			case "doc_res_pago_y_justificacion_adr_isba": 			  			//VIAFIRMA DOC 11
					$data_infor = [
						'doc_res_pago_y_justificacion_adr_isba' => $last_insert_id
					];
					$builder->where('id', $request->uri->getSegment(3));
					$builder->update($data_infor);
				
					$data['byCEOSigned'] = false;
					$data_footer = [
						'tipoDoc' => " Resolució de pagament i justificació",
						'conVIAFIRMA' => false
					];
					echo view('pages/forms/modDocs/IDI-ISBA/pdf/plt-resolucion-pago-y-justificacion-adr-isba', $data);
					echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
					echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
					echo view('pages/forms/go-back-footer', $data_footer);
					break;
			case "doc_inicio_requerimiento_justificacion_adr_isba": 		//VIAFIRMA DOC 12
						$data_infor = [
							'doc_inicio_requerimiento_justificacion_adr_isba' => $last_insert_id
						];
						$builder->where('id', $request->uri->getSegment(3));
						$builder->update($data_infor);
					
						$data['byCEOSigned'] = false;
						$data_footer = [
							'tipoDoc' => " Informe inici requeriment justificació",
							'conVIAFIRMA' => false
						];
						echo view('pages/forms/modDocs/IDI-ISBA/pdf/plt-informe-inicio-requerimiento-justificacion-adr-isba', $data);
						echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
						echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
						echo view('pages/forms/go-back-footer', $data_footer);
						break;
			case "doc_requerimiento_justificacion": 										//VIAFIRMA DOC 13
							$data_infor = [
								'doc_requerimiento_justificacion' => $last_insert_id
							];
							$builder->where('id', $request->uri->getSegment(3));
							$builder->update($data_infor);
						
							$data['byCEOSigned'] = false;
							$data_footer = [
								'tipoDoc' => " Requeriment d'esmena justificació",
								'conVIAFIRMA' => false
							];
							echo view('pages/forms/modDocs/IDI-ISBA/pdf/plt-requerimiento-enmienda-justificacion-adr-isba', $data); 
							echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
							echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
							echo view('pages/forms/go-back-footer', $data_footer);
							break;
			case "doc_informe_sobre_la_subsanacion": 										//VIAFIRMA DOC 14
							$data_infor = [
								'doc_informe_sobre_la_subsanacion' => $last_insert_id
							];
							$builder->where('id', $request->uri->getSegment(3));
							$builder->update($data_infor);
						
							$data['byCEOSigned'] = false;
							$data_footer = [
								'tipoDoc' => " Informe postesmena justificació",
								'conVIAFIRMA' => false
							];
							echo view('pages/forms/modDocs/IDI-ISBA/pdf/plt-informe-postenmienda-justificacion-adr-isba', $data); 
							echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
							echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
							echo view('pages/forms/go-back-footer', $data_footer);
							break;
			case "doc_res_desestimiento_por_renuncia": 									//VIAFIRMA DOC 15
								$data_infor = [
									'doc_res_desestimiento_por_renuncia' => $last_insert_id
								];
								$builder->where('id', $request->uri->getSegment(3));
								$builder->update($data_infor);
							
								$data['byCEOSigned'] = false;
								$data_footer = [
									'tipoDoc' => " Resolució desistiment per renúncia",
									'conVIAFIRMA' => false
								];
								echo view('pages/forms/modDocs/IDI-ISBA/pdf/plt-resolucion-desestimiento-por-renuncia-adr-isba', $data); 
								echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
								echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
								echo view('pages/forms/go-back-footer', $data_footer);
								break;
			case "doc_prop_res_revocacion_por_no_justificar": 					//VIAFIRMA DOC 16
									$data_infor = [
										'doc_prop_res_revocacion_por_no_justificar' => $last_insert_id
									];
									$builder->where('id', $request->uri->getSegment(3));
									$builder->update($data_infor);
								
									$data['byCEOSigned'] = false;
									$data_footer = [
										'tipoDoc' => " Proposta de resolució de revocació per no justificar",
										'conVIAFIRMA' => false
									];
									echo view('pages/forms/modDocs/IDI-ISBA/pdf/plt-propuesta-resolucion-revocacion-por-no-justificar-adr-isba', $data); 
									echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
									echo view('pages/forms/rest_api_firma/envia-a-firma-informe', $data);
									echo view('pages/forms/go-back-footer', $data_footer);
									break;									
		}
		echo view('templates/footer/footer');
	}

	public function muestrasolicitudfirmada()
	{
		//$uri = new \CodeIgniter\HTTP\URI();
		$request = \Config\Services::request();
		$data = [
			'PublicAccessId' => $request->uri->getSegment(3),
		];
		echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
		echo view('pages/forms/rest_api_firma/ver-solicitud-firmada', $data);
	}

	public function muestrasolicitud()
	{
		//$uri = new \CodeIgniter\HTTP\URI();
		$request = \Config\Services::request();
		$data = [
			'PublicAccessId' => $request->uri->getSegment(3),
		];
		echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data);
		echo view('pages/forms/rest_api_firma/ver-solicitud', $data);
	}

	public function muestrasolicitudrechazada()
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

	public function justificacion()
	{
		$data = [];
		echo view('templates/header/header', $data);
		echo view('pages/exped/justificador', $data);
		echo view('templates/footer/footer');
	}

	public function generaExcel()
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

	public function do_datos_empresa_ils_upload($id, $nif, $idioma, $convocatoria)
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
		foreach ($documentosfile['file_logotipoEmpresaIls'] as $lotogtipo) {
			if ($lotogtipo->isValid() && !$lotogtipo->hasMoved()) {
				$newName = $lotogtipo->getRandomName();
				$lotogtipo->move(WRITEPATH . 'documentos/' . $nif . '/' . $selloTiempo . '/', $newName);
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
					sitio_web_empresa = '" . $this->request->getVar('sitio_web_empresa') . "',
					video_empresa = '" . $this->request->getVar('video_empresa') . "',
					canales_comercializacion_empresa = '" . $this->request->getVar('canales_comercializacion_empresa') . "',
					fecha_creacion_empresa = '" . $this->request->getVar('fecha_creacion_empresa') . "'

			WHERE id =" . $id;
		$db->simpleQuery($sql);
		/*-------------------------------------------------------------------------------------------------*/

		$data['titulo'] = "Expedient: " . $id . " / " . $tipo_tramite[1];
		$query = $db->query("SELECT * FROM pindust_expediente WHERE id =" . $id);
		$expediente = $query->getResult();
		foreach ($expediente as $exped_item) :
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

	public function do_doc_informe_resumen_upload($id, $nif, $idioma, $convocatoria)
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
		foreach ($documentosfile['file_informeResumenIls'] as $lotogtipo) {
			if ($lotogtipo->isValid() && !$lotogtipo->hasMoved()) {
				$newName = $lotogtipo->getRandomName();
				$lotogtipo->move(WRITEPATH . 'documentos/' . $nif . '/' . $selloTiempo . '/', $newName);
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

		$data['titulo'] = "Expedient: " . $id . " / " . $tipo_tramite[1];
		$query = $db->query("SELECT * FROM pindust_expediente WHERE id =" . $id);
		$expediente = $query->getResult();
		foreach ($expediente as $exped_item) :
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

	public function do_doc_compromiso_reduccion_upload($id, $nif, $idioma, $convocatoria)
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
		foreach ($documentosfile['file_modeloEjemploIls'] as $lotogtipo) {
			if ($lotogtipo->isValid() && !$lotogtipo->hasMoved()) {
				$newName = $lotogtipo->getRandomName();
				$lotogtipo->move(WRITEPATH . 'documentos/' . $nif . '/' . $selloTiempo . '/', $newName);
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

		$data['titulo'] = "Expedient: " . $id . " / " . $tipo_tramite[1];
		$query = $db->query("SELECT * FROM pindust_expediente WHERE id =" . $id);
		$expediente = $query->getResult();
		foreach ($expediente as $exped_item) :
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

	public function do_doc_itinerario_formativo_upload($id, $nif, $idioma, $convocatoria)
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
		foreach ($documentosfile['file_certificado_itinerario_formativo'] as $lotogtipo) {
			if ($lotogtipo->isValid() && !$lotogtipo->hasMoved()) {
				$newName = $lotogtipo->getRandomName();
				$lotogtipo->move(WRITEPATH . 'documentos/' . $nif . '/' . $selloTiempo . '/', $newName);
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

		$data['titulo'] = "Expedient: " . $id . " / " . $tipo_tramite[1];
		$query = $db->query("SELECT * FROM pindust_expediente WHERE id =" . $id);
		$expediente = $query->getResult();
		foreach ($expediente as $exped_item) :
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

	public function do_doc_informe_gei_upload($id, $nif, $idioma, $convocatoria)
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
		foreach ($documentosfile['file_informeInventarioIls'] as $lotogtipo) {
			if ($lotogtipo->isValid() && !$lotogtipo->hasMoved()) {
				$newName = $lotogtipo->getRandomName();
				$lotogtipo->move(WRITEPATH . 'documentos/' . $nif . '/' . $selloTiempo . '/', $newName);
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

		$data['titulo'] = "Expedient: " . $id . " / " . $tipo_tramite[1];
		$query = $db->query("SELECT * FROM pindust_expediente WHERE id =" . $id);
		$expediente = $query->getResult();
		foreach ($expediente as $exped_item) :
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

	public function do_doc_escritura_empresa_upload($id, $nif, $idioma, $convocatoria)
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
		foreach ($documentosfile['file_escritura_empresa'] as $lotogtipo) {
			if ($lotogtipo->isValid() && !$lotogtipo->hasMoved()) {
				$newName = $lotogtipo->getRandomName();
				$lotogtipo->move(WRITEPATH . 'documentos/' . $nif . '/' . $selloTiempo . '/', $newName);
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

		$data['titulo'] = "Expedient: " . $id . " / " . $tipo_tramite[1];
		$query = $db->query("SELECT * FROM pindust_expediente WHERE id =" . $id);
		$expediente = $query->getResult();
		foreach ($expediente as $exped_item) :
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

	public function do_doc_certificado_iae_upload($id, $nif, $idioma, $convocatoria)
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
		foreach ($documentosfile['file_certificadoIAE'] as $lotogtipo) {
			if ($lotogtipo->isValid() && !$lotogtipo->hasMoved()) {
				$newName = $lotogtipo->getRandomName();
				$lotogtipo->move(WRITEPATH . 'documentos/' . $nif . '/' . $selloTiempo . '/', $newName);
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

		$data['titulo'] = "Expedient: " . $id . " / " . $tipo_tramite[1];
		$query = $db->query("SELECT * FROM pindust_expediente WHERE id =" . $id);
		$expediente = $query->getResult();
		foreach ($expediente as $exped_item) :
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
