<!-----------------------------------------14.-abril_Resolució desistiment  2021 SIN VIAFIRMA--------------------------------->
<div class="card-itramits">

  <div class="card-itramits-body">
  14. Resolució desistiment
  </div>

  	<div class="card-itramits-footer">

	  <?php
        if ( !$esAdmin && !$esConvoActual ) {?>
        <?php }
        else {?>
			<a id="generadoc_el_desestimiento" href="<?php echo base_url('public/index.php/expedientes/generaInforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_res_desestimiento');?>" class="btn-primary-itramits">Genera el desistiment</a>
			<span id="spinner_14" class ="ocultar"><i class="fa fa-refresh fa-spin" style="font-size:16px; color:#000000;"></i></span>
		<?php }?>  

	</div>

  	<div class="card-itramits-footer">
	<?php if ($expedientes['doc_res_desestimiento'] !=0) { ?>
        <a	class='btn btn-ver-itramits' href="<?php echo base_url('public/index.php/expedientes/muestrainforme/'.$id.'/'.$convocatoria.'/'.$programa.'/'.$nifcif.'/doc_res_desestimiento');?>" target = "_self"><i class='fa fa-check'></i>El desistiment</a>	
		<?php }?>
	<?php //} else {?>
        
	<?php //}?>
  	</div>
</div>
<!------------------------------------------------------------------------------------------------------>