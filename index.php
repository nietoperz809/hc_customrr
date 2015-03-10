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
        buttonbar();
        if (isset($_REQUEST['seek']))
        {
            $seektxt = $_REQUEST['bbt_seek'];
            $link = connect();
            $result = seek_customer($link, $seektxt);
            result_table ($result);
            die();
        }
        $id = "?";
        $tbsource = &$_REQUEST;
        if (isset($_REQUEST['bbsub']))
        {
            $bbsub = $_REQUEST['bbsub'];
            $link = connect();
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
                    echo "Changed record: ".$id;
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
        table($tbsource, $id);
        echo "</form>";
        ?>
    </body>
</html>
