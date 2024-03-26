window.addEventListener('load', (event) => {
    /* const intervaloActualizacion = (document.getElementById("updateInterval").value/4 * 60 * 1000)/10; */

    const googleId = document.querySelector(".unreadMails").id;

    setInterval(function(){ getUnreadMessages(googleId); }, 60000);

    // Harcodeo todo lo que sigue por falta de tiempo. Cuando pueda, tengo que refactorizar.  (02/12/2021)
    
});

function onLoad() {
	gapi.load("auth2", () => {
		gapi.auth2.init();
		gapi.client.init({
			//apiKey: APIKEY,
			clientId: CLIENTID,
			scope: SCOPES
		  }).then();
	});
}

function signOut() {
	gapi.auth2.getAuthInstance().disconnect();
	var auth2 = gapi.auth2.getAuthInstance();
	console.log(auth2);
	auth2
		.signOut()
		.then(function () {
			console.log("User signed out.");
		})
		.then(function () {
			window.location.href =
				"https://pre-tramits.idi.es/public/index.php/logout";
		});
}

async function getUnreadMessages(userId) {
	let parameters = {
        "labelIds": "INBOX",
		"q": "is:unread"
  };


	gapi.client.init({
    'apiKey': APIKEY,
    // clientId and scope are optional if auth is not required.
    'clientId': '317070054037-71vr46416dlhb63auo5tv0vg16557cin.apps.googleusercontent.com',
    'scope': 'profile',
  }).then(function() {
    // 3. Initialize and make the API request.
    return gapi.client.request({
      'path': `/gmail/v1/users/${userId}/messages`,
    })
  }).then(function(response) {
    console.log(response.result);
  }, function(reason) {
    console.log('Error: ' + reason.result.error.message);
  });


/* 	await gapi.client.request({
		'path': `/gmail/v1/users/${userId}/messages`,
		'method': 'GET',
		apiKey: APIKEY,
		'params': parameters,
		//'body': resource
	  }).then(function(resp) {
		writeResponse(resp.result);
	  }); */
}

function writeResponse(response) {
	let msgBanner = document.getElementById("totalMsg");
	if ( document.getElementById("linkmsgBanner")) {
		var myobj = document.getElementById("linkmsgBanner");
		myobj.remove(); 
	}
	if ( response['resultSizeEstimate'] > 0) {
		let x = document.createElement("A");
		x.setAttribute("href", "https://mail.google.com/mail/u/0/#inbox");
		x.setAttribute("title", "Consultar els missatges de correu...");
		x.setAttribute("class", "label label-info");
		x.style.color = "#ffffff";
		x.innerHTML = response['resultSizeEstimate']+ " missatges";
		x.setAttribute("target", "_blank");
		x.setAttribute("id", "linkmsgBanner");
		msgBanner.appendChild(x);
	}
	else {
		msgBanner.classList.remove('badge-light');
		msgBanner.classList.remove('badge');
	}
}

// CATÀLEG DADES OBERTES CAIB - Concessions Subvencions Comunitat Autònoma Illes Balears
async function obtieneDatosAbiertos (departament) {
	const URI_API = `https://catalegdades.caib.cat/resource/gy6g-q29z.json?departament=${departament}`;
	return concesionsSubvencionsCAIB = await fetch(URI_API)
		.then((response) => response.text())
		.then((data) => {
			return data;
		});
}
//console.log(await obtieneDatosAbiertos ("SERVICIO DE OCUPACIÓN DE LAS ISLAS BALEARES (SOIB)"));

