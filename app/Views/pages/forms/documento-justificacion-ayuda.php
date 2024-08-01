<?php
require_once('tcpdf/tcpdf.php');
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
        $this->Cell(0, 15, 'Pàgina '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
	
$pdf->SetAuthor("AGÈNCIA DE DESENVOLUPAMENT REGIONAL DE LES ILLES BALEARS (IDI) - SISTEMES D'INFORMACIÓ");
$pdf->SetTitle("Requeriment de justificació documentació d'ajuts xecs consultoria");
$pdf->SetSubject('REQUERIMENT DE JUSTIFICACIÓ XECS CONSULTORIA');
$pdf->SetKeywords('INDUSTRIA 4.0, DIAGNÓSTIC, DIGITAL, PIMES, IDI, GOIB');	

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

// -------------------------------------------------------------------------------------------------------------------------------------------------- //
use App\Models\ConfiguracionModel;
use App\Models\ConfiguracionLineaModel;
use App\Models\ExpedientesModel;

$configuracion = new ConfiguracionModel();
$configuracionLinea = new ConfiguracionLineaModel();
$modelExp = new ExpedientesModel();

$db = \Config\Database::connect();
$uri = new \CodeIgniter\HTTP\URI();
$request = \Config\Services::request();

$tipoTramite = get_cookie ('tipoTramite');
	
$query = $db->query("SELECT * FROM pindust_documentos_justificacion WHERE selloDeTiempo ='" . $selloTiempo."'");
$justificacion = $query->getResult();
$data['configuracion'] = $configuracion->where('convocatoria_activa', 1)->first();
$data['configuracionLinea'] = $configuracionLinea->activeConfigurationLineData('XECS', $data['configuracion']['convocatoria']); 
$data['expedientes'] = $modelExp->where('id', $id)->first();

// --------------------------------------------------------------------------------------------------------------------------------------------------- //
$pdf->AddPage();
$currentY = $pdf->getY();

$html = "<strong>".lang('message_lang.justificacion_titulo')."</strong><br><br>";
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0, 0, 0);
$pdf->writeHTMLCell(180, '', 20, 60, $html, 0, 1, 1, true, 'J', true);

$html = "<strong>".lang('message_lang.titulo_justificacion_idigital')."</strong><br><br>";
$html .= "<strong>".lang('message_lang.destino_solicitud').": Agència de desenvolupament regional de les Illes Balears</strong><br><br>";
$html .= "<strong>".lang('message_lang.codigo_dir3')."</strong>".$data['configuracion']['emisorDIR3']."<br>";
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0, 0, 0);
$pdf->writeHTMLCell(167, '', 20, 70, $html, 0, 1, 1, true, 'J', true);

echo "<content><section>".$html;

$html = "<table cellpadding='5' style='width: 100%; border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.identificacion_sol_idigital').":<br><br>".lang('message_lang.solicitante_sol_idigital').": ".$data['expedientes']['empresa']." NIF: ".$data['expedientes']['nif']."<br>";
$html .= lang('message_lang.nom_rep_legal_sol_idigital').": ".$data['expedientes']['nombre_rep']." ".lang('message_lang.nif_rep_legal_sol_idigital')." ".$data['expedientes']['nif_rep']."<br><br>";
$html .= lang('message_lang.select_programa_justificacion').":<br><br>";
$html .= $data['expedientes']['tipo_tramite']."</td></tr>";
$html .= "</table>";
echo $html;
$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$pdf->writeHTMLCell(167, '', 20, '', $html, 0, 1, 1, true, 'J', true);
/* echo "<br>********".$importeTotalJustificado."********<br>";
echo "<br>********".$id_sol."********<br>"; */

$html = "<table cellpadding='5' style='width: 100%; border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.importe_total_justificacion').": ".$importeTotalJustificado." €<br>";
$html .= "</td></tr>";
$html .= "</table>";
echo $html;
$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$pdf->writeHTMLCell(167, '', 20, '', $html, 0, 1, 1, true, 'J', true);

$html = "<table cellpadding='5' style='width: 100%; border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.declaro')."<br><br>".lang('message_lang.justificacion_declaracion').":<br>";
$html .= "</td></tr>";
$html .= "</table>";
echo $html;
$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$pdf->writeHTMLCell(167, '', 20, '', $html, 0, 1, 1, true, 'J', true);

$html = "<table cellpadding='5' style='border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>";
$html .= "<ul>";
foreach($justificacion as $docsJustif_item):
	if ( $docsJustif_item->corresponde_documento == "file_PlanTransformacionDigital") {
		$html .= "<li>".lang('message_lang.justificacion_plan_doc').".</li>";
	}
endforeach;
$html .= "<li>".lang('message_lang.justificacion_mem_econom').":<ul>";
foreach($justificacion as $docsJustif_item):
    if ( $docsJustif_item->corresponde_documento == "file_FactTransformacionDigital") {
        $html .= "<li>".lang('message_lang.justificacion_facturas_dec_resp')."</li>";
    }
    if ( $docsJustif_item->corresponde_documento == "file_PagosTransformacionDigital") {
        $html .= "<li>".lang('message_lang.justificacion_justificantes_dec_resp')."</li>";
    }
endforeach;
$html .= "</ul></li>";
$html .= "</ul>";
$html .= "</td></tr>";
$html .= "</table><br>";
echo $html;
$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$pdf->writeHTMLCell(158, '', 20, '', $html, 0, 1, 1, true, 'J', true);

$html = "<table cellpadding='5' style='width: 100%; border: 1px solid #ffffff;'>";
$html .= "<tr><td>";
$html .= "<strong>".lang('message_lang.justificacion_mem_econom_titulo').":</strong><br>";
$html .= $memoriaEconomicaJustificativa;
$html .= "</td></tr>";
$html .= "</table>";
echo $html;
$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$pdf->writeHTMLCell(167, '', 20, '', $html, 0, 1, 1, true, 'J', true);

/* ------------------firma el documento ------------------------------ */
$pdf->setPrintHeader(false);
$pdf->AddPage();
$image_file = K_PATH_IMAGES.'logoVerticalIDI.png';
$pdf->Image($image_file, 15, 15, '', '20', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

$html = "<table cellpadding='5' style='font-size: 7px; width: 100%; border: 1px solid #fff;'>";
$html .= "<tr><td style='text-align:left;background-color:#f2f2f2;color:#000;font-size:8px;'>".lang('message_lang.firmo_documento_justificacion')."</td></tr><br>";
$html .= "</table>";

echo $html;
$currentY = $pdf->getY();
$pdf->setY($currentY + 10);
$pdf->writeHTMLCell(167, '', 20, 80, $html, 0, 1, 1, true, 'J', true);

// ---------------------------------------------------------RGDP----------------------- //
$pdf->SetFont('helvetica', '', 7);
$rgpd = lang('message_lang.rgpd_txt');
$html29 = "<table cellpadding='3px' style='width: 100%; border: 1px solid #ffffff;'>";
$html29 .= "<tr><td style='text-align:left;background-color:#f2f2f2;color:#000;font-size:7px;'>$rgpd</td></tr>";
$html29 .= "</table>";
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 9);
$pdf->WriteHTML($html29, true, false, true, false, '');

// --------------------------------------------------------------------------------------------------------------------------------------------- //
// Lo guarda todo en una carpeta del servidor para, luego, enviarlo por correo electrónico.
$pdf->Output(WRITEPATH.'documentos/'.$nif.'/justificacion/'.$selloTiempo.'/'.$nif.'_justificacion_solicitud_ayuda.pdf', 'F');