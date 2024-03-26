<!----------------------------------------- Proposta de resolució definitiva desfavorable sense requeriment DOC 14-->
<div class="card-itramits">
  <div class="card-itramits-body">
	Propuesta de resolución definitiva desfavorable sense requeriment <strong>¡¡¡¡¡[pre-tramits]!!!!!</strong>
  </div>
  <div class="card-itramits-footer">
  		<?php
      if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
      else {?>
			<button id="btnPropResDefDesfavConReq" class='btn btn-primary btn-acto-admin' onclick="generaPropResDefDesfConReq(<?php echo $id;?>, '<?php echo $convocatoria;?>', '<?php echo $programa;?>', '<?php echo $nifcif;?>')">Genera  la resolució</button>
			<div id='infoMissingDataDoc11' class="alert alert-danger ocultar btn-acto-admin"></div>
		<?php }?>
	</div>
  	<div class="card-itramits-footer">
			<?php
			$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'],'doc_prop_res_def_desfavorable_con_req.pdf');
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

	function generaPropResDefDesfConReq(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')
	 	let fecha_propuesta_resolucion = document.getElementById('fecha_propuesta_resolucion') //0000-00-00
		let fecha_propuesta_resolucion_notif = document.getElementById('fecha_propuesta_resolucion_notif')
		let btnPropResDefDesfavConReq = document.getElementById('btnPropResDefDesfavConReq')
		let base_url = 'https://pre-tramits.idi.es/public/index.php/expedientes/generaInforme'
		let infoMissingDataDoc11 = document.getElementById('infoMissingDataDoc11')
		infoMissingDataDoc11.innerText = ""

		if(!fecha_REC.value) {
			infoMissingDataDoc11.innerHTML = infoMissingDataDoc11.innerHTML + "Data REC sol·licitud<br>"
			todoBien = false
		}
		if(!ref_REC.value) {
			infoMissingDataDoc11.innerHTML = infoMissingDataDoc11.innerHTML + "Referència REC sol·licitud<br>"
			todoBien = false
		}
	 	if(!fecha_propuesta_resolucion.value) {
			infoMissingDataDoc11.innerHTML = infoMissingDataDoc11.innerHTML + "Data firma proposta resolució<br>"
			todoBien = false
		}
		if(!fecha_propuesta_resolucion_notif.value) {
			infoMissingDataDoc11.innerHTML = infoMissingDataDoc11.innerHTML + "Data notificació proposta resolució<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDataDoc11.classList.add('ocultar')
			btnPropResDefDesfavConReq.disabled = true
			btnPropResDefDesfavConReq.innerHTML = "Generant i enviant ..."
			window.location.href = base_url+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_prop_res_def_desfavorable_con_req'
		} else {
			infoMissingDataDoc11.classList.remove('ocultar')
		}
	}

</script>