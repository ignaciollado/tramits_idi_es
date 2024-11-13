window.addEventListener('load', (event) => {
    let intervaloActualizacion = (document.getElementById("updateInterval").value/4 * 60 * 1000)/10;
    if (intervaloActualizacion === 0) {
        intervaloActualizacion = 60000
    }
    intervaloActualizacion = 6000
    const googleId = document.querySelector(".unreadMails").id;

    getUnreadMessages(googleId)

/*     totalSolicitudesConvocatoria(2024) */

    //convo
    let totalRequest = 0
    
    // Harcodeo todo lo que sigue por falta de tiempo. Cuando pueda, tengo que refactorizar.  (02/12/2021)

    /* convo 2020 */
/*     totalSolicitudesConvocatoria('2020')
    totalSolicitudesPrograma('2020', 'Programa iDigital 20')
    importeTotalConcedidoPrograma('2020', 'Programa iDigital 20') */

    /* ILS */
    totalSolicitudesLineaMultiConvo("\'ILS\'")
    /* ISBA */
    totalSolicitudesLineaMultiConvo("\'ADR-ISBA\'")

    /* convo 2021 */
    totalSolicitudesConvocatoria('2021')

    importeTotalConcedidoPrograma('2021', 'Programa I')
    importeTotalConcedidoPrograma('2021', 'Programa II')
    importeTotalConcedidoPrograma('2021', 'Programa III')

    totalSolicitudesPorSituacion('2021', 'Programa I', 'nohapasadoREC', 'totalSolicitudesINoREC_2021')
    totalSolicitudesPorSituacion('2021', 'Programa II', 'nohapasadoREC', 'totalSolicitudesIINoREC_2021')
    totalSolicitudesPorSituacion('2021', 'Programa III', 'nohapasadoREC', 'totalSolicitudesIIINoREC_2021')

    totalSolicitudesPorSituacion('2021', 'Programa I', 'Finalizado', 'totalSolicitudesFinalizadasI_2021')
    totalSolicitudesPorSituacion('2021', 'Programa II', 'Finalizado', 'totalSolicitudesFinalizadasII_2021')
    totalSolicitudesPorSituacion('2021', 'Programa III', 'Finalizado', 'totalSolicitudesFinalizadasIII_2021')

    /* convo 2022 */
    totalSolicitudesConvocatoria('2022')

    importeTotalConcedidoPrograma('2022', 'Programa I')
    importeTotalConcedidoPrograma('2022', 'Programa II')
    importeTotalConcedidoPrograma('2022', 'Programa III')

    totalSolicitudesPorSituacion('2022', 'Programa I', 'nohapasadoREC', 'totalSolicitudesINoREC_2022')
    totalSolicitudesPorSituacion('2022', 'Programa II', 'nohapasadoREC', 'totalSolicitudesIINoREC_2022')
    totalSolicitudesPorSituacion('2022', 'Programa III', 'nohapasadoREC', 'totalSolicitudesIIINoREC_2022')

    totalSolicitudesPorSituacion('2022', 'Programa I', 'Finalizado', 'totalSolicitudesFinalizadasI_2022')
    totalSolicitudesPorSituacion('2022', 'Programa II', 'Finalizado', 'totalSolicitudesFinalizadasII_2022')
    totalSolicitudesPorSituacion('2022', 'Programa III', 'Finalizado', 'totalSolicitudesFinalizadasIII_2022')
  
    /* convo 2023 */
    totalSolicitudesConvocatoria('2023')

    importeTotalConcedidoPrograma('2023', 'Programa I')
    importeTotalConcedidoPrograma('2023', 'Programa II')
    importeTotalConcedidoPrograma('2023', 'Programa III')

    totalSolicitudesPorSituacion('2023', 'Programa I', 'nohapasadoREC', 'totalSolicitudesINoREC_2023')
    totalSolicitudesPorSituacion('2023', 'Programa II', 'nohapasadoREC', 'totalSolicitudesIINoREC_2023')
    totalSolicitudesPorSituacion('2023', 'Programa III', 'nohapasadoREC', 'totalSolicitudesIIINoREC_2023')

    totalSolicitudesPorSituacion('2023', 'Programa I', 'Finalizado', 'totalSolicitudesFinalizadasI_2023')
    totalSolicitudesPorSituacion('2023', 'Programa II', 'Finalizado', 'totalSolicitudesFinalizadasII_2023')
    totalSolicitudesPorSituacion('2023', 'Programa III', 'Finalizado', 'totalSolicitudesFinalizadasIII_2023')

    /* convo 2024 */
    totalSolicitudesConvocatoria('2024')

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

    totalSolicitudesPorSituacion('2024', 'Programa I', 'Finalizado', 'totalSolicitudesFinalizadasI_2024')
    totalSolicitudesPorSituacion('2024', 'Programa II', 'Finalizado', 'totalSolicitudesFinalizadasII_2024')
    totalSolicitudesPorSituacion('2024', 'Programa III actuacions corporatives', 'Finalizadas', 'totalSolicitudesFinalizadasIII_org_2024')
    totalSolicitudesPorSituacion('2024', 'Programa III actuacions producte', 'Finalizadas', 'totalSolicitudesFinalizadasIII_prod_2024')
    totalSolicitudesPorSituacion('2024', 'Programa IV', 'Finalizado', 'totalSolicitudesFinalizadasIV_2024')
});

