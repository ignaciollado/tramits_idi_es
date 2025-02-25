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
		$this->Cell(0, 5, "Línia d’ajuts per al disseny de plans de transformació digital 2020 (exp. núm.". $expedientes['id']." / ".$expedientes['tipo_tramite'], 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 15, 'Pàgina '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
	
$pdf->SetAuthor("INSTITUT D'INNOVACIÓ EMPRESARIAL DE LES ILLES BALEARS (IDI) - SISTEMES D'INFORMACIÓ");
$pdf->SetTitle("Resolució sol·licitud ajudes/subvencions DENEGACIÓ");
$pdf->SetSubject('DOCUMENT DE RESOLUCIÓ');
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
// La resolución.
$pdf->AddPage();
$html = "<section>";
$html .= "<h4>Expedient: ". $expedientes['id']." / ".$expedientes['tipo_tramite']." Ajut per al disseny de plans de transformació digital 2020</h4>";
$html .= "<h4>Document: Resolució</h4>";
$html .= "<h4>Emissor: IDI </h4>";

// set color for background
$pdf->SetFillColor(230, 247, 255);

// set color for text
$pdf->SetTextColor(0, 0, 0);
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
$pdf->writeHTMLCell(90, '', 105, 20, $html, 1, 1, 1, true, 'J', true);

$currentY = $pdf->getY();
$currentY = $pdf->setY($currentY + 25);
$html = "Proposta de resolució de la directora gerent de l’IDI per la qual es <strong>denega</strong> la concessió d’un ajut per al disseny i la implementació d’un pla de transformació digital a ".$expedientes['empresa']." amb DNI ".$expedientes['nif'];
$pdf->writeHTMLCell(180, '', '', $currentY, $html, 0, 0, 0, true, 'J', true);

$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>Antecedents</b></td></tr>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>1. Mitjançant Resolució del president de l'Institut d’Innovació Empresarial de les Illes Balears (IDI) de dia $fecha_resol es va aprovar la convocatòria per a l’any 2020 d’ajuts per al disseny de plans de transformació digital per a l’any 2020 destinats a la indústria balear, en el marc d’Idigital, Estratègia de Digitalització Industrial (BOIB núm. XXX, de X de XXXXX de 2020).</td></tr>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>2. D'acord amb el punt 12è de la convocatòria, es designen els membres de la Comissió Avaluadora per a la valoració de les sol·licituds presentades.</td></tr><tr><td style='background-color:</td></tr>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>3. El $fecha_solicitud, l'Institut d’Innovació Empresarial de les Illes Balears (IDI)  va rebre la sol·licitud de ".$expedientes['empresa']." amb DNI ".$expedientes['nif']." d'un ajut per import de XXXXX euros, equivalent a XX hores de consultoria especialitzada.</td></tr>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>4. Una vegada revisada la sol·licitud d’ajut, s’ha comprovat que l’entitat sol·licitant no compleix amb els requisits establerts en la convocatòria.</td></tr>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>5. En la sessió de dia XXXXXXXXXXX de 2020, la Comissió Avaluadora va emetre un informe desfavorable a la concessió de l’ajut, atès que no té un IAE inclosos en les divisions 2,3 i 4 de la secció primera corresponents a activitats empresarials, i els serveis complementaris establers en l’annex 2 de la convocatòria, d’acord amb en punt 3.1 de la convocatòria.</td></tr>";
$html .= "</table>";

$currentY = $pdf->getY();
$currentY = $pdf->setY($currentY + 10);
$pdf->writeHTMLCell(180, '', '', $currentY, $html, 0, 0, 0, true, 'J', true);


$currentY = $pdf->getY();
$pdf->setY($currentY + 5);
$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>Aquest informe serveix de base per a la resolució de no concessió de l’ajut.</b></td></tr>";
$html .= "</table>";

$currentY = $pdf->getY();
$pdf->setY($currentY+2);
$pdf->writeHTML($html, true, false, true, false, '');

$html = "<b>Fonaments de dret</b>";
$pdf->Cell(0, 10, $html, 1, 1, 'L');

$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>1. La Resolució del president de l’Institut d’Innovació Empresarial de les Illes Balears (IDI) de dia XXXXXXXXX per la qual s’aprova la convocatòria per a l’any 2020 d’ajuts per al disseny de plans de transformació digital per a l’any 2020 destinats a la indústria balear, en el marc d’Idigital, Estratègia de Digitalització Industrial (BOIB núm. XXX, d’X de XXXX de 2020).</td></tr>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>2. L'Ordre de la consellera de Comerç, Indústria i Energia per la qual s'estableixen les bases reguladores per a la concessió de subvencions en matèria de promoció industrial (BOIB núm. 52, de 17 d'abril de 2008).</td></tr>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>3. El Text refós de la Llei de subvencions, aprovat pel Decret legislatiu 2/2005, de 28 de desembre.</td></tr>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>4. El Decret 75/2004, de 27 d’agost, de desplegament de determinats aspectes de la Llei de finances i de les lleis de pressupost generals de la Comunitat Autònoma de les Illes Balears (BOIB núm.122, de 2 de setembre).</td></tr>";
$html .= "</table>";

$currentY = $pdf->getY();
$pdf->setY($currentY+2);
$pdf->writeHTML($html, true, false, true, false, '');
$html = "DADES ECONÒMIQUES";
$pdf->Cell(0, 10, $html, 1, 1, 'L');

$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>Per tot això, d’acord amb allò que disposen els preceptes abans esmentats, s’efectua la següent</td></tr>";
$html .= "</table>";

$currentY = $pdf->getY();
$pdf->setY($currentY+2);
$pdf->writeHTML($html, true, false, true, false, '');
$html = "<b>Proposta de resolució</b>";
$pdf->Cell(0, 10, $html, 1, 1, 'L');

$html = "<b>Propòs al president de l’IDI que dicti una resolució en els termes següents:</b>";
$pdf->Cell(0, 10, $html, 1, 1, 'L');

$html = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>$motivo_resol</td></tr>";
$html .= "</table>";
$currentY = $pdf->getY();
$pdf->setY($currentY+2);
$pdf->writeHTML($html, true, false, true, false, '');

// Lo guarda todo en una carpeta del servidor para, luego, enviarlo por correo electrónico.
$pdf->Output(WRITEPATH.'documentos/'.$expedientes['nif'].'/'.$expedientes['selloDeTiempo'].'/'.'resolucion_denegacion.pdf', 'F');