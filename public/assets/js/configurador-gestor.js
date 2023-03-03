$(document).ready(function(){  
    $('#edit-configuracion').submit(function(){
        $("#guarda _config", this)
            .html("Actualitzant, un moment per favor.")
            .attr('disabled', 'disabled')
            .css("background-color","orange");		
    });
});

function obtiene_datos_convo (id) {
    console.log (id)
}

function leeJson() {
    let data = eval(document.getElementById("meses_fecha_lim_consultoria").value);
    let row = "" ;
    for(let i of data){
        row += "<tr>";
        row += "<td>" 
            + i.programa +"</td>" 
            + "<td><input type='number' onchange='generaJson()' required min='1' max='12' name ='meses_p1' class='form-control' id = '"+i.programa+"' value ='" + i.intervalo +"'></td>" 
            ;
        row += "</tr>";
    }
    alert ("####"+row+"#####")
    document.getElementById("result").innerHTML = row;
}

function generaJson() {
    document.getElementById("meses_fecha_lim_consultoria").value = "[{'programa':'I','intervalo':'"+document.getElementById("I").value+"'},{'programa':'II','intervalo':'"+document.getElementById("II").value+"'},{'programa':'III','intervalo':'"+document.getElementById("III").value+"'}]";
}

function guardarFormulario(id) {
    let parentElement = document.getElementById("guarda_config");
    parentElement.disabled = true;
    parentElement.innerHTML ="Un moment, actualitzant dades ...";
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/" + ";SameSite=Strict";
}
