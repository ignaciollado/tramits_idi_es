function averiguaTipoDocumento (valor) {
	let toastMessage = document.getElementById('rest-result')
	let formasJuridicas = document.querySelectorAll('input[name="tipo_solicitante"]');
	let formaJuridaSelected
	for (const formaJuridica of formasJuridicas) {
		if (formaJuridica.checked) {
			formaJuridaSelected = formaJuridica.value
			break;
		}
	}

	if(valor.length != 9)	{
		toastMessage.innerText = "La longitud del número del documento identificador tiene que ser de 9 dígitos."
		toastMessage.classList.add("invalid")
		document.getElementById("nif").value = ""
		return;
	} else {
		toastMessage.innerText = ""
		toastMessage.classList.remove("invalid")
		document.getElementById("nif").setAttribute('class', 'valid')
	}

	if (formaJuridaSelected === "autonomo") {
		analizaDNINIE(valor)
	} else {
		analizaCIF(valor)
	}
}

function analizaCIF (cif) {
	/* Esta función comprueba que la estructura de un CIF sea correcta */
	/* La estructura correcta de un CIF es: */
	/* OPPNNNNNC, donde: */
	/* O: organización 
	/* PP: código de dos díditos de la provincia 
	/* NNNNN: numeración secuencial */
	/* C: dígito de control */
	// Letras de control: letraControl = ["K", "P", "Q", "S"];
	// Números de control: numeroControl = ["A", "B", "E", "H"];
	cif = cif.toUpperCase()
	let motivo = ""
	// De entrada, supongo que todos los códigos son erróneos.
	let organizacion_OK = false
	let provincia_OK = false
	let numeracion_OK = false
	let dControl_OK = false
	let esCIF_OK = false
	let toastMessage = document.getElementById('rest-result')
	// Mostraré el resultado en el elemento HTML con id = info_lbl
	/* document.getElementById("info_lbl").innerHTML = ""; */
	// Creo los arrays con todos los posibles valores de organización, provincia y letras y números de control
	let organizacionCodigo = ["A","B","C","D","E","F","G","J","H","K","L","M","N","P","Q","R","S","U","V","W"];
	// Los códigos de provincia, los separo en varios arrays por comodidad de lectura
	let provinciaCodigo_1 = ["00", "01", "02", "03", "53", "54", "04", "05", "06", "07", "57", "08"];
	let provinciaCodigo_2 = ["58", "59", "60", "61", "62", "63", "64", "65", "66", "68", "09", "10", "11", "72"];
	let provinciaCodigo_3 = ["12", "13", "14", "56", "15", "70", "16", "17", "55", "67", "18"];
	let provinciaCodigo_4 = ["19", "20", "71", "21", "22", "23", "24", "25", "26", "27"];
	let provinciaCodigo_5 = ["28", "78", "79", "80", "81", "82", "83", "84", "85", "86", "87", "88", "29", "92"];
	let provinciaCodigo_6 = ["93", "30", "73", "31", "71", "32", "33", "74", "34", "35", "75"];
	let provinciaCodigo_7 = ["36", "37", "94", "38", "76", "75", "39", "40", "41", "90", "91", "42"];
	let provinciaCodigo_8 = ["43", "77", "44", "45", "46", "96", "97", "98", "47", "48"];
	let provinciaCodigo_9 = ["49", "50", "99", "51", "52"];
	// Los concatenaré en un único array al que llamo provinciaCodigo, 
	let provinciaCodigo = provinciaCodigo_1.concat(provinciaCodigo_2);
	provinciaCodigo = provinciaCodigo.concat(provinciaCodigo_3);
	provinciaCodigo = provinciaCodigo.concat(provinciaCodigo_4);
	provinciaCodigo = provinciaCodigo.concat(provinciaCodigo_5);
	provinciaCodigo = provinciaCodigo.concat(provinciaCodigo_6);
	provinciaCodigo = provinciaCodigo.concat(provinciaCodigo_7);
	provinciaCodigo = provinciaCodigo.concat(provinciaCodigo_8);
	provinciaCodigo = provinciaCodigo.concat(provinciaCodigo_9);
	
	// Separo la parte que corresponde a la Organización y lo convierto todo a mayúsculas	
	let organizacion = cif.substring(0, 1);
	// Separo la parte que corresponde a la provincia
	let provincia = cif.substring(1, 3);
	// Separo la parte correspondiente a la numeración secuencial
	let numeracion = cif.substring(3, 8);
	// Separo la parte correspondiente al dígito de control
	let dControl = cif.substring(8, 9);

	console.log(organizacion, provincia, numeracion, dControl)

	// Verifico que el código de la organización sea un valor correcto, si es así, asigno el valor verdadero
	if (organizacionCodigo.indexOf( organizacion ) != -1) {
		organizacion_OK = true;
	}
	// Compruebo que el código de provincia sea un valor correcto, si es así, asigno el valor verdadero
	if (provinciaCodigo.indexOf( provincia ) != -1) {
		provincia_OK = true;
	}
	// Compruebo que la secuencia de numeración sea un número y, entonces, que no existan letras ni caracteres no numéricos
	if (!isNaN( numeracion )) {
		numeracion_OK = true;
	}
	// Cuando la organización es K,P,Q,S  el dígito de control debe ser una letra
	if ((isNaN(dControl)) && (organizacion == "K" || organizacion == "P" || organizacion == "Q" || organizacion == "S")) {
		dControl_OK = true;
	}
	// Cuando organización es A,B,E,H, el dígito de control debe ser número,
	else if ((!isNaN(dControl)) && (organizacion == "A" || organizacion == "B" || organizacion == "E" || organizacion == "H")) {
		dControl_OK = true;
	}
	dControl_OK = true;
	// Muestro el valor entrado en el elemento HTML con id = info_lbl
	// document.getElementById("info_lbl").innerHTML = document.getElementById("info_lbl").innerHTML + " Control: " + dControl + " " + dControl_OK + "<br>";
	// Si, todos los códigos anteriores son correctos, el CIF es correcto
	if (organizacion_OK && provincia_OK && numeracion_OK && dControl_OK) {
		esCIF_OK = true;
	}
	// En otro caso, indico en que códigos está el error
	if (!organizacion_OK ||  !provincia_OK || !numeracion_OK  || !dControl_OK ) {
		motivo = "Alguna part del CIF no està correcta:\n";
	}
	if (!organizacion_OK) {
		motivo = motivo + "<li>Organització equivocada (el primer caràcter)</li>";
	}
	if (!provincia_OK) {
		motivo = motivo + "<li>Provincia equivocada (el segon i el tercer caràcters)</li>";
	}
	if (!numeracion_OK) {
		motivo = motivo + "<li>Número sequencial erroni (des-de el quart fins al vuité caràcters)</li>";
	}
	if (!dControl_OK) {
		motivo = motivo + "<li>Dígit de control erroni (el darrer caràcter)</li>";
	}

	if (esCIF_OK) 
	{
		toastMessage.innerHTML = "";
		toastMessage.classList.remove("invalid")
		document.getElementById("nif").value = cif;
		/* consultaExpediente ( 'nif', cif )  */
	}
	else 
	{
		toastMessage.innerHTML = motivo
		toastMessage.classList.add("invalid")
		document.getElementById("nif").focus();
	}
	}

