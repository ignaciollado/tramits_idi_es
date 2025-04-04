<!-- -------------------------------------- Renovación informe favorable DOC 10-->
<div class="card-itramits">
  	<div class="card-itramits-body">
    	 Informe favorable
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
			<button id="btnRenInformeFavorableILS" class='btn btn-primary btn-acto-admin' onclick="generaRenovacionInformeFavorableILS(<?php echo $id;?>, '<?php echo $convocatoria;?>', '<?php echo $programa;?>', '<?php echo $nifcif;?>')">Generar l'informe</button>
			<div id='infoMissingDataDoc10ILS' class="alert alert-danger ocultar btn-acto-admin"></div>
	<?php }?>
	</div>

	<div class="card-itramits-footer">
			<?php
			$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'],'doc_renovacion_informe_favorable_ils.pdf');
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
	function generaRenovacionInformeFavorableILS (id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_resolucion = document.getElementById('fecha_resolucion')
		let fecha_resolucion_renov = document.getElementById('fecha_resolucion_renov')
		let fecha_REC_justificacion_renov = document.getElementById('fecha_REC_justificacion_renov')
		let ref_REC_justificacion_renov = document.getElementById('ref_REC_justificacion_renov')
		let btnRenInformeFavorableILS = document.getElementById('btnRenInformeFavorableILS')
		let infoMissingDataDoc10ILS = document.getElementById('infoMissingDataDoc10ILS')
		infoMissingDataDoc10ILS.innerText = ""

		if(!fecha_resolucion.value) {
			infoMissingDataDoc10ILS.innerHTML = infoMissingDataDoc10ILS.innerHTML + "Firma resolució<br>"
			todoBien = false
		}
		if(!fecha_REC_justificacion_renov.value) {
			infoMissingDataDoc10ILS.innerHTML = infoMissingDataDoc10ILS.innerHTML + "Data REC justificació renovació<br>"
			todoBien = false
		}
		if(!ref_REC_justificacion_renov.value) {
			infoMissingDataDoc10ILS.innerHTML = infoMissingDataDoc10ILS.innerHTML + "Referència REC justificació<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDataDoc10ILS.classList.add('ocultar')
			btnRenInformeFavorableILS.disabled = true
			btnRenInformeFavorableILS.innerHTML = "Generant i enviant ..."
			window.location.href = base_url_ils+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_renovacion_informe_favorable_ils'
		} else {
			infoMissingDataDoc10ILS.classList.remove('ocultar')
		}
	}
</script>