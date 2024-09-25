function guardaFiltrado() {
    const convocatoria_fltr = document.forms[0].convocatoria_fltr.value;
    const programa_fltr = document.forms[0].programa_fltr.value;

    const situacion_fltr = document.forms[0].situacion_fltr.value;
    const textoLibre_fltr = document.forms[0].textoLibre_fltr.value;
    console.log(" - "+convocatoria_fltr+" - "+programa_fltr+" - "+situacion_fltr+" - "+textoLibre_fltr);
}

function cambiarTexto(id) {
    let aHrefNode = document.getElementById("_"+id);
    let parentNode = document.getElementById("__"+id);
    aHrefNode.classList.add("ocultar");
    let node = document.createElement("span");       
    let textnode = document.createTextNode("Un moment, actualitzant amb VIAFIRMA ...");
    node.appendChild(textnode);   
    let infoLink = document.getElementById(id);
    parentNode.appendChild(node);

    setCookie('tabSeleccionado', 'Expediente', 1);
    let buttonElement = document.createElement('BUTTON');
    buttonElement.innerHTML = '<button class="tablink" id = "defaultOpen" name = "Expediente" >Detall</button>';
    
	setCookie('elementoTabSeleccionado', buttonElement, 1);
  	setCookie('colorTabSeleccionado', 'red', 1);

    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/" + ";SameSite=Strict";
    }  
}

function enviaPropResolucionResDefinitiva(id, convocatoria, programa, nif) {
    alert (id, convocatoria, programa, nif)
    console.log(id, convocatoria, programa, nif)
}

function enviaPropResolucionResDefinitivaConReq(id, convocatoria, programa, nif) {
    alert (id, convocatoria, programa, nif)
    console.log(id, convocatoria, programa, nif)
}
