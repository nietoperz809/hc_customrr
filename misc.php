<?php

function math_eval($s) 
{
    $ma = eval('return ' . $s . ';');
    return $ma;
}

include ('fpdf.php'); 
function testpdf() 
{
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(40, 10, 'Hello World!');
    $pdf->Output();
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
