<?php namespace App\Controllers;
	
use App\Models\ConfiguracionModel;

class SubirArchivo extends BaseController
{
	public function store()
   {
		helper('filesystem');
		helper(['form', 'url']);
		helper('cookie');
		$idioma = get_cookie('CurrentLanguage');
		$language = \Config\Services::language();
		$language->setLocale($idioma);

		$modelConfig = new ConfiguracionModel();
		$data['configuracion'] = $modelConfig->where('convocatoria_activa', 1)->first();
		$convocatoria =  $data['configuracion']['convocatoria'];
		$idExp = 1; // El contador de expedientes es por convocatoria. Lo inicio a 1 por si, en esta convocatoria, no hay ningún expediente
		$request = \Config\Services::request();
		$viaSolicitud =  $request->uri->getSegment(3);
	
		$db = \Config\Database::connect();
	  $documentos = $db->table('pindust_documentos');
		$expediente = $db->table('pindust_expediente');
		$sql= "SELECT idExp FROM pindust_expediente WHERE convocatoria = '".$convocatoria."' ORDER BY idExp DESC Limit 1";
		$query = $db->query($sql);

		foreach ($query->getResult() as $row)
			{
    	$idExp = $row->idExp;
			$idExp++;
			}

		$tipoTramite = $this->request->getVar('opc_programa');
		$tipoSolicitante = $this->request->getVar('tipo_solicitante');

		date_default_timezone_set("Europe/Madrid");
		$selloTiempo = date("d_m_Y_h_i_sa");
		/* -----------------------------DOCUMENTACIÓN LINEA CHEQUES----------------------------------------------- */

		$documentosfile = $this->request->getFiles();
		
		if ( !$documentosfile['file_memoriaTecnica'][0]->getName() ){
			$file_memoriaTecnica = "NO";
	 	} else {
			$file_memoriaTecnica = "SI";
	 	}

		if ( !$documentosfile['file_certificadoIAE'][0]->getName() ){
			$file_certificadoIAE = "NO";
	 	} else {
			$file_certificadoIAE = "SI";
	 	}

		if ( !$documentosfile['file_certificadoAEAT'][0]->getName() ){
			$file_certificadoAEAT = "NO";
	 	} else {
			$file_certificadoAEAT = "SI";
	 	}		

		if ($tipoSolicitante === 'autonomo'){
			if ( !$documentosfile['file_altaAutonomos'][0]->getName() ){
				$file_altaAutonomos = "NO";
	 		} else {
				$file_altaAutonomos = "SI";
	 		}
		}

		if ($tipoSolicitante != 'autonomo'){		
			if ( !$documentosfile['file_nifEmpresa'][0]->getName() ){
				$file_nifEmpresa = "NO";
	 		} else {
				$file_nifEmpresa = "SI";
	 		}
		}

		if ($this->request->getPost('memoriaTecnicaEnIDI') === 'on') {
				$memoriaTecnicaEnIDI = 'SI';
		} else {
				$memoriaTecnicaEnIDI = 'NO';
		}
		if ($this->request->getPost('certificadoIAEEnIDI') === 'on'){
			$certificadoIAEEnIDI = 'SI';
		} else {
			$certificadoIAEEnIDI = 'NO';
		}
		if ($tipoSolicitante != 'autonomo'){
			if ($request->getVar('copiaNIFSociedadEnIDI') === 'on'){
				$copiaNIFSociedadEnIDI = 'SI';
			} else {
				$copiaNIFSociedadEnIDI = 'NO';
			}
			if ($this->request->getPost('pJuridicaDocAcreditativaEnIDI') == 'on'){
				$pJuridicaDocAcreditativaEnIDI = 'SI';
			} else {
				$pJuridicaDocAcreditativaEnIDI = 'NO';
			}
		}
		
		if ($tipoSolicitante != 'autonomo'){		
			if ( !$documentosfile['file_document_acred_como_repres'][0]->getName() ){
				$file_document_acred_como_repres = "NO ";
			} else {
				$file_document_acred_como_repres = "SI ";
			}
		}

		$cumpleRequisitos_dec_resp = "";	
		//7. AUTORIZACIONES: si/no da el consentimiento para comprobar la identificación de la persona solicitante
		if ($this->request->getPost('consentimiento_identificacion') === 'on'){
			$file_enviardocumentoIdentificacion = "SI ";
		} else {
			$file_enviardocumentoIdentificacion = "NO ";
		}
		//7. AUTORIZACIONES: si/no da el consentimiento cumplimiento obligaciones tributarias
		if ($this->request->getPost('consentimiento_certificadoATIB') === 'on'){
			$file_certificadoATIB = "SI ";
		} else {
			$file_certificadoATIB = "NO ";
		}

		$declaracion_responsable_i = "SI ";

		if ($this->request->getVar('declaracion_responsable_ii') == 'on'){
			$veracidad_datos_bancarios_1 = "SI ";
		} else {
			$veracidad_datos_bancarios_1 = "NO ";
		}

		if (strlen($this->request->getVar('cc')) != 0){
			$datos_bancarios = $this->request->getVar('cc');
		} else {
			$datos_bancarios = $this->request->getVar('cc2');
		}

		$declaracion_responsable_iii = "SI ";

		$declaracion_responsable_iv = "SI ";

		$declaracion_responsable_v = "SI ";

		$declaracion_responsable_vi = "SI ";

		$declaracion_responsable_vii = "SI ";

		$declaracion_responsable_viii = "SI ";

		$declaracion_responsable_ix = "SI ";

		$declaracion_responsable_x = "SI ";

		$declaracion_responsable_xi = "SI ";

		$declaracion_responsable_xii = "SI ";

		if ($this->request->getVar('declaracion_responsable_xiii') == 'on'){
			$declaracion_responsable_xiii = "SI ";
		} else {
			$declaracion_responsable_xiii = "NO ";
		}

		if ($this->request->getVar('declaracion_responsable_xiv') == 'on'){
			$declaracion_responsable_xiv = "SI ";
		} else {
			$declaracion_responsable_xiv = "NO ";
		}

		if ($this->request->getVar('declaracion_responsable_xv') == 'on'){
			$declaracion_responsable_xv = "SI ";
		} else {
			$declaracion_responsable_xv = "NO ";
		}

		if ($this->request->getVar('declaracion_responsable_xvi') == 'on'){
			$declaracion_responsable_xvi = "SI ";
		} else {
			$declaracion_responsable_xvi = "NO ";
		}
		$veracidad_datos_bancarios_2 = "SI ";

		$veracidad_datos_bancarios_3 = "SI ";

		$empresa = $this->request->getVar('denom_interesado');
		$nif = $this->request->getVar('nif');
		$domicilio = $this->request->getVar('domicilio');
		$hay_rep = $this->request->getVar('representanteLegal');

		/* se usarán estos dos campos para notificar */
		$mail_representante = $this->request->getVar('mail_representante');
		$tel_representante = $this->request->getVar('tel_representante');

		if ($hay_rep == 'on') {
			$hay_rep = "SI";
		}
		else
		{
			$hay_rep = "NO";
		}
		$hay_consultor = "si"; 
		
		$importeAyuda = explode(',', $data['configuracion']['programa']);
		//------------------------------- Busco el importe de la ayuda correspondiente al programa y la convocatoria -------------------//
		$programaImporteAyuda = 0;
		foreach($importeAyuda as $x => $x_value) {  
			if ( str_replace("'","",explode("=>",$x_value)[0]) === $tipoTramite){
				$programaImporteAyuda = str_replace("'","",explode("=>",$x_value)[1]);
				break;
			}
		}

		$importeAyuda = $programaImporteAyuda;			
		//-----------------------------------------------------------------------------------------------------------------------------//
		
		$data_exp = [
				'idExp' => $idExp,
				'tipo_tramite' => $tipoTramite,
				'tipo_solicitante' => $tipoSolicitante,
				'fecha_completado' => date("Y-m-d H:i:s"),
				'empresa' => $empresa,
				'nif' => strtoupper($nif),
				'domicilio' => $domicilio,
				'localidad' => $this->request->getVar('localidad'),
				'cpostal' => $this->request->getVar('cpostal'),
				'telefono' => $this->request->getVar('telefono_cont'),
				'iae' => $this->request->getVar('codigoIAE'),
				'nombre_rep' => $this->request->getVar('nom_representante'),
				'nif_rep' => $this->request->getVar('nif_representante'),
				'telefono_rep' => $tel_representante,
				'email_rep' => $mail_representante,

				'hay_rep' => $hay_rep,
				'email' => $this->request->getVar('adreca_mail'),

				'condicion_rep' => $this->request->getVar('cond_rep_legal'),
				'hay_consultor' => $hay_consultor,
				'empresa_consultor' =>  $this->request->getVar('empresa_consultor'),
				'nom_consultor' => $this->request->getVar('nom_consultor'),
				'tel_consultor' => $this->request->getVar('tel_consultor'),
				'mail_consultor'=> $this->request->getVar('mail_consultor'),

				'memoriaTecnicaEnIDI' => $memoriaTecnicaEnIDI,
				'certificadoIAEEnIDI' => $certificadoIAEEnIDI,
				'copiaNIFSociedadEnIDI' => $copiaNIFSociedadEnIDI,
				'pJuridicaDocAcreditativaEnIDI' => $pJuridicaDocAcreditativaEnIDI,

				'file_memoriaTecnica' => $file_memoriaTecnica,
				'file_altaAutonomos' => $file_altaAutonomos,
				'file_nifEmpresa' => $file_nifEmpresa,
				'file_certificadoIAE' => $file_certificadoIAE,
				'file_document_acred_como_repres' => $file_document_acred_como_repres,
				'file_enviardocumentoIdentificacion' => $file_enviardocumentoIdentificacion ,
				'file_certificadoATIB' => $file_certificadoATIB,
				'file_certificadoAEAT' => $file_certificadoAEAT,

				'cumpleRequisitos_participacion_dec_resp' => $cumpleRequisitos_dec_resp,
				'ayudasSubvenSICuales_dec_resp' => $this->request->getVar('ayudasSubvenSICuales_dec_resp'),
				'cumpleNormativaMinimos_dec_resp_1' => $declaracion_responsable_i,
				'importe_minimis' => $this->request->getVar('importe_minimis'), 
				'veracidad_datos_bancarios_1'  => $veracidad_datos_bancarios_1,
				'nom_entidad' => $this->request->getVar('nom_entidad'), 
				'domicilio_sucursal' => $this->request->getVar('domicilio_sucursal'), 
				'codigo_BIC_SWIFT' => $this->request->getVar('codigo_BIC_SWIFT'), 
				'veracidad_datos_bancarios_2'  => $veracidad_datos_bancarios_2,
				'veracidad_datos_bancarios_3'  => $veracidad_datos_bancarios_3,			
				'cc_datos_bancarios'           => $datos_bancarios,
				'opcion_banco'                 => $this->request->getVar('opcion_banco'),
				'ayudasSubven_dec_resp'  			 => $declaracion_responsable_iii,
				'noHaRecibidoAyudas_otra_admin'  	=> $declaracion_responsable_iv,
				'cumpleRequisitos_dec_resp' 			=> $declaracion_responsable_v,
				'noArticulo_10_dec_resp' 					=> $declaracion_responsable_vi,
				'epigrafeIAE_dec_resp' 						=> $declaracion_responsable_vii,
				'registroIndustrialMinero_dec_resp' => $declaracion_responsable_viii,
				'cumpleNormativaSegInd_dec_resp' => $declaracion_responsable_ix,
				'aceptaCondicionesConv_dec_resp' => $declaracion_responsable_x,
				'declaracion_responsable_consultor' => $declaracion_responsable_xi,
				'declaracion_responsable_xii' => $declaracion_responsable_xii,
				'declaracion_responsable_xiii' => $declaracion_responsable_xiii,
				'declaracion_responsable_xiv' => $declaracion_responsable_xiv,
				'declaracion_responsable_xv' => $declaracion_responsable_xv,
				'declaracion_responsable_xvi' => $declaracion_responsable_xvi,
				'file_enviardocumentoIdentificacion'   => $file_enviardocumentoIdentificacion,
			
				'selloDeTiempo' => $selloTiempo,
				'importeAyuda'	=> $importeAyuda,
				'convocatoria' => $convocatoria
				];

		$save_exp = $expediente->insert($data_exp);
		$last_insert_id = $save_exp->connID->insert_id;
		$data_exp ['selloDeTiempo'] = $selloTiempo;
		$data_exp ['last_insert_id'] = $last_insert_id;

		/* Si no existe la carpeta donde se guardará todo, se crea */
		if (!file_exists( WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo."/") ) {
			mkdir(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo, 0755, true);
		}

		/* ------------------------------------------------------------------------------------------------------------ */	
		/* --------------------------------memoria técnica, múltiples documentos------------------OK------------------- */
		if (isset($documentosfile['file_memoriaTecnica'])) {
			foreach($documentosfile['file_memoriaTecnica'] as $memoriaTecnica)
				{
				if ($memoriaTecnica->isValid() && ! $memoriaTecnica->hasMoved())
				{
				$memoriaTecnica->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $memoriaTecnica->getRandomName());
				$data_file = [
				'name' => $memoriaTecnica->getName(),					
				'type' => $memoriaTecnica->getClientMimeType(),
				'cifnif_propietario' => $nif,
				'tipo_tramite' =>$tipoTramite,
				'corresponde_documento' => 'file_memoriaTecnica',
				'datetime_uploaded' => time(),
				'convocatoria' => $convocatoria,
				'docRequerido' => 'NO',
				'created_at'  => $memoriaTecnica->getTempName(),
				'selloDeTiempo'  => $selloTiempo,
				'id_sol'         => $last_insert_id
				];
				$save = $documentos->insert($data_file);
				}
				}
		}
		/* --------------------------------------------------------------------------------------------------------------- */
		/* --------------------------------sube certificado IAE, múltiples documentos--------------OK--------------------- */
		if (isset($documentosfile['file_certificadoIAE'])) {
			foreach($documentosfile['file_certificadoIAE'] as $certificadoIAE)
				{
				if ($certificadoIAE->isValid() && ! $certificadoIAE->hasMoved())
				{
				$certificadoIAE->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $certificadoIAE->getRandomName());
				$data_file = [
					'name' => $certificadoIAE->getName(),					
					'type' => $certificadoIAE->getClientMimeType(),
					'cifnif_propietario' => $nif,
					'tipo_tramite' =>$tipoTramite,
					'corresponde_documento' => 'file_certificadoIAE',
					'datetime_uploaded' => time(),
					'convocatoria' => $convocatoria,
					'created_at'  => $certificadoIAE->getTempName(),
					'selloDeTiempo'  => $selloTiempo,
					'id_sol'         => $last_insert_id
				];
				$save = $documentos->insert($data_file);
				}
				}
		}
		/* ---------------------------------------------------------------------------------------------------------------- */
		/* --------------------------------alta autónomos, múltiples documentos--------------------OK----------------------- */
		if (isset($documentosfile['file_altaAutonomos'])) {
			foreach($documentosfile['file_altaAutonomos'] as $altaAutonomos)
				{	
				if ($altaAutonomos->isValid() && ! $altaAutonomos->hasMoved())
				{
				$altaAutonomos->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $altaAutonomos->getRandomName());
				$data_file = [
					'name' => $altaAutonomos->getName(),					
					'type' => $altaAutonomos->getClientMimeType(),
					'cifnif_propietario' => $nif,
					'tipo_tramite' =>$tipoTramite,
					'corresponde_documento' => 'file_altaAutonomos',
					'datetime_uploaded' => time(),
					'convocatoria' => $convocatoria,
					'created_at'  => $altaAutonomos->getTempName(),
					'selloDeTiempo'  => $selloTiempo,
					'id_sol'         => $last_insert_id
				];
				$save = $documentos->insert($data_file);
				}
				}
		}
		/* ----------------------------------------------------------------------------------------------------------------- */
		/* --------------------------------nif empresa, múltiples documentos-----------------------OK----------------------- */
		if (isset($documentosfile['file_nifEmpresa'])) {
			foreach($documentosfile['file_nifEmpresa'] as $nifEmpresa)
				{
				if ($nifEmpresa->isValid() && ! $nifEmpresa->hasMoved())
				{
				$nifEmpresa->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $nifEmpresa->getRandomName());
				$data_file = [
				'name' => $nifEmpresa->getName(),
				'type' => $nifEmpresa->getClientMimeType(),
				'cifnif_propietario' => $nif,
				'tipo_tramite' => $tipoTramite,
				'corresponde_documento' => 'file_nifEmpresa',
				'datetime_uploaded' => time(),
				'convocatoria' => $convocatoria,
				'docRequerido' => 'NO',
				'created_at'  => $nifEmpresa->getTempName(),
				'selloDeTiempo'  => $selloTiempo,
				'id_sol'         => $last_insert_id
				];
				$save = $documentos->insert($data_file);
				}
				}
		}
		/* ---------------------------------------------------------------------------------------------------------------- */
		/* --------------------------------documento acreditativo como rep legal, múltiples documentos--------OK------------ */
		if (isset($documentosfile['file_document_acred_como_repres'])) {
			foreach($documentosfile['file_document_acred_como_repres'] as $documentoAcreditativo)
				{
				if ($documentoAcreditativo->isValid() && ! $documentoAcreditativo->hasMoved())
					{
					$documentoAcreditativo->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $documentoAcreditativo->getRandomName());
					$data_file = [
					'name' => $documentoAcreditativo->getName(),					
					'type' => $documentoAcreditativo->getClientMimeType(),
					'cifnif_propietario' => $nif,
					'tipo_tramite' =>$tipoTramite,
					'corresponde_documento' => 'file_document_acred_como_repres',
					'datetime_uploaded' => time(),
					'convocatoria' => $convocatoria,
					'created_at'  => $documentoAcreditativo->getTempName(),
					'selloDeTiempo'  => $selloTiempo,
					'id_sol'         => $last_insert_id
					];
				$save = $documentos->insert($data_file);
				}
				}
		}
		/* ------------------------------------------------------------------------------------------------------------------ */
		/* ---------- corriente pago obligaciones AEAT, múltiples documentos--------OK---------- */
		if (isset($documentosfile['file_certificadoAEAT'])) {
			foreach($documentosfile['file_certificadoAEAT'] as $certificadoAEAT)
				{
					if ($certificadoAEAT->isValid() && ! $certificadoAEAT->hasMoved())
						{
						$certificadoAEAT->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $certificadoAEAT->getRandomName());
						$data_file = [
							'name' => $certificadoAEAT->getName(),
							'type' => $certificadoAEAT->getClientMimeType(),
							'cifnif_propietario' => $nif,
							'tipo_tramite' => $tipoTramite,
							'corresponde_documento' => 'file_certificadoAEAT',
							'datetime_uploaded' => time(),
							'convocatoria' => $convocatoria,
							'docRequerido' => 'SI',
							'created_at'  => $certificadoAEAT->getTempName(),
							'selloDeTiempo'  => $selloTiempo,
							'id_sol'         => $last_insert_id
							];
							$save = $documentos->insert($data_file);
						}
				}
		}	
		/* ------------------------------------------------------------------------------------------------------------------- */
		/* -------------------- documento identificativo al NO autorización a IDI comprobar dni, múltiples documentos---OK--- */
		if (isset($documentosfile['file_enviardocumentoIdentificacion'])) {
			foreach($documentosfile['file_enviardocumentoIdentificacion'] as $enviardocumentoIdentificacion)
				{
				if ($enviardocumentoIdentificacion->isValid() && ! $enviardocumentoIdentificacion->hasMoved())
					{
					$enviardocumentoIdentificacion->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $enviardocumentoIdentificacion->getRandomName());
					$data_file = [
					'name' => $enviardocumentoIdentificacion->getName(),
					'type' => $enviardocumentoIdentificacion->getClientMimeType(),
					'cifnif_propietario' => $nif,
					'tipo_tramite' => $tipoTramite,
					'corresponde_documento' => 'file_enviardocumentoIdentificacion',
					'datetime_uploaded' => time(),
					'convocatoria' => $convocatoria,
					'docRequerido' => 'NO',
					'created_at'  => $enviardocumentoIdentificacion->getTempName(),
					'selloDeTiempo'  => $selloTiempo,
					'id_sol'         => $last_insert_id
					];
					$save = $documentos->insert($data_file);
					}
				}
		}
		/* ------------------------------------------------------------------------------------------------------------------- */
		/* ---------- corriente pago obligaciones ATIB NO autoriza a IDI comprobarlo, múltiples documentos--------OK---------- */
		if (isset($documentosfile['file_certificadoATIB'])) {
			foreach($documentosfile['file_certificadoATIB'] as $certificadoATIB)
				{
				if ($certificadoATIB->isValid() && ! $certificadoATIB->hasMoved())
					{
						$certificadoATIB->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $certificadoATIB->getRandomName());
						$data_file = [
						'name' => $certificadoATIB->getName(),
						'type' => $certificadoATIB->getClientMimeType(),
						'cifnif_propietario' => $nif,
						'tipo_tramite' => $tipoTramite,
						'corresponde_documento' => 'file_certificadoATIB',
						'datetime_uploaded' => time(),
						'convocatoria' => $convocatoria,
						'docRequerido' => 'NO',
						'created_at'  => $certificadoATIB->getTempName(),
						'selloDeTiempo'  => $selloTiempo,
						'id_sol'         => $last_insert_id
						];
						$save = $documentos->insert($data_file);
					}
				}
			}	
		/* ------------------------------------------------------------------------------------------------------------------- */

		$data_file['titulo'] = "Resumen de la solicitud de Cheques de consultoría";
		echo view('templates/header/header_form_solicitud_resultado', $data_file);
		echo view('pages/forms/dec-resp-solicitud-ayuda', $data_exp);
		if (strpos($viaSolicitud,"manual") !== false ) {
			//echo "0";
		} else {
			//echo "1";
			echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data_exp);
			echo view('pages/forms/rest_api_firma/envia-a-firma-solicitud', $data_exp);
		}
		echo view('templates/footer/footer_form');
   }

	public function store_ils()
	 {
		helper('filesystem');
		helper(['form', 'url']);
		helper('cookie');
		$request = \Config\Services::request();
		$idioma =  $request->uri->getSegment(3);
	
		$language = \Config\Services::language();
		$language->setLocale($idioma);
 
		$modelConfig = new ConfiguracionModel();
		$data['configuracion'] = $modelConfig->where('convocatoria_activa', 1)->first(); 
		$convocatoria =   $data['configuracion']['convocatoria'];
		$tipo_tramite =  'ILS';
		$idExp = 1; // El contador de expedientes es por convocatoria. Lo inicio a 1 por si, en esta convocatoria, no hay ningún expediente
	 
		$db = \Config\Database::connect();
		$documentos = $db->table('pindust_documentos');
		$expediente = $db->table('pindust_expediente');
		$sql= "SELECT idExp FROM pindust_expediente WHERE tipo_tramite = '".$tipo_tramite."' ORDER BY idExp DESC Limit 1";

		$query = $db->query($sql);
	 	foreach ($query->getResult() as $row)
	 		{
		 	$idExp = $row->idExp;
		 	$idExp++;
			}

	 	$tipoTramite = "ILS"; // $this->request->getVar('opc_programa');
	 	$tipoSolicitante = $this->request->getVar('tipo_solicitante');
 
	 	date_default_timezone_set("Europe/Madrid");
	 	$selloTiempo = date("d_m_Y_h_i_sa");

		/* -------------------------------AUTORIZACIONES-------------------------------------------- */
		//5. AUTORIZACIONES: si/no da el consentimiento para comprobar la identificación de la persona solicitante
		if ($this->request->getVar('consentimiento_identificacion') == 'on'){
			$file_enviardocumentoIdentificacion = "SI ";
		} else {
			$file_enviardocumentoIdentificacion = "NO ";
		}
		//5. AUTORIZACIONES: si/no da el consentimiento cumplimiento obligaciones tributarias
		if ($this->request->getVar('consentimiento_certificadoATIB') == 'on'){
			$file_certificadoATIB = "SI ";
		} else {
			$file_certificadoATIB = "NO ";
		}
	
		/* ---------------------------DECLARACIÓN RESPONSABLE---------------------------------------- */
	
		$declaracion_responsable_v = "SI ";

		$declaracion_responsable_vii = "SI ";

		$declaracion_responsable_viii = "SI ";

		$declaracion_responsable_ix = "SI ";

		$declaracion_responsable_xi = "SI ";

 		/* -------------------------------DOCUMENTACIÓN ILS--------------------------------------------- */
 		$documentosfile = $this->request->getFiles();
		if ( !$documentosfile['file_memoriaTecnica'][0]->getName() ){
			$file_memoriaTecnica = "NO ";
	 	} else {
		 	$file_memoriaTecnica = "SI ";
	 	}
	 
		if ( !$documentosfile['file_escritura_empresa'][0]->getName() ){
			$file_escritura_empresa = "NO ";
	 	} else {
			$file_escritura_empresa = "SI ";
	 	}
 
		if ( !$documentosfile['file_certificadoIAE'][0]->getName() ){
			$file_certificadoIAE = "NO ";
	 	} else {
			$file_certificadoIAE = "SI ";
	 	}
	 
		if ( !$documentosfile['file_nifEmpresa'][0]->getName() ){
			$file_nifEmpresa = "NO ";
		} else {
			$file_nifEmpresa = "SI ";
		}

		if ( !$documentosfile['file_logotipoEmpresaIls'][0]->getName() ){
			$file_logotipoEmpresaIls = "NO ";
	 	} else {
			$file_logotipoEmpresaIls = "SI ";
	 	}

		if ( !$documentosfile['file_informeResumenIls'][0]->getName() ){
			$file_informeResumenIls = "NO ";
		} else {
			$file_informeResumenIls = "SI ";
		}
	
		if ( !$documentosfile['file_informeInventarioIls'][0]->getName() ){
			$file_informeInventarioIls = "NO ";
		} else {
			$file_informeInventarioIls = "SI ";
		}
	
		if ( !$documentosfile['file_modeloEjemploIls'][0]->getName() ){
			$file_modeloEjemploIls = "NO ";
		} else {
			$file_modeloEjemploIls = "SI ";
		}

		if ( !$documentosfile['file_certificado_verificacion_ISO'][0]->getName() ){
			$file_certificado_verificacion_ISO = "NO ";
		} else {
			$file_certificado_verificacion_ISO = "SI ";
		}

		if ( !$documentosfile['file_certificado_itinerario_formativo'][0]->getName() ){
			$file_certificado_itinerario_formativo = "NO ";
		} else {
			$file_certificado_itinerario_formativo = "SI ";
		}
 
		$empresa = $this->request->getVar('denom_interesado');
		$nif = $this->request->getVar('nif');
		$domicilio = $this->request->getVar('domicilio');
		$localidad = $this->request->getVar('localidad');
		$cpostal = $this->request->getVar('cpostal');
		$hay_rep = $this->request->getVar('representanteLegal');
 
		/**** se usarán estos dos campos para notificar al consultor *****/
		$tel_representante = $this->request->getVar('tel_representante');
		$mail_representante = $this->request->getVar('mail_representante');
		/*****************************************************************/

	 	if ($hay_rep == 'on') {
			$hay_rep = "SI";
	 		}
	 	else
	 		{
		 	$hay_rep = "NO";
	 		}
		$hay_consultor = "NO"; 
	 
		$importeAyuda = 0;

		$data_exp = [
			'idExp' => $idExp,
			'tipo_solicitante' => $tipoSolicitante,
			'fecha_completado' => date("Y-m-d H:i:s"),
			'empresa' => $empresa,
			'nif' => strtoupper($nif),
			'domicilio' => $domicilio,
			'localidad' => $localidad,
			'cpostal' => $cpostal,
			'telefono' => $this->request->getVar('telefono_cont'),
			'telefono_rep' => $tel_representante,  // se usa para notificar
			'email_rep' => $mail_representante,	// se usa para notificar
			'tipo_tramite' => $tipoTramite,
			'iae' => $this->request->getVar('codigoIAE'),
			'hay_consultor' => $hay_consultor,
			
			'canales_comercializacion_empresa' => $this->request->getVar('canales_comercializacion_empresa'),
			'sitio_web_empresa' => $this->request->getVar('sitio_web_empresa'),
			'video_empresa' => $this->request->getVar('video_empresa'),
			'fecha_creacion_empresa'  => $this->request->getVar('fecha_creacion_empresa'),
			'nombre_rep' => $this->request->getVar('nom_representante'),
			'nif_rep' => $this->request->getVar('nif_representante'),

			'hay_rep' => $hay_rep,

			'cumpleRequisitos_dec_resp' => $declaracion_responsable_v,
			'epigrafeIAE_dec_resp' => $declaracion_responsable_vii,
			'registroIndustrialMinero_dec_resp' => $declaracion_responsable_viii,
			'cumpleNormativaSegInd_dec_resp' => $declaracion_responsable_ix,
			'declaracion_responsable_consultor' => $declaracion_responsable_xi,

			'file_enviardocumentoIdentificacion'   => $file_enviardocumentoIdentificacion,
			'file_certificadoATIB' => $file_certificadoATIB,

			'file_escritura_empresa' => $file_escritura_empresa,
			'file_certificadoIAE' => $file_certificadoIAE,
			'file_informeResumenIls' =>  $file_informeResumenIls,
			'file_informeInventarioIls' =>  $file_informeInventarioIls,
			'file_modeloEjemploIls' =>  $file_modeloEjemploIls, 
			'file_certificado_verificacion_ISO' => $file_certificado_verificacion_ISO,
			'file_certificado_itinerario_formativo' => $file_certificado_itinerario_formativo,
			
			'file_memoriaTecnica' => $file_memoriaTecnica,
			'file_nifEmpresa' => $file_nifEmpresa,
			'file_logotipoEmpresaIls' => $file_logotipoEmpresaIls,

			'selloDeTiempo' => $selloTiempo,
			'importeAyuda'	=> 0,
			'convocatoria' => $convocatoria
			];
			 

	 	$save_exp = $expediente->insert($data_exp);
	 	$last_insert_id = $save_exp->connID->insert_id;
	 	$data_exp ['selloDeTiempo'] = $selloTiempo;
	 	$data_exp ['last_insert_id'] = $last_insert_id;
 
		/* ---------------------------------------------------------------------------------------------OK-------- */
		/* -------------------- copia nif al NO autorización a IDI comprobar dni, múltiples documentos------------ */

		if (isset($documentosfile['file_enviardocumentoIdentificacion'])) {
		foreach($documentosfile['file_enviardocumentoIdentificacion'] as $copiaDocumentoIdentificacion)
			{
				if ($copiaDocumentoIdentificacion->isValid() && ! $copiaDocumentoIdentificacion->hasMoved())
					{
						$copiaDocumentoIdentificacion->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $copiaDocumentoIdentificacion->getRandomName());
						$data_file = [
						'name' => $copiaDocumentoIdentificacion->getName(),
						'type' => $copiaDocumentoIdentificacion->getClientMimeType(),
						'cifnif_propietario' => $nif,
						'tipo_tramite' => $tipoTramite,
						'corresponde_documento' => 'file_enviardocumentoIdentificacion',
						'datetime_uploaded' => time(),
						'convocatoria' => $convocatoria,
						'docRequerido' => 'NO',
						'created_at'  => $copiaDocumentoIdentificacion->getTempName(),
						'selloDeTiempo'  => $selloTiempo,
						'id_sol'         => $last_insert_id
						];
						$save = $documentos->insert($data_file);
					}
			}
		}
		/* ----------------------------------------------------------------------------------------------------- */
		/* ---------- corriente pago obligaciones ATIB NO autoriza a IDI comprobarlo, múltiples documentos------ */
		if (isset($documentosfile['file_certificadoATIB'])) {
			foreach($documentosfile['file_certificadoATIB'] as $corrientePagoATIB)
				{
				if ($corrientePagoATIB->isValid() && ! $corrientePagoATIB->hasMoved())
					{
						$corrientePagoATIB->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $corrientePagoATIB->getRandomName());
						$data_file = [
						'name' => $corrientePagoATIB->getName(),
						'type' => $corrientePagoATIB->getClientMimeType(),
						'cifnif_propietario' => $nif,
						'tipo_tramite' => $tipoTramite,
						'corresponde_documento' => 'file_certificadoATIB',
						'datetime_uploaded' => time(),
						'convocatoria' => $convocatoria,
						'docRequerido' => 'NO',
						'created_at'  => $corrientePagoATIB->getTempName(),
						'selloDeTiempo'  => $selloTiempo,
						'id_sol'         => $last_insert_id
						];
					$save = $documentos->insert($data_file);
					}
				}
		}

 		/* ------------------------------------------------------------------------------------------------------------ */	
 		/* --------------------------------sede social, múltiples documentos--------------------OK--------------------- */
 		if (isset($documentosfile['file_escritura_empresa' ])) {
		foreach($documentosfile['file_escritura_empresa' ] as $sedeSocial)
			{
			if ($sedeSocial->isValid() && ! $sedeSocial->hasMoved())
				{
					$sedeSocial->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $sedeSocial->getRandomName());
					$data_file = [
					'name' => $sedeSocial->getName(),					
					'type' => $sedeSocial->getClientMimeType(),
					'cifnif_propietario' => $nif,
					'tipo_tramite' =>$tipoTramite,
					'corresponde_documento' => 'file_escritura_empresa',
					'datetime_uploaded' => time(),
					'convocatoria' => $convocatoria,
					'created_at'  => $sedeSocial->getTempName(),
					'selloDeTiempo'  => $selloTiempo,
					'id_sol'         => $last_insert_id
					];
				$save = $documentos->insert($data_file);
				}
			}
		}

 		/* ------------------------------------------------------------------------------------------------------------ */	
 		/* --------------------------------memoria técnica, múltiples documentos------------------OK--------------------- */
 		if (isset($documentosfile['file_memoriaTecnica'])) {
	 	foreach($documentosfile['file_memoriaTecnica'] as $memoriaTecnica)
		 {
		 if ($memoriaTecnica->isValid() && ! $memoriaTecnica->hasMoved())
			 {
				 $memoriaTecnica->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $memoriaTecnica->getRandomName());
				 $data_file = [
				 'name' => $memoriaTecnica->getName(),					
				 'type' => $memoriaTecnica->getClientMimeType(),
				 'cifnif_propietario' => $nif,
				 'tipo_tramite' =>$tipoTramite,
				 'corresponde_documento' => 'file_memoriaTecnica',
				 'datetime_uploaded' => time(),
				 'convocatoria' => $convocatoria,
				 'docRequerido' => 'NO',
				 'created_at'  => $memoriaTecnica->getTempName(),
				 'selloDeTiempo'  => $selloTiempo,
				 'id_sol'         => $last_insert_id
				 ];
			 $save = $documentos->insert($data_file);
			 }
		 }
	 	}
		/* --------------------------------------------------------------------------------------------------------------- */
 		/* --------------------------------sube certificado IAE, múltiples documentos----------------OK--------------------- */
 		if (isset($documentosfile['file_certificadoIAE'])) {
		foreach($documentosfile['file_certificadoIAE'] as $certificadoIAE)
			{
			if ($certificadoIAE->isValid() && ! $certificadoIAE->hasMoved())
				{
					$certificadoIAE->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $certificadoIAE->getRandomName());
					$data_file = [
					'name' => $certificadoIAE->getName(),					
					'type' => $certificadoIAE->getClientMimeType(),
					'cifnif_propietario' => $nif,
					'tipo_tramite' =>$tipoTramite,
					'corresponde_documento' => 'file_certificadoIAE',
					'datetime_uploaded' => time(),
					'convocatoria' => $convocatoria,
					'created_at'  => $certificadoIAE->getTempName(),
					'selloDeTiempo'  => $selloTiempo,
					'id_sol'         => $last_insert_id
					];
				$save = $documentos->insert($data_file);
				}
			}
			}	 
 		/* ----------------------------------------------------------------------------------------------------------- */
 		/* --------------------------------nif empresa, múltiples documentos------------------------------------------ */
 		if (isset($documentosfile['file_nifEmpresa'])) {
	 	foreach($documentosfile['file_nifEmpresa'] as $nifEmpresa)
		 {
			 if ($nifEmpresa->isValid() && ! $nifEmpresa->hasMoved())
			 {
				 $nifEmpresa->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $nifEmpresa->getRandomName());
				 $data_file = [
					 'name' => $nifEmpresa->getName(),
					 'type' => $nifEmpresa->getClientMimeType(),
					 'cifnif_propietario' => $nif,
					 'tipo_tramite' => $tipoTramite,
					 'corresponde_documento' => 'file_nifEmpresa',
					 'datetime_uploaded' => time(),
					 'convocatoria' => $convocatoria,
					 'docRequerido' => 'NO',
					 'created_at'  => $nifEmpresa->getTempName(),
					 'selloDeTiempo'  => $selloTiempo,
					 'id_sol'         => $last_insert_id
				 ];
			 $save = $documentos->insert($data_file);
		 }
		 }
	 	}
 		/* ------------------------------------------------------------------------------------------------------- */
 		/* ---------------- logotipo de la empresa para publicar luego en la web, múltiples documentos------------ */
 		if (isset($documentosfile['file_logotipoEmpresaIls'])) {
	 	foreach($documentosfile['file_logotipoEmpresaIls'] as $logotipoEmpresaIls)
		 {
			 if ($logotipoEmpresaIls->isValid() && ! $logotipoEmpresaIls->hasMoved())
				 {
					 $logotipoEmpresaIls->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $logotipoEmpresaIls->getRandomName());
					 $data_file = [
					 'name' => $logotipoEmpresaIls->getName(),
					 'type' => $logotipoEmpresaIls->getClientMimeType(),
					 'cifnif_propietario' => $nif,
					 'tipo_tramite' => $tipoTramite,
					 'corresponde_documento' => 'file_logotipoEmpresaIls',
					 'datetime_uploaded' => time(),
					 'convocatoria' => $convocatoria,
					 'docRequerido' => 'NO',
					 'created_at'  => $logotipoEmpresaIls->getTempName(),
					 'selloDeTiempo'  => $selloTiempo,
					 'id_sol'         => $last_insert_id
					 ];
				 $save = $documentos->insert($data_file);
				 }
		 }
	 	}
 	
 		/* ----------------------------------------------------------------------------------------------------- */
 		/* ----------------------------- declaración responsable, múltiples documentos ------------------------- */
 		if (isset($documentosfile['file_lineaProduccionBalearesIls'])) {
	 	foreach($documentosfile['file_lineaProduccionBalearesIls'] as $declaracionResponsableIls)
		 {
			 if ($declaracionResponsableIls->isValid() && ! $declaracionResponsableIls->hasMoved())
				 {
					 $declaracionResponsableIls->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $declaracionResponsableIls->getRandomName());
					 $data_file = [
					 'name' => $declaracionResponsableIls->getName(),
					 'type' => $declaracionResponsableIls->getClientMimeType(),
					 'cifnif_propietario' => $nif,
					 'tipo_tramite' => $tipoTramite,
					 'corresponde_documento' => 'file_lineaProduccionBalearesIls',
					 'datetime_uploaded' => time(),
					 'convocatoria' => $convocatoria,
					 'created_at'  => $declaracionResponsableIls->getTempName(),
					 'selloDeTiempo'  => $selloTiempo,
					 'id_sol'         => $last_insert_id
					 ];
				 $save = $documentos->insert($data_file);
				 }
		 }
	 	}
 		/* ----------------------------------------------------------------------------------------------------- */
 		/* ------------------------------------------ informe resumen, múltiples documentos -------------------- */
 		if (isset($documentosfile['file_informeResumenIls'])) {
	 	foreach($documentosfile['file_informeResumenIls'] as $informeResumenIls)
		 {
			 if ($informeResumenIls->isValid() && ! $informeResumenIls->hasMoved())
				 {
					 $informeResumenIls->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $informeResumenIls->getRandomName());
					 $data_file = [
					 'name' => $informeResumenIls->getName(),
					 'type' => $informeResumenIls->getClientMimeType(),
					 'cifnif_propietario' => $nif,
					 'tipo_tramite' => $tipoTramite,
					 'corresponde_documento' => 'file_informeResumenIls',
					 'datetime_uploaded' => time(),
					 'convocatoria' => $convocatoria,
					 'created_at'  => $informeResumenIls->getTempName(),
					 'selloDeTiempo'  => $selloTiempo,
					 'id_sol'         => $last_insert_id
					 ];
				 $save = $documentos->insert($data_file);
				 }
		 }
	 	}
 		/* ----------------------------------------------------------------------------------------------------- */
 		/* ------------------------------------------ informe inventario, múltiples documentos -------------------- */
 		if (isset($documentosfile['file_informeInventarioIls'])) {
		foreach($documentosfile['file_informeInventarioIls'] as $informeInventarioIls)
			{
				if ($informeInventarioIls->isValid() && ! $informeInventarioIls->hasMoved())
					{
						$informeInventarioIls->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $informeInventarioIls->getRandomName());
						$data_file = [
						'name' => $informeInventarioIls->getName(),
						'type' => $informeInventarioIls->getClientMimeType(),
						'cifnif_propietario' => $nif,
						'tipo_tramite' => $tipoTramite,
						'corresponde_documento' => 'file_informeInventarioIls',
						'datetime_uploaded' => time(),
						'convocatoria' => $convocatoria,
						'created_at'  => $informeInventarioIls->getTempName(),
						'selloDeTiempo'  => $selloTiempo,
						'id_sol'         => $last_insert_id
						];
					$save = $documentos->insert($data_file);
					}
			}
		}
 		/* ----------------------------------------------------------------------------------------------------- */
 		/* ------------------------------------------ certificado de verificación ISO 14064-1 -------------------- */
 		if (isset($documentosfile['file_certificado_verificacion_ISO'])) {
		foreach($documentosfile['file_certificado_verificacion_ISO'] as $certificadoVerificacionISO)
			{
				if ($certificadoVerificacionISO->isValid() && ! $certificadoVerificacionISO->hasMoved())
					{
						$certificadoVerificacionISO->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $certificadoVerificacionISO->getRandomName());
						$data_file = [
						'name' => $certificadoVerificacionISO->getName(),
						'type' => $certificadoVerificacionISO->getClientMimeType(),
						'cifnif_propietario' => $nif,
						'tipo_tramite' => $tipoTramite,
						'corresponde_documento' => 'file_certificado_verificacion_ISO',
						'datetime_uploaded' => time(),
						'convocatoria' 		=> $convocatoria,
						'created_at'  		=> $certificadoVerificacionISO->getTempName(),
						'selloDeTiempo'  	=> $selloTiempo,
						'id_sol'         	=> $last_insert_id
						];
					$save = $documentos->insert($data_file);
					}
			}
		}
 		/* ----------------------------------------------------------------------------------------------------- */
 		/* ------------------------------------------ certificado itinerario formativo -------------------- */
 		if (isset($documentosfile['file_certificado_itinerario_formativo'])) {
		foreach($documentosfile['file_certificado_itinerario_formativo'] as $certificadoItinerarioFormativo)
			{
				if ($certificadoItinerarioFormativo->isValid() && ! $certificadoItinerarioFormativo->hasMoved())
					{
						$certificadoItinerarioFormativo->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $certificadoItinerarioFormativo->getRandomName());
						$data_file = [
						'name' => $certificadoItinerarioFormativo->getName(),
						'type' => $certificadoItinerarioFormativo->getClientMimeType(),
						'cifnif_propietario' => $nif,
						'tipo_tramite' => $tipoTramite,
						'corresponde_documento' => 'file_certificado_itinerario_formativo',
						'datetime_uploaded' => time(),
						'convocatoria' => $convocatoria,
						'created_at'  => $certificadoItinerarioFormativo->getTempName(),
						'selloDeTiempo'  => $selloTiempo,
						'id_sol'         => $last_insert_id
						];
					$save = $documentos->insert($data_file);
					}
			}
		}
		/* ----------------------------------------------------------------------------------------------------- */
 		/* ------------------------------------------ modelo ejemplo, múltiples documentos -------------------- */
 		if (isset($documentosfile['file_modeloEjemploIls'])) {
		foreach($documentosfile['file_modeloEjemploIls'] as $modeloEjemploIls)
			{
				if ($modeloEjemploIls->isValid() && ! $modeloEjemploIls->hasMoved())
					{
						$modeloEjemploIls->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $modeloEjemploIls->getRandomName());
						$data_file = [
						'name' => $modeloEjemploIls->getName(),
						'type' => $modeloEjemploIls->getClientMimeType(),
						'cifnif_propietario' => $nif,
						'tipo_tramite' => $tipoTramite,
						'corresponde_documento' => 'file_modeloEjemploIls',
						'datetime_uploaded' => time(),
						'convocatoria' => $convocatoria,
						'created_at'  => $modeloEjemploIls->getTempName(),
						'selloDeTiempo'  => $selloTiempo,
						'id_sol'         => $last_insert_id
						];
					$save = $documentos->insert($data_file);
					}
			}
		}	
 		/* ----------------------------------------------------------------------------------------------------- */	
 
		$data_file['titulo'] = "Resumen de la solicitud solicitud de adhsión a ILS";

	 	echo view('pages/forms/solicitud-concesion-marca-ils', $data_exp);
		echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data_exp);
		echo view('pages/forms/rest_api_firma/envia-a-firma-solicitud-ils', $data_exp);
	 }

	public function envia_dec_resp_con ()
	 {
		helper('filesystem');	
		helper(['form', 'url']); 
		$request = \Config\Services::request();
		$db = \Config\Database::connect();
		$consultor = $db->table('pindust_consultor');
	
		$convocatoria = "2020";
		date_default_timezone_set("Europe/Madrid");
		$selloTiempo = date("d_m_Y_h_i_sa");

		/* ---------------------------------------------------------------------------- */
		if ($this->request->getVar('representanteLegal') == null) {
			$representanteLegal = "NO ";
		} else {
			$representanteLegal = "SI ";
		}
	
		$empresa = $this->request->getVar('denom_interesado');
		$nif = $this->request->getVar('nif');
		$domicilio = $this->request->getVar('domicilio');
		//$telefono_cont = $this->request->getVar('telefono_cont');

		/* --------------------------------------------------------------------------- */
		$mail_representante = $this->request->getVar('mail_representante');
		$tel_representante = $this->request->getVar('tel_representante');
		$data_consultor = [
     'empresa' => $empresa,
    	'nif' => $nif,
			'domicilio' => $domicilio,
			'localidad' => $this->request->getVar('localidad'),
			'cpostal' => $this->request->getVar('cpostal'),
			'telefono' => $this->request->getVar('tel_representante'),			
			'email' => $this->request->getVar('adreca_mail'),			
			'hay_rep' => $representanteLegal,
			'nombre_rep' => $this->request->getVar('nom_representante'),
			'nif_rep' => $this->request->getVar('dni_representante'),
			'domicilio_rep' => $this->request->getVar('dom_representante'),
			'telefono_rep' => $tel_representante,
			'email_rep' => $mail_representante,
			'condicion_rep' => $this->request->getVar('cond_rep_legal'),
			'tipo_tramite' => 'iDigital',
			'expMinDos_dec_resp_cons' => "on",// $this->request->getVar('expMinDos_dec_resp_cons'),
			'expTransDigital_dec_resp_cons' => "on",// $this->request->getVar('expTransDigital_dec_resp_cons'),
			'tieneEstudios_dec_resp_cons' => "on",// $this->request->getVar('tieneEstudios_dec_resp_cons'),
			'selloDeTiempo' => $selloTiempo,
			'id_sol'        => $this->request->getVar('id_sol')
            ];	
		$save_consultor = $consultor->insert($data_consultor);
		$last_insert_id = $save_consultor->connID->insert_id;
		$data_consultor ['selloDeTiempo'] = $selloTiempo;
		$data_consultor ['last_insert_id'] = $last_insert_id;
		$data_consultor ['tipo_Doc'] = "dec_resp_consultor";
		$data_file['titulo'] = "Declaració responsable del consultor";

		/* --------------------------------------------------------------------------- */
		/* --------------------------------------------------------------------------- */
		$map = directory_map(WRITEPATH.'documentos/consultor/');
		if (array_key_exists($nif.'\\', $map))
			{
			// si existe la subcarpeta $nif, comprueba la existencia de la subcarpeta $selloTiempo
			$map = directory_map(WRITEPATH.'documentos/consultor/'.$nif);	
			if (array_key_exists($selloTiempo.'\\',$map))
				{
				// echo "Key exists!";
				}
			else
				{
				mkdir(WRITEPATH.'documentos/consultor/'.$nif.'/'.$selloTiempo);
				// crea la subcarpeta $selloTiempo
				}
			// "Match found";
		}
		else
		{
			mkdir(WRITEPATH.'documentos/consultor/'.$nif);
			mkdir(WRITEPATH.'documentos/consultor/'.$nif.'/'.$selloTiempo);
			// crea la subcarpeta $nif;
		}

		echo view('templates/header/header_dec_resp_cons', $data_file);
		echo view('pages/forms/dec_resp_consultor_idigital', $data_consultor);
		echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data_consultor);
		echo view('pages/forms/rest_api_firma/envia-a-firma-dec-resp-con', $data_consultor);	
		echo view('templates/footer/footer');
	 }	

