<!DOCTYPE html>
<html lang="es-ES">
<head>
	<meta charset="UTF-8">
	<title><?php echo lang('message_lang.titulo_sol_form');?></title>
	<meta name="description" content="Sol·licitud d'ajuts Xecs consultoria">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Latest compiled and minified CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://use.fontawesome.com/5db4446d08.js"></script>
	<link rel="icon" type="image/png" href="/public/assets/images/adr-balears.png" />
	<link rel="stylesheet" type="text/css" href="/public/assets/css/style-pindust.css"/>
	<link rel="stylesheet" type="text/css" href="/public/assets/css/estilos.css"/>
	<link rel="stylesheet" type="text/css" href="/public/assets/css/form-solicitud-ayuda.css"/>
	<script type="text/javascript" src="/public/assets/js/comprueba-Documento-Identificador.js"></script>
	<script type="text/javascript" src="/public/assets/js/solicitud-ayuda.js"></script>
</head>
<body>
<article>
<!-- HEADER: MENU + HEROE SECTION -->
<header>
	<div class="menu">
		<div>
			<a href="http://www.adrbalears.es" target="_blank" title="Agència de desenvolupament regional de les Illes Balears (ADR Balears)">
				<img class="logo" alt="logo ADR Balears" title="Agència de desenvolupament regional de les Illes Balears (ADR Balears)" src="<?php echo base_url() ."/public/assets/images/ADRBalears-conselleria.jpg";?>" />
			</a>
		</div>
		<div>

  <fieldset>
		<h4><?php echo lang('message_lang.destino_solicitud');?>: <strong><?php echo lang('message_lang.idi');?></strong></h4>
		<h4><?php echo lang('message_lang.codigo_dir3');?> <strong><?php echo $configuracion['emisorDIR3'];?></strong></h4>
		<h4><?php echo lang('message_lang.codigo_sia');?> <strong><?php echo $configuracionLinea['codigoSIA'];?></strong></h4>
		<h4><?php echo lang('message_lang.convocatoria_sol_idigital');?>: <strong><?php echo $configuracionLinea['convocatoria'];?></strong></h4>
	</fieldset> 
		</div>
	</div>
</header>
</article>