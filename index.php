<?php
include 'dbaccess.php';
include 'table.php';
include 'misc.php';
?>

<!DOCTYPE html>
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
        echo "<form action='$self' method='post'>";
        $id = "?";
        $tbsource = &$_REQUEST;
        $link = connect();
        if (isset($_REQUEST['rechbutton']))
        {
            $id = $_REQUEST['rechbutton'];
            header ("Location: rechlist.php?id=$id");
            exit;
        }
        // Create invoice
        else if (isset($_REQUEST['rech']))
        {
            $id = $_REQUEST['id2'];
            header ("Location: invoice.php?id=$id");
            exit;
        }
        // Edit invoice
        else if (isset($_REQUEST['old_rechbutt']))
        {
            $id = $_REQUEST['id2'];
            header ("Location: rechlist.php?id=$id");
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
                seek_result_table ($result);
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
                $id = new_customer_dataset($link, $_REQUEST);
            } 
            // update button clicked
            else if ($bbsub == "ändern")
            {
                if (isset($_REQUEST['id2']))
                {
                    $id = $_REQUEST['id2'];
                    update_customer_dataset($link, $id, $_REQUEST);
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
                disable_customer_dataset($link, $id);
                $tbsource = null;
            }
            // show-customer button clicked
            else if ($bbsub == "kunde")
            {
                if (isset($_REQUEST['bbt_seek']))
                {
                    $id = $_REQUEST['bbt_seek'];
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
