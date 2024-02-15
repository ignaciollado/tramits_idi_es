<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<?php
		$empresa = $_POST["empresa"];
		$nif = $_POST["nif"];
		$adreca_mail = $email_not;
		$telefono_cont = $telefono_not;
		
		//$adreca_mail = "ignacio.llado@idi.es";
		//$adreca_mail = "pindust@idi.es";
		//$telefono_cont = "677234076";
		
		require_once dirname(__FILE__) . '/model/AddresseeActionInfo.php';
		require_once dirname(__FILE__) . '/model/AddresseeGroup.php';
		require_once dirname(__FILE__) . '/model/AddresseeLine.php';
		require_once dirname(__FILE__) . '/model/AddresseeUserEntity.php';
		require_once dirname(__FILE__) . '/model/Document.php';
		require_once dirname(__FILE__) . '/model/Item.php';
		require_once dirname(__FILE__) . '/model/Job.php';
		require_once dirname(__FILE__) . '/model/Request.php';
		//require_once dirname(__FILE__) . '/model/StampPosition.php';
		require_once dirname(__FILE__) . '/model/Template.php';
		require_once dirname(__FILE__) . '/model/UserEntity.php';
		require_once dirname(__FILE__) . '/model/VerificationAccess.php';

		// INFO: En este ejemplo se creará una petición en paralelo que constará de dos líneas de firma:
		// Línea 1: Usuario 12345678A (VISTO BUENO) > Usuario 12345678B (FIRMA)
	 
		// Usuario remitente del formulario, a partir del $nif firma el/los documentos (FIRMA)
		// Línea 2: Grupo ZFLVHE6AAJ (FIRMA)
		
		// Construct Request object
		$request = new Request;
		
		$sender = new UserEntity;
		$sender->entityCode = "default";
		$sender->userCode = "Q5755018H";
		$request->sender = $sender;

		$user = new AddresseeUserEntity;
		$user->action = "SIGN";  
		$user->userCode = $adreca_mail; //"ignacio.llado@idi.es";    
		$user->userName = $empresa; // "wwwwwwwwwwwwwwww";
		$user->userSurname1 = $nif; // "43036826P";
		$user->userSurname2 = "";
		$user->userPhone = "+34".$telefono_cont; //"+34677234076";

		$line1 = new AddresseeLine;
		
		$group2Line1 = new AddresseeGroup;
		$group2Line1Users = array ($user);
		$group2Line1->userEntities = $group2Line1Users;
		
		$line1Groups = array ($group2Line1);
		$line1->addresseeGroups = $line1Groups;
		
		// Adding the line
		$lines = array ($line1);
		$request->addresseeLines = $lines;
		
		// Subject, message and sender notification level
		$request->subject = lang('message_lang.titulo_justificacion_idigital'); // "Sol·licitud d'ajuts per al disseny de plans de transformació digital en el marc del programa 'Idigital'";
		$request->message = lang('message_lang.subtitulo_justificacion_idigital'); // "Convocatoria para la concesión de ayudas para el diseño de planes de transformación digital para el año 2020 destinados a la industria balear, en el marco de Idigital, estrategia de digitalización industrial.";					
		$request->senderNotificationLevel = "ALL";
		$request->stampName = "bar_code";
		//$request->useDefaultStamp = true;
		// URL para los callbacks tras realizar una acción con la petición. Será un GET con los parámetros:
		// action (String con el tipo de acción), label (String con la public access id de la petición) y finished=ok (si está finalizada la petición. En caso contrario, no se incluirá).
		$request->notificationUrl = "https://tramits.idi.es/public";
		
		// Adding a document to sign
		$doc = new Document;

		$doc->filename = $nif.'_dec_res_solicitud_iDigital.pdf';
		$doc->base64 = chunk_split(base64_encode(file_get_contents(WRITEPATH.'documentos/'.$nif.'/justificacion/'.$selloTiempo.'/'.$nif.'_justificacion_solicitud_ayuda.pdf')));	

		$documentsToSign = array ($doc);
		$request->documentsToSign = $documentsToSign;
		
		// Set json
		$json = json_encode($request);
		// echo $json;
		$resultRequest = execute("requests", $json, __FUNCTION__);
		printResult($resultRequest, $id_sol, $tipo_Doc, $adreca_mail);

	
	function execute($apiPath, $json, $methodName) {
		$url = REST_API_URL.$apiPath;
		// echo "\nMethod URL: ".$url."\n\n";
		
		// Initiate curl
		$ch = curl_init();
		
		// Disable SSL verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		// Will return the response, if false it print the response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Set the url
		curl_setopt($ch, CURLOPT_URL, $url);
		
		if (is_null($json)) {
			curl_setopt($ch, CURLOPT_HTTPGET, 1);
		} else {
			if ($methodName=='createUser') {
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
			} else {
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			}
			curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=utf-8","Accept:application/json, text/javascript, */*; q=0.01"));
		}

		// Basic Authentication
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, REST_API_KEY.":".REST_API_PASS);
		
		// Execute
		$result = curl_exec($ch);

		// Closing
		curl_close($ch);
		return $result;		
	}	
		
	function printResult($result, $id_sol, $tipo_Doc, $adreca_mail) {
		echo "<content>";
		echo "<section>";
		$respuesta = json_decode ($result, true);
		echo "<div class='alert alert-info'><strong>".$respuesta['subject']."</strong></div>";

		$db      = \Config\Database::connect();
		$builder = $db->table('pindust_expediente');
		$data = [
        'publicAccessIdjustificado' => $respuesta['publicAccessId'],
		];
		$builder->where('id', $id_sol);
		$builder->update($data);	
		
		echo "<div class='alert alert-info'>".lang('message_lang.enviado_correo_electron_justif')." <strong>".$adreca_mail."</strong></div>";
		echo "<div class='alert alert-warning'>".lang('message_lang.nota_info_rec_justif')."</div>";
		echo "<div class='alert alert-info'>".lang('message_lang.contacto_idi_pindust')."</div>";		
		echo "<div class='alert alert-info'>".lang('message_lang.una_vez_firmado')."</div>";
		echo "</section>";
		echo "</content>";
	}
?>