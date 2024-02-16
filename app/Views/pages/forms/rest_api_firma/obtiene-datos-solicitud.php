<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<?php
	$requestPublicAccessId = $PublicAccessId; // document public access id
	$request = execute("requests/".$requestPublicAccessId, null, __FUNCTION__);
	printResult($request);

	//La petición: url-inbox/api/v3/requests/{publicAccessId}
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
		
	function printResult($result) {
	
		$respuesta = json_decode ($result, true);
		
		echo "<div class='further'>";
		echo "<div class='container'>";
		echo "<pre>Ref. pùblica: ".$respuesta['publicAccessId']."</pre>";				
		echo "<pre>Assumpte: ".$respuesta['subject']."</pre>";
		echo "<pre>Missatge: ".$respuesta['message']."</pre>";
		echo "<pre>Data de creació: ".gmdate("d-m-Y H:i:s", intval ($respuesta['creationDate']/1000))."</pre>";
		echo "<pre>Data d'enviament: ".gmdate("d-m-Y H:i:s",intval ($respuesta['sendDate']/1000))."</pre>";
		
		echo "<pre>Segell electrònic: ".$respuesta['stampName']."</pre>";
		echo "<pre>";
		if ($respuesta['status'] == "REJECTED") {
			echo "<div class = 'warning-msg'><i class='fa fa-warning'></i><strong>SOL·LICITUD DE SIGNATURA REBUTJADA.</strong></div>";
		}
		echo "</pre>";

		echo "<div class='alert alert-info'><pre>".$respuesta['rejectInfo']['rejectType']."</pre></div>";
		echo "<div class='alert alert-info'><pre>".$respuesta['rejectInfo']['rejectReason']."</pre></div>";
		echo "<pre>Data rebuig: ".gmdate("d-m-Y H:i:s", intval ($respuesta['rejectInfo']['rejectDate']/1000))."</pre>";
		echo "<pre>".$respuesta['rejectInfo']['autoReminderPeriodicity']."</pre>";	
		echo "<pre>".$respuesta['rejectInfo']['autoReminderAttempts']."</pre>";	
		echo "<pre>Nom del document a signar: ".$respuesta['documentsToSign'][0]['filename']."</pre>";
		echo "<div><button class='btn btn-secondary' onclick='goBack()'>Tornar</button></div>";
		echo "</div>";
		echo "</div>";

	}
?>
		<script>
		function goBack() {
		    window.history.back();
		}
		</script>