function analizaDNINIE (dninie) {
	// Primero averiguar si se trata de DNI o de NIE
	// ---------NIE--------------------------------------------------
	// Estructura del NIE: ADDDDDDDB
	// A: {X,Y,Z}
	// B: Sustituir X->0, Y->1, Z->2, añadir los siete dígitos restantes y hacer módulo 23 . El resto es el índice del array posiblesLetrasDNINIE
	// ---------DNI---------------------------------------------------
	// Estructura del DNI: 12345678A
	// La operación consiste en una división del número del DNI entre 23. 
	// El número del DNI debe tomarse como un entero, por ello los ceros que se encuentren a la izquierda no serán válidos. 
	// Al dividir entre 23 tendremos 23 posibles resultados.  'T,R,W,A,G,M,Y,F,P,D,X,B,N,J,Z,S,Q,V,H,L,C,K,E'
	// $posiblesLetrasDNI = array('T','R','W','A','G','M','Y','F','P','D','X','B','N','J','Z','S','Q','V','H','L','C','K','E');
	// El valor que debemos tomar para el cálculo de la letra del DNI es el resto qué se obtiene de la división anteriormente indicada. 
	// Tendremos pues ventitres posibles resultados desde el 0 hasta el 22. 
	// Cada letra tiene un valor entre 0 y 22 que coincidirá pues con el resto que hemos obtenido de la operación aritmética. 
	// coincide el último dígito con el resultado de la operación de comprobación.

	let currentDNINIE = dninie.toUpperCase();

	// primer dígito numérico
	let primerDigitoDNINIE = currentDNINIE.slice(0, 1);

	// intermedio dígito numérico
	let digitosIntermedio = currentDNINIE.slice(1, 8);	

	// último dígito alfabético
	let caracterVerificacionAlfabetico = currentDNINIE.slice(8, 9);

	//Resultante
	let resultante
	const posiblesLetrasDNINIE = ['T','R','W','A','G','M','Y','F','P','D','X','B','N','J','Z','S','Q','V','H','L','C','K','E'];		
	if (isNaN(primerDigitoDNINIE) ) // si el primer dígito no és un número, se trata de un NIE: ADDDDDDDB, A={X,Y,Z}	
	{
		if (primerDigitoDNINIE!='X' && primerDigitoDNINIE!='Y' && primerDigitoDNINIE!='Z') // y tiene que ser X,Y,Z
			{
			document.querySelector('#rest-result').innerHTML = "El primer dígito tiene que ser una número o una de las letras X, Y o Z."
			/* toastBootstrap.show() */
			document.getElementById("nif").value = ""
			return;
			}
		else 
			{
			switch (primerDigitoDNINIE) 
			{
				case 'X':
					resultante = 0+digitosIntermedio	 
				break
				case 'Y':
					resultante = 1+digitosIntermedio	 
				break
				case 'Z':
					resultante = 2+digitosIntermedio	 
				break
			}
			}
	} else {
		resultante = primerDigitoDNINIE+digitosIntermedio
		document.querySelector('#rest-result').innerHTML = "";
	}
		
		let i = resultante % 23;
		let letraDNINIE = posiblesLetrasDNINIE[i];
		document.getElementById("nif").value = primerDigitoDNINIE+digitosIntermedio+letraDNINIE;
		/* consultaExpediente ( 'nif', primerDigitoDNINIE+digitosIntermedio+letraDNINIE ) */
	}

