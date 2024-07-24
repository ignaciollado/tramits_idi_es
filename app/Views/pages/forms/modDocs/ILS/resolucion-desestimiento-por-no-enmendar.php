<!----------------------------------------- Resolució desistiment por no esmenar SIN VIAFIRMA--------------------------------->
<div class="card-itramits">

  <div class="card-itramits-body">
  	Resolució desistiment per no esmenar
  </div>

  	<div class="card-itramits-footer">
	  <?php
        if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
        else {?>
			<span id="btn_21" class="">	
				<a class="btn btn-secondary btn-acto-admin" id="genera_desestimiento_ils" href="<?php echo base_url('public/index.php/expedientes/generainformeILS/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_res_desestimiento_por_no_enmendar_ils');?>">Genera el desestiment</a>
			</span>
			<span id="spinner_21" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#cbebe9;"></i></span>
		<?php }?>  

	</div>

  	<div class="card-itramits-footer">
	<?php if ($expedientes['doc_res_desestimiento_por_no_enmendar_ils'] !=0) { ?>
        <a class='btn btn-ver-itramits' href="<?php echo base_url('public/index.php/expedientes/muestrainforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_res_desestimiento_por_no_enmendar_ils');?>" target = "_self">El desistiment per no esmenar</a>	
		<?php }?>
	<?php //} else {?>
        
	<?php //}?>
  	</div>
</div>
<!------------------------------------------------------------------------------------------------------>