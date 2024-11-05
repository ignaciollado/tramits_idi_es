<!----------------------------------------- Resolución revocació por no justificar DOC 17 --------------------------------->
<div class="card-itramits">
  	<div class="card-itramits-body">Resolució revocació per no justificar
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
		 	<button type="button" class="btn btn-secondary btn-acto-admin" data-bs-toggle="modal" data-bs-target="#myRevocacionPorNoJustificar" id="myBtnRevocacionPorNoJustificar">Motiu de la revocació</button>
				<span id="btn_17" class="">
					<button id="wrapper_motivoRevocacionPorNoJustificar" class="btn btn-primary ocultar" onclick="enviaResolucionRevocacionPorNoJustificar(<?php echo $id;?>, '<?php echo $convocatoria;?>', '<?php echo $programa;?>', '<?php echo $nifcif;?>')">Envia a signar la resolució</button>
					<div id='infoMissingDoc17' class="alert alert-danger ocultar btn-acto-admin"></div>
				</span>
		<?php }?>
	</div>
  	<div class="card-itramits-footer">
		<?php
			$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'], 'doc_res_revocacion_por_no_justificar.pdf');
			if (isset($tieneDocumentosGenerados))
				{
				$PublicAccessId = $tieneDocumentosGenerados->publicAccessId;
	  		$requestPublicAccessId = $PublicAccessId;
				$request = execute("requests/".$requestPublicAccessId, null, __FUNCTION__);
				$respuesta = json_decode ($request, true);
				$estado_firma = $respuesta['status'];
				switch ($estado_firma) {
					case 'NOT_STARTED':
						$estado_firma = "<div class='btn btn-info btn-acto-admin'><i class='fa fa-info-circle'></i> Pendent de signar</div>";
						break;
					case 'REJECTED':
						$estado_firma = "<a href=".base_url('public/index.php/expedientes/muestrasolicitudrechazada/'.$requestPublicAccessId)."><div class = 'btn btn-warning btn-acto-admin'><i class='fa fa-warning'></i> Signatura rebutjada</div>";
						$estado_firma .= "</a>";
						$estado_firma .= gmdate("d-m-Y", intval ($respuesta['rejectInfo']['rejectDate']/1000));
						$fecha_firma_req = gmdate("d-m-Y", intval ($respuesta['rejectInfo']['rejectDate']/1000));
						break;
					case 'COMPLETED':
						$estado_firma = "<a href=".base_url('public/index.php/expedientes/muestrasolicitudfirmada/'.$requestPublicAccessId)." ><div class='btn btn-success btn-acto-admin'><i class='fa fa-check'></i> Signat</div>";
						$estado_firma .= "</a>";
						$estado_firma .= gmdate("Y-m-d", intval ($respuesta['endDate']/1000));
						$fecha_firma_req = gmdate("Y-m-d", intval ($respuesta['endDate']/1000));
						break;
					case 'IN_PROCESS':
						$estado_firma = "<a href=".base_url('public/index.php/expedientes/muestrasolicitudfirmada/'.$requestPublicAccessId)." ><div class='btn btn-secondary btn-acto-admin'><i class='fa fa-check'></i> En curs</div>";
						$estado_firma .= "</a>";
						break;
					default:
						$estado_firma = "<div class='btn btn-danger btn-acto-admin'><i class='fa fa-info-circle'></i> Desconegut</div>";
				}
				echo $estado_firma;
				}
			 ?>
  	</div>
</div>
<!------------------------------------------------------------------------------------------------------>
<div id="myRevocacionPorNoJustificar" class="modal" tabindex="-1">
  	<div class="modal-dialog">
    	<div class="modal-content">	
			<div class="modal-header">
				<h4 class="modal-title">Motiu de la revocació per no justificar:</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
			  <div class="form-group">
					<textarea required rows="10" cols="30" name="textoRevocacionPorNoJustificar" class="form-control" id = "textoRevocacionPorNoJustificar" 
					placeholder="Motiu de la revocació per no justificar"><?php echo $expedientes['motivoResolucionRevocacionPorNoJustificar']; ?></textarea>
        </div>
      </div>
      <div class="modal-footer">
			 	<div class="form-group">
      		<button type="button" onclick = "javaScript: actualizaMotivoRevocacionPorNoJustificar_click();" id="guardaMotivoRevocacionPorNoJustificar" 
					class="btn-itramits btn-success-itramits" data-bs-dismiss="modal">Guarda</button>
      	</div>				
      </div>
    	</div>
  	</div>
</div>


<script>
	const actualBaseUrl = window.location.origin
	let base_url = actualBaseUrl+'/public/index.php/expedientes/generainformeIDI_ISBA'

	function enviaResolucionRevocacionPorNoJustificar(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_not_pr_revocacion = document.getElementById('fecha_not_pr_revocacion')
		let wrapper_motivoRevocacionPorNoJustificar = document.getElementById('wrapper_motivoRevocacionPorNoJustificar')

		if(!fecha_not_pr_revocacion.value) {
			infoMissingDoc17.innerHTML = infoMissingDoc17.innerHTML + "Notificació Proposta de Resolució de Revocació<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDoc17.classList.add('ocultar')
			wrapper_motivoRevocacionPorNoJustificar.disabled = true
			wrapper_motivoRevocacionPorNoJustificar.innerHTML = "Generant i enviant ..."
			window.location.href = base_url+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_res_revocacion_por_no_justificar'
		} else {
			infoMissingDoc17.classList.remove('ocultar')
		}
	}
</script>