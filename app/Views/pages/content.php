<!-- CONTENT -->
<input type="hidden" name="updateInterval" class="form-control" id="updateInterval" value = "<?php echo $configuracion['updateInterval'];?>">
<script type="text/javascript" src="/public/assets/js/content.js"></script>
<div class="container">
<!------------------------------------------------------ILS---------------------------------------------------------------->  
<button class="accordion"><h1>ILS</h1></button>
<div class="panel" style="display:block;">
  <section id="sectionILS">
    <h2><a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/ILS/2022');?>" target="_self">Expedients</a></h2>
	  <fieldset>
      <div>
        <span id="totalSolicitudesILS_2022"></span>
        <span id="importeTotalILS_2022"></span>
        <span id="importeConcedidoILS_2022"></span>
      </div>
      <div>
          <span id="totalSolicitudesILSNoREC_2022"></span>
          <span id="totalSolicitudesILSPendientes_2022"></span>
          <span id="totalSolicitudesILSDenegadas_2022"></span>
          <span id="totalSolicitudesILSAdheridas_2022"></span>
        <!--   <span id="totalSolicitudesILSJustificado_2022"></span> -->
      </div>
	  </fieldset>
  </section>
</div>
<!-------------------------------------------------------------------------------------------------------------------------->

<!------------------------------------------------------2022---------------------------------------------------------------->
<button class="accordion"><h1>XECS</h1></button>
<div class="panel" style="display:block;">
<button class="accordion accordion--convo"><h1>Convocatòria 2022</h1></button>
<div class="panel">

  <section id="sectionProgramaI">
    <h2><a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa I/2022');?>" target="_self">Programa I</a></h2>
	  <fieldset>
      <div>
        <span id="totalSolicitudesI_2022"></span>
        <span id="importeTotalI_2022"></span>
        <span id="importeConcedidoI_2022"></span>
      </div>
      <div>
          <span id="totalSolicitudesINoREC_2022"></span>
          <span id="totalSolicitudesIPendientes_2022"></span>
          <span id="totalSolicitudesIDenegadas_2022"></span>
          <span id="totalSolicitudesIFinalizadas_2022"></span>
          <span id="totalSolicitudesIJustificado_2022"></span>
      </div>
	  </fieldset>
  </section>

  <section id="sectionProgramaII">
    <h2><a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa II/2022');?>" target="_self">Programa II</a></pre></h2>
	  <fieldset>
      <div>
        <span id="totalSolicitudesII_2022"></span>
        <span id="importeTotalII_2022"></span>
        <span id="importeConcedidoII_2022"></span>
      </div>
      <div>
          <span id="totalSolicitudesIINoREC_2022"></span>
          <span id="totalSolicitudesIIPendientes_2022"></span>
          <span id="totalSolicitudesIIDenegadas_2022"></span>
          <span id="totalSolicitudesIIFinalizadas_2022"></span>
          <span id="totalSolicitudesIIJustificado_2022"></span>
      </div>
	  </fieldset>
  </section>

  <section id="sectionProgramaIII">
    <h2><a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa III/2022');?>" target="_self">Programa III</a></h2>
	  <fieldset>
      <div>
        <span id="totalSolicitudesIII_2022"></span>
        <span id="importeTotalIII_2022"></span>
        <span id="importeConcedidoIII_2022"></span>
      </div>
      <div>
          <span id="totalSolicitudesIIINoREC_2022"></span>
          <span id="totalSolicitudesIIIPendientes_2022"></span>
          <span id="totalSolicitudesIIIDenegadas_2022"></span>
          <span id="totalSolicitudesIIIFinalizadas_2022"></span>
          <span id="totalSolicitudesIIIJustificado_2022"></span>
      </div>
	  </fieldset>
  </section>
