<!DOCTYPE html>
<html>

<head>
	<title>Checkout</title>
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
			<h1>Orden de compra</h1>
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

			<form action="order.php" method="post" id="checkout-order-form">
				<h2>Datos de envio</h2>

				<fieldset id="fieldset-billing">
					<legend>Datos</legend> <?php session_start(); ?>
					<div>
						<label for="name">Nombre</label>
						<input type="text" name="name" id="name" data-type="string" value="<?php echo '' . $_SESSION["username"] . '' ?>" data-message="This field cannot be empty" />
					</div>
					<div>
						<label for="email">Correo</label>
						<input type="text" name="email" id="email" data-type="expression" value="<?php echo '' . $_SESSION["correo"] . '' ?>" data-message="Not a valid email address" />
					</div>
					<div>
						<label for="city">Comuna</label>
						<input type="text" name="city" id="city" data-type="string" data-message="This field cannot be empty" />
					</div>
					<div>
						<label for="address">Direccion</label>
						<input type="text" name="address" id="address" data-type="string" data-message="This field cannot be empty" />
					</div>
					<div>
						<label for="address">Numero contacto</label>
						<input type="text" name="contact" id="contact" data-type="numeric" data-message="This field cannot be empty" />
					</div>
				</fieldset>

				<p><input type="submit" id="submit-order" value="Aceptar" class="btn" /></p>

			</form>
		</div>



	</div>

	<footer id="site-info">
		Copyright &copy;
		Martin Seguel
	</footer>

</body>

</html>