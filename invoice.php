<?php
include 'misc.php';
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
        $linepos = array();
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
        if (isset($rech)) // don't make empty row
        {
            $newline = 0;
        }
        else if (isset($kill)) // kill last row
        {
            $newline = -1;
        }
        else if (isset ($rech_ok))  // ready, store into DB
        {
            
            $pay = $zahlungsart == 'bar' ? 0 : 1;
            $typ2 = $typ == 'alt' ? 0 : 1;
            $invoice_id = new_invoice ($link, $id, $typ2, $pay);
            write_invoice_lines ($link, $invoice_id, $stueck, $einzel, $bez, $linepos);
            header ("Location: index.php");
            exit;
        }
        else if (isset ($break))
        {
            header ("Location: index.php");
            exit;
        }
        invoice_table ($stueck, $bez, $einzel, $gesamt, $newline);
        echo "<hr>";
        invoice_buttons();
        echo "</form>";
        page_end:
        ?>
    </body>
</html>
    

