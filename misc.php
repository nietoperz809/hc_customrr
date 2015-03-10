<?php

function buttonbar()
{
    echo "<input type='submit' name='bbsub' value='new' onclick='return confirm(\"Really wish to insert table as a new record?\")'>";
    echo "<input type='submit' name='bbsub' value='update' onclick='return confirm(\"Really wish to change this record?\")'>";
    echo "<input type='submit' name='bbsub' value='delete' onclick='return confirm(\"Really wish to delete this record?\")'>";
    echo "<input type='submit' name='bbsub' value='clear'>";
    echo "</br><input type='submit' name='bbsub' value='show'>";
    echo "<input type='text' name='bbt_show' size='8'>";
    echo "</br></br><input type='submit' name='bbsub' value='seek'>";
    echo "<input type='text' name='bbt_seek'>";
    echo "<hr>";     
}
