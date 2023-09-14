<!-- -------------------------------------- Resolución concesión adhesión ils sin requerimiento-->
<div class="card-itramits">
  	<div class="card-itramits-body">
    	 Resolució concesió adhesió <strong style="background-color:#c5eae2;padding:0.5rem;">sense</strong> requeriment
  	</div>
	<div class="card-itramits-footer">

		<?php
        if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
        else {?>
			<span id="btn_222" class="">	
    			<a id="generaResolucioConcesionSinReqILS" class = "btn btn-primary" href="<?php echo base_url('public/index.php/expedientes/generainformeILS/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_resolucion_concesion_adhesion_ils');?>">Generar la resolució</a>
			</span>
			<span id="spinner_222" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#cbebe9;"></i></span>
		<?php }?>
	
	</div>
	<div class="card-itramits-footer">
		<?php if ($expedientes['doc_res_concesion_adhesion_sin_req_ils'] != 0) { ?>
			<a href="<?php echo base_url('public/index.php/expedientes/muestrainforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_resolucion_concesion_adhesion_ils');?>" target = "_self"><div class = 'btn btn-ver-itramits'><i class='fa fa-check'></i>La resolució de concesió <br>d'adhesió <strong>sense</strong> requeriment</div></a>

		<?php } ?>
		<?php //} else {
		?>
		<?php //}
		?>
	</div>

</div>
<!------------------------------------------------------------------------------------------------------>