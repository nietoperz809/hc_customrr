<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
include 'dbaccess.php';
include 'table.php';
include 'misc.php';
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
        //create_pdf();
        $self = htmlspecialchars($_SERVER["PHP_SELF"]);
        echo "<form action='$self' method='post'>";
        $id = "?";
        $tbsource = &$_REQUEST;
        $link = connect();
        // Write invoice
        if (isset($_REQUEST['rech']))
        {
            $id = $_REQUEST['id2'];
            header ("Location: invoice.php?id=$id");
            exit;
        }
        // show dataset from search table
        else if (isset($_REQUEST['idbutton']))
        {
            $id = $_REQUEST['idbutton'];
            $arr = get_customer_by_id($link, $id);
            $tbsource = &$arr;
        }
        // Seek button clicked
        else if (isset($_REQUEST['suchen']))
        {
            $seektxt = $_REQUEST['bbt_seek'];
            if (strlen($seektxt) < 3)
            {
                echo "<h1>Suchtext muss mindestens 3 Buchstaben haben<h1>";
                echo "<input type='submit' name='zurück' value='zurück'>";
            }
            else 
            {
                $result = seek_customer($link, $seektxt);
                result_table ($result);
            }
            die ("</form></body></html>");
        }
        // Button in buttonbar clicked
        else if (isset($_REQUEST['bbsub']))
        {
            $bbsub = $_REQUEST['bbsub'];
            // new button clicked
            if ($bbsub == "neu")
            {
                $id = new_dataset($link, $_REQUEST);
            } 
            // update button clicked
            else if ($bbsub == "ändern")
            {
                if (isset($_REQUEST['id2']))
                {
                    $id = $_REQUEST['id2'];
                    update_dataset($link, $id, $_REQUEST);
                    echo "Record $id changed";
                }
            }
            // reset-form button clicked
            else if ($bbsub == "reset")
            {
                $tbsource = null;
            }
            // delete button clicked
            else if ($bbsub == "löschen")
            {
                $id = $_REQUEST['id2'];
                disable_dataset($link, $id);
                $tbsource = null;
            }
            // show-customer button clicked
            else if ($bbsub == "kunde")
            {
                if (isset($_REQUEST['bbt_show']))
                {
                    $id = $_REQUEST['bbt_show'];
                    $arr = get_customer_by_id($link, $id);
                    if ($arr == NULL)
                        $id = "deleted";
                    $tbsource = &$arr;
                }
            }
        }
        echo "<hr>";     
        main_table($tbsource, $id);
        echo "<hr>";     
        main_buttonbar();
        echo "</form>";
        ?>
    </body>
</html>
