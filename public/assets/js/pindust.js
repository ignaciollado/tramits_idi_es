const APIKEY = 'AIzaSyD9mrfcTQaAlFgj4lc5I_pW1Lx8fdUwgPA'; //'WWFCKJIvtNwSOsfw-L_svxMu';

// PRODUCCIÓN
const CLIENTID = '317070054037-71vr46416dlhb63auo5tv0vg16557cin.apps.googleusercontent.com';
const CLIENTSECRET = "fAXlpDPnOqBGkRRRcyKY4G3C";

// DESARROLLO
/* const CLIENTID = '317070054037-t1thp3bfgcsskpuok1f0e12ja6hcbus5.apps.googleusercontent.com';
const CLIENTSECRET = "WWFCKJIvtNwSOsfw-L_svxMu"; */

const SCOPES = [
		//'https://www.googleapis.com/auth/cloud-platform',
		//'https://www.googleapis.com/auth/gmail',
		//'https://www.googleapis.com/auth/blogger',
		//'https://www.googleapis.com/auth/calendar'
	  ];

window.addEventListener('load', () => {
		//const intervaloActualizacion = document.getElementById("updateInterval").value/4 * 60 * 1000;
		//const googleId = document.querySelector(".unreadMails").id;
		//setInterval(function(){ getUnreadMessages(googleId); }, intervaloActualizacion);
	});


function home() {}

function toggleMenu() {
	var menuItems = document.getElementsByClassName("menu-item");
	for (var i = 0; i < menuItems.length; i++) {
		var menuItem = menuItems[i];
		menuItem.classList.toggle("hidden");
	}
}

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

function onSuccess(googleUser) {
	var profile = googleUser.getBasicProfile()
	console.log("Bienvenido otra vez " + profile.getName(), profile.getEmail());
	var id_token = JSON.stringify(gapi.auth2.getAuthInstance().currentUser.get().getAuthResponse(true));
	localStorage.setItem("tokenItramits", id_token)
	let text = localStorage.getItem("tokenItramits")
	let obj = JSON.parse(text);
	window.location.href = "https://tramits.idi.es/public/index.php/loginController/login/" + obj.id_token; //profile.getId() ;
}

function onFailure(error) {
	console.log(error);
}

function renderButton() {
	gapi.signin2.render("signinGooogloToiTramits", {
		scope: "profile https://www.googleapis.com/auth/gmail.readonly", //https://mail.google.com",
		width: 450,
		height: 50,
		longtitle: false,
		theme: "dark",
		onsuccess: onSuccess,
		onfailure: onFailure,
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
				"https://tramits.idi.es/public/index.php/logout";
		});
}

async function getUnreadMessages(userId) {
	var parameters = {
        "labelIds": "INBOX",
		"q": "is:unread"
      };
	await gapi.client.request({
		'path': `/gmail/v1/users/${userId}/messages`,
		'method': 'GET',
		apiKey: APIKEY,
		'params': parameters,
		//'body': resource
	  }).then(function(resp) {
				writeResponse(resp.result);
	  });
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
		x.setAttribute("title", "Consulta els teus missatges de correu");
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
//console.log(await obtieneDatosAbiertos ('SERVICIO DE OCUPACIÓN DE LAS ISLAS BALEARES (SOIB)'));