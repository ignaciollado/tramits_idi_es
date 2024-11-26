<!-- -------------------------------------- Renovacion resolución de renovación de marca con requerimiento DOC 14-->
<div class="card-itramits">
  	<div class="card-itramits-body">
     Resolució de renovació de marca amb requeriment 
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
				<button id="btnRenResolucionRenovacionMarcaConReqILS" class='btn btn-primary btn-acto-admin' onclick="generaRenovacionResolucionRenovacionConReqILS(<?php echo $id;?>, '<?php echo $convocatoria;?>', '<?php echo $programa;?>', '<?php echo $nifcif;?>')">Generar la resolució</button>
				<div id='infoMissingDataDoc14ILS' class="alert alert-danger ocultar btn-acto-admin"></div>					
		<?php }?>
	</div>
	<div class="card-itramits-footer">
		<?php
		$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'],'doc_renovacion_resolucion_renovacion_marca_con_req_ils.pdf');
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
	function generaRenovacionResolucionRenovacionConReqILS (id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_resolucion = document.getElementById('fecha_resolucion')
		let fecha_infor_fav_renov = document.getElementById('fecha_infor_fav_renov')
		let fecha_REC_justificacion_renov = document.getElementById('fecha_REC_justificacion_renov')
		let ref_REC_justificacion_renov = document.getElementById('ref_REC_justificacion_renov')

		let btnRenResolucionRenovacionMarcaConReqILS = document.getElementById('btnRenResolucionRenovacionMarcaConReqILS')
		let infoMissingDataDoc14ILS = document.getElementById('infoMissingDataDoc14ILS')
		infoMissingDataDoc14ILS.innerText = ""

		if(!fecha_resolucion.value) {
			infoMissingDataDoc13ILS.innerHTML = infoMissingDataDoc13ILS.innerHTML + "Firma resolució<br>"
			todoBien = false
		}
		if(!fecha_infor_fav_renov.value) {
			infoMissingDataDoc13ILS.innerHTML = infoMissingDataDoc13ILS.innerHTML + "Data informe favorable renovació<br>"
			todoBien = false
		}
		if(!fecha_REC_justificacion_renov.value) {
			infoMissingDataDoc13ILS.innerHTML = infoMissingDataDoc13ILS.innerHTML + "Data REC justificació renovació<br>"
			todoBien = false
		}
		if(!ref_REC_justificacion_renov.value) {
			infoMissingDataDoc13ILS.innerHTML = infoMissingDataDoc13ILS.innerHTML + "Referència REC justificació<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDataDoc14ILS.classList.add('ocultar')
			btnRenResolucionRenovacionMarcaConReqILS.disabled = true
			btnRenResolucionRenovacionMarcaConReqILS.innerHTML = "Generant i enviant ..."
			window.location.href = base_url_ils+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_renovacion_resolucion_renovacion_marca_con_req_ils'
		} else {
			infoMissingDataDoc14ILS.classList.remove('ocultar')
		}
	}
</script>