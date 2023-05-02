<!----------------------------------------- Propuesta resolución revocació por no justificar DOC 23 SIN VIAFIRMA --------------------------------->
<div class="card-itramits">

  <div class="card-itramits-body">
  Proposta resolució revocació per no justificar
  </div>

  	<div class="card-itramits-footer">

	  <?php
        if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
        else {?>
			<!--<a id="generadoc_el_desestimiento" href="<?php echo base_url('public/index.php/expedientes/generaInforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_prop_res_revocacion_por_no_justificar');?>" class="btn-primary-itramits">Genera el desistiment</a>-->
			<button type = "button" class = "btn-primary-itramits" data-bs-toggle="modal" data-bs-target = "#myResolucionRevocacionPorNoJustificar" id="myBtnResolucionRevocacionPorNoJustificar">Generar la proposta</button>  
			<span id="btn_23" class="">
    			<!-- 	<a id ="wrapper_motivoResolucionRevocacionPorNoJustificar" class="ocultar" href="<?php echo base_url('public/index.php/expedientes/generaInforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_prop_res_revocacion_por_no_justificar');?>"><i class='fa fa-info'></i> Generar el PDF de la proposta</a> -->
					<button id="wrapper_motivoResolucionRevocacionPorNoJustificar" class='btn btn-secondary ocultar' onclick="enviaPropuestaResalucionRevocacionPorNoJustificar(<?php echo $id;?>, '<?php echo $convocatoria;?>', '<?php echo $programa;?>', '<?php echo $nifcif;?>')">Envia a signar l'informe</button>
					<div id='infoMissingDataDoc23' class="alert alert-danger ocultar"></div>
			</span>		
			<span id="spinner_23" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#000000;"></i></span>
		<?php }?>  

	</div>

  	<div class="card-itramits-footer">
	<?php if ($expedientes['doc_prop_res_revocacion_por_no_justificar'] !=0) { ?>
        <a	class='btn btn-ver-itramits' href="<?php echo base_url('public/index.php/expedientes/muestrainforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_prop_res_revocacion_por_no_justificar');?>" target = "_self"><i class='fa fa-check'></i>La proposta</a>	
		<?php }?>
	<?php //} else {?>
        
	<?php //}?>
  	</div>
</div>
<!------------------------------------------------------------------------------------------------------>
<!-- The Modal -->
		<div id="myResolucionRevocacionPorNoJustificar" class="modal">
			<div class="modal-dialog">
                <!-- Modal content-->
    			<div class="modal-content">
      				<div class="modal-header">
      					<label for="motivoResolucionRevocacionPorNoJustificar"><strong>Escriu el motiu de la resolució de revocació:</strong></label>
								<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      				</div>
      				<div class="modal-body">
								<div class="form-group">
									<textarea required rows="10" cols="30" name="motivoResolucionRevocacionPorNoJustificar" class="form-control" id = "motivoResolucionRevocacionPorNoJustificar" 
									placeholder="Motiu del desistiment per renúncia"><?php echo $expedientes['motivoResolucionRevocacionPorNoJustificar']; ?></textarea>
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
			let base_url = 'https://tramits.idi.es/public/index.php/expedientes/generaInforme'
			let spinner_23 = document.getElementById('spinner_23')
			let infoMissingDataDoc23 = document.getElementById('infoMissingDataDoc23')
			infoMissingDataDoc23.innerText = ""
			if(!fecha_REC.value) {
				infoMissingDataDoc23.innerHTML = infoMissingDataDoc23.innerHTML + "Data REC sol·licitud<br>"
				todoBien = false
			}
			if(!ref_REC.value) {
				infoMissingDataDoc23.innerHTML = infoMissingDataDoc23.innerHTML + "Referència REC sol·licitud<br>"
				todoBien = false
			}

			if (todoBien) {
				infoMissingDataDoc23.classList.add('ocultar')
				generaInfFavConReq.disabled = true
				generaInfFavConReq.innerHTML = "Generant ..."
				spinner_23.classList.remove('ocultar')
				window.location.href = base_url+'/'+id+'/'+convocatoria+'/'+programa+'/'+nifcif+'/doc_requeriment'
			} else {
				infoMissingDataDoc23.classList.remove('ocultar')
			}
		}
		</script>				