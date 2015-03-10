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

function result_table ($result)
{
    echo "<table border = '1'>";
    while($row = $result->fetch_assoc())
    {
        extract($row);
        echo "<tr>";
        echo "<td><input type='submit' name='bbutt' value='$id'></td><td>$anrede</td><td>$vname</td><td>$name</td>"
                . "<td>$telnr</td><td>$email</td><td>$plz</td><td>$ort</td>"
                . "<td>$street</td><td>$hausnr</td><td>$remarks</td>";
        echo "</tr>";
    }
    echo "</table>";
}

function disable_dataset ($link, $id)
{
    $q = "update customer set enabled = '0' where id ='$id'";
    mysqli_query($link, $q);
}
