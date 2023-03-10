<!----------------------------------------- abril_Acta Kick off -->
<div class="card-itramits">

  	<div class="card-itramits-body">
    	 Acta de Kick off
  	</div>
  	<div class="card-itramits-footer">

	  	<?php
        if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
        else {?>
	  		<button type = "button" class = "btn-primary-itramits" data-toggle = "modal" data-target = "#myactaDeKickOff" id="myBtnactaDeKickOff">Genera l'acta</button>   
		<?php }?>	
	  	
		<span id="btn_15" class="">
    		<a id="wrapper_actaDeKickOff" class="ocultar" href="<?php echo base_url('public/index.php/expedientes/generaInforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_acta_kickoff');?>" class="btn-primary-itramits">Envia a signar l'acta</a>      	
		</span>	
		<span id="spinner_15" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#000000;"></i></span>
	</div>
  	<div class="card-itramits-footer">
	<?php if ($expedientes['doc_acta_kickoff'] !=0) { 
    //Compruebo el estado de la firma del documento.
	   $db = \Config\Database::connect();
	   $sql = "SELECT publicAccessId FROM pindust_documentos_generados WHERE name='doc_acta_kickoff.pdf' AND id_sol=".$expedientes['id']." AND convocatoria='".$expedientes['convocatoria']."'";
	   $query = $db->query($sql);
	   $row = $query->getRow();
	   if (isset($row))
	   {
       $PublicAccessId = $row->publicAccessId;
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
					    $estado_firma = "<a class='btn btn-ver-itramits' href=".base_url('public/index.php/expedientes/muestrasolicitudfirmada/'.$requestPublicAccessId)." ><i class='fa fa-check'></i>Signada";		
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
		<!--<?php //} else {?>-->
		<?php }?>
		<div id="wrapper_generaactaDeKickOff" class="">
				
        </div>
            <!-- The Modal -->
			<div id="myactaDeKickOff" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">	
					<div class="modal-header">
						<label for="cerrarModalKickOff"><strong>Dades per generar l'acta de kick off</strong></label>
        				<button id="cerrarModalKickOff" type="button" class="close" data-dismiss="modal">&times;</button>
  					</div>

    				<div class="modal-body">

                    <div class="form-group">
						<label style = "color: orange;" for = "actaNumKickOff"><strong>Document Acta n??m.:</strong></label>
						<input type="text" required width="50%" name="actaNumKickOff" class="form-control" id = "actaNumKickOff" 
						placeholder="Acta n??mero" value = "<?php echo $expedientes['actaNumKickOff']; ?>">
        			</div>
					
                    <div class="form-group">
                        <label style = "color: orange;" for = "fecha_kick_off_modal"><strong>Data de kick-off:</strong></label>
                        <input type = "date" readonly width="50%" name = "fecha_kick_off_modal" class = "form-control" id = "fecha_kick_off_modal" onchange = "javaScript: actualizaFechaConsultoria(this.value);" value = "<?php if ($expedientes['fecha_kick_off'] != null) {echo date_format(date_create($expedientes['fecha_kick_off']), 'Y-m-d');}?>">
                    </div>

                    <div class="form-group">
                        <label style = "color: orange;" for = "fecha_HastaRealizacionPlan"><strong>Data l??mit per realitzar la consultoria:</strong><samp>[dd/mm/aaaa]</samp></label>
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
                        	<label style = "color: orange;" for = "tutorKickOff"><strong>Ser?? la tutora d???aquest expedient: </strong></label>
                        	<input type = "text" required name = "tutorKickOff" class = "form-control" id = "tutorKickOff" value = "<?php echo $expedientes['tutorKickOff']; ?>">
                    </div>

					<div class="form-group">
                        <label style = "color: orange;" for = "plazoRealizacionPlan"><strong>Mesos per a realizar el pla de transformaci?? digital: </strong></label>
                        <input type = "number" required name = "plazoRealizacionPlan" class = "form-control" id = "plazoRealizacionPlan" value = "<?php echo $expedientes['plazoRealizacionPlan']; ?>">
                    </div>

                    <div class="form-group">
                        <label style = "color: orange;" for = "observacionesKickOff"><strong>Observacions: </strong></label>
                        <textarea rows="5" cols="40" name="observacionesKickOff" class="form-control" id = "observacionesKickOff" 
						placeholder="Observacions"><?php echo $expedientes['observacionesKickOff']; ?></textarea>
                    </div> 					

					<div class="form-group">
           				<button type="button" onclick = "javaScript: actualizaMotivoactaDeKickOff_click();" id="guardaMotivoactaDeKickOff" 
							class="btn-itramits btn-success-itramits">Guarda</button>
        				</div>	
					</div>
				</div>
			</div>
			</div>
				<script>
				// Get the modal
				let modal_15 = document.getElementById("myactaDeKickOff");
				// Get the button that opens the modal
				let btn_15 = document.getElementById("myBtnactaDeKickOff");
				// Get the <span> element that closes the modal
				let span_15 = document.getElementsByClassName("close")[0];
				// When the user clicks the button, open the modal 
				btn_15.onclick = function() {
                    modal_15.style.display = "block";
				}
				// When the user clicks on <span> (x), close the modal
				span_15.onclick = function() {
                    modal_15.style.display = "none";
				}
				// When the user clicks anywhere outside of the modal, close it
				window.onclick = function(event) {
  				if (event.target == modal_15) {
                    modal_15.style.display = "none";
  				}
				}
				</script>
	<?php //}?>
  	</div>
</div>
<!------------------------------------------------------------------------------------------------------>