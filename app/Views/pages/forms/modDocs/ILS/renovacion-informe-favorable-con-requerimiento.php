<!-- -------------------------------------- Renovación informe favorable con requerimiento DOC 11-->
<div class="card-itramits">
  	<div class="card-itramits-body">
    	Informe favorable amb requeriment
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
			<button id="btnRenInformeFavorableconReqILS" class='btn btn-primary btn-acto-admin' onclick="generaRenovacionInformeFavorableConReqILS(<?php echo $id;?>, '<?php echo $convocatoria;?>', '<?php echo $programa;?>', '<?php echo $nifcif;?>')">Generar l'informe</button>
			<div id='infoMissingDataDoc11ILS' class="alert alert-danger ocultar btn-acto-admin"></div>
		<?php }?>
	</div>

	<div class="card-itramits-footer">
			<?php
			$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'],'doc_renovacion_informe_favorable_con_req_ils.pdf');
			if (isset($tieneDocumentosGenerados)) {
				$PublicAccessId = $tieneDocumentosGenerados->publicAccessId;
				$requestPublicAccessId = $PublicAccessId;
				$request = execute("requests/" . $requestPublicAccessId, null, __FUNCTION__);
				$respuesta = json_decode($request, true);
				$estado_firma = $respuesta['status'];
				switch ($estado_firma) {
					case 'NOT_STARTED':
					$estado_firma = "<div class='btn btn-info btn-acto-admin'><i class='fa fa-info-circle'></i>Pendent de signar</div>";				
					break;
					case 'REJECTED':
					$estado_firma = "<a href=".base_url('public/index.php/expedientes/muestrasolicitudrechazada/'.$requestPublicAccessId)."><div class = 'btn btn-warning btn-acto-admin'><i class='fa fa-warning'></i>Signatura rebutjada</div>";
					$estado_firma .= "</a>";				
					break;
					case 'COMPLETED':
					$estado_firma = "<a href=".base_url('public/index.php/expedientes/muestrasolicitudfirmada/'.$requestPublicAccessId)." ><div class='btn btn-success btn-acto-admin'><i class='fa fa-check'></i>Signat</div>";		
					$estado_firma .= "</a>";					
					break;
					case 'IN_PROCESS':
					$estado_firma = "<a href=".base_url('public/index.php/expedientes/muestrasolicitudfirmada/'.$requestPublicAccessId)." ><div class='btn btn-secondary btn-acto-admin'><i class='fa fa-check'></i>En curs</div>";		
					$estado_firma .= "</a>";						
					default:
					$estado_firma = "<div class='btn btn-danger btn-acto-admin'><i class='fa fa-info-circle'></i>Desconegut</div>";
					}
				echo $estado_firma;
			}	?>
  </div>
</div>
<!------------------------------------------------------------------------------------------------------>
<script>
	function generaRenovacionInformeFavorableConReqILS (id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_notificacion_resolucion = document.getElementById('fecha_notificacion_resolucion')
		let fecha_resolucion_renov = document.getElementById('fecha_resolucion_renov')
		let fecha_REC_justificacion_renov = document.getElementById('fecha_REC_justificacion_renov')
		let ref_REC_justificacion_renov = document.getElementById('ref_REC_justificacion_renov')
		let fecha_firma_req_renov = document.getElementById('fecha_firma_req_renov')
		let fecha_notif_req_renov = document.getElementById('fecha_notif_req_renov')

		let btnRenInformeFavorableconReqILS = document.getElementById('btnRenInformeFavorableconReqILS')
		let infoMissingDataDoc11ILS = document.getElementById('infoMissingDataDoc11ILS')
		infoMissingDataDoc11ILS.innerText = ""

		if(!fecha_notificacion_resolucion.value) {
			infoMissingDataDoc11ILS.innerHTML = infoMissingDataDoc10ILS.innerHTML + "Notificació resolució concessió<br>"
			todoBien = false
		}
		if(!fecha_firma_req_renov.value) {
			infoMissingDataDoc11ILS.innerHTML = infoMissingDataDoc11ILS.innerHTML + "Data firma requeriment<br>"
			todoBien = false
		}
		if(!fecha_notif_req_renov.value) {
			infoMissingDataDoc11ILS.innerHTML = infoMissingDataDoc11ILS.innerHTML + "Data notificació requeriment<br>"
			todoBien = false
		}
		if(!fecha_REC_justificacion_renov.value) {
			infoMissingDataDoc11ILS.innerHTML = infoMissingDataDoc11ILS.innerHTML + "Data REC justificació renovació<br>"
			todoBien = false
		}
		if(!ref_REC_justificacion_renov.value) {
			infoMissingDataDoc11ILS.innerHTML = infoMissingDataDoc11ILS.innerHTML + "Referència REC justificació<br>"
			todoBien = false
		}
/* 		if(!fecha_resolucion_renov.value) {
			infoMissingDataDoc11ILS.innerHTML = infoMissingDataDoc11ILS.innerHTML + "Resolució de renovació<br>"
			todoBien = false
		} */
		
		if (todoBien) {
			infoMissingDataDoc11ILS.classList.add('ocultar')
			btnRenInformeFavorableconReqILS.disabled = true
			btnRenInformeFavorableconReqILS.innerHTML = "Generant i enviant ..."
			window.location.href = base_url_ils+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_renovacion_informe_favorable_con_req_ils'
		} else {
			infoMissingDataDoc11ILS.classList.remove('ocultar')
		}
	}
</script>