public function store_idi_isba()
	 {
		helper('filesystem');
		helper(['form', 'url']);
		helper('cookie');
		$request = \Config\Services::request();
		$idioma =  $request->uri->getSegment(3);
	
		$language = \Config\Services::language();
		$language->setLocale($idioma);
 
		$modelConfig = new ConfiguracionModel();
		$data['configuracion'] = $modelConfig->where('convocatoria_activa', 1)->first(); 
		$convocatoria =   date("Y"); // $data['configuracion']['convocatoria'];
		$tipo_tramite =  'IDI-ISBA';
		$idExp = 1; // El contador de expedientes es por convocatoria. Lo inicio a 1 por si, en esta convocatoria, no hay ningún expediente
	 
		$db = \Config\Database::connect();
		$documentos = $db->table('pindust_documentos');
		$expediente = $db->table('pindust_expediente');
		$sql= "SELECT idExp FROM pindust_expediente WHERE tipo_tramite = '".$tipo_tramite."' ORDER BY idExp DESC Limit 1";

		$query = $db->query($sql);
	 	foreach ($query->getResult() as $row)
	 		{
		 	$idExp = $row->idExp;
		 	$idExp++;
			}

	 	/* $tipoTramite = "IDI-ISBA"; */ // $this->request->getVar('opc_programa');
	 	$tipoSolicitante = $this->request->getVar('tipo_solicitante');
 
	 	date_default_timezone_set("Europe/Madrid");
	 	$selloTiempo = date("d_m_Y_h_i_sa");

		/* -------------------------------6. DECLARO-------------------------------------------- */

		//1. Que el/la solicitante cumple con los requisitos de pequeña o mediana empresa

		if ($this->request->getVar('declaro_idi_isba_que_cumple') === 'on'){ /* OK */
			$declaro_idi_isba_que_cumple = "SI "; /* OK */
		} else {
			$declaro_idi_isba_que_cumple = "NO "; /* OK */
		}
		//2. Que el/la solicitante cumple con el requisito relativo a la no participación superior al 25% ...
		if ($this->request->getVar('declaro_idi_isba_que_cumple_no_mas_25') === 'on'){
			$declaro_idi_isba_que_cumple_no_mas_25 = "SI ";
		} else {
			$declaro_idi_isba_que_cumple_no_mas_25 = "NO ";
		}

		//3. Que el/la solicitante no incurre en ninguna causa de prohibición o de incompatibilidad ...
		if ($this->request->getVar('declaro_idi_isba_que_cumple_no_incurre_prohibicion_incom') === 'on'){
			$declaro_idi_isba_que_cumple_no_incurre_prohibicion_incom = "SI";
		} else {
			$declaro_idi_isba_que_cumple_no_incurre_prohibicion_incom = "NO";
		}


		//5. doy mi consentimiento para que el Instituto de Innovación Empresarial  ...
		if ($this->request->getVar('consentimiento_identificacion') === 'on'){ /* Sí da consentimiento */
			$file_enviardocumentoIdentificacion = "SI"; 
		} else {
			$file_enviardocumentoIdentificacion = "NO"; /* OK */
		}
		//6. doy mi consentimiento para que el Instituto de Innovación Empresarial de las Islas Baleares obtenga ...
		if ($this->request->getVar('consentimiento_certificadoATIB') === 'on'){
			$file_certificadoATIB = "SI"; 
		} else {
			$file_certificadoATIB = "NO";
		}

		//7. Respecto a la acreditación del requisito de estar al corriente de las obligaciones con la Seguridad ...
		if ($this->request->getVar('consentimiento_TesoreriaSegSoc') === 'on'){
			$file_certificadoSegSoc = "SI";
		} else {
			$file_certificadoSegSoc = "NO";
		}
		
		/* ----------------------------------------DOCUMENTACIÓN DE IDI-ISBA----------------------------------------------------- */
 		/* -------------------------------7. DOCUMENTACIÓN QUE NOS PUEDE ADJUNTAR--------------------------------------------- */
 		$documentosfile = $this->request->getFiles();
		
		if ( !$documentosfile['file_escritura_empresa'][0]->getName() ){
			$file_escritura_empresa = "NO";
	 	} else {
			$file_escritura_empresa = "SI";
	 	}
 
 		$nif = $this->request->getVar('nif');
		$empresa = $this->request->getVar('denom_interesado');
		$domicilio = $this->request->getVar('domicilio');
		$localidad = $this->request->getVar('localidad');
		$cpostal = $this->request->getVar('cpostal');
		$codigoIAE = $this->request->getVar('codigoIAE');
		$nom_representante = $this->request->getVar('nom_representante');
		$nif_representante = $this->request->getVar('nif_representante');
		$domicilio_rep = $this->request->getVar('domicilio_rep');
		$telefono_contacto_rep = $this->request->getVar('telefono_contacto_rep');
		$condicion_rep = $this->request->getVar('condicion_rep');

		/*** se usarán estos dos campos para notificar al beneficiario ***/
		$tel_notificacion  = $this->request->getVar('tel_representante');
		$mail_notificacion = $this->request->getVar('mail_representante');
		/*****************************************************************/
		$nom_entidad = ucwords($this->request->getVar('nom_entidad'));
		$importe_prestamo = $this->request->getVar('importe_prestamo');
		$plazo_prestamo   = $this->request->getVar('plazo_prestamo');
		$carencia_prestamo = $this->request->getVar('carencia_prestamo');
		$cuantia_aval_isba = $this->request->getVar('cuantia_aval_isba');
		$plazo_aval_isba = $this->request->getVar('plazo_aval_isba');
		$carencia_idi_isba = $this->request->getVar('carencia_idi_isba');
		$fecha_aval_isba = $this->request->getVar('fecha_aval_isba');
		$finalidad_inversion_idi_isba = ucwords($this->request->getVar('finalidad_inversion_idi_isba'));

		$empresa_eco_idi_isba = $this->request->getVar('empresa_eco_idi_isba');

		$importe_presupuesto_idi_isba = $this->request->getVar('importe_presupuesto_idi_isba');
		$importe_ayuda_solicita_idi_isba = $this->request->getVar('importe_ayuda_solicita_idi_isba');
		$intereses_ayuda_solicita_idi_isba = $this->request->getVar('intereses_ayuda_solicita_idi_isba');
		$coste_aval_solicita_idi_isba = $this->request->getVar('coste_aval_solicita_idi_isba');
		$gastos_aval_solicita_idi_isba = $this->request->getVar('gastos_aval_solicita_idi_isba');

		$tiene_ayudas_subv = $this->request->getVar('tiene_ayudas_subv');

		$ayuda_subv_de = $this->request->getVar('ayuda_subv_de');

		if ( $this->request->getVar('ayuda_subv_de') === 'otros') {
			$ayuda_subv_otros_detalle = $this->request->getVar('ayuda_subv_otros_detalle');
		}

		$data_exp = [
			 'idExp' => $idExp,
			 'tipo_solicitante' => $tipoSolicitante,
			 'fecha_completado' => date("Y-m-d H:i:s"),
			 'empresa' => $empresa,
			 'nif' => strtoupper($nif),
			 'domicilio' => $domicilio,
			 'localidad' => $localidad,
			 'cpostal' => $cpostal,
			 'telefono' => $this->request->getVar('telefono_cont'),
			 'telefono_rep' => $tel_notificacion,  // se usa para notificar
			 'email_rep' => $mail_notificacion,	// se usa para notificar
			 'tipo_tramite' => $tipo_tramite,
			 'iae' => $codigoIAE,

			 'nombre_rep' 		=> $nom_representante,
			 'nif_rep' 				=> $nif_representante,
			 'domicilio_rep' 	=> $domicilio_rep,
			 'telefono_contacto_rep' 	=> $telefono_contacto_rep, //uso este otro ya que en IDI-ISBA necesitan un teléfono de contacto
			 'condicion_rep' 	=> $condicion_rep,

			 'declaro_idi_isba_que_cumple' => $declaro_idi_isba_que_cumple,
			 'declaro_idi_isba_que_cumple_no_mas_25' 	=> $declaro_idi_isba_que_cumple_no_mas_25,
			 'declaro_idi_isba_que_cumple_no_incurre_prohibicion_incom' 	=> $declaro_idi_isba_que_cumple_no_incurre_prohibicion_incom,

			 'nom_entidad' => $nom_entidad,
			 'importe_prestamo' => $importe_prestamo,
			 'plazo_prestamo' => $plazo_prestamo,
			 'carencia_prestamo' => $carencia_prestamo,
			 'cuantia_aval_isba' => $cuantia_aval_isba,
			 'plazo_aval_isba' => $plazo_aval_isba,
			 'carencia_idi_isba' => $carencia_idi_isba,

			 'fecha_aval_isba' => $fecha_aval_isba,
			 'finalidad_inversion_idi_isba' => $finalidad_inversion_idi_isba,
			 'empresa_eco_idi_isba'  => $empresa_eco_idi_isba,//radio button
			 'importe_presupuesto_idi_isba' => $importe_presupuesto_idi_isba,
			 'importe_ayuda_solicita_idi_isba' => $importe_ayuda_solicita_idi_isba,
			 'intereses_ayuda_solicita_idi_isba' => $intereses_ayuda_solicita_idi_isba,
			 'coste_aval_solicita_idi_isba' => $coste_aval_solicita_idi_isba,
			 'gastos_aval_solicita_idi_isba' => $gastos_aval_solicita_idi_isba,
			 'tiene_ayudas_subv' => $tiene_ayudas_subv,
			 'ayuda_subv_de' => $ayuda_subv_de,
			 'ayuda_subv_otros_detalle' => $ayuda_subv_otros_detalle,

			 'file_enviardocumentoIdentificacion'   => $file_enviardocumentoIdentificacion,
			 'file_certificadoATIB' => $file_certificadoATIB,
			 'file_certificadoSegSoc' => $file_certificadoSegSoc,
			 'file_escritura_empresa' => $file_escritura_empresa,

			 'selloDeTiempo' => $selloTiempo,
			 'importeAyuda'	=> 0,
			 'convocatoria' => $convocatoria
			];
	
	 	$save_exp = $expediente->insert($data_exp);
		
	 	$last_insert_id = $save_exp->connID->insert_id;
	 	$data_exp ['selloDeTiempo'] = $selloTiempo;
	 	$data_exp ['last_insert_id'] = $last_insert_id;

		/* Si no existe la carpeta donde se guardará todo, se crea */

		if (file_exists( WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/') != 1 ) {
			mkdir(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/');
		}

		/* ------------------------------------------------------------------------------------------------------- */
		/* -------------------- copia nif al NO autorización a IDI comprobar dni, múltiples documentos------------ */
		if (isset($documentosfile['file_enviardocumentoIdentificacion'])) {
		foreach($documentosfile['file_enviardocumentoIdentificacion'] as $documentoIdentificacion)
			{
				if ($documentoIdentificacion->isValid() && ! $documentoIdentificacion->hasMoved())
					{
						$documentoIdentificacion->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $documentoIdentificacion->getRandomName());
						$data_file = [
						'name' => $documentoIdentificacion->getName(),
						'type' => $documentoIdentificacion->getClientMimeType(),
						'cifnif_propietario' => $nif,
						'tipo_tramite' => $tipo_tramite,
						'corresponde_documento' => 'file_enviardocumentoIdentificacion',
						'datetime_uploaded' => time(),
						'convocatoria' => $convocatoria,
						'docRequerido' => 'SI',
						'created_at'  => $documentoIdentificacion->getTempName(),
						'selloDeTiempo'  => $selloTiempo,
						'id_sol'         => $last_insert_id
						];
						$save = $documentos->insert($data_file);
					}
			}
		}
		/* ----------------------------------------------------------------------------------------------------- */
		/* ---------- corriente pago obligaciones ATIB NO autoriza a IDI comprobarlo, múltiples documentos------ */
		if (isset($documentosfile['file_certificadoATIB'])) {
		foreach($documentosfile['file_certificadoATIB'] as $certificadoATIB)
			{
				if ($certificadoATIB->isValid() && ! $certificadoATIB->hasMoved())
					{
						$certificadoATIB->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $certificadoATIB->getRandomName());
						$data_file = [
						'name' => $certificadoATIB->getName(),
						'type' => $certificadoATIB->getClientMimeType(),
						'cifnif_propietario' => $nif,
						'tipo_tramite' => $tipo_tramite,
						'corresponde_documento' => 'file_certificadoATIB',
						'datetime_uploaded' => time(),
						'convocatoria' => $convocatoria,
						'docRequerido' => 'SI',
						'created_at'  => $certificadoATIB->getTempName(),
						'selloDeTiempo'  => $selloTiempo,
						'id_sol'         => $last_insert_id
						];
						$save = $documentos->insert($data_file);
					}
			}
		}
 		/* ------------------------------------------------------------------------------------------------------------ */
 		/* --------------------------------certificados Tes. Seg. Soc.------------------------------------------------- */
 		if (isset($documentosfile['file_certificadoSegSoc' ])) {
		foreach($documentosfile['file_certificadoSegSoc' ] as $certificadoSegSoc)
			{
				if ($certificadoSegSoc->isValid() && ! $certificadoSegSoc->hasMoved())
				{
					$certificadoSegSoc->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $certificadoSegSoc->getRandomName());
					$data_file = [
					'name' => $certificadoSegSoc->getName(),					
					'type' => $certificadoSegSoc->getClientMimeType(),
					'cifnif_propietario' => $nif,
					'tipo_tramite' =>$tipo_tramite,
					'corresponde_documento' => 'file_certificadoSegSoc',
					'datetime_uploaded' => time(),
					'convocatoria' => $convocatoria,
					'docRequerido' => 'SI',
					'created_at'  => $certificadoSegSoc->getTempName(),
					'selloDeTiempo'  => $selloTiempo,
					'id_sol'         => $last_insert_id
					];
					$save = $documentos->insert($data_file);
				}
			}
		}
 		/* ----------------------------------------------------------------------------------------------------------------- */

 		if (isset($documentosfile['file_escritura_empresa'])) {
	 	foreach($documentosfile['file_escritura_empresa'] as $escrituraEmpresa)
		 	{
		 		if (strlen(trim($escrituraEmpresa->getName()))!=0)
			 	{
				 $escrituraEmpresa->move(WRITEPATH.'documentos/'.$nif.'/'.$selloTiempo.'/', $escrituraEmpresa->getRandomName());
				 $data_file = [
				 'name' => $escrituraEmpresa->getName(),					
				 'type' => $escrituraEmpresa->getClientMimeType(),
				 'cifnif_propietario' => $nif,
				 'tipo_tramite' =>$tipo_tramite,
				 'corresponde_documento' => 'file_escritura_empresa',
				 'datetime_uploaded' => time(),
				 'convocatoria' => $convocatoria,
				 'docRequerido' => 'NO',
				 'created_at'  => $escrituraEmpresa->getTempName(),
				 'selloDeTiempo'  => $selloTiempo,
				 'id_sol'         => $last_insert_id
				 ];
			 		$save = $documentos->insert($data_file);
			 	}
		 	}
	 	}
  	
		$data_file['titulo'] = "Resumen de la solicitud de ayuda IDI-ISBA";

	 	echo view('pages/forms/solicitud-ayuda-idi-isba', $data_exp);
		echo view('pages/forms/rest_api_firma/cabecera_viafirma', $data_exp);
		echo view('pages/forms/rest_api_firma/envia-a-firma-solicitud-ayuda-idi-isba', $data_exp);
   }	
}