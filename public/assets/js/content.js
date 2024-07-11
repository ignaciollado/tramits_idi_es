window.addEventListener('load', (event) => {
    let intervaloActualizacion = (document.getElementById("updateInterval").value/4 * 60 * 1000)/10;
    if (intervaloActualizacion === 0) {
        intervaloActualizacion = 60000
    }
    intervaloActualizacion = 6000
    const googleId = document.querySelector(".unreadMails").id;

    getUnreadMessages(googleId)

    totalSolicitudesConvocatoria(2024)

    // Harcodeo todo lo que sigue por falta de tiempo. Cuando pueda, tengo que refactorizar.  (02/12/2021)

    //convo 2020
    totalSolicitudesPrograma('2020', 'Programa iDigital 20');
    importeTotalSolicitadoPrograma('2020', 'Programa iDigital 20');
    importeTotalConcedidoPrograma('2020', 'Programa iDigital 20'); 
    
    //convo 2021   
    totalSolicitudesPrograma('2021', 'Programa I');
    totalSolicitudesPrograma('2021', 'Programa II');
    totalSolicitudesPrograma('2021', 'Programa III');

    importeTotalConcedidoPrograma('2021', 'Programa I'); 
    importeTotalConcedidoPrograma('2021', 'Programa II'); 
    importeTotalConcedidoPrograma('2021', 'Programa III');

    totalSolicitudesPorSituacion('2021', 'Programa I', 'nohapasadoREC', 'totalSolicitudesINoREC_2021');
    totalSolicitudesPorSituacion('2021', 'Programa II', 'nohapasadoREC', 'totalSolicitudesIINoREC_2021');
    totalSolicitudesPorSituacion('2021', 'Programa III', 'nohapasadoREC', 'totalSolicitudesIIINoREC_2021');

    //convo 2022
    totalSolicitudesPrograma('2022', 'Programa I')
    totalSolicitudesPrograma('2022', 'Programa II')
    totalSolicitudesPrograma('2022', 'Programa III')

    importeTotalConcedidoPrograma('2022', 'Programa I')
    importeTotalConcedidoPrograma('2022', 'Programa II')
    importeTotalConcedidoPrograma('2022', 'Programa III')

    totalSolicitudesPorSituacion('2022', 'Programa I', 'nohapasadoREC', 'totalSolicitudesINoREC_2022')
    totalSolicitudesPorSituacion('2022', 'Programa II', 'nohapasadoREC', 'totalSolicitudesIINoREC_2022')
    totalSolicitudesPorSituacion('2022', 'Programa III', 'nohapasadoREC', 'totalSolicitudesIIINoREC_2022')
    totalSolicitudesPorSituacion('2022', 'ILS', 'nohapasadoREC', 'totalSolicitudesILSNoREC_2022')

    //convo 2023
    totalSolicitudesPrograma('2023', 'Programa I');
    totalSolicitudesPrograma('2023', 'Programa II');
    totalSolicitudesPrograma('2023', 'Programa III');

    importeTotalConcedidoPrograma('2023', 'Programa I')
    importeTotalConcedidoPrograma('2023', 'Programa II')
    importeTotalConcedidoPrograma('2023', 'Programa III')

    totalSolicitudesPorSituacion('2023', 'Programa I', 'nohapasadoREC', 'totalSolicitudesINoREC_2023')
    totalSolicitudesPorSituacion('2023', 'Programa II', 'nohapasadoREC', 'totalSolicitudesIINoREC_2023')
    totalSolicitudesPorSituacion('2023', 'Programa III', 'nohapasadoREC', 'totalSolicitudesIIINoREC_2023')


    //convo 2024
    totalSolicitudesPrograma('2024', 'Programa I')
    totalSolicitudesPrograma('2024', 'Programa II')
    totalSolicitudesPrograma('2024', 'Programa III actuacions corporatives')
    totalSolicitudesPrograma('2024', 'Programa III actuacions producte')
    totalSolicitudesPrograma('2024', 'Programa IV')

    importeTotalConcedidoPrograma('2024', 'Programa I')
    importeTotalConcedidoPrograma('2024', 'Programa II')
    importeTotalConcedidoPrograma('2024', 'Programa III actuacions corporatives')
    importeTotalConcedidoPrograma('2024', 'Programa III actuacions producte')
    importeTotalConcedidoPrograma('2024', 'Programa IV')

    totalSolicitudesPorSituacion('2024', 'Programa I', 'nohapasadoREC', 'totalSolicitudesINoREC_2024')
    totalSolicitudesPorSituacion('2024', 'Programa II', 'nohapasadoREC', 'totalSolicitudesIINoREC_2024')
    totalSolicitudesPorSituacion('2024', 'Programa III actuacions corporatives', 'nohapasadoREC', 'totalSolicitudesIIINoREC_org_2024')
    totalSolicitudesPorSituacion('2024', 'Programa III actuacions producte', 'nohapasadoREC', 'totalSolicitudesIIINoREC_prod_2024')
    totalSolicitudesPorSituacion('2024', 'Programa IV', 'nohapasadoREC', 'totalSolicitudesIVNoREC_2024')

    totalSolicitudesPorSituacion('2024', 'Programa I', 'pendienteJustificar', 'totalPendienteI_2024')
    totalSolicitudesPorSituacion('2024', 'Programa II', 'pendienteJustificar', 'totalPendienteII_2024')
    totalSolicitudesPorSituacion('2024', 'Programa III actuacions corporatives', 'pendienteJustificar', 'totalPendienteIII_org_2024')
    totalSolicitudesPorSituacion('2024', 'Programa III actuacions producte', 'pendienteJustificar', 'totalPendienteIII_prod_2024')
    totalSolicitudesPorSituacion('2024', 'Programa IV', 'pendienteJustificar', 'totalPendienteIV_2024')

    totalSolicitudesPorSituacion('2024', 'Programa I', 'inicioConsultoria', 'totalInicioConsultoriaI_2024')
    totalSolicitudesPorSituacion('2024', 'Programa II', 'inicioConsultoria', 'totalInicioConsultoriaII_2024')
    totalSolicitudesPorSituacion('2024', 'Programa III actuacions corporatives', 'inicioConsultoria', 'totalInicioConsultoriaIII_org_2024')
    totalSolicitudesPorSituacion('2024', 'Programa III actuacions producte', 'inicioConsultoria', 'totalInicioConsultoriaIII_prod_2024')
    totalSolicitudesPorSituacion('2024', 'Programa IV', 'inicioConsultoria', 'totalInicioConsultoriaIV_2024')
});

