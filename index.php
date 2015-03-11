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
        $self = htmlspecialchars($_SERVER["PHP_SELF"]);
        echo "<form action='$self' method='post'>";
        $id = "?";
        $tbsource = &$_REQUEST;
        $link = connect();
        // show dataset from search table
        if (isset($_REQUEST['bbutt']))
        {
            $id = $_REQUEST['bbutt'];
            $arr = load_single_dataset($link, $id);
            $tbsource = &$arr;
        }
        // Seek button clicked
        else if (isset($_REQUEST['seek']))
        {
            $seektxt = $_REQUEST['bbt_seek'];
            $result = seek_customer($link, $seektxt);
            result_table ($result);
            die ("</form></body></html>");
        }
        // Button in buttonbar clicked
        else if (isset($_REQUEST['bbsub']))
        {
            $bbsub = $_REQUEST['bbsub'];
            if ($bbsub == "new")
            {
                $id = new_dataset($link, $_REQUEST);
            } 
            else if ($bbsub == "update")
            {
                if (isset($_REQUEST['id2']))
                {
                    $id = $_REQUEST['id2'];
                    update_dataset($link, $id, $_REQUEST);
                    echo "Record $id changed";
                }
            } 
            else if ($bbsub == "clear")
            {
                $tbsource = null;
            } 
            else if ($bbsub == "delete")
            {
                $id = $_REQUEST['id2'];
                disable_dataset($link, $id);
                $tbsource = null;
            } 
            else if ($bbsub == "show")
            {
                if (isset($_REQUEST['bbt_show']))
                {
                    $id = $_REQUEST['bbt_show'];
                    $arr = load_single_dataset($link, $id);
                    if ($arr == NULL)
                        $id = "deleted";
                    $tbsource = &$arr;
                }
            }
        }
        echo "<hr>";     
        main_table($tbsource, $id);
        echo "<hr>";     
        buttonbar();
        echo "</form>";
        ?>
    </body>
</html>
