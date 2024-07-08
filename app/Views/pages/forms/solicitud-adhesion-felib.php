<?php
helper('cookie');
$language = \Config\Services::language();
$locale = $language->getLocale();

require_once('tcpdf/tcpdf.php');

use App\Models\ConfiguracionModel;
	$modelConfig = new ConfiguracionModel();
	$data['configuracion'] = $modelConfig->where('convocatoria_activa', true)->first();	

class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'ADRBalears-conselleria.jpg';
        $this->Image($image_file, 30, 10, 100, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
	}
    // Page footer
    public function Footer() {
        // Logo

		// Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Address and Page number
		$this->Cell(0, 5, "Agència de desenvolupament regional - Plaça Son Castelló 1 - Tel 971176161 - 07009 - Palma - Illes Balears", 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 15, 'Pàgina '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
	
$pdf->SetAuthor("AGÈNCIA DE DESENVOLUPAMENT REGIONAL DE LES ILLES BALEARS (IDI) - SISTEMES D'INFORMACIÓ");
$pdf->SetTitle("Sol·licitud del Ajuntament per a la adhesió als programes de la ADR Balears");
$pdf->SetSubject('DOCUMENT DE SOL·LICITUD');
$pdf->SetKeywords('INDUSTRIA 4.0, DIAGNÓSTIC, DIGITAL, EXPORTA, ILS, PIMES, ADR Balears, GOIB');	

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

$pdf->SetFont('helvetica', '', 12);
$pdf->setFontSubsetting(false);

// --------------------------------------------------------------CABECERA Programa, datos solicitante, datos consultor ------------------------------------------------------------- //
// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------- //
$pdf->AddPage();

$html1 = lang('message_lang.destino_solicitud').": <b>". lang('message_lang.idi')."</b>";
$html1 .= "<br>";
$html1 .= lang('message_lang.codigo_dir3')." <b>".$data['configuracion']['emisorDIR3']."</b>";
// set color for background
$pdf->SetFillColor(54, 84, 70);
// set color for text
$pdf->SetTextColor(255, 255, 255);
$pdf->writeHTMLCell(90, '', 105, 40, $html1, 1, 1, 1, true, 'J', true);

$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 15);
$pdf->setX($currentX - 10);
$pdf->SetTextColor(0, 0, 0);
$html2 = lang('message_lang.intro_ils_solicitud');
$pdf->writeHTML($html2, true, false, true, false, '');

// --------------------------------------------------1. SELECCIONE EL PROGRAMA DE AYUDA QUE SOLICITA-------------------------------------- //
// --------------------------------------------------------------------------------------------------------------------------------------- //
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 5);
$pdf->setX($currentX - 10);
$html3 = lang('message_lang.convocatoria_sol_idigital')." ".$data['configuracion']['convocatoria']; // El año de la convocatoria de las ayudas

$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 5);
$pdf->setX($currentX - 10);
$html4 =  lang('message_lang.programa'); // el programa de ayudas seleccionado

if ($tipo_tramite == "iDigital") {
	$tipo_tramite = lang('message_lang.programaiDigital');
}
else if ($tipo_tramite == "ILS") {
	$tipo_tramite = lang('message_lang.programaILS');
}
else if ($tipo_tramite == "iExporta") {
	$tipo_tramite = lang('message_lang.programaiExporta');
}

$html5 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html5 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>". $tipo_tramite ."</b></td></tr>";
$html5 .= "</table>";
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 5);
$pdf->setX($currentX - 10);
//$pdf->writeHTML($html5, true, false, true, false, '');

// ------------------------------------------------------------------1. TIPO DE EMPRESA------------------------------------------------------------ //
// ------------------------------------------------------------------------------------------------------------------------------------------------ //
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 5);
/*  $pdf->setX($currentX - 10); */
$html6 =  lang('message_lang.solicitante_tipo_ils'); // TIPO DE EMPRESA
$pdf->Cell(0, 10, $html6, 1, 1, 'C');

if ($tipo_solicitante == "autonomo") {
	$tipo_solicitante = lang('message_lang.solicitante_tipo_autonomo');
	}
else if ($tipo_solicitante == "pequenya") {
	$tipo_solicitante = lang('message_lang.solicitante_tipo_pequenya');
	}
