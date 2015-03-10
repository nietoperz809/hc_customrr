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
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $self = htmlspecialchars($_SERVER["PHP_SELF"]);
        echo "<form action='$self' method='post'>";
        buttonbar();
        $id = "?";
        $tbsource = &$_REQUEST;
        if (isset($_REQUEST['bbsub']))
        {
            $bbsub = $_REQUEST['bbsub'];
            $link = connect();
            if ($bbsub == "new")
            {
                $id = new_dataset ($link, $_REQUEST);
            }
            else if ($bbsub == "clear")
            {
                $tbsource = null;
            }
            else if ($bbsub == "hide")
            {
                if (isset($_REQUEST['bbt_show']))
                {
                    $id = $_REQUEST['bbt_hide'];
                    disable_dataset($link, $id);
                }
            }
            else if ($bbsub == "show")
            {
                if (isset($_REQUEST['bbt_show']))
                {
                    $id = $_REQUEST['bbt_show'];
                    $arr = load_single_dataset ($link, $id);
                    $tbsource = &$arr;
                }
            }
        }
        table($tbsource, $id);
        echo "</form>";
        ?>
    </body>
</html>
