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
    if (isset($rcode))
    {
        header ("Location: invoice.php?o_rnum=$rcode");
        exit;
    }
    else if (isset($end))
    {
        header ("Location: index.php");
    }
    $result = get_invoice_by_customer ($link, $id);
    echo "<form action='$self' method='post'><div align = 'center'><table border = '1'>";
    echo "<tr><td>Datum</td><td>Rechnungsnummer</td></tr>";
    while ($arr = mysqli_fetch_assoc($result))
    {
        $date = $arr['date'];
        $code = $arr['code'];
        echo "<tr><td>$date</td><td><input type='submit' name='rcode' value='$code'></td></tr>";
    }
    echo "</table></div>"
    . "<br/><input type='submit' name='end' value='abbruch'></form>"; 
    ?>
    </body>
</html>



