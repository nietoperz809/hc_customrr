<?php

function buttonbar()
{
    $self = htmlspecialchars($_SERVER['PHP_SELF']);
    echo "<form action='$self' method='post'>";
    echo "<input type='submit' name='new' value='new'>";
    echo "<input type='submit' name='seek' value='seek-->'>";
    echo "<input type='text' name='seektext'>";
    echo "</form><hr>";     
}
