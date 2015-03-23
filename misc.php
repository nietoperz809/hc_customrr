<?php

/**
 * Evaluate an expression given as string
 * @param String $s
 * @return type result as number
 */
function math_eval($s) 
{
    $ma = eval('return ' . $s . ';');
    return $ma;
}

function format_price ($n)
{
    $m = number_format($n/100, 2, ',','.');
    return str_pad ($m, 8, ' ',STR_PAD_LEFT).' €';
}

function null_to_empty ($n)
{
    if ($n == 0)
        return '';
    return $n;
}

/**
 * Helper func: prints variable and exits
 * @param type $x
 */
function dbg ($x)
{
    print_r ($x);
    exit;
}

function send_file($zfilename)
{
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename=' . basename($zfilename));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($zfilename));
    ob_clean();
    flush();
    $img_data = file_get_contents($zfilename);
    echo $img_data;
}
