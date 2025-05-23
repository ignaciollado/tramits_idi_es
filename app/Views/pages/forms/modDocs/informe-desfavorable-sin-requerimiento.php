<!-- -------------------------------------- Informe desfavorable sense requeriment  DOC 5-------------------------------------->
<div class="card-itramits">
  	<div class="card-itramits-body">
    	Informe desfavorable
			<?php if ($base_url === "pre-tramitsidi") {?>
				<span class="label label-warning">***testear*** [PRE]</span>
			<?php }?>
  	</div>
  	<div class="card-itramits-footer" aria-label="generar informe">
		
	  	<?php
        if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
        else {?>
			<button type = "button" class = "btn btn-secondary btn-acto-admin" data-bs-toggle="modal" data-bs-target="#mygeneraInformeDesfSinReq" id="myBtngeneraInformeDesfSinReq">Motiu de la denegació</button>
			<span id="btn_5" class="">		
				<button id="wrapper_generaInformeDesfSinReq" class='btn btn-primary ocultar btn-acto-admin' onclick="enviaInformeDesfavorableSinRequerimiento(<?php echo $id;?>, '<?php echo $convocatoria;?>', '<?php echo $programa;?>', '<?php echo $nifcif;?>')">Envia a signar l'informe</button>
				<div id='infoMissingDataDoc5' class="alert alert-danger ocultar"></div>
			</span>
			<?php }?>			
  	
		</div>
  	<div class="card-itramits-footer">
	<?php 
		$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'], 'doc_informe_desfavorable_sin_requerimiento.pdf');
		if (isset($tieneDocumentosGenerados))
		{
		$PublicAccessId = $tieneDocumentosGenerados->publicAccessId;
		$requestPublicAccessId = $PublicAccessId;
		$request = execute("requests/".$requestPublicAccessId, null, __FUNCTION__);
		$respuesta = json_decode ($request, true);
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
		}
		?>

<div class="modal" id="mygeneraInformeDesfSinReq">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Motiu de la denegació:</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
			<div class="form-group">
        		<input type="hidden" name="motivogeneraInformeDesfSinReq_valor" class="form-control" id = "motivogeneraInformeDesfSinReq_valor" required placeholder="Nom del sol·licitant" value="<?php echo $expedientes['motivoDenegacion']; ?>">
				<textarea rows="10" cols="30" name="motivogeneraInformeDesfSinReq" class="form-control" id = "motivogeneraInformeDesfSinReq" min="0" placeholder="Motiu de la denegació"><?php echo $expedientes['motivoDenegacion']; ?></textarea>
        	</div>	
      </div>
      <div class="modal-footer">
			<div class="form-group">
          		<button type="button" onclick = "javaScript: actualizaMotivoDesfavorable_click();" id="guardaMotivogeneraInformeDesfSinReq" 
						class="btn-itramits btn-success-itramits" data-bs-dismiss="modal">Guarda</button>
			</div>		
      </div>
    </div>
  </div>
</div>

  	</div>
</div>
<!------------------------------------------------------------------------------------------------------>

<script>
	function enviaInformeDesfavorableSinRequerimiento(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')
		let generaInfFavSinReq = document.getElementById('wrapper_generaInformeDesfSinReq')
		let infoMissingDataDoc5 = document.getElementById('infoMissingDataDoc5')
		infoMissingDataDoc5.innerText = ""

		if(!fecha_REC.value) {
			infoMissingDataDoc5.innerHTML = infoMissingDataDoc5.innerHTML + "Data SEU sol·licitud<br>"
			todoBien = false
		}
		if(!ref_REC.value) {
			infoMissingDataDoc5.innerHTML = infoMissingDataDoc5.innerHTML + "Referència SEU sol·licitud<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDataDoc5.classList.add('ocultar')
			generaInfFavSinReq.disabled = true
			generaInfFavSinReq.innerHTML = "Generant i enviant..."
			window.location.href = base_url+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_informe_desfavorable_sin_requerimiento'
		} else {
			infoMissingDataDoc5.classList.remove('ocultar')
		}
	}
</script>