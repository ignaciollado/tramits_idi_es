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
		<h3><strong><?php echo lang('message_lang.solicitud_doc_informe_gei_ils_titulo');?></strong></h3>
  </div>

  <form action="<?php echo base_url('/public/index.php/expedientes/do_doc_informe_gei_upload/'.$data['expedientes']['id'].'/'.$data['expedientes']['nif'].'/'.$data['expedientes']['tipo_tramite'].'/'.$data['expedientes']['convocatoria'].'/'. $idioma);?>" name="form_informeGEI" id="form_informeGEI" method="post" accept-charset="utf-8" enctype="multipart/form-data">

  <input type = "hidden" name="id_sol" id="id_sol" value = "<?php echo $data['expedientes']['id'];?>">
	<input type = "hidden" name="empresa" id="empresa" value = "<?php echo $data['expedientes']['empresa'];?>">
	<input type = "hidden" name="nif" id="nif" maxlength = "9" value = "<?php echo $data['expedientes']['nif'];?>">
	<input type = "hidden" name="convocatoria" id="convocatoria" maxlength = "9" value = "<?php echo $data['expedientes']['convocatoria'];?>">


  <fieldset> 
    <div>
      <h3><strong><?php echo $data['expedientes']['empresa'];?></strong></h3><br>					
				<h3><?php echo lang('message_lang.solicitante_adhesion_ils');?>
          <?php 
	          echo lang('message_lang.informe_gei');
          ?>
        </h3>
    </div>
  </fieldset> 

  <fieldset>  
  	<legend><h4><strong><?php echo lang('message_lang.documento_informe_gei_ils');?></strong></h4> </legend>
	  <section class="panel-justificacion">
		  <div class = "content-file-upload">
  			<h5>[.pdf, .jpg, .png, .webp] <span class="container-radio-invalid">(Max. file size: 10.0 M)</span>:</h5>
	  		  <div>
					  <input type="file" onchange="detectExtendedASCII(this.id, this.files)" id = "file_informeInventarioIls" name="file_informeInventarioIls[]" required size="20" accept=".pdf, .jpg, .png, .webp"/>
				  </div>
		  </div>
	  </section>
	</fieldset>

	<section>
  	<button type="submit" class = "btn-success btn-lg" id = "enviar_docs"><?php echo lang('message_lang.enviar_los_datos');?></button>
  </section>

  </form>

</article>

<script>
	$('#form_informeGEI').submit(function(){

			let theForm = document.getElementById("form_informeGEI");
			theForm.style.cursor = "progress";
  			theForm.disabled = true;
  			theForm.style.opacity =".2";
			$("#enviar_docs", this)
				.html("Enviant, un moment per favor ...")
				.attr('disabled', 'disabled')
				.css("background-color","orange");			

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