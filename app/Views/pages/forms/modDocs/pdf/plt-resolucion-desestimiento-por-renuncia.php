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

$configuracion = new ConfiguracionModel();
$configuracionLinea = new ConfiguracionLineaModel();
$expediente = new ExpedientesModel();

$data['configuracion'] = $configuracion->configuracionGeneral();   
$data['configuracionLinea'] = $configuracionLinea->activeConfigurationLineData('XECS', $convocatoria);
$data['expediente'] = $expediente->where('id', $id)->first();
   
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
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'ADRBalears-conselleria.jpg';
        $this->Image($image_file, 10, 10, 90, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
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
	
$pdf->SetAuthor("AGÈNCIA DE DESENVOLUPAMENT REGIONAL DE LES ILLES BALEARS (ADR Balears) - SISTEMES D'INFORMACIÓ");
$pdf->SetTitle("RESOLUCIÓN DE DESESTIMIENTO POR RENUNCIA");
$pdf->SetSubject("RESOLUCIÓN DE DESESTIMIENTO POR RENUNCIA");
$pdf->SetKeywords("INDUSTRIA 4.0, DIAGNOSTIC, DIGITAL, EXPORTA, ILS, PIMES, ADR Balears, GOIB");	

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
$fmt = new NumberFormatter( 'es_ES', NumberFormatter::CURRENCY );

$pdf->SetFont('helvetica', '', 9);
$pdf->setFontSubsetting(false);

// -------------------------------------------------------------- Programa, datos solicitante, datos consultor ------------------------------------------------------------- //
// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------- //
$pdf->AddPage();

$currentY = $pdf->getY();
$pdf->setY($currentY + 15);
$html = "Document: resolució desestiment<br>";
$html .= "Núm. Expedient: ". $data['expediente']['idExp']."/".$data['expediente']['convocatoria']." (".$data['expediente']['tipo_tramite'].")"."<br>";
$html .= "Nom sol·licitant: ".$data['expediente']['empresa']."<br>";
$html .= "NIF: ". $data['expediente']['nif']."<br>";
$html .= "Emissor (DIR3): ".$data['configuracion']['emisorDIR3']."<br>";
$html .= "Codi SIA: ".$data['configuracionLinea']['codigoSIA']."<br>";

// set color for background
$pdf->SetFillColor(255, 255, 255);
// set color for text
$pdf->SetTextColor(0, 0, 0);
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
$pdf->writeHTMLCell(90, '', 120, 40, $html, 0, 1, 1, true, 'J', true);
$pdf->SetFont('helvetica', '', 11);
$pdf->setFontSubsetting(false);

$currentY = $pdf->getY();
$pdf->setY($currentY + 15);
$intro = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], lang('25_resolucion_desistimiento.25_intro'));
$intro = str_replace("%NIF%", $data['expediente']['nif'], $intro);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>". $intro ."</b></td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 6);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>". lang('25_resolucion_desistimiento.25_fets_tit') ."</b></td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 4);
$parrafo_1 = str_replace("%FECHARESPRESIDI%", $data['configuracion']['respresidente'], lang('25_resolucion_desistimiento.25_fets_1_2_3'));
$parrafo_1 = str_replace("%BOIBNUM%", $data['configuracionLinea']['num_BOIB'], $parrafo_1);
$parrafo_1 = str_replace("%BOIBFECHA%", date_format(date_create($data['configuracionLinea']['fecha_BOIB']),"d/m/Y"), $parrafo_1);
$parrafo_1 = str_replace("%CONVO%", $convocatoria, $parrafo_1);
$parrafo_1 = str_replace("%FECHASOL%", date_format(date_create($data['expediente']['fecha_REC']),"d/m/Y"), $parrafo_1);
$parrafo_1 = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], $parrafo_1);
$parrafo_1 = str_replace("%NIF%", $data['expediente']['nif'], $parrafo_1);
$parrafo_1 = str_replace("%NUMREC%", $data['expediente']['ref_REC'], $parrafo_1);
$parrafo_1 = str_replace("%IMPORTEAYUDA%", $fmt->formatCurrency($data['expediente']['importeAyuda'], "EUR"), $parrafo_1);
$parrafo_1 = str_replace("%PROGRAMA%", $tipo_tramite, $parrafo_1);
$parrafo_1 = str_replace("%FECHA_DESESTIMIENTO%",  date_format(date_create($data['expediente']['fecha_REC_desestimiento']),"d/m/Y"), $parrafo_1);
$parrafo_1 = str_replace("%NUM_EXPEDIENTE%", $data['expediente']['idExp']."/".$data['expediente']['convocatoria'], $parrafo_1);
$parrafo_1 = str_replace("%REFERENCIA_SEDE_DESESTIMIENTO%", $data['expediente']['ref_REC_desestimiento'], $parrafo_1);

$html = $parrafo_1;
$pdf->writeHTML($html, true, false, true, false, '');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->AddPage();
$image_file = K_PATH_IMAGES.'logoVertical.png';
$pdf->Image($image_file, 15, 15, '', '20', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
$currentY = $pdf->getY();
$pdf->setY($currentY + 30);

$parrafo_2 = str_replace("%FECHAREC%", date_format(date_create($data['expediente']['fecha_REC']),"d/m/Y") , lang('25_resolucion_desistimiento.25_fundamentosDeDerecho_tit'));
$html = "<b>". $parrafo_2 ."</b>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 4);
$parrafo_3 = lang('25_resolucion_desistimiento.25_fundamentosDeDerechoTxt');
$html = $parrafo_3;
$pdf->writeHTML($html, true, false, true, false, '');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->AddPage();
$image_file = K_PATH_IMAGES.'logoVertical.png';
$pdf->Image($image_file, 15, 15, '', '20', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
$currentY = $pdf->getY();
$pdf->setY($currentY + 30);

$parrafo_4 = lang('25_resolucion_desistimiento.25_dicto');
$html = $parrafo_4;
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 3);
$resolucion_tit = lang('25_resolucion_desistimiento.25_resolucion_tit');
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;'><b>". $resolucion_tit ."</b></td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 3);
$resolucion = lang('25_resolucion_desistimiento.25_resolucion');
$resolucion = str_replace("%SOLICITANTE%", $data['expediente']['empresa'], $resolucion);
$resolucion = str_replace("%NIF%", $data['expediente']['nif'], $resolucion);
$html =  $resolucion;
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$recursos_tit = lang('25_resolucion_desistimiento.25_recursos_tit');
$html = "<b>". $recursos_tit ."</b>";
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 3);
$recursos = lang('25_resolucion_desistimiento.25_recursos');
$html =  $recursos;
$pdf->writeHTML($html, true, false, true, false, '');

$currentY = $pdf->getY();
$pdf->setY($currentY + 3);
$firma = lang('25_resolucion_desistimiento.25_firma');
$firma = str_replace("%BOIBNUM%", $data['configuracionLinea']['num_BOIB'], $firma);
$firma = str_replace("%DGERENTE%", $data['configuracion']['directorGerenteIDI'], $firma);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>". $firma ."</td></tr>";
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');
// ------------------------------------------------------------------------------------ //
// ------------------------------------------------------------------------------------ //
/* Limpiamos la salida del búfer y lo desactivamos */
//ob_end_clean();
 /* Finalmente se genera el PDF */
$numExped = $data['expediente']['idExp']."_".$data['expediente']['convocatoria'];  
$pdf->Output(WRITEPATH.'documentos/'.$nif.'/informes/'.$numExped.'_res_desestimiento_por_renuncia.pdf', 'F');