else if ($tipo_solicitante == "mediana") {
	$tipo_solicitante = lang('message_lang.solicitante_tipo_mediana');
}
else if ($tipo_solicitante == "cluster_ct") {
	$tipo_solicitante = lang('message_lang.solicitante_tipo_cluster_ct');
}

$html7 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html7 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'><b>". $tipo_solicitante ."</b></td></tr>";
$html7 .= "</table>";
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 5);
$pdf->setX($currentX - 10);
$pdf->writeHTML($html7, true, false, true, false, '');

$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 5);
$pdf->setX($currentX - 10);
$html8 = lang('message_lang.identificacion_empresa_ils'); // DADES SOL·LICITANT
$pdf->Cell(0, 10, $html8, 1, 1, 'C');

// ------------------------------------------------------------------2. DATOS EMPRESA---------------------------------------------------------------------- //
// -------------------------------------------------------------------------------------------------------------------------------------------------------- //
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 5);
/* $pdf->setX($currentX - 10); */
$html9 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html9 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.solicitante_sol_idigital').": <b>".$empresa."</b></td></tr>"; 
$html9 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>NIF: <b>".$nif."</b></td></tr>";
$html9 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>Domicili: <b>".$domicilio."</b></td></tr>";
$html9 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>Localitat: <b>".$cpostal." ".$localidad."</b></td></tr>";
$html9 .= "<tr><td></td></tr>";
$html9 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.nom_rep_legal_sol_idigital')." :  <b>". $nombre_rep ."</b></td></tr>"; 
$html9 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>NIF :  <b>".  $nif_rep . "</b></td></tr>";

$html9 .= "</table>";
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 5);
$pdf->setX($currentX - 10);
$pdf->writeHTML($html9, true, false, true, false, '');

// ------------------------------------------------------------------3. NOTIFICACIÓN----------------------------------------------------------------------------------- //
// -------------------------------------------------------------------------------------------------------------------------------------------------------------------- //
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 10);
$pdf->setX($currentX - 10);
$html10 = "3. ". lang('message_lang.notificacion_corto'); // "NOTIFICACIÓ (en aquest correu i mòbil rebreu els avisos de les notificacions corresponents al procediment)";
$pdf->Cell(0, 10, $html10, 1, 1, 'C');

$html11 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html11 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.mail_rep_legal_sol_idigital')." :  <b>". $email_rep . "</b></td></tr>";
$html11 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>".lang('message_lang.tel_rep_legal_sol_idigital')." :  <b>" . $telefono_rep . "</b></td></tr>";
$html11 .= "</table>";
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 10);
$pdf->setX($currentX - 10);
$pdf->writeHTML($html11, true, false, true, false, '');

// ----------------------------------------------4. DOCUMENTACIÓN ADJUNTADA requerida y opcional-------------------------------------------------- //
// ----------------------------------------------------------------------------------------------------------------------------------------------- //
$pdf->AddPage();

$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 10);
$pdf->setX($currentX - 10);
$html15 = lang('message_lang.documentacion_adjuntada_ils');
$pdf->Cell(0, 10, $html15, 1, 1, 'C');

$html16 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html16 .= "<tr><td></td></tr>";
$html16 .= "<tr><td></td></tr>";
$html16 .= "<tr><td><ol>";

if ( $file_escritura_empresa == "SI ") {
	$html16 .= "<li>".lang('message_lang.doc_Sede_Social')."-". $file_escritura_empresa."-"."</li>";		
}
if ( $file_lineaProduccionBalearesIls  == "SI ") {
	$html16 .= "<li>".lang('message_lang.linea_Produccion_Baleares_Ils')."</li>";		
}
if ( $file_certificadoIAE == "SI ") {
	$html16 .= "<li>".lang('message_lang.doc_certificado_IAE')."</li>";		
}
if ( $file_informeResumenIls == "SI ") {
	$html16 .= "<li>".lang('message_lang.informe_resumen_ils')."</li>";		
}
if ( $file_informeInventarioIls == "SI ") {
	$html16 .= "<li>".lang('message_lang.informe_inventario_ils')."</li>";		
}
if ( $file_modeloEjemploIls == "SI ") {
	$html16 .= "<li>".lang('message_lang.modelo_ejemplo_ils')."</li>";		
}
if ( $file_certificado_verificacion_ISO == "SI ") {
	$html16 .= "<li>".lang('message_lang.certificado_verificacion_ISO')."</li>";		
}
if ( $file_certificado_itinerario_formativo == "SI ") {
	$html16 .= "<li>".lang('message_lang.certificado_itinerario_formativo')."</li>";		
}

