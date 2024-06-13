<!----------------------------------------- abril_Acta Kick off DOC 19 -->
<div class="card-itramits">
  	<div class="card-itramits-body">
    	 Acta de Kick off
		</div>
  	<div class="card-itramits-footer">
	  	<?php
        if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
        else {?>
	  		<button type = "button" id="myBtnactaDeKickOff" class = "btn btn-secondary btn-acto-admin" onclick="actaDeKickOff(<?php echo $id; ?>, '<?php echo $convocatoria; ?>', '<?php echo $programa; ?>', '<?php echo $nifcif; ?>')">Genera l'acta</button>   
			<?php }?>	
	  	
		<span id="btn_14" class="">
    		<a id="wrapper_actaDeKickOff" class = "btn btn-primary ocultar btn-acto-admin" href="<?php echo base_url('public/index.php/expedientes/generaInforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_acta_kickoff');?>" onclick="enviaElActaDeKickOff()">Envia a signar l'acta</a>      	
		</span>
		<div id='infoMissingDataDoc19' class = "alert alert-danger ocultar"></div>
	</div>
  	<div class="card-itramits-footer">
	<?php if ($expedientes['doc_acta_kickoff'] !=0) { 
    //Compruebo el estado de la firma del documento.
		 $tieneDocumentosGenerados = $modelDocumentosGenerados->documentosGeneradosPorExpedYTipo($expedientes['id'], $expedientes['convocatoria'],'doc_acta_kickoff.pdf');
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
	 }?>
		<div id="wrapper_generaactaDeKickOff" class="">
				
    </div>

		<div class="modal" id="myactaDeKickOff">
			<div class="modal-dialog">
				<div class="modal-content">	
					<div class="modal-header">
						<h4 class="modal-title">Dades per generar l'acta de kick off</h4>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
  				</div>
    				<div class="modal-body">

                <div class="form-group">
									<label style = "color: orange;" for = "actaNumKickOff"><strong>Document Acta núm.:</strong></label>
									<input type="text" required width="50%" name="actaNumKickOff" class="form-control" id = "actaNumKickOff" 
									placeholder="Acta número" value = "<?php echo $expedientes['actaNumKickOff']; ?>">
        				</div>
					
                <div class="form-group">
                  <label style = "color: orange;" for = "fecha_kick_off_modal"><strong>Data de kick-off:</strong></label>
                  <input type = "date" readonly width="50%" name = "fecha_kick_off_modal" class = "form-control" id = "fecha_kick_off_modal" onchange = "javaScript: actualizaFechaConsultoria(this.value);" value = "<?php if ($expedientes['fecha_kick_off'] != null) {echo date_format(date_create($expedientes['fecha_kick_off']), 'Y-m-d');}?>">
                </div>

                <div class="form-group">
                  <label style = "color: orange;" for = "fecha_HastaRealizacionPlan"><strong>Data límit per realitzar la consultoria:</strong><samp>[dd/mm/aaaa]</samp></label>
                  <input type = "date" readonly name = "fecha_HastaRealizacionPlan" class = "form-control" id = "fecha_HastaRealizacionPlan" value = "<?php if ($expedientes['fecha_limite_consultoria'] != null) {echo date_format(date_create($expedientes['fecha_limite_consultoria']), 'Y-m-d');}?>">
                </div>					
					
  							<div class="form-group">
                  <label style = "color: orange;" for = "horaInicioSesionKickOff"><strong>Hora inici:</strong></label>
                  <input type = "time" required width="50%" name = "horaInicioSesionKickOff" class = "form-control" id = "horaInicioSesionKickOff" value = "<?php echo $expedientes['horaInicioSesionKickOff'];?>">
                </div>
  					
  							<div class="form-group">
                  <label style = "color: orange;" for = "horaFinSesionKickOff"><strong>Hora acabament:</strong></label>
                  <input type = "time" required width="50%" name = "horaFinSesionKickOff" class = "form-control" id = "horaFinSesionKickOff" value = "<?php echo $expedientes['horaFinSesionKickOff'];?>">
                </div>
					
								<div class="form-group">
                  <label style = "color: orange;" for = "lugarSesionKickoff"><strong>Lloc: </strong></label>
                  <input type = "text" required name = "lugarSesionKickoff" class = "form-control" id = "lugarSesionKickoff" value = "<?php echo $expedientes['lugarSesionKickoff']; ?>">
                </div>

				  			<div class="form-group">
                   	<label style = "color: orange;" for = "asistentesKickOff"><strong>Assistents: </strong></label>
                   	<textarea rows="5" cols="40" required name="asistentesKickOff" class="form-control" id = "asistentesKickOff" 
										placeholder="Assistents"><?php echo $expedientes['asistentesKickOff']; ?></textarea>
              	</div>   					

								<div class="form-group">
                        	<label style = "color: orange;" for = "tutorKickOff"><strong>Serà el/la tutor/a d’aquest expedient: </strong></label>
                        	<input type = "text" required name = "tutorKickOff" class = "form-control" id = "tutorKickOff" value = "<?php echo $expedientes['tutorKickOff']; ?>">
                </div>

								<div class="form-group">
                        <label style = "color: orange;" for = "plazoRealizacionPlan"><strong>Mesos per a realizar el pla de transformació digital: </strong></label>
                        <input type = "number" required name = "plazoRealizacionPlan" class = "form-control" id = "plazoRealizacionPlan" value = "<?php echo $expedientes['plazoRealizacionPlan']; ?>">
                </div>

                <div class="form-group">
                      <label style = "color: orange;" for = "observacionesKickOff"><strong>Observacions: </strong></label>
                      <textarea rows="5" cols="40" name="observacionesKickOff" class="form-control" id = "observacionesKickOff" 
											placeholder="Observacions"><?php echo $expedientes['observacionesKickOff']; ?></textarea>
                </div> 					

								<div class="form-group">
           				<button type="button" onclick = "javaScript: actualizaMotivoactaDeKickOff_click();" id="guardaMotivoactaDeKickOff" 
									class="btn-itramits btn-success-itramits"
									data-bs-dismiss="modal">Guarda</button>
        				</div>	
					</div>
				</div>
			</div>
		</div>
  	</div>
</div>
<!------------------------------------------------------------------------------------------------------>
<script>
	function actaDeKickOff(id, convocatoria, programa, nifcif) {
		let todoBien = true
		let fecha_kick_off = document.getElementById('fecha_kick_off')
		let infoMissingDataDoc19 = document.getElementById('infoMissingDataDoc19')
		const myactaDeKickOff = new bootstrap.Modal(document.getElementById('myactaDeKickOff'), {  keyboard: false });
		infoMissingDataDoc19.innerText = ""

		if (!fecha_kick_off.value) {
			infoMissingDataDoc19.innerHTML = infoMissingDataDoc19.innerHTML + "Data de kick-off<br>"
			todoBien = false
		}
		if (todoBien) {
			infoMissingDataDoc19.classList.add('ocultar')
			myactaDeKickOff.show()
		} else {
			infoMissingDataDoc19.classList.remove('ocultar')
		}
	}

	function enviaElActaDeKickOff() {
		let myBtnactaDeKickOff = document.getElementById('myBtnactaDeKickOff')
		myBtnactaDeKickOff.disabled = true
		myBtnactaDeKickOff.innerHTML = "Enviant ..."
	}
</script>