<!-- CONTENT -->
<input type="hidden" name="updateInterval" class="form-control" id="updateInterval" value = "<?php echo $configuracion['updateInterval'];?>">
<script type="text/javascript" src="/public/assets/js/content.js"></script>
<div class="container">
<!------------------------------------------------------ILS---------------------------------------------------------------->  
<button class="accordion"><h1>ILS</h1></button>
<div class="panel" style="display:block;">
  <section id="sectionILS">
    <h2><a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/ILS');?>" target="_self">Expedients</a></h2>
	  <fieldset>
      <div>
        <span class="badge text-bg-success" id="totalSolicitudesILSAdheridas_2022"></span>
      </div>
	  </fieldset>
  </section>
</div>
<?php 
    use App\Models\ExpedientesModel;
    $modelExp = new ExpedientesModel();
    $totalexpedAZero = "<span class='badge bg-secondary'>".$modelExp->getWithZeroIdSol()."</span>";
    ?>
<!-----------------------------------------------------CHEQUES-------------------------------------------------------------->
<!-- <button class="accordion"><h1>XECS</h1></button> -->
<!-- <div class="panel" style="display:block;"> -->
<!------------------------------------------------------2024---------------------------------------------------------------->
<button class="accordion accordion--convo"><h1>Xecs consultoria</h1></button>

