<!DOCTYPE html>
<html lang="es-ES">
<head>
	<meta charset="UTF-8">
	<title><?php echo lang('message_lang.titulo_sol_form_ils');?></title>
	<meta name="description" content="Assistent per sol·licitar l'adhesió al programa i formar part d'ILS">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Latest compiled and minified CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<!-- jQuery library -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 -->
<!-- <script src="https://use.fontawesome.com/5db4446d08.js"></script>
 -->
<!-- Latest compiled JavaScript -->
	
	<link rel="icon" type="image/png" href="/public/assets/images/adr-balears.png" />
	<link rel="stylesheet" type="text/css" href="/public/assets/css/style-pindust.css"/>
	<link rel="stylesheet" type="text/css" href="/public/assets/css/estilos.css"/>	
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
		$nif = $data['expedientes']['nif'];
		$tipoTramite = $data['expedientes']['tipo_tramite'];
		$convocatoria = $data['expedientes']['convocatoria'];
?>

<body>
<article>
	<!-- HEADER: MENU + HEROE SECTION -->
	<header class="header__formempresasils">
		<fieldset class="header__formempresasils--logo">
			<a href="http://www.adrbalears.es" target="_blank">
				<img class="logo" alt="logo" title="ADR Balers" src="<?php echo base_url() ."/public/assets/images/con-adr-ils.svg";?>" />
			</a>
		</fieldset>
		<fieldset class="header__formempresasils--documento">
    	<h5><?php echo lang('message_lang.justificacion_exp');?>:  <?php echo $data['expedientes']['idExp'];?> / <?php echo $data['expedientes']['convocatoria'];?></h5>
    	<h5><?php echo lang('message_lang.destino_solicitud');?>: <?php echo lang('message_lang.idi');?></h5>
    	<h5><?php echo lang('message_lang.codigo_dir3');?> <?php echo $data['configuracion']['emisorDIR3'];?></h5>
  	</fieldset>
	</header>
	<div class="btn-group" role="group" aria-label="lang toggle">
		<a href="<?php echo base_url('/public/index.php/home/renovacion_marca_ils/').'/'.$id.'/'.$nif.'/'.$tipoTramite.'/'.$convocatoria.'/ca'; ?>" class="btn btn-outline-primary" role="button"> Català</a>
		<a href="<?php echo base_url('/public/index.php/home/renovacion_marca_ils/').'/'.$id.'/'.$nif.'/'.$tipoTramite.'/'.$convocatoria.'/es'; ?>" class="btn btn-outline-primary" role="button"> Castellano</a>
	</div>
</article>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>