<!----------------------------------------- Resolución desestimiento por renuncia DOC 15 -------------------->
<div class="card-itramits">
  	<div class="card-itramits-body">
    	Resolucio desistiment per renúncia
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
			<button id="btnResolucionDesestimientoRenuncia" class='btn btn-primary btn-acto-admin' onclick="generaResolucionDesestimientoPorRenuncia(<?php echo $id;?>, '<?php echo $convocatoria;?>', '<?php echo $programa;?>', '<?php echo $nifcif;?>')">Genera la resolució</button>
			<div id='infoMissingDoc15' class="alert alert-danger ocultar btn-acto-admin"></div>
		<?php }?>
	</div>
  	<div class="card-itramits-footer">
			<?php
			$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'],'doc_res_desestimiento_por_renuncia.pdf');
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
  	</div>
</div>
<!------------------------------------------------------------------------------------------------------>
<script>
	const actualBaseUrl = window.location.origin
	let base_url = actualBaseUrl+'/public/index.php/expedientes/generainformeIDI_ISBA'

function generaResolucionDesestimientoPorRenuncia(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC_desestimiento = document.getElementById('fecha_REC_desestimiento')
		let ref_REC_desestimiento = document.getElementById('ref_REC_desestimiento')

		let btnResolucionDesestimientoRenuncia = document.getElementById('btnResolucionDesestimientoRenuncia')
		let infoMissingDoc15 = document.getElementById('infoMissingDoc15')
		infoMissingDoc15.innerText = ""

		if(!fecha_REC_desestimiento.value) {
			infoMissingDoc15.innerHTML = infoMissingDoc15.innerHTML + "Data SEU desistiment<br>"
			todoBien = false
		}
		if(!ref_REC_desestimiento.value) {
			infoMissingDoc15.innerHTML = infoMissingDoc15.innerHTML + "Referència SEU desistiment<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDoc15.classList.add('ocultar')
			btnResolucionDesestimientoRenuncia.disabled = true
			btnResolucionDesestimientoRenuncia.innerHTML = "Generant i enviant ..."
			window.location.href = base_url+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_res_desestimiento_por_renuncia'
		} else {
			infoMissingDoc15.classList.remove('ocultar')
		}
	}

</script>