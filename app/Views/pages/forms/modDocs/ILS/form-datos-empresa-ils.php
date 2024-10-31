<!-- CONTENT -->
  <script defer type="text/javascript" src="/public/assets/js/comprueba-Documento-Identificador.js"></script>
	<script defer type="text/javascript" src="/public/assets/js/adhesion-ils.js"></script>	
	<link rel="stylesheet" type="text/css" href="/public/assets/css/form-adhesion-ils.css"/>


<?php 
	use App\Models\ConfiguracionModel;
	use App\Models\ExpedientesModel;
	$configuracion = new ConfiguracionModel();
	$modelExp = new ExpedientesModel();
	$db = \Config\Database::connect();
	
	$uri = new \CodeIgniter\HTTP\URI();
	$request = \Config\Services::request();

	$language = \Config\Services::language();
	$language->setLocale($idioma);

	$data['configuracion'] = $configuracion->where('convocatoria_activa', 1)->first();
	$data['expedientes'] = $modelExp->where('id', $id)->first();
?>

<article>

  <div class="alert alert-info">
		<h3><strong><?php echo lang('message_lang.datos_empresa_ils_titulo');?></strong></h3>
  </div>

  <form action="<?php echo base_url('/public/index.php/expedientes/do_datos_empresa_ils_upload/'.$data['expedientes']['id'].'/'.$data['expedientes']['nif'].'/'.$data['expedientes']['tipo_tramite'].'/'.$data['expedientes']['convocatoria'].'/'. $idioma);?>" name="form_justificacion" id="form_justificacion" method="post" accept-charset="utf-8" enctype="multipart/form-data">

  <input type = "hidden" name="id_sol" id="id_sol" value = "<?php echo $data['expedientes']['id'];?>">
	<input type = "hidden" name="empresa" id="empresa" value = "<?php echo $data['expedientes']['empresa'];?>">
	<input type = "hidden" name="nif" id="nif" maxlength = "9" value = "<?php echo $data['expedientes']['nif'];?>">
	<input type = "hidden" name="convocatoria" id="convocatoria" maxlength = "9" value = "<?php echo $data['expedientes']['convocatoria'];?>">


    <fieldset> 
      <div>
        <h3><strong><?php echo $data['expedientes']['empresa'];?></strong></h3><br>
					
				<h3><?php echo lang('message_lang.solicitante_adhesion_ils');?>
          <?php 
	          echo lang('message_lang.datos_empresa_ils_adicionales');
          ?>
        </h3>
      </div>
    </fieldset> 

    <fieldset>  
  		<legend><h4><strong><?php echo lang('message_lang.logotipo_empresa_ils');?></strong></h4> </legend>
		  <section class="panel-justificacion">
			  <div class = "content-file-upload">
  				<h5>[.jpg, .png, .webp] <span class="container-radio-invalid">(Max. file size: 10.0 M)</span>:</h5>
				  <div>
					  <input type="file" onchange="detectExtendedASCII(this.id, this.files)" id = "file_logotipoEmpresaIls" name="file_logotipoEmpresaIls[]" required size="20" accept=".jpg, .png, .webp"/>
				  </div>
			  </div>
		  </section>
	  </fieldset>

	  <fieldset> 
		  <legend><h4><strong><?php echo lang('message_lang.sitio_web_empresa_ils');?></strong></h4> </legend>
  			<section class="panel-justificacion">
	  				<div>
		  				<input type="text" id = "sitio_web_empresa" name = "sitio_web_empresa" size = "20" />
					  </div>
			  </section>
		</fieldset>
	
		<fieldset> 
			<legend><h4><strong><?php echo lang('message_lang.video_empresa_ils');?></strong></h4> </legend>
			<section class="panel-justificacion">
					<div>
						<input type = "text" id = "video_empresa" name = "video_empresa" size = "20" />
					</div>
			</section>		
		</fieldset>

    <fieldset> 
			<legend><h4><strong><?php echo lang('message_lang.canales_comercializacion_empresa');?></strong></h4> </legend>
			<section class="panel-justificacion">
					<div>
          <textarea id="canales_comercializacion_empresa" name="canales_comercializacion_empresa" title="<?php echo lang('message_lang.comercializacion_empresa_ils');?>" placeholder = "<?php echo lang('message_lang.comercializacion_empresa_ils');?>" rows="3" cols="50"></textarea>
					</div>
			</section>		
		</fieldset>  

    <fieldset> 
			<legend><h4><strong><?php echo lang('message_lang.fecha_creacion_empresa_ils');?></strong></h4> </legend>
			<section class="panel-justificacion">
					<div>
						<input type = "date" id = "fecha_creacion_empresa" name = "fecha_creacion_empresa" size = "20" />
					</div>
			</section>		
		</fieldset>  

	  <section>
  		<button type="submit" class = "btn-success btn-lg" id = "enviar_docs"><?php echo lang('message_lang.enviar_los_datos');?></button>
  	</section>

  </form>
<!--   <div class="alert alert-info"> 
	  <i class="fa fa-info-circle" style="font-size:24px;color:red;"></i> info
	  <span > <?php echo lang('message_lang.upload_multiple');?></span>
  </div> -->
</article>

<script>
	$('#form_justificacion').submit(function(){
		if ( $("#file_PlanTransformacionDigital").val().length == 0 && $("#file_FactTransformacionDigital").val().length == 0 && $("#file_PagosTransformacionDigital").val().length == 0)
			{
			alert ("¡Por favor, seleccione algún archivo para enviarnos!");
			return false;
			}
		else {
			let theForm=document.getElementById("form_justificacion");
			theForm.style.cursor="progress";
  			theForm.disabled = true;
  			theForm.style.opacity =".2";
			$("#enviar_docs", this)
				.html("Enviant, un moment per favor ...")
				.attr('disabled', 'disabled')
				.css("background-color","orange");			
		}
	});
</script>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
		    <h4 class="modal-title"><?php echo lang('message_lang.clausula_idi');?></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div><span style='font-size:8pt'><span style='font-family:Trebuchet\ MS,Default\ Sans\ Serif,Verdana,Arial,Helvetica,sans-serif'>
        <?php echo lang('message_lang.rgpd_txt');?>
        </span></div>
        <div class="modal-footer">
          <button type = "button" id = "documentacion_justificacion" class = "btn btn-default" data-dismiss="modal"><?php echo lang('message_lang.cierra');?></button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
	$(document).ready(function(){
		$("#file_PlanTransformacionDigital").focusout(function() {
		var inputValue = $(this).val();
		var txt = "";
		
		if (inputValue == "" || document.getElementById("file_PlanTransformacionDigital").validity.patternMismatch)
			{
			txt = "Hauria de ser un nom vàlid !!!";
			document.getElementById("mensaje").innerHTML = txt;			
			$("#file_PlanTransformacionDigital").focus();
			$('#centre').prop('disabled', true);
			$("#file_PlanTransformacionDigital").addClass("form-control is-not-valid");
			$('#enviar_inscripcion').prop('disabled', true);
			}
		else
			{
			txt = "";
			document.getElementById("mensaje").innerHTML = txt;		
			$('#centre').prop('disabled', false);
			}
			})
			
		$( "#rgpd" ).change(function() {
		if ($(this).is(":checked"))
			{
			$('#documentacion_justificacion').prop('disabled', false);
		}
		else
		{
			$('#documentacion_justificacion').prop('disabled', true);	
		}
		});
	});	
</script>