  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
  <script type="text/javascript" src="/public/assets/js/edita-expediente.js"></script>
<?php

define("K_PATH_IMAGES", "/home/pre-tramitsidi/www/app/Views/pages/forms/modDocs/pdf/fpdf/images/");
define("LINE_HEIGHT", 14);
/* require('fpdf/fpdf.php'); */
require('dompdf/src/Dompdf.php');
require('dompdf/src/Options.php');
require('dompdf/src/CanvasFactory.php');


setlocale(LC_MONETARY,"es_ES");
use App\Models\ConfiguracionModel;
use App\Models\ExpedientesModel;
use App\Models\MejorasExpedienteModel;
    //obtengo los datos de la convocatoria
    $configuracion = new ConfiguracionModel();
    $data['configuracion'] = $configuracion->where('convocatoria_activa', 1)->first();
    //obtengo los datos de la solicitud
    $expediente = new ExpedientesModel();
    $data['expediente'] = $expediente->where('id', $id)->first();
    //obtengo los datos de la última mejora de la solicitud (si la hay)
    $mejorasSolicitud = new MejorasExpedienteModel();
    $data['ultimaMejora'] = $mejorasSolicitud->selectLastMejorasExpediente($id);
    $ultimaMejora = explode("##",  $data['ultimaMejora']);
    //obtengo los datos del documento
    $db = \Config\Database::connect();
	  $query = $db->query("SELECT * FROM pindust_documentos_generados WHERE id_sol=".$id." AND convocatoria='".$convocatoria."' AND tipo_tramite='".$programa."'");
    foreach ($query->getResult() as $row)
        {
        $nif = $row->cifnif_propietario;
        }
        
    $session = session();
    if ($session->has('logged_in')) {  
       $pieFirma =  $session->get('full_name');
    }

  // reference the Dompdf namespace
  use Dompdf\Dompdf;
  use Dompdf\Options;
  
  $options = new Options();
  $options->set('defaultFont', 'Courier');
  $dompdf = new Dompdf($options);

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$options = $dompdf->getOptions();
$dompdf->loadHtml('hello world');

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
header("Content-type: application/pdf");
header("Content-Disposition: inline; filename=documentoNacho.pdf");
echo $dompdf->output();