function tenemosDatosSolicitante(documentoIdentificativo) {
	let nif = documentoIdentificativo;
	let modal = document.getElementById("myModal");
	let response = false;
	$.post(
		"/public/assets/utils/buscarSolicitudPorNIF.php",
		{ nif: nif },
		function (data) {
			document.getElementById("aviso").innerHTML = "Buscando datos ...";
		  })
			.done(function( data ) {
				let infoDisponible = document.getElementById('info-disponible');
				let dataToArray = data.split('#');
				console.log (data)
				if (dataToArray != "0 results"){
					modal.style.display = "block";
					infoDisponible.innerHTML = "<li>NIF: "+dataToArray[0]+"</li>";
					infoDisponible.innerHTML += "<li>Raó social: "+dataToArray[1]+"</li>";
					infoDisponible.innerHTML += "<li>Domcili: "+dataToArray[2]+"</li>";
					infoDisponible.innerHTML += "<li>Localitat: "+dataToArray[3]+"-"+dataToArray[4]+"</li>";
					infoDisponible.innerHTML += "<li>Codi Postal: "+dataToArray[5]+"</li>";
					infoDisponible.innerHTML += "<li>Telèfon de contacte: "+dataToArray[6]+"</li>";
					infoDisponible.innerHTML += "<li>Epigraf IAE: "+dataToArray[7]+"</li>";
					infoDisponible.innerHTML += "<li>Nom del representant: "+dataToArray[8]+"</li>";
					infoDisponible.innerHTML += "<li>DNI del representant: "+dataToArray[9]+"</li>";
					infoDisponible.innerHTML += "<li>Telèfon de notificacions: "+dataToArray[10]+"</li>";
					infoDisponible.innerHTML += "<li>Adreça electrònica de notificacions: "+dataToArray[11]+"</li>";

					infoDisponible.innerHTML += "<li>Tenim Escriptura empresa: "+dataToArray[12]+"</li>";
					infoDisponible.innerHTML += "<li>Tenim la memòria Tècnica: "+dataToArray[13]+"</li>";
					infoDisponible.innerHTML += "<li>Tenim el certificat IAE: "+dataToArray[14]+"</li>";
					infoDisponible.innerHTML += "<li>Tenim una còpia del NIF: "+dataToArray[15]+"</li>";

					localStorage.setItem('nif', dataToArray[0]);
					localStorage.setItem('empresa', dataToArray[1]);
					localStorage.setItem('domicilio', dataToArray[2]);
					localStorage.setItem('localidad', dataToArray[3]+"#"+dataToArray[4]);
					localStorage.setItem('cpostal', dataToArray[5]);
					localStorage.setItem('telefono', dataToArray[6]);
					localStorage.setItem('epigrafe_IAE', dataToArray[7]);

					localStorage.setItem('nombre_rep', dataToArray[8]);
					localStorage.setItem('nif_rep', dataToArray[9]);
					localStorage.setItem('telefono_rep', dataToArray[10]);
					localStorage.setItem('email_rep', dataToArray[11]);

					localStorage.setItem('file_escritura_empresa', dataToArray[12]);
					localStorage.setItem('file_memoriaTecnica', dataToArray[13]);
					localStorage.setItem('file_certificadoIAE', dataToArray[14]);
					localStorage.setItem('file_copiaNIF', dataToArray[15]);


				} else {
					document.getElementById("aviso").innerHTML = "No hay datos.";
				}

			})
			.fail(function( e ) {
			  alert( "Error: " + e.status );
			})
			.always(function() {
			  //alert( "finished" );
			});
}

