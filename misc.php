<?php

function math_eval($s) 
{
    $ma = eval('return ' . $s . ';');
    return $ma;
}

function conv ($in)
{
    return iconv ('UTF-8', 'windows-1252', $in);
}

function hcheader (FPDF $pdf, $xstart, $ystart)
{
    $y = $ystart; $x = $xstart;
    $pdf->Line ($x, $y, $x+80, $y);
    $y += 6;
    $pdf->SetXY ($x,$y);
    $pdf->Write(5, conv ('• Hardware'));
    $y += 6;
    $pdf->SetXY ($x,$y);
    $pdf->Write(5, conv ('• Software'));
    $y += 6;
    $pdf->SetXY ($x,$y);
    $pdf->Write(5, conv ('• Netzwerke'));
    $y += 6;
    $pdf->SetXY ($x,$y);
    $pdf->Write(5, conv ('• Beratung'));
    $y = $ystart; $x = $xstart+30;
    $pdf->SetXY ($x,$y);
    $pdf->Write(5, conv ('• Eigene Werkstatt'));
    $y += 6;
    $pdf->SetXY ($x,$y);
    $pdf->Write(5, conv ('• Vor-Ort-Service'));
    $y += 6;
    $pdf->SetXY ($x,$y);
    $pdf->Write(5, conv ('• 24h-Service'));
    $y += 6;
    $pdf->SetXY ($x,$y);
    $pdf->Write(5, conv ('• An- und Verkauf'));
    $y += 12; $x = $xstart;
    $pdf->Line ($x, $y, $x+80, $y);
}

include ('fpdf.php'); 
function testpdf() 
{
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('times','',12);
    $pdf->SetFontSize(12);
    hcheader ($pdf, 2, 2);
    $pdf->Output('c:\\test.pdf','F');
}

/*
 * Rechnungsnummer jahr/
 * b oder u (bar oder unbar)
 * fortlauf. nummer immer 6 stellig, 
 * ersten beiden stellen == monat (mit führender 0)
 * keine führenden nullen in der fortlaufenden nummer
 * reset der fortlaufenden nummer am jahresanfang
 * 
 *  
 * 
 * 
 * 
 * 
 */

