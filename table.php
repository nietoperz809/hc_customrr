<?php

function table($input_array, $id)
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
    if ($input_array != NULL)
        extract($input_array);
    echo "<table border='1'>"
    . "<tbody><tr>"
    . "<td>Anrede</td><td><input type='text' name='anrede' value='$anrede'></td>"
    . "<td>Kundennummer</td><td><input type='text' name='id2' value='$id' readonly></td>"
    . "</tr><tr>"
    . "<td>Name</td><td><input type='text' name='name' value='$name'></td>"
    . "<td>Vorname</td><td><input type='text' name='vname' value='$vname'></td>"
    . "</tr><tr>"
    . "<td>TelNr</td><td><input type='text' name='telnr' value='$telnr'></td>"
    . "<td>Email</td><td><input type='text' name='email' value='$email'></td>"
    . "</tr><tr>"
    . "<td>Straße</td><td><input type='text' name='street' value='$street'></td>"
    . "<td>Hausnummer</td><td><input type='text' name='hausnr' value='$hausnr'></td>"
    . "</tr><tr>"
    . "<td>Ort</td><td><input type='text' name='ort' value='$ort'></td>"
    . "<td>PLZ</td><td><input type='text' name='plz' value='$plz'></td>"
    . "</tr><tr>"
    . "<td>Bemerkung</td><td colspan='3'><input type='text' size='65' name='remarks' value='$remarks'></td>"
    . "</tr></tbody></table>";
}