<div class="row">
  <div class="col-sm-12 mb-3 mb-sm-0">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Convocatòria 2024</h5>
        <p class="d-inline-flex gap-1">
          <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#convo2024PI" aria-expanded="false" aria-controls="convo2024PI">
            Programa I (iDigital)
          </button>
        </p>
        <div class="collapse" id="convo2024PI">
          <div class="card card-body">
          <div>
            <span class="badge text-bg-success" id="totalSolicitudesI_2024"></span>
            <span class="badge text-bg-success" id="importeConcedidoI_2024"></span>
          </div>
          <a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa I/2024');?>" class="btn btn-primary">+info</a>
          </div>
        </div>
        <p class="d-inline-flex gap-1">
          <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#convo2024PII" aria-expanded="false" aria-controls="convo2024PII">
            Programa II (iExporta)
          </button>
        </p>
        <div class="collapse" id="convo2024PII">
          <div class="card card-body">
          <div>
            <span class="badge text-bg-success" id="totalSolicitudesII_2024"></span>
            <span class="badge text-bg-success" id="importeConcedidoII_2024"></span>
          </div>
            <a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa II/2024');?>" class="btn btn-primary">+info</a>
          </div>
        </div>
        <p class="d-inline-flex gap-1">
          <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#convo2024PIII" aria-expanded="false" aria-controls="convo2024PIII">
            Programa III (ISostenibilitat)
          </button>
        </p>
        <div class="collapse" id="convo2024PIII">
          <div class="card card-body">
          <div>
            <span class="badge text-bg-success" id="totalSolicitudesIII_2024"></span>
            <span class="badge text-bg-success" id="importeConcedidoIII_2024"></span>
          </div>
            <a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa III/2024');?>" class="btn btn-primary">+info</a>
          </div>
        </div>
        <p class="d-inline-flex gap-1">
        <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#convo2024PIV" aria-expanded="false" aria-controls="convo2024PIV">
          Programa IV (IGestió)
        </button>
        </p>
        <div class="collapse" id="convo2024PIV">
          <div class="card card-body">
          <div>
            <span class="badge text-bg-success" id="totalSolicitudesIV_2024"></span>
            <span class="badge text-bg-success" id="importeConcedidoIV_2024"></span>
          </div>
            <a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa IV/2024');?>" class="btn btn-primary">+info</a>
          </div>
        </div>
      </div>
    </div> 
  </div> 
  <div class="col-sm-12 mb-3 mb-sm-0">
    <div class="card">
      <div class="card-body">
      <h5 class="card-title">Convocatòria 2023</h5>
      <p class="d-inline-flex gap-1">
        <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#convo2023PI" aria-expanded="false" aria-controls="convo2023PI">
          Programa I (iDigital)
        </button>
      </p>
      <div class="collapse" id="convo2023PI">
        <div class="card card-body">
          <div>
            <span class="badge text-bg-success" id="totalSolicitudesI_2023"></span>
            <span class="badge text-bg-success" id="importeConcedidoI_2023"></span>
          </div>
          <a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa I/2023');?>" class="btn btn-info">+info</a>
        </div>
      </div>
      <p class="d-inline-flex gap-1">
        <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#convo2023PII" aria-expanded="false" aria-controls="convo2023PII">
          Programa II (iExporta)
        </button>
      </p>
      <div class="collapse" id="convo2023PII">
        <div class="card card-body">
          <div>
            <span class="badge text-bg-success" id="totalSolicitudesII_2023"></span>
            <span class="badge text-bg-success" id="importeConcedidoII_2023"></span>
          </div>
          <a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa II/2023');?>" class="btn btn-info">+info</a>
        </div>
      </div>
      <p class="d-inline-flex gap-1">
        <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#convo2023PIII" aria-expanded="false" aria-controls="convo2023PIII">
          Programa III (ISostenibilitat)
        </button>
      </p>
      <div class="collapse" id="convo2023PIII">
        <div class="card card-body">
          <div>
            <span class="badge text-bg-success" id="totalSolicitudesIII_2023"></span>
            <span class="badge text-bg-success" id="importeConcedidoIII_2023"></span>
          </div>
          <a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa III/2023');?>" class="btn btn-info">+info</a>
        </div>
      </div>
      </div>
    </div>
  </div>
  <div class="col-sm-12 mb-3 mb-sm-0">
    <div class="card">
      <div class="card-body">
      <h5 class="card-title">Convocatòria 2022</h5>
      <p class="d-inline-flex gap-1">
        <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#convo2022PI" aria-expanded="false" aria-controls="convo2022PI">
          Programa I (iDigital)
        </button>
      </p>
      <div class="collapse" id="convo2022PI">
        <div class="card card-body">
          <div>
            <span class="badge text-bg-success" id="totalSolicitudesI_2022"></span>
            <span class="badge text-bg-success" id="importeConcedidoI_2022"></span>
          </div>
          <a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa I/2022');?>" class="btn btn-info">+info</a>
        </div>
      </div>
      <p class="d-inline-flex gap-1">
        <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#convo2022PII" aria-expanded="false" aria-controls="convo2022PII">
          Programa II (IExporta)
        </button>
      </p>
      <div class="collapse" id="convo2022PII">
        <div class="card card-body">
          <div>
            <span class="badge text-bg-success" id="totalSolicitudesII_2022"></span>
            <span class="badge text-bg-success" id="importeConcedidoII_2022"></span>
          </div>
          <a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa II/2022');?>" class="btn btn-info">+info</a>
        </div>
      </div>
      <p class="d-inline-flex gap-1">
        <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#convo2022PIII" aria-expanded="false" aria-controls="convo2022PIII">
          Programa III (ISostenibilitat)
        </button>
      </p>
      <div class="collapse" id="convo2022PIII">
        <div class="card card-body">
          <div>          
            <span class="badge text-bg-success" id="totalSolicitudesIII_2022"></span>
            <span class="badge text-bg-success" id="importeConcedidoIII_2022"></span>
          </div>
          <a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa III/2022');?>" class="btn btn-info">+info</a>
        </div>
      </div>
      </div>
    </div>
  </div>
  <div class="col-sm-12 mb-3 mb-sm-0">
    <div class="card">
      <div class="card-body">
      <h5 class="card-title">Convocatòria 2021</h5>
      <p class="d-inline-flex gap-1">
        <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#convo2021PI" aria-expanded="false" aria-controls="convo2021PI">
          Programa I (iDigital)
        </button>
      </p>
      <div class="collapse" id="convo2021PI">
        <div class="card card-body">
          <div>
            <span class="badge text-bg-success" id="totalSolicitudesI_2021"></span>
            <span class="badge text-bg-success" id="importeConcedidoI_2021"></span>
          </div>
          <a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa I/202I');?>" class="btn btn-info">+info</a>
        </div>
      </div>
      <p class="d-inline-flex gap-1">
        <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#convo2021PII" aria-expanded="false" aria-controls="convo2021PII">
          Programa II (iExporta)
        </button>
      </p>
      <div class="collapse" id="convo2021PII">
        <div class="card card-body">
        <div>
          <span class="badge text-bg-success" id="totalSolicitudesII_2021"></span>
          <span class="badge text-bg-success" id="importeConcedidoII_2021"></span>
        </div>
        <a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa II/2021');?>" class="btn btn-info">+info</a>
        </div>
      </div>
      <p class="d-inline-flex gap-1">
        <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#convo2021PIII" aria-expanded="false" aria-controls="convo2021PIII">
          Programa III (ISostenibilitat)
        </button>
      </p>
      <div class="collapse" id="convo2021PIII">
        <div class="card card-body">
          <div>         
            <span class="badge text-bg-success" id="totalSolicitudesIII_2021"></span>
            <span class="badge text-bg-success" id="importeConcedidoIII_2021"></span>
          </div>
          <a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/Programa III/2021');?>" class="btn btn-info">+info</a>
        </div>
      </div>
      </div>
    </div>
  </div>
</div>
<!-----------------------------------------------2020----------------------------------------------------------------------->
<button class="accordion accordion--convo"><h1>Convocatòria 2020</h1></button>
  <div class="panel">
    <section id="sectioniDigital2020">
	    <h2 id="iDigital2020" onclick="listPrograma('2020', 'iDigital 2020')">iDigital 2020</h2>
      <pre><code><a href="<?php echo base_url('public/index.php/expedientes/expedientesPrograma/iDigital 2020/2020');?>" target="_self">Consultar les sol·licituds</a></code></pre>
      <div><span id="totaliDigital2020"></span><span id="importeTotaliDigital2020"></span><span id="importeConcedidoiDigital2020"></span></div>
    </section>
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