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
    $pdf->SetFontSize(12);
    $y = $ystart; $x = $xstart;
    $pdf->Line ($x, $y, $x+80, $y);
    $y += 1;
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
    $y += 1;
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
    $y += 6; $x = $xstart;
    $pdf->Line ($x, $y, $x+80, $y);
}

function address_field (FPDF $pdf, $x, $y)
{
    $pdf->SetFontSize(10);
    $pdf->SetXY ($x,$y);
    $pdf->Write (5, conv ("Hanseatic Computer · Scheidestr. 17 · 30625 Hannover"));
    $pdf->SetLineWidth(0.1);
    $pdf->SetDrawColor(200, 200, 200);
    $pdf->Rect($x-5, $y+5, 100, 50); 
    $pdf->SetFontSize(12);
    $pdf->SetXY ($x, $y+60);
    $pdf->Write (5, conv ("Ihr Zeichen                       "
                         . "Ihre Nachricht vom                       "
                         . "Unser Zeichen                       "
                         . "Durchwahl"));
}

function set_date ($pdf, $x, $y)
{
    $pdf->SetFont('times','U',12);
    $pdf->SetXY ($x, $y);
    $pdf->Write (5, conv ("Datum: ".date("j.n.Y")));
}

include ('pdf/fpdf.php'); 
function testpdf() 
{
    $pdf = new FPDF('P');
    $pdf->AddPage();
    $pdf->SetFont('times','',12);
    hcheader ($pdf, 12, 16);
    address_field ($pdf, 15, 45);
    $pdf->Image ('pix/hanse.png', 115, 25);
    set_date ($pdf, 150, 96);
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

