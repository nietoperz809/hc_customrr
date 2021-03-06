<?php

function main_table($input_array, $id)
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
    echo "<div align='center'><table border='1'>"
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
    . "</tr></tbody></table></div>";
}

/**
 * Fills customer result table from SQL query result
 * @param type $result
 */
function seek_result_table ($result)
{
    echo "<div align='center'><table border = '1'>";
    while($row = $result->fetch_assoc())
    {
        extract($row);
        echo "<tr>";
        echo "<td>Kunde:&nbsp;<input type='submit' name='idbutton' value='$id' "
                . "title='Zeige Datensatz für Kundennummer #$id'></td>"
                . "<td>$anrede</td><td>$vname</td><td>$name</td>"
                . "<td>$telnr</td><td>$email</td><td>$plz</td><td>$ort</td>"
                . "<td>$street</td><td>$hausnr</td><td>$remarks</td>"
                . "<td>Rechnungen:&nbsp;<input type='submit' name='rechbutton' value='$id' "
                . "title='Zeige Rechnungen für Kundennummer #$id'></td>";
        echo "</tr>";
    }
    echo "</table></div>";
}

function main_buttonbar()
{
    echo "<input type='submit' name='bbsub' value='neu' "
    . "title ='Hier klicken um einen neuen Datensatz aufzunehmen'"
    . "onclick='return confirm(\"Diese Tabelle wirklich als neuen Datensatz anlegen?\")'>";
    echo "<input type='submit' name='bbsub' value='ändern' "
    . "title ='Klick auf diesen Button um den geänderten Datensatz zu speichern'"
    . "onclick='return confirm(\"Diesen Datensatz wirklich verändern?\")'>";
    echo "<input type='submit' name='bbsub' value='löschen' "
    . "title ='Hier klicken um den Datensatz zu löschen'"
    . "onclick='return confirm(\"Diesen Datensatz wirklich löschen?\")'>";
    echo "<input type='submit' name='bbsub' value='reset' "
    . "title ='Leert die Tabelle auf dem Bildschirm'>";
    echo "<br/><input type='submit' name='bbsub' value='kunde' "
    . "title ='Rechts die Kundennummer eingeben und hier klicken um entsprechenden Datensatz zu zeigen'>";
    echo "<input type='text' name='bbt_seek'>";
    echo "<input type='submit' name='suchen' value='suchen' "
    . "title ='Links Suchbegriff eingeben und hier klicken um nach einem Kunden zu suchen'>";
    echo "<hr/>";
    echo "<input type='submit' name='rech' value='rechnung erstellen'>";
    echo "<br/><input type='submit' name='old_rechbutt' value='rechnung bearbeiten'>";
}

/**
 * Make radio buttons for invoice form
 * @param type $arr $_RESPONSE
 */
function invoice_form_header ($arr)
{   
    define("CHECK", "checked = 'checked'");
    define("CLEAR", "");
    $c1 = CHECK;
    $c2 = CLEAR;
    $c3 = CHECK;
    $c4 = CLEAR;
    if (isset($arr['zahlungsart']) && $arr['zahlungsart'] != 'bar')
    {
        $c1 = CLEAR;
        $c2 = CHECK;
    }
    if (isset($arr['typ']) && $arr['typ'] != 'neu')
    {
        $c3 = CLEAR;
        $c4 = CHECK;
    }
    $fil = 'A';
    if (isset ($arr['filiale']))
    {
        $fil = $arr['filiale'];
    }
    echo "<Input type = 'Radio' Name ='zahlungsart' value= 'bar' $c1>Bar";
    echo "<Input type = 'Radio' Name ='zahlungsart' value= 'überweisung' $c2>Überweisung";
    echo "<Input type = 'Radio' Name ='typ' value= 'neu' $c3>Neu/Dienstleistung";
    echo "<Input type = 'Radio' Name ='typ' value= 'alt' $c4>Gebraucht";
    echo "</br>Filiale: <Input type = 'text' Name ='filiale' value= '$fil'>";
}

/**
 * 
 * @param type $a
 * @param type $b
 * @param type $c
 * @param $pos row order
 */
function invoice_row ($a, $b, $c, $pos)
{
    echo "\n<tr>"
    . "<td> <input type='hidden' name='linepos[]' value='$pos'>"
    . "<input type='text' size='6' name='stueck[]' value='$a'></td>"
    . "<td><input type='text' size='60' name='bez[]' value='$b'></td>"
    . "<td><input type='text' name='einzel[]' value='$c'></td>"
    . "</tr>";
}

/**
 * 
 * @param type $stueck array of items per entry
 * @param type $bez text describing the item
 * @param type $einzel price of single item
 * @param type $gesamt sum of prices for all items
 * @param type $newline 1 == generate new row
 *                      0 == no action
 *                     -1 == delete last row
 */
function invoice_table ($stueck, $bez, $einzel, $newline=1)
{
    echo "<p><table align='center'>";
    echo "<tr><th>Stück</th><th>Bezeichnung</th><th>Einzelpreis</th></tr>";
    $count = count ($stueck);
    if ($count > 0 && $newline == -1)
    {
        $count--;
    }
    for ($n=0; $n<$count; $n++)
    {
        $fixed = str_replace(",", ".", $einzel[$n]); // replace comma with colon
        invoice_row($stueck[$n], $bez[$n], $einzel[$n], $n);
    }
    if ($newline == 1)
    {
        invoice_row('', '', '', $n); // Insert empty row
    }
    echo "</table></p>";
}

/**
 * makes invoice form uttons
 * fist button is ivisible to catch 'enter-key' event
 */
function invoice_buttons()
{
    echo "<input type='submit' name='noaction' class = 'default 'value='noaction'>" 
    . "<input type='submit' name='rech_ok' value='fertig'>"
    . "<input type='submit' name='next' value='nächste position'>"
    . "<input type='submit' name='kill' value='letzte position löschen'>"
    . "<input type='submit' name='break' value='abbruch'>";
}