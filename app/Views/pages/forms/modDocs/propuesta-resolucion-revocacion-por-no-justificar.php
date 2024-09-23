<!----------------------------------------- Propuesta resolución revocació por no justificar DOC 23 SIN VIAFIRMA --------------------------------->
<div class="card-itramits">
  <div class="card-itramits-body">
		Proposta resolució revocació per no justificar<br>
		<small>Pendent crear plantilla json</small>
	</div>
  	<div class="card-itramits-footer">
	  <?php
        if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
        else {?>
			<button type = "button" class = "btn btn-secondary btn-acto-admin" data-bs-toggle = "modal" data-bs-target = "#myResolucionRevocacionPorNoJustificar" id="myBtnResolucionRevocacionPorNoJustificar">Motiu de la revocació</button>  
			<span id="btn_23" class="">
				<button id="wrapper_motivoResolucionRevocacionPorNoJustificar" class='btn btn-secondary btn-acto-admin ocultar' onclick="enviaPropuestaResalucionRevocacionPorNoJustificar(<?php echo $id;?>, '<?php echo $convocatoria;?>', '<?php echo $programa;?>', '<?php echo $nifcif;?>')">Envia a signar l'informe</button>
				<div id='infoMissingDataDoc23' class="alert alert-danger ocultar"></div>
			</span>		
			<span id="spinner_23" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#000000;"></i></span>
		<?php }?>
	</div>
  	<div class="card-itramits-footer">
	<?php if ($expedientes['doc_prop_res_revocacion_por_no_justificar'] !=0) { ?>
        <a class='btn btn-success btn-acto-admin' href="<?php echo base_url('public/index.php/expedientes/muestrainforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_prop_res_revocacion_por_no_justificar');?>" target = "_self"><i class='fa fa-check'></i>La proposta</a>	
	<?php }?>
  	</div>
</div>
<!------------------------------------------------------------------------------------------------------>

		<div id="myResolucionRevocacionPorNoJustificar" class="modal">
			<div class="modal-dialog">
    			<div class="modal-content">
      				<div class="modal-header">
					  	<h4 class="modal-title">Motiu de la revocació:</h4>
        				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      				</div>
      				<div class="modal-body">
								<div class="form-group">
									<textarea required rows="10" cols="30" name="motivoResolucionRevocacionPorNoJustificar" class="form-control" id = "motivoResolucionRevocacionPorNoJustificar" 
									placeholder="Explica el motiu de la revocació"><?php echo $expedientes['motivoResolucionRevocacionPorNoJustificar']; ?></textarea>
        				</div>
								<div class="form-group">
           				<button type="button" onclick = "javaScript: actualizaMotivoResolucionRevocacionPorNoJustificar_click();" id="guardaMotivoResolucionRevocacionPorNoJustificar" 
											class="btn-itramits btn-success-itramits" data-bs-dismiss="modal">Guarda</button>
        				</div>				
    					</div>
  				</div>
			</div>
		</div>
		
	<script>
 		function enviaPropuestaResalucionRevocacionPorNoJustificar(id, convocatoria, programa, nifcif) {
			let todoBien = true
			let fecha_REC = document.getElementById('fecha_REC')
			let ref_REC = document.getElementById('ref_REC')
			let fecha_firma_resolucion_desestimiento = document.getElementById('fecha_firma_resolucion_desestimiento')
			let fecha_notificacion_resolucion = document.getElementById('fecha_notificacion_resolucion')
			let fecha_de_pago = document.getElementById('fecha_de_pago')
			let fecha_reunion_cierre = document.getElementById('fecha_reunion_cierre')
			let fecha_REC_justificacion = document.getElementById('fecha_REC_justificacion')
			let ref_REC_justificacion = document.getElementById('ref_REC_justificacion')
			let fecha_requerimiento_notif = document.getElementById('fecha_requerimiento_notif')

			let base_url = 'https://tramits.idi.es/public/index.php/expedientes/generaInforme'
			let spinner_23 = document.getElementById('spinner_23')
			let infoMissingDataDoc23 = document.getElementById('infoMissingDataDoc23')
			infoMissingDataDoc23.innerText = ""
			if(!fecha_REC.value) {
				infoMissingDataDoc23.innerHTML = infoMissingDataDoc23.innerHTML + "Data SEU sol·licitud<br>"
				todoBien = false
			}
			if(!ref_REC.value) {
				infoMissingDataDoc23.innerHTML = infoMissingDataDoc23.innerHTML + "Referència SEU sol·licitud<br>"
				todoBien = false
			}
			if(!fecha_firma_resolucion_desestimiento.value) {
				infoMissingDataDoc23.innerHTML = infoMissingDataDoc23.innerHTML + "Data firma resolució de desistiment<br>"
				todoBien = false
			}
			if(!fecha_notificacion_resolucion.value) {
				infoMissingDataDoc23.innerHTML = infoMissingDataDoc23.innerHTML + "Data notificació resolució<br>"
				todoBien = false
			}
			if(!fecha_de_pago.value) {
				infoMissingDataDoc23.innerHTML = infoMissingDataDoc23.innerHTML + "Data pagament<br>"
				todoBien = false
			}
			if(!fecha_reunion_cierre.value) {
				infoMissingDataDoc23.innerHTML = infoMissingDataDoc23.innerHTML + "Data reunió tancament<br>"
				todoBien = false
			}
			if(!fecha_REC_justificacion.value) {
				infoMissingDataDoc23.innerHTML = infoMissingDataDoc23.innerHTML + "Data SEU justificació<br>"
				todoBien = false
			}
			if(!ref_REC_justificacion.value) {
				infoMissingDataDoc23.innerHTML = infoMissingDataDoc23.innerHTML + "Referència SEU justificació<br>"
				todoBien = false
			}
			if(!fecha_requerimiento_notif.value) {
				infoMissingDataDoc23.innerHTML = infoMissingDataDoc23.innerHTML + "Data notificació requeriment<br>"
				todoBien = false
			}
			if (todoBien) {
				infoMissingDataDoc23.classList.add('ocultar')
				generaInfFavConReq.disabled = true
				generaInfFavConReq.innerHTML = "Generant ..."
				spinner_23.classList.remove('ocultar')
				window.location.href = base_url+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_prop_res_revocacion_por_no_justificar'
			} else {
				infoMissingDataDoc23.classList.remove('ocultar')
			}
		}
	</script>				