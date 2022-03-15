<!DOCTYPE html>
<html>

<head>
	<title>WhatTheFloral - Carro</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="style.css" media="screen" type="text/css" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<script type="text/javascript" src="jquery.store.js"></script>
</head>

<body>

	<div id="site">
		<header id="masthead">
			<h1></h1>
		</header>
		<div id="content">
			<h1>Tu carro de compras</h1>
			<form id="shopping-cart" action="cart.php" method="post">
				<table class="shopping-cart">
					<thead>
						<tr>
							<th scope="col">Item</th>
							<th scope="col">Cantidad</th>
							<th scope="col" colspan="2">Precio</th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
				<p id="sub-total">
					<strong>Sub Total</strong>: <span id="stotal"></span>
				</p>
				<ul id="shopping-cart-actions">
					<li>
						<input type="submit" name="update" id="update-cart" class="btn" value="Actualizar Carro" />
					</li>
					<li>
						<input type="submit" name="delete" id="empty-cart" class="btn" value="Vaciar Carro" />
					</li>
					<li>
						<a href="index.php" class="btn">Continuar comprando</a>
					</li>
					<li>
						<a href="checkout.php" class="btn">Comprar</a>
					</li>
				</ul>
			</form>
		</div>



	</div>

	<footer id="site-info">
		Copyright &copy;
		Martin Seguel
	</footer>

</body>

</html>