<!DOCTYPE html>
<html lang="es-ES">
<head>
	<meta charset="UTF-8">
	<title><?= esc($titulo); ?></title>
	<meta name="description" content="iTramits: Gestor d'ajuts i de subvencions de  l'IDI">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- <meta name="google-signin-scope" content="profile email"> -->
	<!--- PRODUCCIÓN -->
    <meta name="google-signin-client_id" content="317070054037-71vr46416dlhb63auo5tv0vg16557cin.apps.googleusercontent.com">
	<!--- DESARROLLO -->
	<!-- <meta name="google-signin-client_id" content="317070054037-t1thp3bfgcsskpuok1f0e12ja6hcbus5.apps.googleusercontent.com"> -->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<link rel="shortcut icon" type="image/jpg" href="/public/assets/images/headeridi.jpg" />
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
	?>
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <div class="menu">
		<ul>
			<li class="menu-item"><a href="<?php echo base_url('public/index.php/home/ca'); ?>" target="_self">Inici</a></li>
			<li class="menu-item"><a href="<?php echo base_url('/public/index.php/home/solicitud_ayuda/'); ?>" target = "_blank"><?php echo lang('message_lang.sol_idigital_menu');?></a></li>
			<li class="menu-item"><a href="<?php echo base_url('/public/index.php/home/solicitud_adhesion_ils/'); ?>" target = "_blank"><?php echo lang('message_lang.sol_adhesion_ils_menu');?></a></li>
			<li class="menu-item"><a href="<?php echo base_url('/public/index.php/home/solicitud_linea_idi_isba/'); ?>" target = "_blank"><?php echo lang('message_lang.sol_linea_idi_isba_menu');?></a></li>		

			<li class="menu-item"><a href="<?php echo base_url('/public/index.php/expedientes/');?>" target="_self"><?php echo lang('message_lang.expediente_menu');?></a></li>
			<?php if ($session->get('rol')=='admin') {?>
			<li class="menu-item"><a href="<?php echo base_url('/public/index.php/custodia/');?>" target="_self">CUSTODIA</a></li>
			<?php }?>			
			<li class="menu-item"><a href="<?php echo base_url('public/index.php/home/dec_resp_consul/'); ?>" target = "_blank"><?php echo lang('message_lang.dec_resp_con_menu');?></a></li>				
			<li class="menu-item"><a href="https://inbox.viafirma.com/inbox/app/idi/" target="_blank"><?php echo lang('message_lang.portafirmas_menu');?></a></li>	
			<li class="menu-item"><a href="https://rec.redsara.es/registro/action/are/acceso.do" target="_blank">Registro Electrónico Común (REC)</a></li>
			<li class="menu-item"><a href="https://notifica.redsara.es" target="_blank">Notifica</a></li>
			<li class="menu-item"><a href="https://intranet.caib.es/notib/notificacio" target="_blank">Notificacions i comunicacions electròniques (NOTIB)</a></li>
			<li class="menu-item"><a href="https://intranet.caib.es/pinbal/index" target="_blank">Plataforma d'interoperabilitat (PINBAL)</a></li>
			<li class="menu-item"><a href="https://www.caib.es/seucaib/" target="_blank"><?php echo lang('message_lang.sede_caib_menu');?></a></li>	
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
		<img class="item3" title="Institut d'Innovació Empresarial de les Illes Balears" height="40px"
			alt="Visita la web oficial del IDI"
			src="data:image/png;base64,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">
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