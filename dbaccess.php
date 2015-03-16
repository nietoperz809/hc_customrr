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
    $id = mysqli_insert_id($link);
    return $id;
}

function update_dataset ($link, $id, $input_array)
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
    $q = "update customer set name='$name', vname='$vname', telnr='$telnr', "
            . "email='$email', street='$street', ort='$ort', hausnr='$hausnr', "
            . "plz='$plz', remarks='$remarks', anrede='$anrede' where id='$id'"; 
    mysqli_query ($link, $q);
}

function load_single_dataset ($link, $id)
{
    $q = "select * from customer where id ='$id' and enabled ='1'";
    $result = mysqli_query($link, $q, MYSQLI_USE_RESULT);
    $arr = mysqli_fetch_array($result);
    return $arr;
}

function seek_customer ($link, $needle)
{
    $q = "select * from customer where"
            . " (name like '%$needle%'"
            . " or remarks like '%$needle%'"
            . " or vname like '%$needle%'"
            . " or telnr like '%$needle%'"
            . " or street like '%$needle%'"
            . " or hausnr like '%$needle%'"
            . " or plz like '%$needle%'"
            . " or ort like '%$needle%'"
            . " or anrede like '%$needle%')"
            . " and enabled = '1'";
    $result = mysqli_query($link, $q, MYSQLI_USE_RESULT);
    return $result;
}

function disable_dataset ($link, $id)
{
    $q = "update customer set enabled = '0' where id ='$id'";
    mysqli_query($link, $q);
}

/**
 * 
 * @param type $link database link
 * @param type $cust_id customer id (foreign key)
 * @param type $typ 0 == alt, 1 == neu
 * @param type $payment 0 == bar, 1 == überweisung 
 * @return type
 */
function new_invoice ($link, $cust_id, $typ, $payment)
{
    $q = "insert into invoice (cust_id, typ, payment) values ('$cust_id', '$typ', '$payment')";
    mysqli_query ($link, $q);
    $id = mysqli_insert_id($link);
    return $id;
}

/**
 * Stores all lines of invoice into DB
 * @param type $link database link
 * @param type $inv_id invoice id (foreign key)
 * @param type $numitems number of items (array)
 * @param type $price price of one item (array)
 * @param type $text description (array)
 * @param type $linepos position  (array)
 */
function write_invoice_lines ($link, $inv_id, $numitems, $price, $text, $linepos)
{
    $count = count ($numitems);
    for ($n=0; $n<$count; $n++)
    {
        $p = round ($price[$n]*100);
        $q = "insert into invoice_line (invoice_id, items, price, text, line_pos) "
             . "values ('$inv_id', '$numitems[$n]', '$p', '$text[$n]', '$linepos[$n]')";
        mysqli_query ($link, $q);
    }
}
