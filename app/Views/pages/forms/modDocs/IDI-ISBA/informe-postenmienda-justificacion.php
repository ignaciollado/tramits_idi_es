<!----------------------------------------- Informe post enmienda justificación DOC 14 --------->
<div class="card-itramits">
  <div class="card-itramits-body">
    Informe postesmena justificació
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
			<button type = "button" class = "btn btn-secondary btn-acto-admin" data-bs-toggle = "modal" data-bs-target = "#mySobreSubsanacionRequerimiento" id="myBtnSobreSubsanacionRequerimiento">Genera l'informe</button>
			<span id="btn_20" class="">
				<button id="wrapper_informe_sobre_subsanacion" class='btn btn-secondary ocultar btn-acto-admin' onclick="enviaInformeSobreSubsanacion(<?php echo $id;?>, '<?php echo $convocatoria;?>', '<?php echo $programa;?>', '<?php echo $nifcif;?>')">Envia a signar l'informe</button>
				<div id='infoMissingDataDoc14' class="alert alert-danger ocultar"></div>
			</span>
		<?php }?>
	</div>
	<div class="card-itramits-footer">
	<?php
	//Compruebo el estado de la firma del documento.
	$tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'], 'doc_informe_sobre_la_subsanacion.pdf');
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
	}
			 ?>
  	</div>
</div>
<!------------------------------------------------------------------------------------------------------>
<!-- The Modal -->
<div id="mySobreSubsanacionRequerimiento" class="modal" tabindex="-1">
				<div class="modal-dialog">
                <!-- Modal content-->
    				<div class="modal-content">
      				<div class="modal-header">
      					<label for="motivoSobreSubsanacion"><strong>Una vegada transcorregut el termini, el tècnic exposa i propossa que:</strong></label>
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
		let fecha_not_req_just = document.getElementById('fecha_not_req_just')
		let fecha_firma_requerimiento_justificacion = document.getElementById('fecha_firma_requerimiento_justificacion')
		let wrapper_informe_sobre_subsanacion = document.getElementById('wrapper_informe_sobre_subsanacion')
		let infoMissingDataDoc14 = document.getElementById('infoMissingDataDoc14')
		infoMissingDataDoc14.innerText = ""

		if(!fecha_firma_requerimiento_justificacion.value) {
			infoMissingDataDoc14.innerHTML = infoMissingDataDoc14.innerHTML + "Data firma requeriment justificació<br>"
			todoBien = false
		}

		if (todoBien) {
			infoMissingDataDoc14.classList.add('ocultar')
			wrapper_informe_sobre_subsanacion.disabled = true
			wrapper_informe_sobre_subsanacion.innerHTML = "Generant i enviant..."
			window.location.href = base_url_isba+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_informe_sobre_la_subsanacion'
		} else {
			infoMissingDataDoc14.classList.remove('ocultar')
		}
	}
</script>