<?php
// Initialize the session
session_start();
// Include config file
require_once "config.php";
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
		<header id="masthead">
			<h1></h1>
		</header>
		<div id="content">
			<h1>Tu pedido</h1>
			<table id="checkout-cart" class="shopping-cart">
				<thead>
					<tr>
						<th scope="col">Item</th>
						<th scope="col">Cantidad</th>
						<th scope="col">Precio</th>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>
			<div id="pricing">

				<p id="shipping">
					<strong>Envio</strong>: <span id="sshipping"></span>
				</p>

				<p id="sub-total">
					<strong>Total</strong>: <span id="stotal"></span>
				</p>
			</div>

			<div id="user-details">
				<h2>Tus datos</h2>
				<div id="user-details-content"></div>
			</div>

			<form class="formInsertOrder" id="formInsertOrder" name="formInsertOrder" method="post" action="insertOrder.php">
				
				<input type="hidden" name="monto" id="monto" value="XXXXX"/>
				<input type="hidden" name="client" id="client" value="<?php echo $_SESSION["id"] ?>"/>
				<input type="hidden" name="orderStatus" id="orderStatus" value="Pendiente"/>
				<input type="hidden" name="cantProducts" id="cantProducts" value="XXXXX" />

				<input type='image' title='Imagen' id='button1' name='button1' src='https://www.webpay.cl/portalpagodirecto/img/pagar01.png' value='Boton 1'/>
			</form>

		</div>
	</div>

	<footer id="site-info">
		Copyright &copy;
		Martin Seguel
	</footer>

</body>

</html>