</div>  
<!-------------------------------------------------------------------------------------------------------------------------->
<!----------------------------------------------------2021------------------------------------------------------------------>
<button class="accordion accordion--convo"><h1>Convocatòria 2021</h1></button>
<div class="panel" >
    <section id="sectionProgramaI">
      <h2><a title="Consultar els expedients" href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa I/2021');?>" target="_self">Programa I</a></h2>
	    <fieldset>
        <div>
          <span id="totalSolicitudesI_2021"></span>
          <span id="importeTotalI_2021"></span>
          <span id="importeConcedidoI_2021"></span>
        </div>
        <div>
          <span id="totalSolicitudesINoREC_2021"></span>
          <span id="totalSolicitudesIPendientes_2021"></span>
          <span id="totalSolicitudesIDenegadas_2021"></span>
          <span id="totalSolicitudesIFinalizadas_2021"></span>
          <span id="totalSolicitudesIJustificado_2021"></span>
        </div>
	    </fieldset>
    </section>

    <section id="sectionProgramaII">
      <h2><a title="Consultar els expedients" href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa II/2021');?>" target="_self">Programa II</a></h2>
	    <fieldset>
        <div>
          <span id="totalSolicitudesII_2021"></span>
          <span id="importeTotalII_2021"></span>
          <span id="importeConcedidoII_2021"></span>
        </div>
        <div>
            <span id="totalSolicitudesIINoREC_2021"></span>
            <span id="totalSolicitudesIIPendientes_2021"></span>
            <span id="totalSolicitudesIIDenegadas_2021"></span>
            <span id="totalSolicitudesIIFinalizadas_2021"></span>
            <span id="totalSolicitudesIIJustificado_2021"></span>
        </div>
	    </fieldset>
    </section>

    <section id="sectionProgramaIII">
      <h2><a title="Consultar els expedients" href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa III/2021');?>" target="_self">Programa III</a></h2>
	    <fieldset>
        <div>
          <span id="totalSolicitudesIII_2021"></span>
          <span id="importeTotalIII_2021"></span>
          <span id="importeConcedidoIII_2021"></span>
        </div>
        <div>
          <span id="totalSolicitudesIIINoREC_2021"></span>
          <span id="totalSolicitudesIIIPendientes_2021"></span>
          <span id="totalSolicitudesIIIDenegadas_2021"></span>
          <span id="totalSolicitudesIIIFinalizadas_2021"></span>
          <span id="totalSolicitudesIIIJustificado_2021"></span>
        </div>
	    </fieldset>
    </section>
  </div>  
  <!-------------------------------------------------------------------------------------------------------------------------->
  <!-----------------------------------------------2020----------------------------------------------------------------------->
  <button class="accordion accordion--convo"><h1>Convocatòria 2020</h1></button>
  <div class="panel">
    <section id="sectioniDigital2020">
	    <h2 id="iDigital2020" onclick="listPrograma('2020', 'iDigital 2020')">iDigital 2020</h2>
      <pre><code><a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/iDigital 2020/2020');?>" target="_self">Consultar les sol·licituds</a></code></pre>
      <div><span id="totaliDigital2020"></span><span id="importeTotaliDigital2020"></span><span id="importeConcedidoiDigital2020"></span></div>
    </section>
  </div>
</div>  
<!---------------------------------------------------------------------------------------------------------------------------->

<!------------------------------------------------------IDI-ISBA-------------------------------------------------------------->  
<button class="accordion"><h1>IDI-ISBA</h1></button>
<div class="panel" style="display:block;">
  <section id="sectionILS">
    <h2><a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/IDI-ISBA/'.date("Y"));?>" target="_self">Expedients</a></h2>
	  <fieldset>
      <div>
        <span id="totalSolicitudesILS_2022"></span>
        <span id="importeTotalILS_2022"></span>
        <span id="importeConcedidoILS_2022"></span>
      </div>
      <div>
          <span id="totalSolicitudesILSNoREC_2022"></span>
          <span id="totalSolicitudesILSPendientes_2022"></span>
          <span id="totalSolicitudesILSDenegadas_2022"></span>
          <span id="totalSolicitudesILSAdheridas_2022"></span>
        <!--   <span id="totalSolicitudesILSJustificado_2022"></span> -->
      </div>
	  </fieldset>
  </section>
</div>
<!-------------------------------------------------------------------------------------------------------------------------->

</div>


<script>
  var acc = document.getElementsByClassName("accordion");
  var i;
  console.log("Acordeones home: " + acc.length +"--")
for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });
}
</script>