<?php
// Include config file
require_once "config.php";
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

function getFileName($link, $product_id)
{
	$sql = "SELECT filename FROM images WHERE product_id = ? LIMIT 1";
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

function getCantImages($link, $id)
{
	$sql = "SELECT filename FROM images WHERE product_id = ?";
	if ($stmt = mysqli_prepare($link, $sql)) {
		mysqli_stmt_bind_param($stmt, "i", $param_id);
		$param_id = $id;
		if (mysqli_stmt_execute($stmt)) {
			$result = $stmt->get_result();
			while ($row = $result->fetch_assoc()) {
				echo $row['name'];
			}
		}
	}
}

function getProducts($link)
{
	$sql = "SELECT * FROM products WHERE Active = 1 ORDER BY id ASC";
	if ($stmt = mysqli_prepare($link, $sql)) {
		if (mysqli_stmt_execute($stmt)) {
			$mysqli_result = $stmt->get_result();
			foreach ($mysqli_result as $row) {
				$filename = getFileName($link, $row["id"]);
				$actImg = "images/" . $filename;
				if (file_exists($actImg)) {
					$imgTag = '<img src="images/' . $filename . '" >';
				} else {
					$imgTag = '<img src="images/prdErr.jpg" >';
				}
				echo '<div class="col-md-3">
						<div class="product-top">
								<a href="product.php?productId='. urlencode($row["id"]) .'">' . $imgTag . '</a>
								<div class="overlay-right">
									<button type="button" class="btn btn-secondary" title="Ver">
										<i class="fa fa-eye"></i>
									</button>
						
									<button type="button" class="btn btn-secondary" title="Agregar a Fav">
										<i class="fa fa-heart-o"></i>
									</button>
						
									<button type="button" class="btn btn-secondary" title="Agregar a carrito">
										<i class="fa fa-shopping-cart"></i>
									</button>
								</div>
						</div>
				
				
						<div class="product-bottom text-center">
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star-half-o"></i>
							<h3>' . requestName($row["id"], $link) . '</h3>
							<div class="product-description" data-name="' . requestName($row["id"], $link) . '" data-price="' . requestPrice($row["id"], $link) . '">
					
								<p class="product-price">&dollar; ' . requestPrice($row["id"], $link) . '</p>
								';
				if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
					echo '
											<form class="add-to-cart" action="cart.php" method="post">
												<div>
													<label for="qty-2">Cantidad</label>
													<input type="number" name="qty-2" id="qty-2" class="qty" value="1" min="1" max="' . requestStock($row["id"], $link) . '" />
												</div>
												<p><input type="submit" value="Agregar" class="btn" /></p>
										';
				} else {
					echo '
											<form class="add-to-cart-notLogged" action="" method="post">
												<div>
													<label for="qty-2">Cantidad</label>
													<input type="number" name="qty-2" id="qty-2" class="qty" value="1" min="1" max="' . requestStock($row["id"], $link) . '" />
												</div>
												<p><input type="submit" value="Agregar" class="btn" /></p>
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
<html>

<head>
	<title>What The Floral</title>
	<meta charset="utf-8" />
	<meta name="viewpoint" content="width=device-width,initial-scal=1.0">
	<meta http-equip="X-UA-compatible" content="ie=edge">
	<link rel="stylesheet" href="style.css" media="screen" type="text/css" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<script type="text/javascript" src="jquery.store.js"></script>
	<script type="text/javascript" src="main.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

	<link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>

</head>

<body>

	<style>
		#page-loader {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			z-index: 1000;
			background: #FFF none repeat scroll 0% 0%;
			z-index: 99999;
		}

		#page-loader .preloader-interior {
			display: block;
			position: relative;
			left: 50%;
			top: 50%;
			width: 150px;
			height: 150px;
			margin: -75px 0 0 -75px;
			border-radius: 50%;
			border: 3px solid transparent;
			border-top-color: #3498db;

			-webkit-animation: spin 2s linear infinite;
			/* Chrome, Opera 15+, Safari 5+ */
			animation: spin 2s linear infinite;
			/* Chrome, Firefox 16+, IE 10+, Opera */
		}

		#page-loader .preloader-interior:before {
			content: "";
			position: absolute;
			top: 5px;
			left: 5px;
			right: 5px;
			bottom: 5px;
			border-radius: 50%;
			border: 3px solid transparent;
			border-top-color: #e74c3c;

			-webkit-animation: spin 3s linear infinite;
			/* Chrome, Opera 15+, Safari 5+ */
			animation: spin 3s linear infinite;
			/* Chrome, Firefox 16+, IE 10+, Opera */
		}

		#page-loader .preloader-interior:after {
			content: "";
			position: absolute;
			top: 15px;
			left: 15px;
			right: 15px;
			bottom: 15px;
			border-radius: 50%;
			border: 3px solid transparent;
			border-top-color: #f9c922;

			-webkit-animation: spin 1.5s linear infinite;
			/* Chrome, Opera 15+, Safari 5+ */
			animation: spin 1.5s linear infinite;
			/* Chrome, Firefox 16+, IE 10+, Opera */
		}

		@-webkit-keyframes spin {
			0% {
				-webkit-transform: rotate(0deg);
				/* Chrome, Opera 15+, Safari 3.1+ */
				-ms-transform: rotate(0deg);
				/* IE 9 */
				transform: rotate(0deg);
				/* Firefox 16+, IE 10+, Opera */
			}

			100% {
				-webkit-transform: rotate(360deg);
				/* Chrome, Opera 15+, Safari 3.1+ */
				-ms-transform: rotate(360deg);
				/* IE 9 */
				transform: rotate(360deg);
				/* Firefox 16+, IE 10+, Opera */
			}
		}

		@keyframes spin {
			0% {
				-webkit-transform: rotate(0deg);
				/* Chrome, Opera 15+, Safari 3.1+ */
				-ms-transform: rotate(0deg);
				/* IE 9 */
				transform: rotate(0deg);
				/* Firefox 16+, IE 10+, Opera */
			}

			100% {
				-webkit-transform: rotate(360deg);
				/* Chrome, Opera 15+, Safari 3.1+ */
				-ms-transform: rotate(360deg);
				/* IE 9 */
				transform: rotate(360deg);
				/* Firefox 16+, IE 10+, Opera */
			}
		}
	</style>

	<script>
		$(window).load(function() {
			$('#page-loader').fadeOut(500);
		});
	</script>

	<div id="page-loader">
		<span class="preloader-interior"></span>
	</div>

	<section id="nav-bar">
		<nav class="navbar navbar-expand-lg navbar-light">

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="topnav">
				<a style="color:black;" class="active-title">Envios a todo Chile</a>
			</div>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav ml-auto">
					<?php
					session_start();
					if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
						echo '<li class="nav-item"><a style="color:black; font-size: 20px;" class="nav-link" href="profile.php"> ' . $_SESSION["username"] . '</a></li>
					<li class="nav-item"><a style="color:black;" class="nav-link" href="cart.php">Carro</a></li>
					<li class="nav-item"><a style="color:black;" class="nav-link" href="logout.php">Cerrar sesion</a></li>
					
					';
					} else {
						echo '<li class="nav-item"><a style="color:black;" class="nav-link" href="login.php">Login</a></li>
						<li class="nav-item"> <a style="color:black;" class="nav-link" href="register.php">Register</a></li>';
					} ?>
				</ul>
			</div>
		</nav>

		<div class="img-logo">
			<a href="index.php">
				<img src="images/brand.png" class="img-logo">
			</a>
		</div>

		<div class="slider">
			<div id="carouselExampleInterval" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">
					<div class="carousel-item active" data-interval="10000">
						<img src="images/image1.jpg" class="d-block w-100" alt="..." style="width:auto;height:800px;">
					</div>
					<div class="carousel-item" data-interval="2000">
						<img src="images/image2.jpg" class="d-block w-100" alt="..." style="width:auto;height:800px;">
					</div>
					<div class="carousel-item">
						<img src="images/image3.jpg" class="d-block w-100" alt="..." style="width:auto;height:800px;">
					</div>
				</div>
				<a class="carousel-control-prev" href="#carouselExampleInterval" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="carousel-control-next" href="#carouselExampleInterval" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</div>


		<section class="on-sale">
			<div id="site">
				<div class="container">
					<div class="title-box">
						<h2>Productos</h2>
					</div>
					<div class="row">
						<?php
						getProducts($link);
						?>
					</div>
		</section>

		<!------About Section------->
		<section id="about">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<h2>Sobre nosotros</h2>
						<div class="about-content">
							aaaaa

						</div>
					</div>
				</div>

			</div>

			<!------Services Section------->
			<section id="services">

				<div class="container">
					<h1>Servicios</h1>
					<div class="row services">
						<div class="col-md-4 text-center">
							<div class="icon">
								<i class="fa fa-phone"></i>
							</div>
							<h3>Soporte 24/7</h3>
							<p>en preguntas sobre pedidos</p>
						</div>

						<div class="col-md-4 text-center">
							<div class="icon">
								<i class="fa fa-shopping-cart"></i>
							</div>
							<h3> Devoluciones</h3>
							<p>hasta 30 dias</p>
						</div>

						<div class="col-md-4 text-center">
							<div class="icon">
								<i class="fa fa-truck"></i>
							</div>
							<h3>Envio gratis</h3>
							<p>en pedidos de +50.000 clp</p>
						</div>
					</div>
				</div>

			</section>

			<!------COntact------------>
			<section id="contact">

				<div class="container">
					<h1>Contactanos</h1>
					<div class="row">
						<div class="col-md-6">
							<form class="contact-form">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Nombre..">
								</div>
								<div class="form-group">
									<input type="number" class="form-control" placeholder="N° Telefono.">
								</div>
								<div class="form-group">
									<input type="email" class="form-control" placeholder="Email..">
								</div>
								<div class="form-group">
									<textarea class="form-control" rows="4" placeholder="Mensaje.."></textarea>
								</div>

								<button type="submit" class="btn btn-primary">Enviar</button>
							</form>
						</div>
						<div class="col-md-6 contact-info">
							<div class="follow"><b><i class="fa fa-map-marker"></i> </b>Las condes, Santiago</div>
							<div class="follow"><b><i class="fa fa-mobile"></i> </b>(+56) 951970995</div>
							<div class="follow"><b><i class="fa fa-envelope"></i> </b>aaaa@gmail.com</div>


							<div class="follow"><label><b>Redes Sociales</b></label>
								<a href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a>
								<a href="https://www.youtube.com/"><i class="fa fa-youtube-play"></i></a>
								<a href="https://twitter.com/login"><i class="fa fa-twitter"></i></a>
								<a href="https://myaccount.google.com/"><i class="fa fa-google-plus"></i></a>

							</div>
						</div>

					</div>

				</div>

			</section>

			<footer id="site-info">
				Copyright &copy;
				Martin Seguel
				<a style="text-align: right;" href="admin/adminLogin.php">Admin</a>
			</footer>

</body>

</html>