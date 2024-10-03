<!-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"> -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<?php	
  use App\Models\ConfiguracionModel;

  $session = session();
  $empresa = $session->get('full_name');
  $nif = $nifcif;
	$adreca_mail = $session->get('username');
	$telefono_cont = $session->get('telefono');

		
	if ( $byCEOSigned ) {
    $configuracion = new ConfiguracionModel();
		$theUserCode = $adreca_mail;
    $data['ceoData'] = $configuracion->where('activeGeneralData', 'SI')->first();
		$adreca_mail = $data['ceoData']['eMailDGerente'];
		$telefono_cont = $data['ceoData']['telDGerente'];
	}

require_once dirname(__FILE__) . '/model/AddresseeActionInfo.php';
require_once dirname(__FILE__) . '/model/AddresseeGroup.php';
require_once dirname(__FILE__) . '/model/AddresseeLine.php';
require_once dirname(__FILE__) . '/model/AddresseeUserEntity.php';
require_once dirname(__FILE__) . '/model/Document.php';
require_once dirname(__FILE__) . '/model/Item.php';
require_once dirname(__FILE__) . '/model/Job.php';
require_once dirname(__FILE__) . '/model/Request.php';
/* require_once dirname(__FILE__) . '/model/StampPosition.php'; */ //COMENTADO PORQUE EN, VERSIÓN PRE y PRO, NO ES COMPATIBLE
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
//$sender->userCode = "Q5755018H";
$sender->userCode = "Q5755018H";
$sender->entityCode = "default";
$request->sender = $sender;

$user = new AddresseeUserEntity;
$user->action = "SIGN";  
$user->userCode = $adreca_mail; //"ignacio.llado@idi.es";  
$user->entityCode = "default";
//$user->userName = $empresa; // "wwwwwwwwwwwwwwww";
//$user->userSurname1 = $nif; // "43036826P";
//$user->userSurname2 = "";
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
$request->subject = "AUTOSEND ".$nombreDocumento; //"Gestor de tràmits administratius- AUTOSEND";
$request->message = "Document per signar";
$request->senderNotificationLevel = "ALL";
$request->signatureLevel = "ALL";
$request->useDefaultStamp = true;
// URL para los callbacks tras realizar una acción con la petición. Será un GET con los parámetros:
// action (String con el tipo de acción), label (String con la public access id de la petición) y finished=ok (si está finalizada la petición. En caso contrario, no se incluirá).
$request->notificationUrl = "https://tramits.idi.es/public";

// Adding a document to sign
$doc = new Document;
$doc->filename = $nombreDocumento;
$doc->base64 = chunk_split(base64_encode(file_get_contents(WRITEPATH.'documentos/'.$nif.'/informes/'.$nombreDocumento)));

/* $doc->filename = "fichero_a_firmar.pdf";
$doc->base64 = chunk_split(base64_encode(file_get_contents('fichero_a_firmar.pdf')));
echo $doc->filename."-"; */

$documentsToSign = array ($doc);
$request->documentsToSign = $documentsToSign;

// Set json
$json = json_encode($request);

$json = str_replace(array('\r','\n'),'',$json)."<br>";
$resultRequest = execute("requests", $json, __FUNCTION__);
printResult($resultRequest, $last_insert_id, $id);

function execute($apiPath, $json, $methodName) {
$url = REST_API_URL.$apiPath;

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
$data = json_decode($result, true);
echo "<br><div class='alert alert-dark' role='alert'>";
echo "<strong>Dades de la sol·licitud de signatura:</strong><br>";
echo "Destinatari: <strong>" . $data['addresseeLines'][0]['addresseeGroups'][0]['userEntities'][0]['userCode'] . "</strong><br>";
echo "Dotument per signar: <strong>" . $data['documentsToSign'][0]['filename'] . "</strong><br>";
$formatted_date = date("Y-m-d H:i:s", $data['sendDate']/ 1000);
echo "Data de enviament: " . $formatted_date . "<br>";
echo "Public Access ID: " . $data['publicAccessId'] . "<br>";
echo "</div>";
// Closing
curl_close($ch);
return $result;
}	
		
function printResult($result, $last_insert_id, $id) {
	$respuesta = json_decode ($result, true);
	$db = \Config\Database::connect();
	$builder = $db->table('pindust_documentos_generados');
	$data = [
    'publicAccessId' => $respuesta['publicAccessId'],
	];
	$builder->where('id', $last_insert_id);
	$builder->update($data);

  $builder = $db->table('pindust_expediente');
	$data = [
    'fecha_requerimiento_sended' => $respuesta['sendDate'],
	];
	$builder->where('id', $id);
	$builder->update($data);
}
?>