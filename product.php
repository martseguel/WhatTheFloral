<?php
require_once "config.php";

session_start();

function requestStock($requestingId, $link)
{
    $sql = "SELECT stock FROM products WHERE id = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = $requestingId;
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt, $stock);
            if (mysqli_stmt_fetch($stmt)) {
                $thisStock = $stock;
                return $thisStock;
            }
        }
    }
}

function requestPrice($requestingId, $link)
{
    $sql = "SELECT precio FROM products WHERE id = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = $requestingId;
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt, $precio);
            if (mysqli_stmt_fetch($stmt)) {
                $thisPrecio = $precio;
                return $thisPrecio;
            }
        }
    }
}

function requestCat($requestingId, $link)
{
    $sql = "SELECT Categoria FROM products WHERE id = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = $requestingId;
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt, $cat);
            if (mysqli_stmt_fetch($stmt)) {
                $thisCat = $cat;
                return $thisCat;
            }
        }
    }
}

function requestName($requestingId, $link)
{
    $sql = "SELECT name FROM products WHERE id = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = $requestingId;
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt, $name);
            if (mysqli_stmt_fetch($stmt)) {
                $thisName = $name;
                return $thisName;
            }
        }
    }
}

function requestDescription($requestingId, $link)
{
    $sql = "SELECT description FROM products WHERE id = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = $requestingId;
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt, $name);
            if (mysqli_stmt_fetch($stmt)) {
                $thisName = $name;
                return $thisName;
            }
        }
    }
}

function getFileName($link, $product_id)
{
    $sql = "SELECT filename FROM images WHERE product_id = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = $product_id;
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt, $filename);
            if (mysqli_stmt_fetch($stmt)) {
                $thisfileName = $filename;
                return $thisfileName;
            }
        }
    }
}


function getImages($link, $id)
{
    $sql = "SELECT filename FROM images WHERE product_id = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = $id;
        if (mysqli_stmt_execute($stmt)) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $actImg = "images/" . $row['filename'];
                if (file_exists($actImg)) {
                    echo '<img src="images/' . $row['filename'] . '" width="300" height="400">';
                } else {
                    echo '<img src="images/prdErr.jpg" >';
                }
            }
        }
    }
}

function getProduct($link, $id_req)
{
    $sql = "SELECT * FROM products WHERE id = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = $id_req;
        if (mysqli_stmt_execute($stmt)) {
            $mysqli_result = $stmt->get_result();
            foreach ($mysqli_result as $row) {
                echo '
							<div class="product-description" data-name="' . requestName($row["id"], $link) . '" data-price="' . requestPrice($row["id"], $link) . '">
					
								';
                if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                    echo '
											<form class="add-to-cart" action="cart.php" method="post">
												<div>
													<input type="hidden" name="qty-2" id="qty-2" class="qty" value="1" />
												</div>
												<p><input type="submit" value="Agregar" class="btnn" /></p>
										';
                } else {
                    echo '
											<form class="add-to-cart-notLogged" action="" method="post">
												<div>
													<label for="qty-2">Cantidad</label>
													<input type="number" name="qty-2" id="qty-2" class="qty" value="1" min="1" max="' . requestStock($row["id"], $link) . '" />
												</div>
												<p><input type="submit" value="Agregar" class="btnn" /></p>
										';
                }
                echo '</form>		
							</div>
						</div>
					</div>';
            }
        }
    }
}



?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Producto</title>
    <link rel="stylesheet" href="product.css" media="screen" type="text/css" />

	<meta name="viewpoint" content="width=device-width,initial-scal=1.0">
	<meta http-equip="X-UA-compatible" content="ie=edge">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<script type="text/javascript" src="jquery.store.js"></script>
	<script type="text/javascript" src="main.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
</head>

<body>
    <div class="wrapper">
    <div id="site">
        <main class="container">

            <!-- Left Column / Headphones Image -->
            <div class="left-column">
                <?php getImages($link, $_GET["productId"]) ?>
            </div>


            <!-- Right Column -->
            <div class="right-column">

                <!-- Product Description -->
                <div class="product-description">
                    <span><?php echo requestCat($_GET["productId"], $link) ?></span>
                    <a href="index.php" style="float: right;">X</a>
                    <h1><?php echo requestName($_GET["productId"], $link) ?></h1>
                    <p><?php echo requestDescription($_GET["productId"], $link) ?></p>
                </div>

                <!-- Product Pricing -->
                <div class="product-price">
                    <span>&dollar;<?php echo requestPrice($_GET["productId"], $link) ?></span>

                    <?php getProduct($link, $_GET["productId"]); ?>



                </div>
            </div>
        </main>


    </div>
</body>

</html>