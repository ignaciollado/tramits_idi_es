<!-----------------------------------------Resolució de pagament sense requeriment. DOC 24.-->
<div class="card-itramits">
  	<div class="card-itramits-body">
    	Resolució de pagament<br>sense requeriment<br>
  	</div>
		<div class="card-itramits-footer">
  		<?php
      if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
      else {?>
			<button id="btnResPagoSinReq" class='btn btn-primary btn-acto-admin' onclick="generaResolucionPagoSinReq(<?php echo $id;?>, '<?php echo $convocatoria;?>', '<?php echo $programa;?>', '<?php echo $nifcif;?>')">Genera la resolució</button>
			<div id='infoMissingDataDoc24' class="alert alert-danger ocultar btn-acto-admin"></div>
		<?php }?>
	</div>
  	<div class="card-itramits-footer">
			<?php
			$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'],'doc_res_pago_sin_req.pdf');
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

function generaResolucionPagoSinReq(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_not_propuesta_resolucion_prov = document.getElementById('fecha_not_propuesta_resolucion_prov')
		let fecha_firma_propuesta_resolucion_def = document.getElementById('fecha_firma_propuesta_resolucion_def')
    let fecha_firma_propuesta_resolucion_prov = document.getElementById('fecha_firma_propuesta_resolucion_prov')
	 	let fecha_not_propuesta_resolucion_def = document.getElementById('fecha_not_propuesta_resolucion_def') //0000-00-00
		let fecha_firma_res = document.getElementById('fecha_firma_res_pago_just')
		let fecha_REC_justificacion = document.getElementById('fecha_REC_justificacion')
		
		let btnResPagoSinReq = document.getElementById('btnResPagoSinReq')
		infoMissingDataDoc24.innerText = ""

		if(!fecha_not_propuesta_resolucion_prov.value) {
			infoMissingDataDoc24.innerHTML = infoMissingDataDoc24.innerHTML + "Data notificació proposta resolució provisional<br>"
			todoBien = false
		}
		if(!fecha_firma_propuesta_resolucion_def.value) {
			infoMissingDataDoc24.innerHTML = infoMissingDataDoc24.innerHTML + "Data firma proposta resolució definitiva<br>"
			todoBien = false
		}
		if(!fecha_firma_propuesta_resolucion_prov.value) {
			infoMissingDataDoc24.innerHTML = infoMissingDataDoc24.innerHTML + "Data firma proposta resolució provisional<br>"
			todoBien = false
		}
    
	 	if(!fecha_not_propuesta_resolucion_def.value) {
			infoMissingDataDoc24.innerHTML = infoMissingDataDoc24.innerHTML + "Data notificació proposta resolució definitiva<br>"
			todoBien = false
		}
		if(!fecha_firma_res.value) {
			infoMissingDataDoc24.innerHTML = infoMissingDataDoc24.innerHTML + "Firma resolució de pagament / justificació<br>"
			todoBien = false
		}
		if(!fecha_REC_justificacion.value) {
			infoMissingDataDoc24.innerHTML = infoMissingDataDoc24.innerHTML + "Data SEU justificació<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDataDoc24.classList.add('ocultar')
			btnResPagoSinReq.disabled = true
			btnResPagoSinReq.innerHTML = "Generant i enviant ..."
			window.location.href = base_url+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_res_pago_sin_req'
		} else {
			infoMissingDataDoc24.classList.remove('ocultar')
		}
	}

</script>