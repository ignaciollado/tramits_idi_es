<!-- -------------------------------------- Renovación informe desfavorable DOC 12-->
<div class="card-itramits">
  	<div class="card-itramits-body">
    	 Informe desfavorable [falta json]
  	</div>
	<div class="card-itramits-footer">

		<?php
        if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
        else {?>
			<span id="btn_22212" class="">	
    			<a class="btn btn-secondary btn-acto-admin" id="generaResolucioConcesionSinReqILS" href="<?php echo base_url('public/index.php/expedientes/generainformeILS/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_renovacion_informe_desfavorable_ils');?>">Generar l'informe</a>
			</span>
			<span id="spinner_22212" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#cbebe9;"></i></span>
		<?php }?>
	
	</div>
	<div class="card-itramits-footer">
		<?php if ($expedientes['doc_renovacion_informe_desfavorable_ils'] != 0) { ?>
			<a href="<?php echo base_url('public/index.php/expedientes/muestrainforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_renovacion_informe_desfavorable_ils');?>" target = "_self"><div class = 'btn btn-ver-itramits'><i class='fa fa-check'></i>L'informe desfavorable</div></a>
		<?php } ?>
		<?php //} else {
		?>
		<?php //}
		?>
	</div>
</div>
<!------------------------------------------------------------------------------------------------------>