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
    $result = get_invoice_by_customer ($link, $id);
    echo "<form action='$self' method='post'><table border = '1'>";
    echo "<tr><td>Datum</td><td>Rechnungsnummer</td></tr>";
echo "--->". mysqli_error($link);
    while ($arr = mysqli_fetch_assoc($result))
    {
        $date = $arr['date'];
        $code = $arr['code'];
        echo "<tr><td>$date</td><td>$code</td></tr>";
    }
echo "--->".mysqli_error($link);
    echo "</table></form>"; 
    ?>
    </body>
</html>



