<!-- -------------------------------------- Resolución concesión adhesión ils sin requerimiento-->
<div class="card-itramits">
  	<div class="card-itramits-body">
    	 Resolució concesió adhesió <strong>amb</strong> requeriment
  	</div>
	<div class="card-itramits-footer">

		<?php
        if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
        else {?>
			<span id="btn_333" class="">	
    			<a id="generaResolucioConcesionConReqILS" href="<?php echo base_url('public/index.php/expedientes/generaInformeILS/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_resolucion_concesion_adhesion_con_req_ils');?>"><i title="Generar la resolució" class="fa-solid fa-file-pdf fa-2xl" style="color: #365446;"></i></a>
			</span>
			<span id="spinner_333" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#cbebe9;"></i></span>
		<?php }?>
	
	</div>
	<div class="card-itramits-footer">
		<?php if ($expedientes['doc_res_concesion_adhesion_con_req_ils'] != 0) { ?>
			<a href="<?php echo base_url('public/index.php/expedientes/muestrainforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_resolucion_concesion_adhesion_con_req_ils');?>" target = "_self"><div class = 'btn btn-ver-itramits'><i class='fa fa-check'></i>La resolució de concesió <br>d'adhesió <strong>amb</strong> requeriment</div></a>

		<?php } ?>
		<?php //} else {
		?>
		<?php //}
		?>
	</div>	
	
</div>
<!------------------------------------------------------------------------------------------------------>