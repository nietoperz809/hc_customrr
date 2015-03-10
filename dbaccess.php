<?php

function err ($txt)
{
    $t2 = "<font size='3' color='red'>".$txt."</font>: ".mysql_error();
    die ($t2);
}

function connect() 
{
    $link = mysql_connect('localhost:3306', 'root', '');
    if (!$link) 
    {
        err("Can't connect to mySQL: ");
    }
    $sel = mysql_select_db('hc_customer_db');
    if ($sel == FALSE)
    {
        err ("Can't open DB");
    }
    return $link;
}

function query ($in)
{
    $res = mysql_query($in);
    if ($res == FALSE)
    {
        err ("SQL query failed");
    }
    return $res;
}

function new_dataset ($input_array)
{
    $anrede = "";
    $name = "";
    $vname = "";
    $telnr = "";
    $email = "";
    $street = "";
    $hausnr = "";
    $ort = "";
    $plz = "";
    $remarks = "";
    extract($input_array);
    $q = "insert into customer (name, vname, telnr, email, street, ort, hausnr, plz, remarks, anrede) "
         ."values ('$name', '$vname', '$telnr', '$email', '$street', '$ort', '$hausnr', '$plz', '$remarks', '$anrede')";   
    connect();
    query ($q);
}