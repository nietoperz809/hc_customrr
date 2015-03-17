<?php

include ('pdf/fpdf.php'); 

/**
 * Converts UTF8 to win 1252
 * @param type $in
 * @return type
 */
function conv ($in)
{
    return iconv ('UTF-8', 'windows-1252', $in);
}

/**
 * PDF output function
 * @param type $pdf PDF object
 * @param type $txt Text to print
 */
function out ($pdf, $txt)
{
    $pdf->Write(5, conv ($txt));
}

function hcheader ($pdf, $xstart, $ystart)
{
    $pdf->SetFont('times','',12);
    $y = $ystart; $x = $xstart;
    $pdf->Line ($x, $y, $x+80, $y);
    $y += 1;
    $pdf->SetXY ($x,$y);
    out ($pdf, '• Hardware');
    $y += 6;
    $pdf->SetXY ($x,$y);
    out ($pdf, '• Software');
    $y += 6;
    $pdf->SetXY ($x,$y);
    out ($pdf, '• Netzwerke');
    $y += 6;
    $pdf->SetXY ($x,$y);
    out ($pdf, '• Beratung');
    $y = $ystart; $x = $xstart+30;
    $y += 1;
    $pdf->SetXY ($x,$y);
    out ($pdf, '• Eigene Werkstatt');
    $y += 6;
    $pdf->SetXY ($x,$y);
    out ($pdf, '• Vor-Ort-Service');
    $y += 6;
    $pdf->SetXY ($x,$y);
    out ($pdf, '• 24h-Service');
    $y += 6;
    $pdf->SetXY ($x,$y);
    out ($pdf, '• An- und Verkauf');
    $y += 6; $x = $xstart;
    $pdf->Line ($x, $y, $x+80, $y);
}

/**
 * Draws the address field
 * @param FPDF $pdf PDF object
 * @param type $x xPos
 * @param type $y yPos
 * @param type $arr Associative Array with values from DB
 */
function address_field (FPDF $pdf, $x, $y, $arr)
{
    $pdf->SetFontSize(10);
    $pdf->SetXY ($x,$y);
    out ($pdf, "Hanseatic Computer · Scheidestr. 17 · 30625 Hannover");
    $pdf->SetLineWidth(0.1);
    $pdf->SetDrawColor(200, 200, 200);
    $pdf->Rect($x-5, $y+5, 100, 50); 
    
    $pdf->SetFontSize(14);
    $y1 = $y+20;
    $x1 = $x+10;
    $pdf->SetXY ($x1,$y1);
    out ($pdf, $arr['anrede']);
    $y1 += 5;
    $pdf->SetXY ($x1,$y1);
    out ($pdf, $arr['vname'].' '.$arr['name']);
    $y1 += 5;
    $pdf->SetXY ($x1,$y1);
    out ($pdf, $arr['street'].' '.$arr['hausnr']);
    $y1 += 5;
    $pdf->SetXY ($x1,$y1);
    out ($pdf, $arr['plz'].' '.$arr['ort']);
    
    $pdf->SetFontSize(12);
    $pdf->SetXY ($x, $y+60);
    out ($pdf, "Ihr Zeichen                       "
               . "Ihre Nachricht vom                       "
               . "Unser Zeichen                       "
               . "Durchwahl");
}

function set_date ($pdf, $x, $y)
{
    $pdf->SetFont('times','U',12);
    $pdf->SetXY ($x, $y);
    out ($pdf, "Datum: ".date("j.n.Y"));
}

function invoice_number ($pdf, $x, $y, $num)
{
    $pdf->SetFont('times','B', 20);
    $pdf->SetXY ($x, $y);
    out ($pdf, "Rechnung Nr.  ".$num);
    $pdf->SetFont('times','', 10);
    $pdf->SetXY ($x, $y+8);
    out ($pdf, "Das Lieferdatum entspricht dem Rechnungsdatum");
}

function table_header ($pdf, $x, $y)
{
    $pdf->SetFont('times','B',12);
    $pdf->SetXY ($x, $y);
    out ($pdf, "Anzahl           Artikel");
    $pdf->SetXY ($x+95, $y);
    out ($pdf, "Einzelpreis    Einzelpreis      Gesamtpreis");
    $pdf->SetXY ($x+95, $y-5);
    out ($pdf, "  Brutto-           Netto-                Netto-");
    $pdf->SetLineWidth (0.5);
    $pdf->SetDrawColor (0,0,0);
    $pdf->Line($x-5, $y+5, $x+170, $y+5); 
}

