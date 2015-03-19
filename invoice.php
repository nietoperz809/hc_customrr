<?php
include 'misc.php';
include 'dbaccess.php';
include 'table.php';
include 'pdf_template.php';
?>

<html>
    <head>
        <style>
            body {text-align:center;}
        input.default {
            width: 0px;
            height: 0px;
            margin: 0px;
            padding: 0px;
            outline: none;
            border: 0px;
            }        
        </style>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $self = htmlspecialchars($_SERVER["PHP_SELF"]);
        $link = connect();  // open DB
        $stueck = array();
        $bez = array();
        $einzel = array();
        $linepos = array();
        extract($_REQUEST);
        if (!isset ($rnum))
        {
            $rnum = FALSE;
        }
        if (isset ($o_rnum)) // Edit existing invoice
        {
            $rnum = urldecode($o_rnum);
            $id = get_invoice_id_by_code ($link, $rnum);
            if ($id == -1)
                die ("Rechnungsnummer existiert nicht");
            $inv = get_invoice_by_id ($link, $id);
            $_REQUEST['zahlungsart'] = ($inv['payment'] == 0 ? 'bar' : 'überweisung');
            $_REQUEST['typ'] = ($inv['typ'] == 0 ? 'alt' : 'neu');
            $all = read_invoice_lines_as_array ($link, $id);
            if ($all != NULL)
            {
                $stueck = $all[0];
                $bez = $all[2];
                $einzel = $all[1];
                $linepos = $all[3];
            }
        }
        $customer = get_customer_by_id ($link, $id);
        if ($customer == NULL)
        {
            echo ("Datenssatz ungültig");
            goto page_end;
        }
        echo "<form action='$self' method='post'>";
        echo "\n<input type='hidden' name ='id' value='$id'>"; // keep id alive
        echo "\n<input type='hidden' name ='rnum' value='$rnum'></br>"; // keep id alive
        invoice_form_header($_REQUEST);
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
            if ($rnum != FALSE) // delete former invoice
            {
                $id = get_invoice_id_by_code ($link, $rnum);
                delete_invoice ($link, $id);
            }
            $pay = ($zahlungsart == 'bar' ? 0 : 1);
            $typ2 = ($typ == 'alt' ? 0 : 1);
            $inv_per_year = invoices_per_year ($link, date('Y'));
            $invoice_id = new_invoice ($link, $id, $typ2, $pay, $inv_per_year, $filiale);
            write_invoice_lines ($link, $invoice_id, $stueck, $einzel, $bez, $linepos);
            
            // generate PDF
            $arr1 = get_invoice_by_id ($link, $invoice_id);  // invoice
            $arr2 = get_customer_by_id ($link, $arr1['cust_id']); // customer
            $inv_lines = read_invoice_lines ($link, $invoice_id); // invoice lines
            create_pdf($arr1, $arr2, $inv_lines);
            
            header ("Location: index.php");
            exit;
        }
        else if (isset ($break))  // Abbruch
        {
            header ("Location: index.php");
            exit;
        }
        invoice_table ($stueck, $bez, $einzel, $newline);
        echo "<hr>";
        invoice_buttons();
        echo "</form>";
        page_end:
        ?>
    </body>
</html>
    

