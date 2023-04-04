<div class="card-itramits">
  	<div class="card-itramits-body">
    	Requeriment
  	</div>
	<div class="card-itramits-footer">

	<?php
        if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
        else {?>
			<button class="btn btn-secondary" type="button" data-bs-toggle="modal" data-bs-target="#motivoRequerimiento">Motiu del requeriment</button>
			<div id='infoMissingDataDoc1' class="alert alert-danger ocultar"></div>
			<span id="btn_1" class="">
    			<a id ="wrapper_motivoRequerimiento" class="ocultar" href="<?php echo base_url('public/index.php/expedientes/generaInforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_requeriment');?>">Envia a signar el requeriment</a>
			</span>
			<span id="spinner_1" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#000000;"></i></span>
	<?php }?>
	
	</div>
  <div class ="card-itramits-footer">
	<?php if ($expedientes['doc_requeriment'] !=0) { ?>
		<!-- <a	class='btn btn-ver-itramits' href="<?php echo base_url('public/index.php/expedientes/muestrainforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_requeriment');?>" target = "_self"><i class='fa fa-check'></i>El requeriment</a> -->
	<?php }?>
	<?php
	//Compruebo el estado de la firma del documento.
	$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria']);
	if (isset($tieneDocumentosGenerados))
	{
		$PublicAccessId = $tieneDocumentosGenerados->publicAccessId;
	  $requestPublicAccessId = $PublicAccessId;
		$request = execute("requests/".$requestPublicAccessId, null, __FUNCTION__);
		$respuesta = json_decode ($request, true);
		$estado_firma = $respuesta['status'];
			switch ($estado_firma)
				{
				case 'NOT_STARTED':
				$estado_firma = "<div class='info-msg'><i class='fa fa-info-circle'></i>Pendent de signar</div>";				
				break;
				case 'REJECTED':
				$estado_firma = "<a href=".base_url('public/index.php/expedientes/muestrasolicitudrechazada/'.$requestPublicAccessId)."><div class = 'warning-msg'><i class='fa fa-warning'></i>Signatura rebutjada</div>";
				$estado_firma .= "</a>";				
				break;
				case 'COMPLETED':
				$estado_firma = "<a class='btn btn-ver-itramits' href=".base_url('public/index.php/expedientes/muestrasolicitudfirmada/'.$requestPublicAccessId)." ><i class='fa fa-check'></i>Signat";		
				$estado_firma .= "</a>";					
				break;
				case 'IN_PROCESS':
				$estado_firma = "<a href=".base_url('public/index.php/expedientes/muestrasolicitudfirmada/'.$requestPublicAccessId)." ><div class='info-msg'><i class='fa fa-check'></i>En curs</div>";		
				$estado_firma .= "</a>";						
				default:
				$estado_firma = "<div class='info-msg'><i class='fa fa-info-circle'></i>Desconegut</div>";
				}
			echo $estado_firma;
	}
			 ?>

<div class="modal" id="motivoRequerimiento">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Motiu del requeriment:</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
					<div class="form-group">
						<textarea required rows="10" cols="30" name="motivoRequerimientoTexto" class="form-control" id = "motivoRequerimientoTexto" 
						placeholder="Motiu del requeriment"><?php echo $expedientes['motivoRequerimiento']; ?></textarea>
        	</div>
					
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
				<div class="form-group">
          	<button type="button" onclick = "javaScript: actualizaMotivoRequerimiento_click();" id="guardaMotivoRequerimiento" 
						class="btn-itramits btn-success-itramits" data-bs-dismiss="modal">Guarda</button>
				</div>		
      </div>

    </div>
  </div>
</div>

  </div>  
</div>

<script>

/* 	function enviaRequerimiento(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_REC = document.getElementById('fecha_REC')
		let ref_REC = document.getElementById('ref_REC')
		let base_url = 'https://tramits.idi.es/public/index.php/expedientes/generaInforme'
		let spinner_3 = document.getElementById('spinner_3')
		let infoMissingDataDoc1 = document.getElementById('infoMissingDataDoc1')
		infoMissingDataDoc1.innerText = ""
		if(!fecha_REC.value) {
			infoMissingDataDoc1.innerHTML = infoMissingDataDoc1.innerHTML + "Data REC sol·licitud<br>"
			todoBien = false
		}
		if(!ref_REC.value) {
			infoMissingDataDoc1.innerHTML = infoMissingDataDoc1.innerHTML + "Referència REC sol·licitud<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDataDoc1.classList.add('ocultar')
			generaInfFavConReq.disabled = true
			generaInfFavConReq.innerHTML = "Generant ..."
			spinner_3.classList.remove('ocultar')
			window.location.href = base_url+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_requeriment'
		} else {
			infoMissingDataDoc1.classList.remove('ocultar')
		}
	}
 */
</script>