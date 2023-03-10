<!DOCTYPE html>
<html lang="es-ES">
<head>
	<meta charset="UTF-8">
	<title><?php echo lang('message_lang.titulo_solicitud_idi_isba');?></title>
	<meta name="description" content="Assistent per sol·licitar la linia de ajuts idi-isba">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
	<link rel="icon" type="image/jpg" href="/public/assets/images/headeridi.jpg" />
	<link rel="stylesheet" type="text/css" href="/public/assets/css/style-idi-isba.css"/>
	<script defer type="text/javascript" src="/public/assets/js/comprueba-Documento-Identificador.js"></script>
	<script defer type="text/javascript" src="/public/assets/js/adhesion-idi-isba.js"></script>	
</head>


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


<body>
<article>
	<!-- HEADER: MENU + HEROE SECTION -->
	<header class="header__formlineaidiisba">
		<div class="langtoggle btn-group">
			<a title="Català" href="<?php echo base_url('/public/index.php/home/solicitud_linea_idi_isba'); ?>" class="btn btn-outline-light text-dark" role="button"> Català</a>
			<a title="Castellano" href="<?php echo base_url('/public/index.php/home/solicitud_linea_idi_isba_es'); ?>" class="btn btn-outline-light text-dark" role="button"> Castellano</a>
		</div>

		<div class='logoarea'>
			<a href='https://www.isbasgr.es/es/' target="_blank">
				<img src='/public/assets/images/logo-isba-sgr-317.png' alt=' logo isba sgr'>
			</a>
			<a href='https://www.idi.es' target="_blank">
				<img src='/public/assets/images/logo_institut_dinnovacio_empresarial_col_horitz.jpg' alt='logo idi-conselleria'>
			</a>
		</div>

		<div class='titleform'>
			<h1><?php echo lang('message_lang.titulo_solicitud_idi_isba');?></h1>
		</div>

		<div class='siacode'>
			<h5><?php echo lang('message_lang.Codi_SIA');?>: <?php echo $data['configuracion']['codigoSIA'];?></h5>
		</div>

		<div class="formspecifications">
	   	<div class='formspecifications_row'><span class='formspecifications_col'><?php echo lang('message_lang.destino_solicitud');?>:</span><span class='formspecifications_col'><?php echo lang('message_lang.idi');?></span></div>
			<div class='formspecifications_row'><span class='formspecifications_col'><?php echo lang('message_lang.codigo_dir3');?></span><span class='formspecifications_col'><?php echo $data['configuracion']['emisorDIR3'];?></span></div>
			<div class='formspecifications_row'><span class='formspecifications_col'><?php echo lang('message_lang.tramite_procedimiento');?>:</span class='formspecifications_col'><span><?php echo lang('message_lang.tramite_procedimiento_texto');?></span></div>
		</div>
	</header>
</article>