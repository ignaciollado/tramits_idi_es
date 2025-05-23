<!-----------------------------------------Resolució de pagament sense requeriment. DOC 11.-->
<div class="card-itramits">
  	<div class="card-itramits-body">
    	Resolució de pagament i justificació
			<?php
				if ($base_url === "pre-tramitsidi") {?>
					**testear** [PRE]
				<?php }?>
  	</div>
		<div class="card-itramits-footer">
  		<?php
      if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
      else {?>
			<button id="btnResPagoSinReq" class='btn btn-primary btn-acto-admin' onclick="generaResolucionPagoSinReq(<?php echo $id;?>, '<?php echo $convocatoria;?>', '<?php echo $programa;?>', '<?php echo $nifcif;?>')">Genera la resolució</button>
			<div id='infoMissingDataDoc11' class="alert alert-danger ocultar btn-acto-admin"></div>
		<?php }?>
	</div>
  	<div class="card-itramits-footer">
		<?php if ($expedientes['doc_res_pago_y_justificacion_adr_isba'] != 0) { ?>
			<?php
			$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'],'doc_res_pago_y_justificacion_adr_isba.pdf');
			if (isset($tieneDocumentosGenerados)) {
				$PublicAccessId = $tieneDocumentosGenerados->publicAccessId;
				$requestPublicAccessId = $PublicAccessId;
				$request = execute("requests/" . $requestPublicAccessId, null, __FUNCTION__);
				$respuesta = json_decode($request, true);
				$estado_firma = $respuesta['status'];
				switch ($estado_firma) {
					case 'NOT_STARTED':
						$estado_firma = "<div class='btn btn-info btn-acto-admin'><i class='fa fa-info-circle'></i> Pendent de signar</div>";
						break;
					case 'REJECTED':
						$estado_firma = "<a href=".base_url('public/index.php/expedientes/muestrasolicitudrechazada/'.$requestPublicAccessId)."><div class = 'btn btn-warning btn-acto-admin'><i class='fa fa-warning'></i> Signatura rebutjada</div>";
						$estado_firma .= "</a>";
						$estado_firma .= gmdate("d-m-Y", intval ($respuesta['rejectInfo']['rejectDate']/1000));
						break;
					case 'COMPLETED':
						$estado_firma = "<a href=".base_url('public/index.php/expedientes/muestrasolicitudfirmada/'.$requestPublicAccessId)." ><div class='btn btn-success btn-acto-admin'><i class='fa fa-check'></i> Signat</div>";
						$estado_firma .= "</a>";
						$estado_firma .= gmdate("d-m-Y", intval ($respuesta['endDate']/1000));
						break;
					case 'IN_PROCESS':
						$estado_firma = "<a href=".base_url('public/index.php/expedientes/muestrasolicitudfirmada/'.$requestPublicAccessId)." ><div class='btn btn-secondary btn-acto-admin'><i class='fa fa-check'></i> En curs</div>";
						$estado_firma .= "</a>";
						break;
					default:
						$estado_firma = "<div class='btn btn-danger btn-acto-admin'><i class='fa fa-info-circle'></i> Desconegut</div>";
					}
				echo $estado_firma;
				}	?>
				<?php } ?>
  	</div>
</div>
<!------------------------------------------------------------------------------------------------------>
<script>
	function generaResolucionPagoSinReq(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_not_propuesta_resolucion_prov = document.getElementById('fecha_not_propuesta_resolucion_prov')
		let fecha_firma_propuesta_resolucion_def = document.getElementById('fecha_firma_propuesta_resolucion_def')
    let fecha_firma_propuesta_resolucion_prov = document.getElementById('fecha_firma_propuesta_resolucion_prov')
	 	let fecha_not_propuesta_resolucion_def = document.getElementById('fecha_not_propuesta_resolucion_def') //0000-00-00
		let fecha_firma_res = document.getElementById('fecha_firma_res')
		let fecha_notificacion_resolucion = document.getElementById('fecha_notificacion_resolucion')
		let fecha_REC_justificacion = document.getElementById('fecha_REC_justificacion')
    let ref_REC_justificacion = document.getElementById('ref_REC_justificacion')
		let btnResPagoSinReq = document.getElementById('btnResPagoSinReq')
		let infoMissingDataDoc11 = document.getElementById('infoMissingDataDoc11')
		infoMissingDataDoc11.innerText = ""

		if(!fecha_not_propuesta_resolucion_prov.value) {
			infoMissingDataDoc11.innerHTML = infoMissingDataDoc11.innerHTML + "Notificació proposta resolució provisional<br>"
			todoBien = false
		}
		if(!fecha_firma_propuesta_resolucion_prov.value) {
			infoMissingDataDoc11.innerHTML = infoMissingDataDoc11.innerHTML + "Firma proposta resolució provisional<br>"
			todoBien = false
		}
		if(!fecha_firma_propuesta_resolucion_def.value) {
			infoMissingDataDoc11.innerHTML = infoMissingDataDoc11.innerHTML + "Firma proposta resolució definitiva<br>"
			todoBien = false
		}
	 	if(!fecha_not_propuesta_resolucion_def.value) {
			infoMissingDataDoc11.innerHTML = infoMissingDataDoc11.innerHTML + "Notificació proposta resolució definitiva<br>"
			todoBien = false
		}
		if(!fecha_firma_res.value) {
			infoMissingDataDoc11.innerHTML = infoMissingDataDoc11.innerHTML + "Firma resolució<br>"
			todoBien = false
		}

		if(!fecha_notificacion_resolucion.value) {
			infoMissingDataDoc11.innerHTML = infoMissingDataDoc11.innerHTML + "Notificació resolució<br>"
			todoBien = false
		}
	 	if(!fecha_REC_justificacion.value) {
			infoMissingDataDoc11.innerHTML = infoMissingDataDoc11.innerHTML + "Data SEU justificació<br>"
			todoBien = false
		}
		if(!ref_REC_justificacion.value) {
			infoMissingDataDoc11.innerHTML = infoMissingDataDoc11.innerHTML + "Referència SEU justificació<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDataDoc11.classList.add('ocultar')
			btnResPagoSinReq.disabled = true
			btnResPagoSinReq.innerHTML = "Generant i enviant ..."
			console.log (actualBaseUrl)
			window.location.href = base_url_isba + '/' + id + '/' + convocatoria + '/' + programa + '/' + nifcif + '/doc_res_pago_y_justificacion_adr_isba'
		} else {
			infoMissingDataDoc11.classList.remove('ocultar')
		}
	}
</script>