async function totalSolicitudesConvocatoria(convo) {
    let totalHTMLElement = document.getElementById("totalSolicitudes"+convo)
    let recurso = `/public/assets/utils/totalSolicitudesPorConvocatoria.php?convocatoria=${convo}`
    const totalSolicitudesConvo = await fetch(recurso).json(res => res.json())
    console.log ("total solicitudes:",totalSolicitudesConvo)
    totalHTMLElement.innerHTML = "Total sol·licituds: " + totalSolicitudesConvo
}

async function totalSolicitudesPrograma(convo, stage) {
    let resultadoP;
	let recurso = '/public/assets/utils/numSolicitudesPrograma.php?convocatoria="'+ convo + '"/tipo_tramite="' + stage +'"'
	const totalSolicitudes = await fetch(recurso).then(res => res.json())
    if (stage == 'Programa iDigital 20') { resultadoP = document.getElementById("totaliDigital2020"); }
    if (stage == 'Programa I') {resultadoP = document.getElementById("totalSolicitudesI_"+convo)}
    if (stage == 'Programa II') {resultadoP = document.getElementById("totalSolicitudesII_"+convo)}
    if (stage == 'Programa III') {resultadoP = document.getElementById("totalSolicitudesIII_"+convo)}
    if (stage == 'Programa III actuacions corporatives') {resultadoP = document.getElementById("totalSolicitudesIII_org_"+convo)}
    if (stage == 'Programa III actuacions producte') {resultadoP = document.getElementById("totalSolicitudesIII_prod_"+convo)}
    if (stage == 'Programa IV') {resultadoP = document.getElementById("totalSolicitudesIV_"+convo)}
    if (stage == 'ILS')  { resultadoP = document.getElementById("totalSolicitudesILSAdheridas"); }
    resultadoP.innerHTML = "Aprovades: "+ totalSolicitudes;

}

async function importeTotalSolicitadoPrograma(convo, stage) {
    let resultadoP;
	let recurso = '/public/assets/utils/importeTotalSolicitadoPrograma.php?convocatoria="'+ convo + '"/tipo_tramite="' + stage +'"';
	const importeSolicitado = await fetch(recurso).then(res => res.json());
    //if (stage == 'Programa iDigital 20')  { resultadoP = document.getElementById("importeTotaliDigital2020"); }
    if (stage == 'Programa I')  { resultadoP = document.getElementById("importeTotalI_"+convo); }
    if (stage == 'Programa II')  { resultadoP = document.getElementById("importeTotalII_"+convo); }
    if (stage == 'Programa III')  { resultadoP = document.getElementById("importeTotalIII_"+convo); }
    if (stage == 'Programa III actuacions corporatives') { resultadoP = document.getElementById("importeTotalIII_org_"+convo); }
    if (stage == 'Programa III actuacions producte') { resultadoP = document.getElementById("importeTotalIII_prod_"+convo); }
    if (stage == 'Programa IV') { resultadoP = document.getElementById("importeTotalIV_"+convo); }
    resultadoP.innerHTML = "Import total sol·licitat: "+ new Intl.NumberFormat().format(importeSolicitado) + " €";
}

