<?php

function buttonbar()
{
    echo "<input type='submit' name='bbsub' value='new' "
    . "title ='Hier klicken um einen neuen Datensatz aufzunehmen'"
    . "onclick='return confirm(\"Diese Tabelle wirklich als neuen Datensatz anlegen?\")'>";
    echo "<input type='submit' name='bbsub' value='update' "
    . "title ='Klick auf diesen Button um den geänderten Datensatz zu speichern'"
    . "onclick='return confirm(\"Diesen Datensatz wirklich verändern?\")'>";
    echo "<input type='submit' name='bbsub' value='delete' "
    . "title ='Hier klicken um den Datensatz zu löschen'"
    . "onclick='return confirm(\"Diesen Datensatz wirklich löschen?\")'>";
    echo "<input type='submit' name='bbsub' value='clear' "
    . "title ='Leert die Tabelle auf dem Bildschirm'>";
    echo "<br/><input type='submit' name='bbsub' value='show' "
    . "title ='Rechts die Kundennummer eingeben und hier klicken um entsprechenden Datensatz zu zeigen'>";
    echo "<input type='text' name='bbt_show' size='8'>";
    echo "<br/><br/><input type='submit' name='seek' value='seek' "
    . "title ='Rechts Suchbegriff eingeben und hier klicken um nach einem Kunden zu suchen'>";
    echo "<input type='text' name='bbt_seek'>";
    echo "<hr>";     
}
