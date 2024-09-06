<?php
// PRODUCCIÓN
/*   const REST_API_URL = "https://inbox.viafirma.com/inbox/api/v3/";
  const REST_API_KEY = "viafirma";
  const REST_API_PASS = "HXN91O5HBYNUNGVRVTQKBFXWDLPIOMBPKIBSJNCC"; */
// DESARROLLO	

const REST_API_URL = "https://sandbox.viafirma.com/inbox/api/v3/";
const REST_API_KEY = "dev_idi";
const REST_API_PASS = "V3CBFZVZS6THXSWZG9HL3AFF06KD4NGAQHGXGF6Y";

$url =  $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$items = parse_url( $url);
$itemsArray = explode  ("=", $items['query']);

$requestPublicAccessId =  $itemsArray[1];

$request = execute("requests/".$requestPublicAccessId, null, __FUNCTION__);
$respuesta = json_decode ($request, true);
echo $respuesta['status'];

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
?>