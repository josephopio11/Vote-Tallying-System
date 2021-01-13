<?php
$locale  = service('request')->getLocale();
$title = lang('votes._form_votes62729055');
$formSlug = 'votes62729055';
$id = $pdfData['id'];
$table_name = 'votes';

$font = 'freeserif'; //DejaVu Sans

$path = WRITEPATH . "uploads/{$table_name}/pdf/";

if(!file_exists($path))
{
mkdir($path, 0777, true);
}

require_once(APPPATH . 'ThirdParty/tcpdf/config/tcpdf_config.php');
require_once(APPPATH . 'ThirdParty/tcpdf/tcpdf.php');

$html = <<<EOF
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body{ 
            font-family: $font;
            font-style: normal;
            font-size: 12pt;
        } 
        table{ 
            font-family: $font;
            font-style: normal;
            font-size: 12pt;
        }
        div{  
            font-family: $font;
            font-style: normal;
            font-size: 12pt;
        }
        label{ 
            font-family: $font;
            font-style: normal;
            font-size: 10pt;
            line-height: 1.5;
            color: #212529;
            display: inline-block;
            margin-bottom: 0;
        }
        hr{
            color: #ccc;
            height: 1rem;
        }
        
    </style>
    <h1 class="title">{$title}</h1>
EOF;

$html .= <<<HTML
    
HTML;

$md5      = md5($title . $locale . $html);
$fileName = $formSlug . '-' . $id . '-' . $locale . '-' . $md5 . '.pdf';
$fullPath = $path . $fileName;

if (file_exists($fullPath))
{
echo json_encode(['newCreated' => 0, 'md5' => $md5, 'name' => $fileName, 'fullPath'=> $fullPath, 'path' => $path]);
return;
}

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('veboMedia.com');
$pdf->SetTitle($title);
$pdf->SetSubject($title);
$pdf->SetKeywords('key1');
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT - 5, PDF_MARGIN_TOP - 15, PDF_MARGIN_RIGHT - 5);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// ---------------------------------------------------------
// set default font subsetting mode
$pdf->setFontSubsetting(true);
// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont($font);
$pdf->SetFont($font, '', 12, true, true);

//$pdf->SetFont('DejaVu Sans', '', 10, true, true);

$pdf->AddPage();

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Output($fullPath, 'F');

echo json_encode(['newCreated' => 1, 'md5' => $md5, 'name' => $fileName, 'fullPath'=> $fullPath, 'path' => $path]);