async function totalSolicitudesConvocatoria(convo) {
    let resultadoP;
	let recurso = '/public/assets/utils/totalSolicitudesPorConvocatoria.php?convocatoria="'+convo+'"'
    resultadoP = document.getElementById('totalSolicitudesXecs'+convo)
    await fetch(recurso).then(totalRequests => totalRequests.json()).then((totalRequests) => {
        resultadoP.innerText = totalRequests
        resultadoP.title = "Total sol·licituds: "+ totalRequests
    })
}

async function totalSolicitudesLineaMultiConvo(tipoTramite) {
    let resultadoP;
    switch (tipoTramite) {
        case "\'ILS\'":
            resultadoP = document.getElementById('totalSolicitudesILS')
            break;
        case "\'ADR-ISBA\'":
            resultadoP = document.getElementById('totalSolicitudesISBA')
            break;
    }
	let recurso = "/public/assets/utils/totalSolicitudesLineaMultiConvo.php?tipo_tramite='"+tipoTramite+"'"

    await fetch(recurso).then(totalRequests => totalRequests.json()).then((totalRequests) => {
        resultadoP.innerText = totalRequests
        resultadoP.title = "Total sol·licituds: "+ totalRequests
    })
}

async function totalSolicitudesPrograma(convo, stage) {
    let resultadoP;
	let recurso = '/public/assets/utils/numSolicitudesTerminadasPrograma.php?convocatoria="'+ convo + '"/tipo_tramite="' + stage +'"'
	const totalSolicitudes = await fetch(recurso).then(res => res.json())
    if (stage == 'Programa iDigital 20') {resultadoP = document.getElementById("totaliDigital_"+convo)}
    if (stage == 'Programa I') {resultadoP = document.getElementById("totalSolicitudesI_"+convo)}
    if (stage == 'Programa II') {resultadoP = document.getElementById("totalSolicitudesII_"+convo)}
    if (stage == 'Programa III') {resultadoP = document.getElementById("totalSolicitudesIII_"+convo)}
    if (stage == 'Programa III actuacions corporatives') {resultadoP = document.getElementById("totalSolicitudesIII_org_"+convo)}
    if (stage == 'Programa III actuacions producte') {resultadoP = document.getElementById("totalSolicitudesIII_prod_"+convo)}
    if (stage == 'Programa IV') {resultadoP = document.getElementById("totalSolicitudesIV_"+convo)}
    if (stage == 'ILS')  {resultadoP = document.getElementById("totalSolicitudesILSAdheridas")}
    resultadoP.innerHTML = "Finalitzades: "+ totalSolicitudes;
}

