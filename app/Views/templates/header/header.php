<!DOCTYPE html>
<html lang="es-ES">
<head>
	<meta charset="UTF-8">
	<title><?= esc($titulo); ?></title>
	<meta name="description" content="Gestor d'ajuts i de subvencions de  l'ADR Balears">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- <meta name="google-signin-scope" content="profile email"> -->
	<!--- PRODUCCIÓN -->
   <!--  <meta name="google-signin-client_id" content="317070054037-71vr46416dlhb63auo5tv0vg16557cin.apps.googleusercontent.com"> -->
	<!--- DESARROLLO -->
	<meta name="google-signin-client_id" content="317070054037-t1thp3bfgcsskpuok1f0e12ja6hcbus5.apps.googleusercontent.com">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<link rel="icon" type="image/png" href="/public/assets/images/adr-balears.png" />
	<link rel="stylesheet" type="text/css" href="/public/assets/css/style-pindust.css"/>
	<link rel="stylesheet" type="text/css" href="/public/assets/css/estilos.css"/>
	<script type="text/javascript" src="/public/assets/js/pindust.js"></script>
</head>

<body onload="onLoad()">
<!-- HEADER: MENU + HEROE SECTION -->
<input type="hidden" name="updateInterval" class="form-control" id="updateInterval" value = "<?php echo $configuracion['updateInterval'];?>">

<style>
ul { list-style-type: none; }
.sidenav {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #f1f1f1;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
}

.sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 1rem;
  color: #818181;
  display: block;
  transition: 0.3s;
}