$html16 .= "</ol></td></tr>";
$html16 .= "<tr><td></td></tr>";
$html16 .= "</table>";
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 5);
$pdf->setX($currentX - 10);
$pdf->writeHTML($html16, true, false, true, false, '');

$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 10);
$pdf->setX($currentX - 10);
$html155 = lang('message_lang.documentacion_adjuntada_opcional_ils');
$pdf->Cell(0, 10, $html155, 1, 1, 'C');

$html166 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html166 .= "<tr><td></td></tr>";
$html166 .= "<tr><td></td></tr>";
$html166 .= "<tr><td><ol>";
if ( $file_memoriaTecnica == "SI ") {
	$html166 .= "<li>".lang('message_lang.doc_Memoria_Tecnica')."</li>";		
}
if ( $file_nifEmpresa == "SI ") {
	$html166 .= "<li>".lang('message_lang.cif_empresa')."</li>";		
}
if ( $file_logotipoEmpresaIls == "SI ") {
	$html166 .= "<li>".lang('message_lang.doc_Logo_Empresa')."</li>";		
}
$html166 .= "</ol></td></tr>";
$html166 .= "<tr><td></td></tr>";
$html166 .= "</table>";
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 5);
$pdf->setX($currentX - 10);
$pdf->writeHTML($html166, true, false, true, false, '');

// ---------------------------------------------------------------------------------------------------------------------------- //
// ----------------------------------------------5. AUTORIZACIONES------------------------------------------------------------- //
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 10);
$pdf->setX($currentX - 10);
$html17 = lang('message_lang.autorizaciones_solicitud_ils'); // AUTORIZACIONES
$pdf->Cell(0, 10, $html17, 1, 1, 'C');

$html18 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html18 .= "<tr><td></td></tr>";
$html18 .= "<tr><td><ul>";
	
$html18 .= "<li><b>".$file_enviardocumentoIdentificacion."</b> ".lang('message_lang.consentimiento_identificacion_solicitante')."</li>";		
$html18 .= "<li><b>".$file_certificadoATIB."</b> ".lang('message_lang.doy_mi_consentimiento_aeat_atib')."</li>";		
	
$html18 .= "</ul></td></tr>";
$html18 .= "</table>";
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 5);
$pdf->setX($currentX - 10);
$pdf->writeHTML($html18, true, false, true, false, '');

// ----------------------------------------------------------------------------------------------------------------------------------------------------- //
// ----------------------------------------------6. DECLARACIÓN RESPONSABLE------------------------------------------------------------- //
$pdf->AddPage();
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 10);
$pdf->setX($currentX - 10);

$html20 = "6. ". lang('message_lang.declaracion_responsable_cabecera_ils'); //."DECLARACIÓ RESPONSABLE</h5>";
$localidad = explode ("#", $localidad);
$pdf->Cell(0, 10, $html20, 1, 1, 'C');

$html21 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html21 .= "<tr><td style='background-color:#ffffff;color:#000;font-size:14px;'>" . $empresa . ",".  lang('message_lang.domicilio_notifica_dec_resp') . $domicilio . " de " . $localidad[1] . "</td></tr><br>";
$html21 .= "</table>";
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 5);
$pdf->setX($currentX - 10);
$pdf->writeHTML($html21, true, false, true, false, '');

$html23 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html23 .= "<tr><td>".lang('message_lang.declaro');
$html23 .= "<p>".lang('message_lang.declaracion_responsable_ils')."</p>";

if ( $cumpleRequisitos_dec_resp == "SI ") {
	$html23 .= "<p>".lang('message_lang.declaracion_responsable_ils_v')."</p>";
}

if ( $epigrafeIAE_dec_resp == "SI ") {
	$html23 .= "<p>".lang('message_lang.declaracion_responsable_ils_vii')."</p>";
}

$html23 .= "<p>IV) ".lang('message_lang.datos_consignados')."</p>";
$html23 .= "</td></tr>";
$html23 .= "</table>";

$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 5);
$pdf->setX($currentX - 10);
$pdf->writeHTML($html23, true, false, true, false, '');


// ---------------------------------------------------------------------------------------------------------------------------- //
// ----------------------------------------------7. SOLICITO------------------------------------------------------------------- //
$pdf->AddPage();
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 10);
$pdf->setX($currentX - 10);

