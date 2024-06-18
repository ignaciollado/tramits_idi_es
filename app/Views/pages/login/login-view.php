
<div class="wrapper fadeInDown">
  <div id="formContent">
      <div class="fadeIn first logo-area">
        <img width="95" src='../../../../public/assets/images/adr-balears.png' alt="Agència de desenvolupament regional de les Illes Balears" title="Gestor de tràmits de l'Agència de desenvolupament regional de les Illes Balears">
      </div>
      <!-- <span class='mensaje'><?= session('msg');?></span> -->
	
      <form method="post"  action="<?= base_url('/public/index.php/loginController/login') ?>"> 
        <input type="text" disabled id="user_id" required name="user_id" placeholder="la teva acreça de correu">
        <input type="password" disabled id="password" required name="password" placeholder="Clau">
        <input type="submit" disabled value="Log In">
      </form>  
      <div class="g-signin2" id="signinGooogloToiTramits"></div>
      <!-- <div class="g-signin2"></div> -->

    <div id="formFooter"> 
        <div><strong>Gestor de tràmits administratius</strong></div>
        <div>&copy; <?= date('Y') ?></div>
        <div>Agència de desenvolupament regional</div>
        <div>de les Illes Balears</div>
    </div>
  </div>
</div>
<script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>