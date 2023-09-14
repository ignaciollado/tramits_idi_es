window.addEventListener('load', (event) => {
    let intervaloActualizacion = (document.getElementById("updateInterval").value/4 * 60 * 1000)/10;
    if (intervaloActualizacion === 0) {
        intervaloActualizacion = 60000
    }
    intervaloActualizacion = intervaloActualizacion / 10
    const googleId = document.querySelector(".unreadMails").id;

    setInterval(function(){ getUnreadMessages(googleId); }, intervaloActualizacion);

    // Harcodeo todo lo que sigue por falta de tiempo. Cuando pueda, tengo que refactorizar.  (02/12/2021)

    listPrograma('2020', 'Programa iDigital 20');

    listPrograma('2021', 'Programa I');
    listPrograma('2021', 'Programa II');
    listPrograma('2021', 'Programa III');

    listPrograma('2022', 'Programa I');
    listPrograma('2022', 'Programa II');
    listPrograma('2022', 'Programa III');

    listPrograma('2022', 'ILS');

    /* importeTotalSolicitadoPrograma('2022', 'Programa I');
    importeTotalSolicitadoPrograma('2022', 'Programa II');
    importeTotalSolicitadoPrograma('2022', 'Programa III');

    
    importeTotalConcedidoPrograma('2022', 'Programa I');
    importeTotalConcedidoPrograma('2022', 'Programa II');
    importeTotalConcedidoPrograma('2022', 'Programa III');

    totalSolicitudesPorSituacion('2022', 'Programa I', 'Finalizado', 'totalSolicitudesIFinalizadas_2021');
    totalSolicitudesPorSituacion('2022', 'Programa II', 'Finalizado', 'totalSolicitudesIIFinalizadas_2021');
    totalSolicitudesPorSituacion('2022', 'Programa III', 'Finalizado', 'totalSolicitudesIIIFinalizadas_2021');

    totalSolicitudesPorSituacion('2022', 'Programa I', 'Denegado', 'totalSolicitudesIDenegadas_2021');
    totalSolicitudesPorSituacion('2022', 'Programa II', 'Denegado', 'totalSolicitudesIIDenegadas_2021');
    totalSolicitudesPorSituacion('2022', 'Programa III', 'Denegado', 'totalSolicitudesIIIDenegadas_2021');

    totalSolicitudesPorSituacion('2022', 'Programa I', 'pendiente', 'totalSolicitudesIPendientes_2021');
    totalSolicitudesPorSituacion('2022', 'Programa II', 'pendiente', 'totalSolicitudesIIPendientes_2021');
    totalSolicitudesPorSituacion('2022', 'Programa III', 'pendiente', 'totalSolicitudesIIIPendientes_2021');

    totalSolicitudesPorSituacion('2022', 'Programa I', 'nohapasadoREC', 'totalSolicitudesINoREC_2021');
    totalSolicitudesPorSituacion('2022', 'Programa II', 'nohapasadoREC', 'totalSolicitudesIINoREC_2021');
    totalSolicitudesPorSituacion('2022', 'Programa III', 'nohapasadoREC', 'totalSolicitudesIIINoREC_2021');

    totalSolicitudesPorSituacion('2022', 'Programa I', 'Justificado', 'totalSolicitudesIJustificado_2021');
    totalSolicitudesPorSituacion('2022', 'Programa II', 'Justificado', 'totalSolicitudesIIJustificado_2021');
    totalSolicitudesPorSituacion('2022', 'Programa III', 'Justificado', 'totalSolicitudesIIIJustificado_2021'); */

    //convo 2020

    listPrograma('2020', 'Programa iDigital 20');
    importeTotalSolicitadoPrograma('2020', 'Programa iDigital 20');
    importeTotalConcedidoPrograma('2020', 'Programa iDigital 20'); 
    
    //convo 2021

    listPrograma('2021', 'Programa I');
    listPrograma('2021', 'Programa II');
    listPrograma('2021', 'Programa III');

    importeTotalSolicitadoPrograma('2021', 'Programa I'); 
    importeTotalSolicitadoPrograma('2021', 'Programa II'); 
    importeTotalSolicitadoPrograma('2021', 'Programa III');

    importeTotalConcedidoPrograma('2021', 'Programa I'); 
    importeTotalConcedidoPrograma('2021', 'Programa II'); 
    importeTotalConcedidoPrograma('2021', 'Programa III');


    totalSolicitudesPorSituacion('2021', 'Programa I', 'Finalizado', 'totalSolicitudesIFinalizadas_2021');
    totalSolicitudesPorSituacion('2021', 'Programa II', 'Finalizado', 'totalSolicitudesIIFinalizadas_2021');
    totalSolicitudesPorSituacion('2021', 'Programa III', 'Finalizado', 'totalSolicitudesIIIFinalizadas_2021');

    totalSolicitudesPorSituacion('2021', 'Programa I', 'Denegado', 'totalSolicitudesIDenegadas_2021');
    totalSolicitudesPorSituacion('2021', 'Programa II', 'Denegado', 'totalSolicitudesIIDenegadas_2021');
    totalSolicitudesPorSituacion('2021', 'Programa III', 'Denegado', 'totalSolicitudesIIIDenegadas_2021');

    totalSolicitudesPorSituacion('2021', 'Programa I', 'inicioConsultoria', 'totalSolicitudesIPendientes_2021');
    totalSolicitudesPorSituacion('2021', 'Programa II', 'inicioConsultoria', 'totalSolicitudesIIPendientes_2021');
    totalSolicitudesPorSituacion('2021', 'Programa III', 'inicioConsultoria', 'totalSolicitudesIIIPendientes_2021');

    totalSolicitudesPorSituacion('2021', 'Programa I', 'nohapasadoREC', 'totalSolicitudesINoREC_2021');
    totalSolicitudesPorSituacion('2021', 'Programa II', 'nohapasadoREC', 'totalSolicitudesIINoREC_2021');
    totalSolicitudesPorSituacion('2021', 'Programa III', 'nohapasadoREC', 'totalSolicitudesIIINoREC_2021');

    totalSolicitudesPorSituacion('2021', 'Programa I', 'Justificado', 'totalSolicitudesIJustificado_2021');
    totalSolicitudesPorSituacion('2021', 'Programa II', 'Justificado', 'totalSolicitudesIIJustificado_2021');
    totalSolicitudesPorSituacion('2021', 'Programa III', 'Justificado', 'totalSolicitudesIIIJustificado_2021');

    
    //convo 2022

    listPrograma('2022', 'Programa I');
    listPrograma('2022', 'Programa II');
    listPrograma('2022', 'Programa III');

    setInterval(function(){ listPrograma('2022', 'Programa I'); }, intervaloActualizacion);
    setInterval(function(){ listPrograma('2022', 'Programa II'); }, intervaloActualizacion);
    setInterval(function(){ listPrograma('2022', 'Programa III'); }, intervaloActualizacion);

    setInterval(function(){ importeTotalSolicitadoPrograma('2022', 'Programa I'); }, intervaloActualizacion);
    setInterval(function(){ importeTotalSolicitadoPrograma('2022', 'Programa II'); }, intervaloActualizacion);
    setInterval(function(){ importeTotalSolicitadoPrograma('2022', 'Programa III'); }, intervaloActualizacion);

    
    setInterval(function(){ importeTotalConcedidoPrograma('2022', 'Programa I'); }, intervaloActualizacion);
    setInterval(function(){ importeTotalConcedidoPrograma('2022', 'Programa II'); }, intervaloActualizacion);
    setInterval(function(){ importeTotalConcedidoPrograma('2022', 'Programa III'); }, intervaloActualizacion);

    setInterval(function(){ totalSolicitudesPorSituacion('2022', 'Programa I', 'Finalizado', 'totalSolicitudesIFinalizadas_2022'); }, intervaloActualizacion);
    setInterval(function(){ totalSolicitudesPorSituacion('2022', 'Programa II', 'Finalizado', 'totalSolicitudesIIFinalizadas_2022'); }, intervaloActualizacion);
    setInterval(function(){ totalSolicitudesPorSituacion('2022', 'Programa III', 'Finalizado', 'totalSolicitudesIIIFinalizadas_2022'); }, intervaloActualizacion);
    setInterval(function(){ totalSolicitudesPorSituacion('2022', 'ILS', 'empresaAdherida', 'totalSolicitudesILSAdheridas_2022'); }, intervaloActualizacion);

    setInterval(function(){ totalSolicitudesPorSituacion('2022', 'Programa I', 'Denegado', 'totalSolicitudesIDenegadas_2022'); }, intervaloActualizacion);
    setInterval(function(){ totalSolicitudesPorSituacion('2022', 'Programa II', 'Denegado', 'totalSolicitudesIIDenegadas_2022'); }, intervaloActualizacion);
    setInterval(function(){ totalSolicitudesPorSituacion('2022', 'Programa III', 'Denegado', 'totalSolicitudesIIIDenegadas_2022'); }, intervaloActualizacion);
    setInterval(function(){ totalSolicitudesPorSituacion('2022', 'ILS', 'empresaDenegada', 'totalSolicitudesILSDenegadas_2022'); }, intervaloActualizacion);


    setInterval(function(){ totalSolicitudesPorSituacion('2022', 'Programa I', 'inicioConsultoria', 'totalSolicitudesIPendientes_2022'); }, intervaloActualizacion);
    setInterval(function(){ totalSolicitudesPorSituacion('2022', 'Programa II', 'inicioConsultoria', 'totalSolicitudesIIPendientes_2022'); }, intervaloActualizacion);
    setInterval(function(){ totalSolicitudesPorSituacion('2022', 'Programa III', 'inicioConsultoria', 'totalSolicitudesIIIPendientes_2022'); }, intervaloActualizacion);
    setInterval(function(){ totalSolicitudesPorSituacion('2022', 'ILS', 'inicioConsultoria', 'totalSolicitudesILSPendientes_2022'); }, intervaloActualizacion);


    setInterval(function(){ totalSolicitudesPorSituacion('2022', 'Programa I', 'nohapasadoREC', 'totalSolicitudesINoREC_2022'); }, intervaloActualizacion);
    setInterval(function(){ totalSolicitudesPorSituacion('2022', 'Programa II', 'nohapasadoREC', 'totalSolicitudesIINoREC_2022'); }, intervaloActualizacion);
    setInterval(function(){ totalSolicitudesPorSituacion('2022', 'Programa III', 'nohapasadoREC', 'totalSolicitudesIIINoREC_2022'); }, intervaloActualizacion);
    setInterval(function(){ totalSolicitudesPorSituacion('2022', 'ILS', 'nohapasadoREC', 'totalSolicitudesILSNoREC_2022'); }, intervaloActualizacion);


    setInterval(function(){ totalSolicitudesPorSituacion('2022', 'Programa I', 'Justificado', 'totalSolicitudesIJustificado_2022'); }, intervaloActualizacion);
    setInterval(function(){ totalSolicitudesPorSituacion('2022', 'Programa II', 'Justificado', 'totalSolicitudesIIJustificado_2022'); }, intervaloActualizacion);
    setInterval(function(){ totalSolicitudesPorSituacion('2022', 'Programa III', 'Justificado', 'totalSolicitudesIIIJustificado_2022'); }, intervaloActualizacion);


    //convo 2023

    listPrograma('2023', 'Programa I');
    listPrograma('2023', 'Programa II');
    listPrograma('2023', 'Programa III');

    setInterval(function(){ listPrograma('2023', 'Programa I'); }, intervaloActualizacion);
    setInterval(function(){ listPrograma('2023', 'Programa II'); }, intervaloActualizacion);
    setInterval(function(){ listPrograma('2023', 'Programa III'); }, intervaloActualizacion);

    setInterval(function(){ importeTotalSolicitadoPrograma('2023', 'Programa I'); }, intervaloActualizacion);
    setInterval(function(){ importeTotalSolicitadoPrograma('2023', 'Programa II'); }, intervaloActualizacion);
    setInterval(function(){ importeTotalSolicitadoPrograma('2023', 'Programa III'); }, intervaloActualizacion);

    
    setInterval(function(){ importeTotalConcedidoPrograma('2023', 'Programa I'); }, intervaloActualizacion);
    setInterval(function(){ importeTotalConcedidoPrograma('2023', 'Programa II'); }, intervaloActualizacion);
    setInterval(function(){ importeTotalConcedidoPrograma('2023', 'Programa III'); }, intervaloActualizacion);

    setInterval(function(){ totalSolicitudesPorSituacion('2023', 'Programa I', 'Finalizado', 'totalSolicitudesIFinalizadas_2023'); }, intervaloActualizacion);
    setInterval(function(){ totalSolicitudesPorSituacion('2023', 'Programa II', 'Finalizado', 'totalSolicitudesIIFinalizadas_2023'); }, intervaloActualizacion);
    setInterval(function(){ totalSolicitudesPorSituacion('2023', 'Programa III', 'Finalizado', 'totalSolicitudesIIIFinalizadas_2023'); }, intervaloActualizacion);
    setInterval(function(){ totalSolicitudesPorSituacion('2023', 'ILS', 'empresaAdherida', 'totalSolicitudesILSAdheridas_2023'); }, intervaloActualizacion);

    setInterval(function(){ totalSolicitudesPorSituacion('2023', 'Programa I', 'Denegado', 'totalSolicitudesIDenegadas_2023'); }, intervaloActualizacion);
    setInterval(function(){ totalSolicitudesPorSituacion('2023', 'Programa II', 'Denegado', 'totalSolicitudesIIDenegadas_2023'); }, intervaloActualizacion);
    setInterval(function(){ totalSolicitudesPorSituacion('2023', 'Programa III', 'Denegado', 'totalSolicitudesIIIDenegadas_2023'); }, intervaloActualizacion);
    setInterval(function(){ totalSolicitudesPorSituacion('2023', 'ILS', 'empresaDenegada', 'totalSolicitudesILSDenegadas_2023'); }, intervaloActualizacion);


    setInterval(function(){ totalSolicitudesPorSituacion('2023', 'Programa I', 'inicioConsultoria', 'totalSolicitudesIPendientes_2023'); }, intervaloActualizacion);
    setInterval(function(){ totalSolicitudesPorSituacion('2023', 'Programa II', 'inicioConsultoria', 'totalSolicitudesIIPendientes_2023'); }, intervaloActualizacion);
    setInterval(function(){ totalSolicitudesPorSituacion('2023', 'Programa III', 'inicioConsultoria', 'totalSolicitudesIIIPendientes_2023'); }, intervaloActualizacion);
    setInterval(function(){ totalSolicitudesPorSituacion('2023', 'ILS', 'inicioConsultoria', 'totalSolicitudesILSPendientes_2023'); }, intervaloActualizacion);


    setInterval(function(){ totalSolicitudesPorSituacion('2023', 'Programa I', 'nohapasadoREC', 'totalSolicitudesINoREC_2023'); }, intervaloActualizacion);
    setInterval(function(){ totalSolicitudesPorSituacion('2023', 'Programa II', 'nohapasadoREC', 'totalSolicitudesIINoREC_2023'); }, intervaloActualizacion);
    setInterval(function(){ totalSolicitudesPorSituacion('2023', 'Programa III', 'nohapasadoREC', 'totalSolicitudesIIINoREC_2023'); }, intervaloActualizacion);
    setInterval(function(){ totalSolicitudesPorSituacion('2023', 'ILS', 'nohapasadoREC', 'totalSolicitudesILSNoREC_2023'); }, intervaloActualizacion);


    setInterval(function(){ totalSolicitudesPorSituacion('2023', 'Programa I', 'Justificado', 'totalSolicitudesIJustificado_2023'); }, intervaloActualizacion);
    setInterval(function(){ totalSolicitudesPorSituacion('2023', 'Programa II', 'Justificado', 'totalSolicitudesIIJustificado_2023'); }, intervaloActualizacion);
    setInterval(function(){ totalSolicitudesPorSituacion('2023', 'Programa III', 'Justificado', 'totalSolicitudesIIIJustificado_2023'); }, intervaloActualizacion);

   /*  setInterval(function(){ totalSolicitudesPorSituacion('2022', 'ILS', 'Justificado', 'totalSolicitudesILSJustificado_2022'); }, intervaloActualizacion); */

});

