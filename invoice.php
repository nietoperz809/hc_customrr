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
        $rows = 1;
        if (isset($stueck))
        {
           $rows = count($stueck) + 1;
        }
        invoice_table($rows);
        echo "<p><input type='submit' name='rech_ok' value='fertig'>";
        echo "</form>";
        page_end:
        ?>
    </body>
</html>
    