$html20 = "7. ". lang('message_lang.solicito_cabecera_ils');
$pdf->Cell(0, 10, $html20, 1, 1, 'C');

$html18 = "<table cellpadding='5' style='width: 100%;border: 1px solid #ffffff;'>";
$html18 .= "<tr><td></td></tr>";
$html18 .= "<tr><td></td></tr>";
$html18 .= "<tr><td>".lang('message_lang.expongo_ils')."</td></tr>";
$html18 .= "<tr><td></td></tr>";
$html18 .= "<tr><td>".lang('message_lang.solicito_ils')."</td></tr>";
$html18 .= "</table>";

$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 10);
$pdf->setX($currentX - 10);
$pdf->writeHTML($html18, true, false, true, false, '');

// ---------------------------------------------------------FECHA y FIRMA----------------------------------------------------- //

$pdf->SetFont('helvetica', '', 12);

$html29 = "<br>";
$html29 .= "<table cellpadding='3px' style='width: 100%; border: 1px solid #ffffff;'>";
$html29 .= "<tr><td style='text-align:left;background-color:#f2f2f2;color:#000;'>".lang('message_lang.fecha_ils')."</td></tr>";
$html29 .= "<tr><td style='text-align:left;background-color:#f2f2f2;color:#000;'>".lang('message_lang.firma_ils')."</td></tr>";
$html29 .= "</table>";
$currentY = $pdf->getY();
$pdf->setY($currentY+35);
$pdf->WriteHTML($html29, true, false, true, false, '');

// ------------------------------------------------------------------------------------ //
// ------------------------------------------------------------------------------------ //

// ---------------------------------------------------------RGDP-------------------------------------------------- //

$pdf->SetFont('helvetica', '', 7);
$rgpd = lang('message_lang.rgpd_txt');
$html29 = "<br>";
$html29 .= "<table cellpadding='3px' style='width: 100%; border: 1px solid #ffffff;'>";
$html29 .= "<tr><td style='text-align:center;background-color:#f2f2f2;color:#000;font-size:7px;'>$rgpd</td></tr>";
$html29 .= "</table>";
$currentY = $pdf->getY();
$currentX = $pdf->getX();
$pdf->setY($currentY + 10);
$pdf->setX($currentX - 10);
$pdf->WriteHTML($html29, true, false, true, false, '');

$pdf->Output(WRITEPATH.'documentos/'.$nif.'/'.$selloDeTiempo.'/'.$nif.'_dec_res_solicitud_felib.pdf', 'F');

?>


<div class="container">
	<div><?php echo $html1;?></div>
	<div><?php echo $html2;?></div>

	<div class="cabecera-apartado"><?php echo $html6;?></div>
	<div ><?php echo $html7;?></div>
	<div class="cabecera-apartado"><?php echo $html8;?></div>
	<div ><?php echo $html9;?></div>
	<div class="cabecera-apartado"><?php echo $html10;?></div>
	<div ><?php echo $html11;?></div>
	<div class="cabecera-apartado"><?php echo $html12;?></div>
	<div ><?php echo $html13;?></div>

	<div class="cabecera-apartado"><?php echo $html15;?></div>
	<div ><?php echo $html16;?></div>
	<div class="cabecera-apartado"><?php echo $html155;?></div>
	<div ><?php echo $html166;?></div>
	<div ><?php echo $html17;?></div>
	<div ><?php echo $html18;?></div>

	<div ><?php echo $html20;?></div>
	<div ><?php echo $html21;?></div>
	<div class="cabecera-apartado"><?php echo $html22;?></div>
	<div ><?php echo $html23;?></div>
	<div ><?php echo $html24;?></div>
	<div ><?php echo $html25;?></div>

	<div ><?php echo $html27;?></div>
	<div ><?php echo $html28;?></div>

</div>
<style>
	html, body {
		font-size: 14px!important;
	}
	table, li {
		font-size: 1rem!important;
	}

	td {
		padding: 0.5cm!important;
	}
	.cabecera-apartado {
		margin-top:1rem;
	}
	.container {
    max-width: 1140px;
    border: 1px solid black;
    background-color: #cdebe8;
    color: #000;
    border-radius: .5rem;
	padding: 1rem;
	margin-bottom: 1rem;
	}
</style>