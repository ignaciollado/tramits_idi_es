<input type="hidden" name="updateInterval" class="form-control" id="updateInterval" value = "<?php echo $configuracion['updateInterval'];?>">
<!-- CLOSE DIV ID="container"-->
</div>
<script type="text/javascript" src="/public/assets/js/footer.js"></script>
<!-- FOOTER: DEBUG INFO + COPYRIGHTS -->
<footer class="copyrights">
	<?php $session = session();?>
	<div class="footer-item1">
	<span>&copy; <?= date('Y') ?> Institut d'Innovació Empresarial de les Illes Balears</span> | 
		 
		 <!--<p>Pàgina carregada en {elapsed_time} segons</p>-->
 
		 <!--<p>Entorn: <//?= ENVIRONMENT."<br> ### ".base_url()." ### " ?></p>-->
		 <span>Gestor de tràmits administratius</span> | 
		<span>
			<img width="22px" title="L'avatar de l'usuari de Gsuite" alt="L'avatar de l'usuari de Gsuite" src="<?php echo $session->get('avatar');?>">
		</span>
		<span>
		<?php 
		
		if ($session->has('logged_in')) {
			echo "<strong style='color:orange;'>".$session->get('full_name') ."</strong>";
		} else {
			return redirect('login');
		}
		echo "<br> ### ".base_url()." ### " ?>
		</span> 
		<span>
			<span id="<?php echo $session->get('googleSub');?>" class="unreadMails">
  				<span class="" id="totalMsg"></span>
			</span>	
		</span>
		
	</div>
</footer>
</body>
</html>

<script src="https://apis.google.com/js/platform.js?onload=init" async defer></script>