<!DOCTYPE html>
<?php
include 'dbaccess.php';
include 'table.php';
include 'misc.php';
?>

<!DOCTYPE html>
<html>
<head>
</head>
    <body>
    <?php
    $self = htmlspecialchars($_SERVER["PHP_SELF"]);
    $link = connect();
    extract($_REQUEST);
    echo "<form action='$self' method='post'><table border = '1'>";
    echo "<tr><td>Datum</td><td>Rechnungsnummer</td></tr>";
    echo "</table></form>"; 
    ?>
    </body>
</html>



