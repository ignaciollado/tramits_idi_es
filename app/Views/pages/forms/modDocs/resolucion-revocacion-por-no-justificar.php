<!----------------------------------------- Resolución revocació por no justificar DOC 24 SIN VIAFIRMA --------------------------------->
<div class="card-itramits">

  <div class="card-itramits-body">
  Resolució revocació per no justificar
  </div>

  	<div class="card-itramits-footer">

	  <?php
        if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
        else {?>
			<!--<a id="generadoc_el_desestimiento" href="<?php echo base_url('public/index.php/expedientes/generaInforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_res_revocacion_por_no_justificar');?>" class="btn-primary-itramits">Genera el desistiment</a>-->
			<button type = "button" class = "btn-primary-itramits" data-toggle = "modal" data-target = "#myDesestimientoRenuncia" id="myBtnDesestimientoRenuncia">Generar la resolució</button>  
			<span id="btn_14" class="">
    			<a id ="wrapper_motivoDesestimientoRenuncia" class="ocultar" href="<?php echo base_url('public/index.php/expedientes/generaInforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_res_revocacion_por_no_justificar');?>"><i class='fa fa-info'></i> Generar el PDF de la resolució</a>
			</span>		
			<span id="spinner_14" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#000000;"></i></span>
		<?php }?>  

	</div>

  	<div class="card-itramits-footer">
	<?php if ($expedientes['doc_res_revocacion_por_no_justificar'] !=0) { ?>
        <a	class='btn btn-ver-itramits' href="<?php echo base_url('public/index.php/expedientes/muestrainforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_res_revocacion_por_no_justificar');?>" target = "_self"><i class='fa fa-check'></i>La resolució</a>	
		<?php }?>
	<?php //} else {?>
        
	<?php //}?>
  	</div>
</div>
<!------------------------------------------------------------------------------------------------------>

<!-- The Modal -->
<div id="myDesestimientoRenuncia" class="modal fade" role="dialog">
			<div class="modal-dialog">
                <!-- Modal content-->
    			<div class="modal-content" style = "width: 80%;">
      				<div class="modal-header">
      					<label for="motivoDesestimientoRenuncia"><strong>Escriu el motiu del desistiment per renúncia:</strong></label>
        				<button type="button" class="close" data-dismiss="modal">&times;</button>
      				</div>
      				<div class="modal-body">
						<div class="form-group">
						<textarea required rows="10" cols="30" name="motivoDesestimientoRenuncia" class="form-control" id = "motivoDesestimientoRenuncia" 
						placeholder="Motiu del desistiment per renúncia"><?php echo $expedientes['motivoDesestimientoRenuncia']; ?></textarea>
        				</div>
						<div class="form-group">
           				<button type="button" onclick = "javaScript: actualizaMotivoDesestimientoRenuncia_click();" id="guardaMotivoDesestimientoRenuncia" 
							class="btn-itramits btn-success-itramits">Guarda</button>
        				</div>				
    					</div>
  					</div>
				</div>
				</div>
				<script>
					// Get the modal
					let modal_14 = document.getElementById("myDesestimientoRenuncia");
					// Get the button that opens the modal
					let btn_14 = document.getElementById("myBtnDesestimientoRenuncia");
					// Get the <span> element that closes the modal
					let span_14 = document.getElementsByClassName("close")[0];
					// When the user clicks the button, open the modal 
					btn_14.onclick = function() {
                    	modal_14.style.display = "block";
					}
					// When the user clicks on <span> (x), close the modal
					span_14.onclick = function() {
	                    modal_14.style.display = "none";
					}
					// When the user clicks anywhere outside of the modal, close it
					window.onclick = function(event) {
  					if (event.target == modal_14) {
	                    modal_14.style.display = "none";
  					}
					}
				</script>