<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="/public/assets/js/edita-expediente.js"></script>
<?php
require_once('tcpdf/tcpdf.php');
setlocale(LC_MONETARY,"es_ES");
use App\Models\ConfiguracionModel;
use App\Models\ConfiguracionLineaModel;
use App\Models\ExpedientesModel;
use App\Models\MejorasExpedienteModel;
            
$configuracion = new ConfiguracionModel();
$configuracionLinea = new ConfiguracionLineaModel();
$expediente = new ExpedientesModel();
$mejorasSolicitud = new MejorasExpedienteModel();
    
$data['configuracion'] = $configuracion->where('convocatoria_activa', 1)->first();
$data['expediente'] = $expediente->where('id', $id)->first();
    
$db = \Config\Database::connect();
$query = $db->query("SELECT * FROM pindust_documentos_generados WHERE id_sol=".$id." AND convocatoria='".$convocatoria."' AND tipo_tramite='".$programa."'");
foreach ($query->getResult() as $row) {
    $nif = $row->cifnif_propietario;
}
            
$session = session();
if ($session->has('logged_in')) {  
    $pieFirma =  $session->get('full_name');
}

class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // Logo
         // $pdf->Image('images/image_demo.jpg', $x, $y, $w, $h, 'JPG', 'url', 'align', false (resize), 300 (dpi), 'align (L (left) C (center) R (righ)', false, false, 0, $fitbox, false, false);
        // align: T (top), M (middle), B (bottom), N (next line)
        $image_file = K_PATH_IMAGES.'bannerChequesConsultoria.jpg';
        $this->Image($image_file, 0, 10, 210, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
	}
    // Page footer
    public function Footer() {
        // Logo

		// Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Address and Page number
        $this->Cell(0, 5, "Agència de desenvolupament regional - Plaça Son Castelló 1 - Tel. 971 17 61 61 - 07009 - Palma - Illes Balears", 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 15, $this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
	
$pdf->SetAuthor("INSTITUT D'INNOVACIÓ EMPRESARIAL DE LES ILLES BALEARS (IDI) - SISTEMES D'INFORMACIÓ");
$pdf->SetTitle("ACUERDO DE CONFIDENCIALIDAD");
$pdf->SetSubject("ACUERDO DE CONFIDENCIALIDAD");
$pdf->SetKeywords("INDUSTRIA 4.0, DIAGNOSTIC, DIGITAL, EXPORTA, ILS, PIMES, IDI, GOIB");	

$pdf->setFooterData(array(0,64,0), array(0,64,128));
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$pdf->SetFont('helvetica', '', 10);
$pdf->setFontSubsetting(false);

// -------------------------------------------------------------- Intro ---------------------------------------------------------------------------------------------------- //
// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------- //
$pdf->AddPage();

// set color for background
$pdf->SetFillColor(255, 255, 255);
// set color for text
$pdf->SetTextColor(0, 0, 0);
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

$pdf->SetFont('helvetica', '', 11);
$pdf->setFontSubsetting(false);

$currentY = $pdf->getY();
$pdf->setY($currentY + 20);
$intro = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], lang('message_lang.doc_acuerdo_de_confidencialidad_intro'));
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>". $intro ."</b></td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$parrafo_1 = lang('message_lang.doc_acuerdo_de_confidencialidad_p1');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $parrafo_1 ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$parrafo_2 = lang('message_lang.doc_acuerdo_de_confidencialidad_p2');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $parrafo_2 ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$parrafo_3 = lang('message_lang.doc_acuerdo_de_confidencialidad_p3');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $parrafo_3 ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$parrafo_3_1 = lang('message_lang.doc_acuerdo_de_confidencialidad_p3_1');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $parrafo_3_1 ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$parrafo_3_2 = lang('message_lang.doc_acuerdo_de_confidencialidad_p3_2');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $parrafo_3_2 ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$parrafo_3_3 = lang('message_lang.doc_acuerdo_de_confidencialidad_p3_3');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $parrafo_3_3 ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$parrafo_3_4 = lang('message_lang.doc_acuerdo_de_confidencialidad_p3_4');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'>". $parrafo_3_4 ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 3);
//$currentX = $pdf->getX();
//$pdf->setX($currentX + 10);
$firma = lang('message_lang.doc_acuerdo_de_confidencialidad_firma');
$firma1 = lang('message_lang.doc_acuerdo_de_confidencialidad_firma_1');
$firma2 = lang('message_lang.doc_acuerdo_de_confidencialidad_firma_2');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:12px;'>". $firma ."</td><td style='background-color:#ffffff;color:#000;font-size:12px;'>". $firma1 ."</td><td style='background-color:#ffffff;color:#000;font-size:12px;'>". $firma2 ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');
// ------------------------------------------------------------------------------------ //
// ------------------------------------------------------------------------------------ //
/* Limpiamos la salida del búfer y lo desactivamos */
//ob_end_clean();
 /* Finalmente se genera el PDF */
$numExped = $data['expediente']['idExp']."_".$data['expediente']['convocatoria'];
$pdf->Output(WRITEPATH.'documentos/'.$nif.'/informes/'.$numExped.'_acuerdo_confidencialidad.pdf', 'F');
