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
        <span class="badge text-bg-success" id="totalSolicitudesILSAdheridas"></span>
      </div>
	  </fieldset>
  </section>
</div>
<?php 
    use App\Models\ExpedientesModel;
    $modelExp = new ExpedientesModel();
    $totalexpedAZero = "<span class='badge bg-secondary'>".$modelExp->getWithZeroIdSol()."</span>";
    ?>
<!-----------------------------------------------------CHEQUES---------------------------------------------------------------->
<!-- <button class="accordion"><h1>XECS</h1></button> -->
<!-- <div class="panel" style="display:block;"> -->
<!------------------------------------------------------2024------------------------------------------------------------------>
<button class="accordion accordion--convo"><h1>Xecs consultoria</h1></button>
<div class="row">
  <div class="col-sm-12 mb-3 mb-sm-0">
    <div class="accordion" id="accordionExample">
      <h5 class="card-title">Convocatòria 2024</h5>

      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Programa I (iDigital)</button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            <strong>«IDigital»</strong>, estratègia per impulsar la digitalització en la indústria de les Illes Balears.<br>
            <span class="badge text-bg-success" id="totalSolicitudesI_2024">0</span>
            <span class="badge text-bg-success" id="importeConcedidoI_2024">0.00</span>
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Programa II (iExporta)</button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            <strong>«IExporta»</strong>, estratègia per impulsar la internacionalització de les empreses industrials de les Illes Balears.<br>
            <span class="badge text-bg-success" id="totalSolicitudesII_2024">0</span>
            <span class="badge text-bg-success" id="importeConcedidoII_2024">0.00</span>
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Programa III (iSostenibilitat)</button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            <strong>«ISostenibilitat»</strong>, estratègia per impulsar la millora de la sostenibilitat de la indústria de les Illes Balears.<br>
            <ol>
              <li>Identificació i càlcul de les emissions de gasos amb efecte d'hivernacle de l'organització:
                <ol>
                  <li><span class="badge text-bg-success" id="totalSolicitudesIII_org_2024">0</span></li>
                  <li><span class="badge text-bg-success" id="importeConcedidoIII_org_2024">0.00</span></li>
                </ol>
              </li>
              <li>Identificació i càlcul de les emissions de gasos d'efecte d'hivernacle de producte
                <ol>
                  <li><span class="badge text-bg-success" id="totalSolicitudesIII_prod_2024">0</span></li>
                  <li><span class="badge text-bg-success" id="importeConcedidoIII_prod_2024">0.00</span></li>
                </ol>
              </li>
            </ol>
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">Programa IV (iGestió)</button>
        </h2>
        <div id="collapseFour" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            <strong>«IGestió»</strong>, estratègia per impulsar la implantació d'eines de gestió avançada i optimització de processos de la indústria de les Illes Balears.<br>
            <span class="badge text-bg-success" id="totalSolicitudesIV_2024">0</span>
            <span class="badge text-bg-success" id="importeConcedidoIV_2024">0.00</span>
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
<!------------------------------------------------------2020------------------------------------------------------------------>
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