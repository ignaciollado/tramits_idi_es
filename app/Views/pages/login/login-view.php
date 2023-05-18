
<div class="wrapper fadeInDown">
  <div id="formContent">
      <div class="fadeIn first">
        <i class="fa fa-sign-in" aria-hidden="true" style='font-size:50px'></i>
      </div>
      <span class='mensaje'><?= session('msg');?></span>
	
      <form method="post"  action="<?= base_url('/public/index.php/loginController/login') ?>"> 
        <input type="text" id="user_id" required disabled name="user_id" placeholder="la teva acreça de correu">
        <input type="password" id="password" required disabled name="password" placeholder="Clau">
        <input type="submit" disabled value="Log In">
      </form>  
      <div class="g-signin2" id="signinGooogloToiTramits"></div>
      <!-- <div class="g-signin2"></div> -->

    <div id="formFooter"> 
        <div><strong>iTramits - Gestor de tràmits administratius</strong></div>
        <div>&copy; <?= date('Y') ?> Institut d'Innovació Empresarial</div>
        <div>Illes Balears</div>
    </div>
  </div>
</div>
<script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>