.sidenav a:hover {
  color: #f1f1f1;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

#main {
  transition: margin-left .5s;
  padding: .5rem;
  /* min-height:100%; */
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
</style>

<header>
<?php
	$session = session();
	$rol = ($session->get('rol'));
	?>
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <div class="menu">
		<ul>
			<li class="menu-item"><a href="<?php echo base_url('public/index.php/home/ca'); ?>" target="_self">Inici</a></li>
			<?php if ($session->get('rol') !== 'felib' && $session->get('rol') !== 'adr-isba') {?>
				<li class="menu-item"><a href="<?php echo base_url('public/index.php/home/set_lang/ca'); ?>" target = "_blank"><?php echo lang('message_lang.sol_idigital_menu');?></a></li>
				<li class="menu-item"><a href="<?php echo base_url('/public/index.php/home/solicitud_adhesion_ils/ca'); ?>" target = "_blank"><?php echo lang('message_lang.sol_adhesion_ils_menu');?></a></li>
				<li class="menu-item"><a href="<?php echo base_url('/public/index.php/home/solicitud_linea_idi_isba/ca'); ?>" target = "_blank"><?php echo lang('message_lang.sol_linea_idi_isba_menu');?></a></li>	
			<?php }?>	
			<?php if ($session->get('rol') == 'felib') {?>
				<li class="menu-item"><a href="<?php echo base_url('/public/index.php/home/solicitud_adhesion_felib/ca'); ?>" target = "_blank"><?php echo lang('message_lang.sol_adhesion_felib_menu');?></a></li>		
			<?php }?>
			<?php if ($session->get('rol') == 'adr-isba') {?>
					<li class="menu-item"><a href="<?php echo base_url('/public/index.php/home/solicitud_linea_idi_isba/ca'); ?>" target = "_blank"><?php echo lang('message_lang.sol_linea_idi_isba_menu');?></a></li>		
			<?php }?>
			<?php if ($session->get('rol') !== 'felib' && $session->get('rol') !== 'adr-isba') {?>
				<li class="menu-item"><a href="<?php echo base_url('/public/index.php/expedientes/');?>" target="_self">
					<?php	echo lang('message_lang.expediente_menu'); }?></a></li>
			<?php if ($session->get('rol') == 'felib') {?>
				<li class="menu-item"><a href="<?php echo base_url('/public'); ?>">Resum adhesions als programes</a></li>		
			<?php }?>
			<?php if ($session->get('rol') == 'admin') {?>
			<li class="menu-item"><a href="<?php echo base_url('/public/index.php/custodia/');?>" target="_self">CUSTODIA</a></li>
			<?php }?>	
			<?php if ($session->get('rol') !== 'felib' && $session->get('rol') !== 'adr-isba') {?>		
				<li class="menu-item"><a href="<?php echo base_url('public/index.php/home/dec_resp_consul/'); ?>" target = "_blank"><?php echo lang('message_lang.dec_resp_con_menu');?></a></li>				
			<?php }?>

			<li class="menu-item"><a href="https://inbox.viafirma.com/inbox/app/idi/" target="_blank"><?php echo lang('message_lang.portafirmas_menu');?></a></li>	
			<?php if ($session->get('rol') !== 'felib' && $session->get('rol') !== 'adr-isba') {?>
				<li class="menu-item"><a href="https://rec.redsara.es/registro/action/are/acceso.do" target="_blank">Registro Electrónico Común (REC)</a></li>
				<li class="menu-item"><a href="https://notifica.redsara.es" target="_blank">Notifica</a></li>
				<li class="menu-item"><a href="https://intranet.caib.es/notib/notificacio" target="_blank">Notificacions i comunicacions electròniques (NOTIB)</a></li>
				<li class="menu-item"><a href="https://intranet.caib.es/pinbal/index" target="_blank">Plataforma d'interoperabilitat (PINBAL)</a></li>
				<li class="menu-item"><a href="https://www.caib.es/seucaib/" target="_blank"><?php echo lang('message_lang.sede_caib_menu');?></a></li>	
			<?php }?>
			<li class="menu-item"><a href="https://inbox.viafirma.com/inbox/app/idi/verificacion/index.jsf" target="_blank">Servei de consulta de CSV IDI</a></li>
			<li class="menu-item"><a href="https://valide.redsara.es/valide/validarCertificado/ejecutar.html" target="_blank">VALIDe (herramienta para verificar la validez de los documentos firmados</a></li>

			<?php if ($session->get('rol')=='admin') {?>	
				<li class="menu-item"><a href="<?php echo base_url('/public/index.php/crud/customers_management'); ?>" target="_self">Crud</a></li>
			<?php }?>

			<?php if ($session->get('rol')=='admin') {?>	
				<li class="menu-item">
					<a title="Generar un arxiu EXCEL amb les ordres de pagament" href="<?php echo base_url('/public/index.php/crud/payment_orders'); ?>" target="_self">Generar fitxer amb ordres de pagament</a>
				</li>
			<?php }?>
			<?php if ($session->get('rol')=='admin') {?>	
				<li class="menu-item"><a href="<?php echo base_url('/public/index.php/crud/customers_management'); ?>" target="_self">Control ordre</a></li>
			<?php }?>					
			<?php if ($session->get('rol')=='admin') {?>	
				<li class="menu-item"><a href="<?php echo base_url('/public/index.php/configuracion/configurador_edit'); ?>" target="_self"><?php echo lang('message_lang.config_general');?></a></li>
				<li class="menu-item"><a href="<?php echo base_url('/public/index.php/configGestorAyudas/profile_management'); ?>" target="_self"><?php echo lang('message_lang.config_linea');?></a></li>

			<?php }?>
			<?php if ($session->get('rol')=='admin') {?>	
				<li class="menu-item"><a href="https://soporte.viafirma.com/" target="_self">Soporte técnico VIAFIRMA</a></li>
			<?php }?>			
			
			<li class="menu-item"><button class = "btn btn-logout" title = "Sortida" onclick = "signOut()"><i class="bi bi-box-arrow-right" style="font-size: 2.5rem; color: cornflowerblue;"></i></button></li>

		</ul>
	</div>
</div>
</header>
<div id="main">
	<div class="heroe main-header">
		<button type="button"  onclick="openNav()" class="btn item1" title="open menu"><i class="bi bi-menu-app" style="font-size: 2.5rem; "></i></button>
		<h1 class="item2"><?= esc($titulo); ?></h1>
		<img class="item3" title="Agència de desenvolupament regional de les Illes Balears (ADR Balears)" height="40px"
			alt="Visita la web oficial de l'ADR Balears"
			src="/public/assets/images/adr-balears.png">
	</div>
	

<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<!--<div id="container">-->