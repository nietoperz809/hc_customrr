<?php

function math_eval ($s)
{
    $ma = eval('return '.$s.';');
    return $ma;
}