function actualizoFormConDatosSolicitante () {
	document.getElementById("denom_interesado").value = localStorage.getItem('nif');
	document.getElementById("denom_interesado").value = localStorage.getItem('empresa')
	document.getElementById("domicilio").value =  localStorage.getItem('domicilio')
	document.getElementById("cpostal").value = localStorage.getItem('cpostal')
	document.getElementById("telefono_cont").value = localStorage.getItem('telefono')
	document.getElementById("codigoIAE").value = localStorage.getItem('epigrafe_IAE')
	document.getElementById("localidad").value =  localStorage.getItem('localidad')

	document.getElementById("nom_representante").value = localStorage.getItem('nombre_rep')
	document.getElementById("nif_representante").value = localStorage.getItem('nif_rep');
	document.getElementById("tel_representante").value = localStorage.getItem('telefono_rep');
	document.getElementById("mail_representante").value = localStorage.getItem('email_rep');

	if (localStorage.getItem('file_escritura_empresa') === 'SI') {
		document.getElementById('mostrarEscritura').style.display = 'none'
	}
	if (localStorage.getItem('file_memoriaTecnica') === 'SI') {
		document.getElementById('mostrarMemoriaTecnica').style.display = 'none'
	}	
	if (localStorage.getItem('file_certificadoIAE') === 'SI') {
		document.getElementById('mostrarIAE').style.display = 'none'
	}
	if (localStorage.getItem('file_copiaNIF') === 'SI') {
		document.getElementById('mostrarNIF').style.display = 'none'
	}

	cierraModal()
}

