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
			<button type = "button" class = "btn btn-primary" data-bs-toggle="modal" data-bs-target = "#myDesestimientoRenuncia" id="myBtnDesestimientoRenuncia">Generar la resolució</button>  
			<span id="btn_24" class="">
    			<a id ="wrapper_motivoDesestimientoRenuncia" class="ocultar" href="<?php echo base_url('public/index.php/expedientes/generaInforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_res_revocacion_por_no_justificar');?>"><i class='fa fa-info'></i> Generar el PDF de la resolució</a>
			</span>		
			<span id="spinner_24" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#000000;"></i></span>
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
<div id="myDesestimientoRenuncia" class="modal">
			<div class="modal-dialog">
                <!-- Modal content-->
    			<div class="modal-content" style = "width: 80%;">
      				<div class="modal-header">
					  	<h4 class="modal-title">Motiu del desistiment per renúncia:</h4>
        				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      				</div>
      				<div class="modal-body">
						<div class="form-group">
						<textarea required rows="10" cols="30" name="motivoDesestimientoRenuncia" class="form-control" id = "motivoDesestimientoRenuncia" 
						placeholder="Motiu del desistiment per renúncia"><?php echo $expedientes['motivoDesestimientoRenuncia']; ?></textarea>
        				</div>
						<div class="form-group">
           				<button type="button" onclick = "javaScript: actualizaMotivoDesestimientoRenuncia_click();" id="guardaMotivoDesestimientoRenuncia" 
							class="btn-itramits btn-success-itramits" data-bs-dismiss="modal">Guarda</button>
        				</div>				
    					</div>
  					</div>
				</div>
				</div>
				<script>
					// Get the modal
					let modal_24 = document.getElementById("myDesestimientoRenuncia");
					// Get the button that opens the modal
					let btn_24 = document.getElementById("myBtnDesestimientoRenuncia");
					// Get the <span> element that closes the modal
					let span_24 = document.getElementsByClassName("close")[0];
					// When the user clicks the button, open the modal 
					btn_24.onclick = function() {
                    	modal_24.style.display = "block";
					}
					// When the user clicks on <span> (x), close the modal
					span_24.onclick = function() {
	                    modal_24.style.display = "none";
					}
					// When the user clicks anywhere outside of the modal, close it
					window.onclick = function(event) {
  					if (event.target == modal_24) {
	                    modal_24.style.display = "none";
  					}
					}
				</script>