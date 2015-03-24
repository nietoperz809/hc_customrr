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

function out2 ($x, $y, $pdf, $txt)
{
    $pdf->SetXY ($x,$y);
    $pdf->Write(5, conv ($txt));
}

function hcheader ($pdf, $xstart, $ystart)
{
    $pdf->SetFont('times','',12);
    $y = $ystart; $x = $xstart;
    $pdf->Line ($x, $y, $x+80, $y);
    $y += 1;
    out2 ($x,$y, $pdf, '• Hardware');
    $y += 6;
    out2 ($x,$y, $pdf, '• Software');
    $y += 6;
    out2 ($x,$y, $pdf, '• Netzwerke');
    $y += 6;
    out2 ($x,$y, $pdf, '• Beratung');
    $y = $ystart; $x = $xstart+30;
    $y += 1;
    out2 ($x,$y, $pdf, '• Eigene Werkstatt');
    $y += 6;
    out2 ($x,$y, $pdf, '• Vor-Ort-Service');
    $y += 6;
    out2 ($x,$y, $pdf, '• 24h-Service');
    $y += 6;
    out2 ($x,$y, $pdf, '• An- und Verkauf');
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
    out2 ($x,$y, $pdf, "Hanseatic Computer · Scheidestr. 17 · 30625 Hannover");
    $pdf->SetLineWidth(0.1);
    $pdf->SetDrawColor(200, 200, 200);
    $pdf->Rect($x-5, $y+5, 100, 50); 
    
    $pdf->SetFontSize(14);
    $y1 = $y+20;
    $x1 = $x+10;
    out2 ($x,$y, $pdf, $arr['anrede']);
    $y1 += 5;
    out2 ($x,$y, $pdf, $arr['vname'].' '.$arr['name']);
    $y1 += 5;
    out2 ($x,$y, $pdf, $arr['street'].' '.$arr['hausnr']);
    $y1 += 5;
    out2 ($x,$y, $pdf, $arr['plz'].' '.$arr['ort']);
    
    $pdf->SetFontSize(12);
    out2 ($x,$y, $pdf, "Ihr Zeichen                       "
               . "Ihre Nachricht vom                       "
               . "Unser Zeichen                       "
               . "Durchwahl");
}

function set_date ($pdf, $x, $y)
{
    $pdf->SetFont('times','U',12);
    out2 ($x,$y, $pdf, "Datum: ".date("j.n.Y"));
}

function invoice_number ($pdf, $x, $y, $num)
{
    $pdf->SetFont('times','B', 20);
    out2 ($x, $y, $pdf, "Rechnung Nr.  ".$num);
    $pdf->SetFont('times','', 10);
    out2 ($x, $y+8, $pdf, "Das Lieferdatum entspricht dem Rechnungsdatum");
}

function table_header ($pdf, $x, $y)
{
    $pdf->SetFont('times','B',12);
    out2 ($x, $y, $pdf, "Anzahl           Artikel");
    out2 ($x+95, $y, $pdf, "Einzelpreis    Einzelpreis      Gesamtpreis");
    out2 ($x+95, $y-5, $pdf, "  Brutto-           Netto-                Netto-");
    $pdf->SetLineWidth (0.5);
    $pdf->SetDrawColor (0,0,0);
    $pdf->Line($x-5, $y+5, $x+170, $y+5); 
}

function table_sumfield ($pdf, $x, $y, $sum)
{
    $mwst = $sum*0.19;
    $pdf->SetLineWidth (0.1);
    $pdf->SetDrawColor (0,0,0);
    $pdf->Line($x, $y, $x+81, $y); 
    $pdf->SetFont('courier','B',12);
    out2 ($x, $y, $pdf, " Netto-Gesamtbetrag =".format_price($sum));
    $y += 5;
    out2 ($x, $y, $pdf, "     Zzgl. 19% MwSt =".format_price($mwst));
    $y += 5;
    out2 ($x, $y, $pdf, "Brutto-Gesamtbetrag =".format_price($sum+$mwst));
    $y += 5;
    $pdf->Line($x, $y, $x+81, $y); 
    $pdf->Line($x, $y+1, $x+81, $y+1); 
}

/**
 * Generates Table rows
 * @param FPDF $pdf PDF object
 * @param int $x start X
 * @param int $y start Y
 * @param array $inv_lines invoice lines  
 * @param array $invoice invoice as array
 */
function table_rows ($pdf, $x, $y, $inv_lines, $invoice)
{
    $pdf->SetFont('courier','',12);
    $xold = $x;
    $yold = $y;
    $netto_sum = 0;
    while (1)
    {
        $arr = mysqli_fetch_array($inv_lines);
        if ($arr == NULL)
        {
            break;
        }
        $price = $arr['price'];
        $text = $arr['text'];
        $counts = $arr['items'];
        $netto_e = $price*100/119;
        $brutto_e = $price;
        $netto_g = $counts*$price*100/119;
        if ($counts != 0)
            out2 ($x, $y, $pdf, $counts);
        $x += 20;
        out2 ($x, $y, $pdf, $text);
        $x += 62;
        if ($counts != 0)
            out2 ($x, $y, $pdf, format_price($brutto_e));
        $x += 28;
        if ($counts != 0)
            out2 ($x, $y, $pdf, format_price($netto_e));
        $x += 28;
        if ($counts != 0)
            out2 ($x, $y, $pdf, format_price($netto_g));
        $y += 5;
        $x = $xold;
        $netto_sum += $netto_g;
    }
    table_sumfield ($pdf, $x+84, $y, $netto_sum);
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
 * @param array $q_inv_lines invoice lines
 */
function create_pdf ($arr_invoice, $arr_customer, $q_inv_lines) 
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
    table_rows ($pdf, 25, 147, $q_inv_lines, $arr_invoice);
    footer2 ($pdf, 15, 250);
    signatures ($pdf, 15, 240);
    endtext($pdf, 15, 215, FALSE, FALSE);
    $path1 = 'c:\\'.$filename.'.pdf';
    $pdf->Output($path1,'F');
    send_file($path1);
}



