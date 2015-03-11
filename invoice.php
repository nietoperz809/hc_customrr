<?php
include 'dbaccess.php';
include 'table.php';
?>

<html>
    <head>
        <style>
            body {text-align:center;}
        </style>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $self = htmlspecialchars($_SERVER["PHP_SELF"]);
        $link = connect();
        $stueck = array();
        $bez = array();
        $einzel = array();
        $gesamt = array();
        extract($_REQUEST);
        $dataset = load_single_dataset ($link, $id);
        if ($dataset == NULL)
        {
            echo ("Datenssatz ungültig");
            goto page_end;
        }
        echo "<form action='$self' method='post'>";
        echo "<input type='hidden' name ='id' value='$id'>"; // keep id alive
        invoice_radiobuttons($_REQUEST);
        $newline = 1;
        if (isset($rech))
        {
            $newline = 0;
        }
        else if (isset($kill))
        {
            $newline = -1;
        }
        invoice_table($stueck, $bez, $einzel, $gesamt, $newline);
        echo "<hr>"
        . "<input type='submit' name='rech_ok' value='fertig'>"
        . "<input type='submit' name='rech' value='rechnen'>"
        . "<input type='submit' name='next' value='nächste position'>"
        . "<input type='submit' name='kill' value='letzte position löschen'>";
        echo "</form>";
        page_end:
        ?>
    </body>
</html>
    

