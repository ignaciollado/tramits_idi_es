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
	<header class="headerFormlineaXecs">
		<div class="langtoggle btn-group" role="group" aria-label="Language toggle">
			<a title="Català" href="<?php echo base_url('/public/index.php/home/set_lang/ca'); ?>" class="btn btn-outline-light text-dark" role="button"> Català</a>
			<a title="Castellano" href="<?php echo base_url('/public/index.php/home/set_lang/es'); ?>" class="btn btn-outline-light text-dark" role="button"> Castellano</a>
		</div>
		<div class='logoarea'>
				<a href='https://www.adrbalears.es' target="_blank" title="Agència de desenvolupament regional de les Illes Balears (ADR Balears)">
					<img width="70%" src='/public/assets/images/ADRBalears-conselleria.jpg' alt='logo adr-balears-conselleria' title="Agència de desenvolupament regional de les Illes Balears (ADR Balears)">
				</a>
		</div>

  	<div class="formspecifications">
			<div class='formspecifications_row'><span class='formspecifications_col'><?php echo lang('message_lang.destino_solicitud');?>: </span><span class='formspecifications_col'><?php echo lang('message_lang.idi');?></span></div>
			<div class='formspecifications_row'><span class='formspecifications_col'><?php echo lang('message_lang.codigo_dir3');?> </span><span class='formspecifications_col'><?php echo $configuracion['emisorDIR3'];?></span></div>
			<div class='formspecifications_row'><span class='formspecifications_col'><?php echo lang('message_lang.codigo_sia');?> </span><span class='formspecifications_col'><?php echo $configuracionLinea['codigoSIA'];?></span></div>
			<div class='formspecifications_row'><span class='formspecifications_col'><?php echo lang('message_lang.convocatoria_sol_idigital');?>: </span><span class='formspecifications_col'><?php echo $configuracionLinea['convocatoria'];?></span></div>
		</div>
	</header>
</article>