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
