<div class="card-itramits">
  	<div class="card-itramits-body">
    	Requeriment sol·licitud  <strong>¡¡¡¡¡[pre-tramits]!!!!!</strong>
  	</div>
	<div class="card-itramits-footer">

	<?php
    if ( !$esAdmin && !$esConvoActual ) {?>
      <?php }
    else {?>
			<button class="btn btn-secondary btn-acto-admin" type="button" data-bs-toggle="modal" data-bs-target="#motivoRequerimiento">Motiu del requeriment</button>
			<span id="btn_1" class="">
					<button id="wrapper_motivoRequerimiento" class="btn btn-primary ocultar" onclick="enviaRequerimiento(<?php echo $id;?>, '<?php echo $convocatoria;?>', '<?php echo $programa;?>', '<?php echo $nifcif;?>')">Envia a signar el requeriment</button>
			</span>
	<?php }?>
	
	</div>
  <div class ="card-itramits-footer">
		<?php
			$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'], 'doc_requeriment.pdf');
			if (isset($tieneDocumentosGenerados))
				{
				$PublicAccessId = $tieneDocumentosGenerados->publicAccessId;
	  		$requestPublicAccessId = $PublicAccessId;
				$request = execute("requests/".$requestPublicAccessId, null, __FUNCTION__);
				$respuesta = json_decode ($request, true);
				$estado_firma = $respuesta['status'];
				switch ($estado_firma) {
				case 'NOT_STARTED':
				$estado_firma = "<div class = 'btn btn-info btn-acto-admin'><i class='fa fa-info-circle'></i>Pendent de signar</div>";				
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
  </div> 
</div>
<div class="modal" id="motivoRequerimiento">
  	<div class="modal-dialog">
    	<div class="modal-content">	
      		<div class="modal-header">
        		<h4 class="modal-title">Motiu del requeriment:</h4>
        		<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      		</div>
      		<div class="modal-body">
				<div class="form-group">
					<textarea required rows="10" cols="30" name="motivoRequerimientoTexto" class="form-control" id = "motivoRequerimientoTexto" 
					placeholder="Motiu del requeriment"><?php echo $expedientes['motivoRequerimiento']; ?></textarea>
        		</div>		
      		</div>
      		<div class="modal-footer">
				<div class="form-group">
          			<button type="button" onclick = "javaScript: actualizaMotivoRequerimiento_click();" id="guardaMotivoRequerimiento" 
					class="btn-itramits btn-success-itramits" data-bs-dismiss="modal">Guarda</button>
				</div>		
      		</div>
    	</div>
  	</div>
</div>

<script>
function actualizaMotivoRequerimiento_click() {  //SE EMPLEA
	let textoMotivoReq = document.getElementById("motivoRequerimientoTexto").value;
	let id = document.getElementById("id").value;
	let modal = document.getElementById("motivoRequerimiento");
	if ( textoMotivoReq === "" ) {
		alert ("Falta indicar el motiu.")
		return;
	}
	$.post(
		"/public/assets/utils/actualiza_motivo_requerimiento_en_expediente.php",
		{ id: id, textoMotivoReq: textoMotivoReq },
		function (data) {
			$(".result").html(data);
			if (data == 1) {
				document.getElementById("wrapper_motivoRequerimiento").className = "btn btn-primary";
				console.log (document.getElementById("wrapper_motivoRequerimiento").innerText)
				modal.style.display = "none";
				$("div").removeClass("modal-backdrop fade in"); // modal-backdrop fade in
			}
		}
	);
}


	function enviaRequerimiento(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let wrapper_motivoRequerimiento = document.getElementById('wrapper_motivoRequerimiento')
		let base_url = 'https://pre-tramits.idi.es/public/index.php/expedientes/generainforme'
		if (todoBien) {
			wrapper_motivoRequerimiento.disabled = true
			wrapper_motivoRequerimiento.innerHTML = "Generant i enviant ..."
			window.location.href = base_url+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_requeriment'
		}
	}
</script>