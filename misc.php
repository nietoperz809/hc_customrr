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

