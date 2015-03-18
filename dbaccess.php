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

function get_customer_by_id ($link, $id)
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
 * Creates new invoice entry in DB
 * @param type $link database link
 * @param type $cust_id customer id (foreign key)
 * @param type $typ 0 == alt, 1 == neu
 * @param type $payment 0 == bar, 1 == überweisung 
 * @return type
 */
function new_invoice ($link, $cust_id, $typ, $payment, $inv_per_year, $filiale)
{
    $code = date('Y')
            . ($payment == TRUE ? 'U' : 'B')
            . $filiale
            . date ("m")
            . $inv_per_year;
    $q = "insert into invoice (cust_id, typ, payment, code) values ('$cust_id', '$typ', '$payment', '$code')";
    mysqli_query ($link, $q);
    $id = mysqli_insert_id($link);
    return $id;
}

/**
 * Get number of invoices per year that are stored in DB 
 * @param type $link DB link
 * @param int $year Year to search for
 * @return int
 */
function invoices_per_year ($link, $year)
{
    $q = "SELECT COUNT(*) FROM `invoice` WHERE YEAR(date) = $year";
    $result = mysqli_query($link, $q, MYSQLI_USE_RESULT);
    $arr = mysqli_fetch_array($result);
    if ($arr == NULL)
        return 0;
    return $arr[0];
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
        $q = "insert into invoice_line (invoice_id, items, price, text, linepos) "
             . "values ('$inv_id', '$numitems[$n]', '$p', '$text[$n]', '$linepos[$n]')";
        mysqli_query ($link, $q);
    }
}

/**
 * 
 * @param type $link DB link
 * @param int $inv_id invoice ID
 * @return type SQL query resultset
 */
function read_invoice_lines ($link, $inv_id)
{
    $q = "SELECT * FROM invoice_line WHERE invoice_id = '$inv_id' order by linepos";
    $result = mysqli_query($link, $q, MYSQLI_USE_RESULT);
    return $result;
}

/**
 * Reads invoice main record into array
 * @param type $link DB link
 * @param type $id id of record
 * @return type Array containing search result
 */
function get_invoice_by_id ($link, $id)
{
    $q = "SELECT * FROM invoice WHERE id = '$id'";
    $result = mysqli_query($link, $q, MYSQLI_USE_RESULT);
    $arr = mysqli_fetch_array($result);
    return $arr;
}

/**
 * Deletes invoice and all of its lines
 * @param type $link DB link
 * @param string $code
 * @return type null
 */
function delete_invoice ($link, $code)
{
    $q = "SELECT id FROM `invoice` WHERE code = '$code'";
    $result = mysqli_query($link, $q, MYSQLI_USE_RESULT);
    $arr = mysqli_fetch_array($result);
 print_r ($arr);
    if ($arr == NULL)
        return;
    $id = $arr['id'];
    mysqli_free_result($result); // NECESSARY!! otherwise out of sync   
    $q = "delete from invoice where id = '$id'";
 echo "</br>".$q;
    $ret = mysqli_query ($link, $q);
echo "</br>".$ret;
echo "</br>".mysqli_error($link);
    $q = "delete from invoice_line where invoice_id = '$id'";
echo "</br>".$ret;
echo "</br>".mysqli_error($link);
    mysqli_query ($link, $q);
}
