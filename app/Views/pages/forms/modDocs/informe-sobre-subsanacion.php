<!----------------------------------------- Informe inici requeriment d'esmena DOC 20 SIN VIAFIRMA --------->
<div class="card-itramits">
  	<div class="card-itramits-body">
      Informe post esmena justificació
	</div>
	<div class="card-itramits-footer">
		<?php
        if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
        else {?>
			<button type = "button" class = "btn btn-primary btn-acto-admin" data-bs-toggle = "modal" data-bs-target = "#mySobreSubsanacionRequerimiento" id="myBtnSobreSubsanacionRequerimiento">Genera l'informe</button>
			<span id="btn_20" class="">
					<button id="wrapper_informe_sobre_subsanacion" class='btn btn-secondary ocultar btn-acto-admin' onclick="enviaInformeSobreSubsanacion(<?php echo $id;?>, '<?php echo $convocatoria;?>', '<?php echo $programa;?>', '<?php echo $nifcif;?>')">Envia a signar l'informe</button>
					<div id='infoMissingDataDoc20' class="alert alert-danger ocultar"></div>
			</span>
			<span id="spinner_20" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#000000;"></i></span>
		<?php }?>
	
	</div>
	<div class="card-itramits-footer">
	<?php if ($expedientes['doc_informe_sobre_la_subsanacion'] !=0) { ?>
		<a	class='btn btn-ver-itramits' href="<?php echo base_url('public/index.php/expedientes/muestrainforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_informe_sobre_la_subsanacion');?>" target = "_self"><i class='fa fa-check'></i>Informe sobre l'esmena</a>		
		<?php }?>
		<?php
	//Compruebo el estado de la firma del documento.
	$db = \Config\Database::connect();
	$sql = "SELECT * FROM pindust_documentos_generados WHERE name='doc_informe_sobre_la_subsanacion.pdf' AND id_sol=".$expedientes['id']." AND convocatoria='".$expedientes['convocatoria']."'";
	$query = $db->query($sql);
	$row = $query->getRow();
	if (isset($row))
	{
		$PublicAccessId = $row->publicAccessId;
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
			$estado_firma = "<div class='btn btn-light btn-acto-admin'><i class='fa fa-info-circle'></i>Desconegut</div>";
			}
			echo $estado_firma;
	}
			 ?>
  	</div>
</div>
<!------------------------------------------------------------------------------------------------------>
<!-- The Modal -->
<div id="mySobreSubsanacionRequerimiento" class="modal">
				<div class="modal-dialog">
                <!-- Modal content-->
    			<div class="modal-content">
      				<div class="modal-header">
      					<label for="motivoSobreSubsanacion"><strong>Una vegada transcorregut el termini, el tècnic exposa i proposa que:</strong></label>
								<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      				</div>
      				<div class="modal-body">
						<div class="form-group">
							<textarea required rows="10" cols="30" name="motivoSobreSubsanacion" class="form-control" id = "motivoSobreSubsanacion" 
							placeholder="El tècnic exposa que ..."><?php echo $expedientes['motivoSobreSubsanacion']; ?></textarea>
        				</div>
						<div class="form-group">
							<textarea required rows="10" cols="30" name="propuestaTecnicoSobreSubsanacion" class="form-control" id = "propuestaTecnicoSobreSubsanacion" 
							placeholder="El tècnic proposa que ..."><?php echo $expedientes['propuestaTecnicoSobreSubsanacion']; ?></textarea>
        				</div>					
						<div class="form-group">
           				<button type="button" onclick = "javaScript: actualizaMotivoInformeSobreSubsanacion_click();" id="guardaMotivoInformeSobreSubsanacion" 
							class="btn-itramits btn-success-itramits" data-bs-dismiss="modal">Guarda</button>
        				</div>				
    					</div>
  					</div>
				</div>
		</div>

		<script>
	function enviaInformeSobreSubsanacion(id, convocatoria, programa, nifcif) {
		let todoBien = true
		
	 	let fecha_propuesta_resolucion = document.getElementById('fecha_propuesta_resolucion') //0000-00-00
		let fecha_firma_requerimiento_justificacion = document.getElementById('fecha_firma_requerimiento_justificacion')

		let wrapper_informe_sobre_subsanacion = document.getElementById('wrapper_informe_sobre_subsanacion')
		let base_url = 'https://tramits.idi.es/public/index.php/expedientes/generaInforme'
		let spinner_20 = document.getElementById('spinner_20')
		let infoMissingDataDoc20 = document.getElementById('infoMissingDataDoc20')
		infoMissingDataDoc20.innerText = ""

		if(!fecha_propuesta_resolucion.value) {
			infoMissingDataDoc20.innerHTML = infoMissingDataDoc20.innerHTML + "Data firma proposta resolució<br>"
			todoBien = false
		}
		if(!fecha_firma_requerimiento_justificacion.value) {
			infoMissingDataDoc20.innerHTML = infoMissingDataDoc20.innerHTML + "Data firma requeriment justificació<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDataDoc20.classList.add('ocultar')
			wrapper_informe_sobre_subsanacion.disabled = true
			wrapper_informe_sobre_subsanacion.innerHTML = "Generant ..."
			spinner_20.classList.remove('ocultar')
			window.location.href = base_url+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_informe_sobre_la_subsanacion'
		} else {
			infoMissingDataDoc20.classList.remove('ocultar')
		}
	}
</script>