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
        buttonbar();
        $self = htmlspecialchars($_SERVER["PHP_SELF"]);
        echo "<form action='$self' method='post'>";
        table($_REQUEST);
        if (isset($_REQUEST['submit']))
            new_dataset ($_REQUEST);
        ?>
            <input type="submit" name="submit" value="Submit">
        </form>    
    </body>
</html>