async function listPrograma(year, stage) {
    let resultadoP;
	let recurso = '/public/assets/utils/numSolicitudesPrograma.php?convocatoria="'+ year + '"/tipo_tramite="' + stage +'"';
	const totalSolicitudes = await fetch(recurso).then(res => res.json());
    console.log (`${year} ${stage} ${totalSolicitudes}`);
    if (stage == 'Programa iDigital 20')  { resultadoP = document.getElementById("totaliDigital2020"); }
    if (stage == 'Programa I')  { resultadoP = document.getElementById("totalSolicitudesI_"+year); }
    if (stage == 'Programa II')  { resultadoP = document.getElementById("totalSolicitudesII_"+year); }
    if (stage == 'Programa III')  { resultadoP = document.getElementById("totalSolicitudesIII_"+year); }
    if (stage == 'ILS')  { resultadoP = document.getElementById("totalSolicitudesILS_"+year); }

    resultadoP.innerHTML = "<code class='alert alert-info'>Num. sol·licituds: "+ totalSolicitudes + "</code>";
}

async function importeTotalSolicitadoPrograma(year, stage) {
    let resultadoP;
	let recurso = '/public/assets/utils/importeTotalSolicitadoPrograma.php?convocatoria="'+ year + '"/tipo_tramite="' + stage +'"';
	const importeSolicitado = await fetch(recurso).then(res => res.json());
    console.log(JSON.stringify(importeSolicitado));
    console.log ("Importe total solicitado: "+year+" "+stage+" "+importeSolicitado);
    if (stage == 'Programa iDigital 20')  { resultadoP = document.getElementById("importeTotaliDigital2020"); }
    if (stage == 'Programa I')  { resultadoP = document.getElementById("importeTotalI_"+year); }
    if (stage == 'Programa II')  { resultadoP = document.getElementById("importeTotalII_"+year); }
    if (stage == 'Programa III')  { resultadoP = document.getElementById("importeTotalIII_"+year); }
    resultadoP.innerHTML = "<code class='alert alert-info'>Import total sol·licitat: "+ new Intl.NumberFormat().format(importeSolicitado) + " €</code>";
}

