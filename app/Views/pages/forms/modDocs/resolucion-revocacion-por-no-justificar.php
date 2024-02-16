<!----------------------------------------- Resolución revocació por no justificar DOC 24 SIN VIAFIRMA --------------------------------->
<div class="card-itramits">
  	<div class="card-itramits-body">Resolució revocació per no justificar</div>
  	<div class="card-itramits-footer">
	  <?php
        if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
        else {?>
		 	<button type="button" class="btn btn-secondary btn-acto-admin" data-bs-toggle="modal" data-bs-target="#myRevocacionPorNoJustificar" id="myBtnRevocacionPorNoJustificar">Motiu de la revocació</button>
			<span id="btn_24" class="">
    			<a id ="wrapper_motivoRevocacionPorNoJustificar" class="ocultar btn-acto-admin" href="<?php echo base_url('public/index.php/expedientes/generaInforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_res_revocacion_por_no_justificar');?>"><i class='fa fa-info'></i> Genera la resolució</a>
			</span>
			<span id="spinner_24" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#000000;"></i></span>
		<?php }?>
	</div>
  	<div class="card-itramits-footer">
		<?php if ($expedientes['doc_res_revocacion_por_no_justificar'] !=0) { ?>
	      <a	class='btn btn-success btn-acto-admin' href="<?php echo base_url('public/index.php/expedientes/muestrainforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_res_revocacion_por_no_justificar');?>" target = "_self"><i class='fa fa-check'></i>La resolució</a>	
		<?php }?>
  	</div>
</div>
<!------------------------------------------------------------------------------------------------------>
<div id="myRevocacionPorNoJustificar" class="modal" >
  	<div class="modal-dialog">
    	<div class="modal-content">	
			<div class="modal-header">
				<h4 class="modal-title">Motiu de la revocació per no justificar:</h4>
        		<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      		</div>
      		<div class="modal-body">
			  	<div class="form-group">
					<textarea required rows="10" cols="30" name="textoRevocacionPorNoJustificar" class="form-control" id = "textoRevocacionPorNoJustificar" 
					placeholder="Motiu de la revocació per no justificar"><?php echo $expedientes['motivoResolucionRevocacionPorNoJustificar']; ?></textarea>
        		</div>
      		</div>
      		<div class="modal-footer">
			  	<div class="form-group">
           			<button type="button" onclick = "javaScript: actualizaMotivoRevocacionPorNoJustificar_click();" id="guardaMotivoRevocacionPorNoJustificar" 
					class="btn-itramits btn-success-itramits" data-bs-dismiss="modal">Guarda</button>
        		</div>				
      		</div>
    	</div>
  	</div>
</div>