async function importeTotalConcedidoPrograma(convo, stage) {
    let resultadoP;
	let recurso = '/public/assets/utils/importeTotalConcedidoPrograma.php?convocatoria="'+ convo + '"/tipo_tramite="' + stage +'"';
	const importeConcedido = await fetch(recurso).then(res => res.json())
    //if (stage == 'Programa iDigital 20')  { resultadoP = document.getElementById("importeConcedidoiDigital2020"); }
    if (stage == 'Programa I')  { resultadoP = document.getElementById("importeConcedidoI_"+convo); }
    if (stage == 'Programa II')  { resultadoP = document.getElementById("importeConcedidoII_"+convo); }
    if (stage == 'Programa III')  { resultadoP = document.getElementById("importeConcedidoIII_"+convo); }
    if (stage == 'Programa III actuacions corporatives') { resultadoP = document.getElementById("importeConcedidoIII_org_"+convo); }
    if (stage == 'Programa III actuacions producte') { resultadoP = document.getElementById("importeConcedidoIII_prod_"+convo); }
    if (stage == 'Programa IV') { resultadoP = document.getElementById("importeConcedidoIV_"+convo); }
    resultadoP.innerHTML = "Import concedit: "+ new Intl.NumberFormat().format(importeConcedido) + " €";
}

async function totalSolicitudesPorSituacion(convo, stage, situacion, elementID) {
    let resultadoP;
	let recurso = '/public/assets/utils/totalSolicitudesPorSituacion.php?convocatoria="' + convo + '"/tipo_tramite="' + stage + '"/situacion="' + situacion +'"';
	const totalSolicitudes = await fetch(recurso).then(res => res.json());
    
    if (situacion == 'nohapasadoREC') {
        situacion = 'No han passat SEU: <strong>' + new Intl.NumberFormat().format(totalSolicitudes) + '</strong>'
    }
    if (situacion == 'pendienteJustificar') {
        situacion = 'Pendents de justificar: <strong>' + new Intl.NumberFormat().format(totalSolicitudes) + '</strong>'
    }
    if (situacion == 'inicioConsultoria') {
        situacion = ' Inici consultoria: <strong>' + new Intl.NumberFormat().format(totalSolicitudes) + '</strong>';
    }
    if (situacion == 'Denegado') {
        situacion = ' <strong>' + new Intl.NumberFormat().format(totalSolicitudes) + '</strong> sol·licituds DENEGADES'
    }
    if (situacion == 'empresaDenegada') {
        situacion = ' <strong>' + new Intl.NumberFormat().format(totalSolicitudes) + '</strong> sol·licituds DENEGADES'
    }
    if (situacion == 'Finalizado') {
        situacion = ' <strong>' + new Intl.NumberFormat().format(totalSolicitudes) + '</strong> sol·licituds FINALITZADES'
    }
    if (situacion == 'empresaAdherida') {
        situacion = ' <strong>' + new Intl.NumberFormat().format(totalSolicitudes) + '</strong> empreses ADHERIDES'
    }
    if (situacion == 'Justificado') {
        situacion = ' <strong>' + new Intl.NumberFormat().format(totalSolicitudes) + '</strong> sol·licituds JUSTIFICADES'
    }

    if (stage == 'Programa iDigital 20')  { resultadoP = document.getElementById("totalSolicitudesiDigital2020Pendientes"); }
    if (stage == 'Programa I')  { resultadoP = document.getElementById(elementID); }
    if (stage == 'Programa II')  { resultadoP = document.getElementById(elementID); }
    if (stage == 'Programa III')  { resultadoP = document.getElementById(elementID); }
    if (stage == 'Programa III actuacions corporatives')  { resultadoP = document.getElementById(elementID); }
    if (stage == 'Programa III actuacions producte')  { resultadoP = document.getElementById(elementID); }
    if (stage == 'Programa IV')  { resultadoP = document.getElementById(elementID); }

    if (stage == 'ILS')  { resultadoP = document.getElementById(elementID); }
    resultadoP.innerHTML = situacion;

}