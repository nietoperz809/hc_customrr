<?php

function err ($txt)
{
    $t2 = "<font size='3' color='red'>".$txt."</font>: ".mysql_error();
    die ($t2);
}

function connect() 
{
    $link = mysqli_connect('localhost', 'root', '', 'hc_customer_db');
    if (mysqli_connect_errno()) 
    {
        err("Can't connect to mySQL: ");
    }
    return $link;
}

function query ($link, $in)
{
    $res = mysqli_query($link, $in);
    if ($res == FALSE)
    {
        err ("SQL query failed");
    }
    return $res;
}

function new_dataset ($link, $input_array)
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
    query ($link, $q);
    return mysqli_insert_id($link);
}