async function importeTotalConcedidoPrograma(convo, stage) {
    let resultadoP
	let recurso = '/public/assets/utils/importeTotalConcedidoPrograma.php?convocatoria="'+ convo + '"/tipo_tramite="' + stage +'"'
	const importeConcedido = await fetch(recurso).then(res => res.json())
    if (stage == 'Programa iDigital 20') {resultadoP = document.getElementById("importeConcedidoiDigital_"+convo)}
    if (stage == 'Programa I')  { resultadoP = document.getElementById("importeConcedidoI_"+convo)}
    if (stage == 'Programa II')  { resultadoP = document.getElementById("importeConcedidoII_"+convo)}
    if (stage == 'Programa III')  { resultadoP = document.getElementById("importeConcedidoIII_"+convo)}
    if (stage == 'Programa III actuacions corporatives') { resultadoP = document.getElementById("importeConcedidoIII_org_"+convo)}
    if (stage == 'Programa III actuacions producte') { resultadoP = document.getElementById("importeConcedidoIII_prod_"+convo)}
    if (stage == 'Programa IV') { resultadoP = document.getElementById("importeConcedidoIV_"+convo)}
    resultadoP.innerHTML = "Import concedit: "+ new Intl.NumberFormat().format(importeConcedido) + " €";
}

async function totalSolicitudesPorSituacion(convo, stage, situacion, elementID) {
    let resultadoP
	let recurso = '/public/assets/utils/totalSolicitudesPorSituacion.php?convocatoria="' + convo + '"/tipo_tramite="' + stage + '"/situacion="' + situacion +'"';
	const totalSolicitudes = await fetch(recurso).then(res => res.json());
    
    if (situacion == 'nohapasadoREC') {
        situacion = 'No han passat SEU: <strong>' + new Intl.NumberFormat().format(totalSolicitudes) + '</strong>'
    }
    if (situacion == 'pendienteJustificar') {
        situacion = 'Pendents de justificar: <strong>' + new Intl.NumberFormat().format(totalSolicitudes) + '</strong>'
    }
    if (situacion == 'inicioConsultoria') {
        situacion = ' Inici consultoria: <strong>' + new Intl.NumberFormat().format(totalSolicitudes) + '</strong>'
    }
    if (situacion == 'Denegado') {
        situacion = 'Denegades: <strong>' + new Intl.NumberFormat().format(totalSolicitudes) + '</strong>'
    }
    if (situacion == 'empresaDenegada') {
        situacion = 'Adhesió denegada: <strong>' + new Intl.NumberFormat().format(totalSolicitudes) + '</strong>'
    }
    if (situacion == 'Finalizado') {
        situacion = 'Finalitzades: <strong>' + new Intl.NumberFormat().format(totalSolicitudes) + '</strong>'
    }
    if (situacion == 'empresaAdherida') {
        situacion = 'Adherides: <strong>' + new Intl.NumberFormat().format(totalSolicitudes) + '</strong>'
    }
    if (situacion == 'Justificado') {
        situacion = 'Justificades: <strong>' + new Intl.NumberFormat().format(totalSolicitudes) + '</strong>'
    }

    if (stage == 'Programa iDigital 20') {resultadoP = document.getElementById("totalSolicitudesiDigital2020Pendientes")}
    if (stage == 'Programa I') {resultadoP = document.getElementById(elementID)}
    if (stage == 'Programa II') {resultadoP = document.getElementById(elementID)}
    if (stage == 'Programa III') {resultadoP = document.getElementById(elementID)}
    if (stage == 'Programa III actuacions corporatives') {resultadoP = document.getElementById(elementID)}
    if (stage == 'Programa III actuacions producte') {resultadoP = document.getElementById(elementID)}
    if (stage == 'Programa IV') {resultadoP = document.getElementById(elementID)}
    if (stage == 'ILS') {resultadoP = document.getElementById(elementID)}
    resultadoP.innerHTML = situacion
}