async function importeTotalConcedidoPrograma(year, stage) {
    let resultadoP;
	let recurso = '/public/assets/utils/importeTotalConcedidoPrograma.php?convocatoria="'+ year + '"/tipo_tramite="' + stage +'"';
	const importeConcedido = await fetch(recurso).then(res => res.json());
    console.log ("Importe total concedido: "+year+" "+stage+" "+importeConcedido);
    if (stage == 'Programa iDigital 20')  { resultadoP = document.getElementById("importeConcedidoiDigital2020"); }
    if (stage == 'Programa I')  { resultadoP = document.getElementById("importeConcedidoI_"+year); }
    if (stage == 'Programa II')  { resultadoP = document.getElementById("importeConcedidoII_"+year); }
    if (stage == 'Programa III')  { resultadoP = document.getElementById("importeConcedidoIII_"+year); }
    resultadoP.innerHTML = "<code class='alert alert-info'>Import total concedit: "+ new Intl.NumberFormat().format(importeConcedido) + " €</code>";
}

async function totalSolicitudesPorSituacion(year, stage, situacion, elementID) {
    let resultadoP;
	let recurso = '/public/assets/utils/totalSolicitudesPorSituacion.php?convocatoria="' + year + '"/tipo_tramite="' + stage + '"/situacion="' + situacion +'"';
	const totalSolicitudes = await fetch(recurso).then(res => res.json());
    
    if (situacion == 'nohapasadoREC') {
        situacion = '<code class="alert solicitud"> <strong>' + new Intl.NumberFormat().format(totalSolicitudes) + '</strong> sol·licituds NO HAN PASSAT PEL REC</code>'
    }

    if (situacion == 'inicioConsultoria') {
        situacion = '<code class="alert solicitud"> <strong>' + new Intl.NumberFormat().format(totalSolicitudes) + '</strong> sol·licituds en INICI CONSULTORIA</code>';
    }

    if (situacion == 'Denegado') {
        situacion = '<code class="alert validacion"> <strong>' + new Intl.NumberFormat().format(totalSolicitudes) + '</strong> sol·licituds DENEGADES</code>'
    }

    if (situacion == 'empresaDenegada') {
        situacion = '<code class="alert validacion"> <strong>' + new Intl.NumberFormat().format(totalSolicitudes) + '</strong> sol·licituds DENEGADES</code>'
    }

    if (situacion == 'Finalizado') {
        situacion = '<code class="alert justificacion"> <strong>' + new Intl.NumberFormat().format(totalSolicitudes) + '</strong> sol·licituds FINALITZADES</code>'
    }

    if (situacion == 'empresaAdherida') {
        situacion = '<code class="alert justificacion"> <strong>' + new Intl.NumberFormat().format(totalSolicitudes) + '</strong> empreses ADHERIDES</code>'
    }


    if (situacion == 'Justificado') {
        situacion = '<code class="alert justificacion"> <strong>' + new Intl.NumberFormat().format(totalSolicitudes) + '</strong> sol·licituds JUSTIFICADES</code>'
    }

    console.log (`Total pendientes: ${year} ${stage} ${situacion} ${totalSolicitudes}`);
    if (stage == 'Programa iDigital 20')  { resultadoP = document.getElementById("totalSolicitudesiDigital2020Pendientes"); }
    if (stage == 'Programa I')  { resultadoP = document.getElementById(elementID); }
    if (stage == 'Programa II')  { resultadoP = document.getElementById(elementID); }
    if (stage == 'Programa III')  { resultadoP = document.getElementById(elementID); }
    if (stage == 'ILS')  { resultadoP = document.getElementById(elementID); }

    resultadoP.innerHTML = "<strong>" + situacion + "</strong>";

}