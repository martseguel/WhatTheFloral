<?php
// Initialize the session
session_start();
// Include config file
require_once "config.php";

$lol2 = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "INSERT INTO orders (client_id, monto, order_status) VALUES (?, ?, ?)";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "iis", $param_clientID, $param_monto, $param_orderStatus);

        // Set parameters
        $param_clientID = $_POST["client"];
        $param_monto = $_POST["monto"];
        $param_orderStatus = $_POST["orderStatus"];

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    $cant = $_POST["cantProducts"];

    $productos = explode("#", $cant);
    foreach ($productos as $producto) {
        if ($producto != "") {
            $partes = explode("/", $producto);
            $sql = "SELECT id from products WHERE name = ?";
            if ($stmt = mysqli_prepare($link, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_name);
                $param_name = $partes[1];
                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);
                    mysqli_stmt_bind_result($stmt, $idd);
                    if (mysqli_stmt_fetch($stmt)) {
                        $actualProductId = $idd;
                    }
                }
            }

            $sql = "INSERT INTO orderDetails (order_id, product_id, unitPrice, cantidad) VALUES (?, ?, ?, ?)";
            if ($stmt = mysqli_prepare($link, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "iiii", $param_OrderId, $param_ProductId, $param_UnitPrice, $param_Cant);

                // Set parameters
                $param_OrderId = requestOrderId($link);
                $param_ProductId = $actualProductId;
                $param_UnitPrice = $partes[2];
                $param_Cant = $partes[3];

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
        }
    }
    $lol = true;
}

function requestValue($link)
{
    $sql = "SELECT monto FROM orders ORDER BY order_id DESC LIMIT 1";
    if ($stmt = mysqli_prepare($link, $sql)) {
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt, $value);
            if (mysqli_stmt_fetch($stmt)) {
                $thisvalue = $value;
                echo $thisvalue;
            }
        }
    }
}

function requestOrderId($link)
{
    $sql = "SELECT order_id FROM orders ORDER BY order_id DESC LIMIT 1";
    if ($stmt = mysqli_prepare($link, $sql)) {
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt, $value);
            if (mysqli_stmt_fetch($stmt)) {
                $thisvalue = $value;
                return $thisvalue;
            }
        }
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Tu pedido</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="jquery.store.js"></script>
</head>

<body id="checkout-page">
    <div id="site">
        <div id="content">
            <form name='rec100720462_btn1' id="webpayForm" method='post' action='https://www.webpay.cl/portalpagodirecto/pages/datos.jsf'>
                <input type='hidden' name='idRecaudacion' value='100720462' />
                <input type='hidden' name='monto' id="monto" value='<?php requestValue($link) ?>' />
            </form>
            <?php
            while ($lol2) :
                if ($lol === true) {
                    echo "<script>document.getElementById('webpayForm').submit();</script>";
                    $lol2 = false;
                }
            endwhile;

            ?>

        </div>
    </div>
</body>

</html>