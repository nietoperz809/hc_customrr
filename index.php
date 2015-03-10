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
        if (isset($_REQUEST['bbsub']))
        {
            $bbsub = $_REQUEST['bbsub'];
            if ($bbsub == "new")
            {
                $link = connect();
                $id = new_dataset ($link, $_REQUEST);
            }
        }
        table($_REQUEST, $id);
        echo "</form>";
        ?>
    </body>
</html>
