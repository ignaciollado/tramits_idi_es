<!----------------------------------------- Propuesta de resolución de revocación por no justificar DOC 16 -------------------->
<div class="card-itramits">
  	<div class="card-itramits-body">
    	Proposta de resolució de revocació per no justificar **** [PRE]
  	</div>
		<div class="card-itramits-footer">
  		<?php
      if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
      else {?>
			<button id="btnPropuestaResolucionRevocacionPorNoJustificar" class='btn btn-primary btn-acto-admin' onclick="generaPropuestaResolucionRevocacionPorNoJustificar(<?php echo $id;?>, '<?php echo $convocatoria;?>', '<?php echo $programa;?>', '<?php echo $nifcif;?>')">Genera la resolució</button>
			<div id='infoMissingDoc16' class="alert alert-danger ocultar btn-acto-admin"></div>
		<?php }?>
	</div>
  	<div class="card-itramits-footer">
			<?php
			$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'],'doc_prop_res_revocacion_por_no_justificar.pdf');
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
						break;
						case 'COMPLETED':
						$estado_firma = "<a href=".base_url('public/index.php/expedientes/muestrasolicitudfirmada/'.$requestPublicAccessId)." ><div class='btn btn-success btn-acto-admin'><i class='fa fa-check'></i> Signat</div>";		
						$estado_firma .= "</a>";					
						break;
						case 'IN_PROCESS':
						$estado_firma = "<a href=".base_url('public/index.php/expedientes/muestrasolicitudfirmada/'.$requestPublicAccessId)." ><div class='btn btn-secondary btn-acto-admin'><i class='fa fa-check'></i> En curs</div>";		
						$estado_firma .= "</a>";						
						default:
						$estado_firma = "<div class='btn btn-danger btn-acto-admin'><i class='fa fa-info-circle'></i> Desconegut</div>";
					}
				echo $estado_firma;
			}	?>
  	</div>
</div>
<!------------------------------------------------------------------------------------------------------>
<script>

function generaPropuestaResolucionRevocacionPorNoJustificar(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC_desestimiento = document.getElementById('fecha_REC_desestimiento')
		let ref_REC_desestimiento = document.getElementById('ref_REC_desestimiento')

		let btnPropuestaResolucionRevocacionPorNoJustificar = document.getElementById('btnPropuestaResolucionRevocacionPorNoJustificar')
		let base_url = 'https://pre-tramits.idi.es/public/index.php/expedientes/generainformeIDI_ISBA'
		let infoMissingDoc16 = document.getElementById('infoMissingDoc16')
		infoMissingDoc16.innerText = ""

		if(!fecha_REC_desestimiento.value) {
			infoMissingDoc16.innerHTML = infoMissingDoc16.innerHTML + "Data SEU desistiment<br>"
			todoBien = false
		}
		if(!ref_REC_desestimiento.value) {
			infoMissingDoc16.innerHTML = infoMissingDoc16.innerHTML + "Referència SEU desistiment<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDoc16.classList.add('ocultar')
			btnPropuestaResolucionRevocacionPorNoJustificar.disabled = true
			btnPropuestaResolucionRevocacionPorNoJustificar.innerHTML = "Generant i enviant ..."
			window.location.href = base_url+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_prop_res_revocacion_por_no_justificar'
		} else {
			infoMissingDoc16.classList.remove('ocultar')
		}
	}

</script>