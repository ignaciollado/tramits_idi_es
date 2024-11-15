<!-- -------------------------------------- Renovacion resolución de renovación de marca DOC 13-->
<div class="card-itramits">
  <div class="card-itramits-body">
  	Resolució de renovació de marca [falta json]
  </div>
	<div class="card-itramits-footer">
		<?php
      if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
      else {?>
			<button id="btnRenResolucionRenovacionMarcaILS" class='btn btn-primary btn-acto-admin' onclick="generaRenovacionResolucionRenovacionILS(<?php echo $id;?>, '<?php echo $convocatoria;?>', '<?php echo $programa;?>', '<?php echo $nifcif;?>')">Generar la resolució</button>
			<div id='infoMissingDataDoc13ILS' class="alert alert-danger ocultar btn-acto-admin"></div>		
		<?php }?>
	</div>
	<div class="card-itramits-footer">
		<?php
		$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'],'doc_renovacion_resolucion_renovacion_marca_ils.pdf');
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
	function generaRenovacionResolucionRenovacionILS (id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')

		let btnRenResolucionRenovacionMarcaILS = document.getElementById('btnRenResolucionRenovacionMarcaILS')
		let infoMissingDataDoc13ILS = document.getElementById('infoMissingDataDoc13ILS')
		infoMissingDataDoc13ILS.innerText = ""

		if(!fecha_REC.value) {
			infoMissingDataDoc13ILS.innerHTML = infoMissingDataDoc13ILS.innerHTML + "Data SEU sol·licitud<br>"
			todoBien = false
		}
		if(!ref_REC.value) {
			infoMissingDataDoc13ILS.innerHTML = infoMissingDataDoc13ILS.innerHTML + "Referència SEU sol·licitud<br>"
			todoBien = false
		}
		
		if (todoBien) {
			infoMissingDataDoc13ILS.classList.add('ocultar')
			btnRenResolucionRenovacionMarcaILS.disabled = true
			btnRenResolucionRenovacionMarcaILS.innerHTML = "Generant i enviant ..."
			window.location.href = base_url_ils+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_renovacion_resolucion_renovacion_marca_ils'
		} else {
			infoMissingDataDoc13ILS.classList.remove('ocultar')
		}
	}
</script>