<?php
include 'dbaccess.php';
include 'table.php';
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
        invoice_form();
        echo "</form";
        ?>
    </body>
</html>
    

