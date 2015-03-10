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
    mysqli_query ($link, $q);
    return mysqli_insert_id($link);
}

function load_single_dataset ($link, $id)
{
    $q = "select * from customer where id ='$id' and enabled ='1'";
    $result = mysqli_query($link, $q, MYSQLI_USE_RESULT);
    print_r ($result);
    return mysqli_fetch_array($result);
}

function disable_dataset ($link, $id)
{
    $q = "update customer set enabled = '0' where id ='$id'";
    mysqli_query($link, $q);
}