function table_sumfield ($pdf, $x, $y, $sum)
{
    $pdf->SetLineWidth (0.1);
    $pdf->SetDrawColor (0,0,0);
    $pdf->Line($x, $y, $x+81, $y); 
    $pdf->SetFont('courier','B',12);
    $pdf->SetXY ($x, $y);
    out ($pdf, " Netto-Gesamtbetrag =".format_price($sum));
    $y += 5;
    $pdf->SetXY ($x, $y);
    out ($pdf, "     Zzgl. 19% MwSt =".format_price(1));
    $y += 5;
    $pdf->SetXY ($x, $y);
    out ($pdf, "Brutto-Gesamtbetrag =".format_price(999));
    $y += 5;
    $pdf->Line($x, $y, $x+81, $y); 
    $pdf->Line($x, $y+1, $x+81, $y+1); 
}

/**
 * Generates Table rows
 * @param FPDF $pdf PDF object
 * @param int $x start X
 * @param int $y start Y
 * @param array $counts 
 * @param array $prices
 */
function table_rows ($pdf, $x, $y, $counts, $prices, $names)
{
    $counts = array (1,2,3);
    $prices = array (41200,500,666);
    $names = array ('hallo', 'dumm', 'doof');

    $pdf->SetFont('courier','',12);
    $num = count ($counts);
    $xold = $x;
    $yold = $y;
    for ($n=0; $n<$num; $n++)
    {
        $netto_e = format_price($prices[$n]);
        $brutto_e = format_price($prices[$n]);
        $pdf->SetXY ($x, $y);
        out ($pdf, $counts[$n]);
        $x += 20;
        $pdf->SetXY ($x, $y);
        out ($pdf, $names[$n]);
        $x += 62;
        $pdf->SetXY ($x, $y);
        out ($pdf, format_price($prices[$n]));
        $x += 28;
        $pdf->SetXY ($x, $y);
        out ($pdf, $netto_e);
        $x += 28;
        $pdf->SetXY ($x, $y);
        out ($pdf, $brutto_e);
        $y += 5;
        $x = $xold;
    }
    table_sumfield ($pdf, $x+84, $y, 1234567);
}

function footer1 ($pdf, $x, $y)
{
    $pdf->SetFont('times','',10);
    $pdf->SetXY ($x, $y);
    out ($pdf, "Die Ware bleibt bis zu vollständigen Bezahlung unser Eigentum");
    $pdf->SetXY ($x, $y+5);
    out ($pdf, "Bankverbindung: Postbank Hannover, BLZ 250 100 30, Konto-Nr. 454382306");
    $pdf->SetXY ($x, $y+10);
    out ($pdf, "Ust.-ID DE186984567");
    $pdf->SetXY ($x, $y+15);
    out ($pdf, "Geschäftsführer: H. Erkan");
}

function footer2 ($pdf, $x, $y)
{
    $pdf->SetFont('times','',10);
    $pdf->SetXY ($x, $y);
    out ($pdf, "Die Lieferung unterliegt gemäß Paragraf 25a UStG der Differenzbesteuerung");
    footer1 ($pdf, $x, $y+5);
}

function signatures ($pdf, $x, $y)
{
    $pdf->SetFont('times','',12);
    $pdf->SetLineWidth (0.1);
    $pdf->SetDrawColor (0,0,0);
    $pdf->Line($x, $y, $x+65, $y);
    $pdf->SetXY ($x+15, $y+2);
    out ($pdf, "Hanseatic Computer");
    $pdf->SetXY ($x+130, $y+2);
    out ($pdf, "Ware erhalten");
    $pdf->Line($x+110, $y, $x+175, $y); 
}

function endtext ($pdf, $x, $y, $type1, $type2)
{
    $pdf->SetFont('times','BI',10);
    $pdf->SetXY ($x, $y);
    if ($type1 == TRUE)
    {
        out ($pdf, "6 Monate Gewährleistung");
    }
    else
    {
        out ($pdf, "12 Monate Herstellergarantie");
    }
    $pdf->SetXY ($x, $y+5);
    out ($pdf, "Wir danken für Ihren Auftrag.");
    $pdf->SetXY ($x, $y+10);
    if ($type2 == TRUE)
    {
        out ($pdf, "Betrag bar erhalten.");
    }
    else
    {
        out ($pdf, "Zahlbar sofort ohne Abzug auf unser Konto.");
    }
}

/**
 * Creates invoice as PDF 
 * @param array $arr_invoice invoice data 
 * @param array $arr_customer customer data
 */
function create_pdf ($arr_invoice, $arr_customer) 
{
    $filename = urlencode($arr_invoice['code']);
    $pdf = new FPDF('P');
    $pdf->AddPage();
    hcheader ($pdf, 12, 16);
    address_field ($pdf, 15, 45, $arr_customer);
    $pdf->Image ('pix/hanse.png', 115, 25);
    set_date ($pdf, 150, 96);
    invoice_number($pdf, 15, 120, $arr_invoice['code']);
    table_header ($pdf, 20, 140);
    table_rows ($pdf, 25, 147, 0,0,0);
    footer2 ($pdf, 15, 250);
    signatures ($pdf, 15, 240);
    endtext($pdf, 15, 215, FALSE, FALSE);
    $pdf->Output('c:\\'.$filename.'.pdf','F');
}



