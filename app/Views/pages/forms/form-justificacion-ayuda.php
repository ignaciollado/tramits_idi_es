<!-- CONTENT -->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->


<!-- <script async type="text/javascript" src="/public/assets/js/edita-expediente.js"></script> -->


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

	/* $data['configuracion'] = $modelConfig->where('tipo_tramite', 'iDigital')->first(); */
	$data['configuracion'] = $configuracion->where('convocatoria_activa', 1)->first();
	$data['expedientes'] = $modelExp->where('id', $id)->first();
?>

<section>
    <fieldset>
<h5><?php echo lang('message_lang.justificacion_doc');?>: <strong><?php echo lang('message_lang.justificacion_titulo');?></strong></h5>
<h5><?php echo lang('message_lang.justificacion_exp');?>:  <?php echo $data['expedientes']['idExp'];?> / <?php echo $data['expedientes']['convocatoria'];?></h5>
<h5><?php echo lang('message_lang.destino_solicitud');?>: <?php echo lang('message_lang.idi');?></h5>
<h5><?php echo lang('message_lang.codigo_dir3');?> <?php echo $data['configuracion']['emisorDIR3'];?></h5>
   </fieldset> 

<div class="alert alert-info">
<?php echo lang('message_lang.intro_sol_idigital');?>
</div>

<?php 
//$attributes = ['id' => 'form_justificacion'];
//echo form_open_multipart('public/index.php/expedientes/do_justificacion_upload/'.$data['expedientes']['id'].'/'.$nif.'/'.$tipoTramite, $attributes);?>

<form action="<?php echo base_url('/public/index.php/expedientes/do_justificacion_upload/'.$data['expedientes']['id'].'/'.$data['expedientes']['nif'].'/'.$data['expedientes']['tipo_tramite'].'/'.$data['expedientes']['convocatoria'].'/'. $idioma);?>" name="form_justificacion" id="form_justificacion" method="post" accept-charset="utf-8" enctype="multipart/form-data">

<input type = "hidden" name="id_sol" id="id_sol" value = "<?php echo $data['expedientes']['id'];?>">

<div>
<fieldset> 
<div><h4><?php echo lang('message_lang.solicitante');?>
<span><?php echo $data['expedientes']['empresa'];?></span> <?php echo lang('message_lang.conCIF');?><span><?php echo $data['expedientes']['nif'];?></span>
		<input type = "hidden" title = "<?php echo lang('message_lang.solicitante_sol_idigital');?>" readonly 
		placeholder = "<?php echo lang('message_lang.solicitante_sol_idigital');?>" class="grid-item-profesor" required minlength = "4" name="empresa" id="empresa" value = "<?php echo $data['expedientes']['empresa'];?>" >
		<input type = "hidden" title="NIF del consultor digital" readonly  placeholder = "NIF" class="grid-item-profesor" required name="nif" id="nif" maxlength = "9" value = "<?php echo $data['expedientes']['nif'];?>">

<?php 
/* if ($data['expedientes']['tipo_tramite'] =='Programa I') { */
	echo lang('message_lang.justificacion_declaracion').": ";
/* }
else {
	echo lang('message_lang.justificacion_declaracion_PII_PIII').": ";
} */
?>
</h4>
</div>
</fieldset> 
</div>

<div>  
	<fieldset>  
		<!-- <?php //if ($data['expedientes']['tipo_tramite'] =='Programa I' || $data['expedientes']['tipo_tramite'] =='Programa iDigital 20') {?> -->
			<legend><h4><strong><?php echo lang('message_lang.justificacion_plan_p1');?></strong></h4> </legend>
		<!-- <?php //} else {?>
			<legend><h4><strong><?php echo lang('message_lang.justificacion_plan_p2_p3');?></strong></h4> </legend>
		<?php //}?>	 -->	
		<div class="panel-justificacion">
			<div class = "content-file-upload">
				<h5>[.pdf]:</h5>
				<div>
					<input type="file" onchange="detectExtendedASCII(this.id, this.files)" id = "file_PlanTransformacionDigital" name="file_PlanTransformacionDigital[]" required size="20" accept=".pdf" multiple />
				</div>
			</div>
		</div>
	</fieldset>

	<!-- <?php //if ($data['expedientes']['tipo_tramite'] =='Programa I' || $data['expedientes']['tipo_tramite'] =='Programa iDigital 20') {?> -->
		<fieldset> 
			<legend><h4><strong><?php echo lang('message_lang.justificacion_facturas_doc');?></strong></h4> </legend>
			<div class="panel-justificacion">
				<div class = "content-file-upload">
				<h5>[.pdf]:</h5>
					<div>
						<input type="file" onchange="detectExtendedASCII(this.id, this.files)" id = "file_FactTransformacionDigital" name = "file_FactTransformacionDigital[]" required size = "20" accept = ".pdf" multiple />
					</div>
				</div>
			</div>
		</fieldset>
	
		<fieldset> 
			<legend><h4><strong><?php echo lang('message_lang.justificacion_justificantes_doc');?></strong></h4> </legend>
			<div class="panel-justificacion">
				<div class = "content-file-upload">
				<h5>[.pdf]:</h5>
					<div>
						<input type = "file" onchange="detectExtendedASCII(this.id, this.files)" id = "file_PagosTransformacionDigital" name = "file_PagosTransformacionDigital[]" required size = "20" accept = ".pdf" multiple />
					</div>
				</div>		
			</div>
		</fieldset>
	<!-- <?php //}?> -->
	<div>
		<button type="submit" class = "btn-success btn-lg" id = "enviar_docs"><?php echo lang('message_lang.enviar_documentacion');?></button>
	</div>
</div>
</form>
<div class="alert alert-info"> 
	<i class="fa fa-info-circle" style="font-size:24px;color:red;"></i> info
	<span > <?php echo lang('message_lang.upload_multiple');?></span>
</div>

<script>
	$('#form_justificacion').submit(function(){
		if ( $("#file_PlanTransformacionDigital").val().length == 0 && $("#file_FactTransformacionDigital").val().length == 0 && $("#file_PagosTransformacionDigital").val().length == 0)
			{
			alert ("??Por favor, seleccione alg??n archivo para enviarnos!");
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
</section>

<script>
	//var acc = document.getElementsByClassName("accordion");
	//var i;

	//for (i = 0; i < acc.length; i++) {
  	//	acc[i].addEventListener("click", function() {
	//    /* Toggle between adding and removing the "active" class,
    //	to highlight the button that controls the panel */
    //	this.classList.toggle("active");

    //	/* Toggle between hiding and showing the active panel */
    //	var panel = this.nextElementSibling;
    //	if (panel.style.display === "block") {
    //  		panel.style.display = "none";
    //	} else {
    //  		panel.style.display = "block";
    //	}
  	//});
	//}
</script>

<script>
	$(document).ready(function(){
		$("#file_PlanTransformacionDigital").focusout(function() {
		var inputValue = $(this).val();
		var txt = "";
		
		if (inputValue == "" || document.getElementById("file_PlanTransformacionDigital").validity.patternMismatch)
			{
			txt = "Hauria de ser un nom v??lid !!!";
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