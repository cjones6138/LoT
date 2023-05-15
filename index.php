<?PHP
require_once("create_database.php");
require_once("mysql_connection.php");

// Query database and store query in variable to display items in shop
$shop_result = shopData();
$cart = customerCart();
// Initialize Cart Sum variable to 0
$cartSum = 0;
?>

<!DOCTYPE html>
<html>

<head>
	<?php include("./modular/head.php") ?>
</head>

<body>
	<header>
		<?php include("./modular/header.php") ?>
	</header>
	<div class="wrapper">

		<!-- The shop starts here -->
		<article class="container contentSection">
			<h2 class="sectionHeader">Shop</h2>
			<div class="shopItems">

				<!-- Loop through inventory_table for all cart items to display -->
				<?php
				while ($row = mysqli_fetch_assoc($shop_result)) {
				?>
					<div class="shopItem">
						<span class="shopItemTitle"><?php echo $row['item_title']; ?></span>
						<?php echo '<img class="shopItemImage" src="' . $row['item_img'] . '">'; ?>
						<div class="shopItemDetails">
							<span class="shopItemPrice"><?php echo $row['item_price']; ?></span>
							<form>
								<button class="btn btnPrimary shopItemButton" type="button" name="shopItemButton">Add to Cart</button>
							</form>
						</div>
					</div>
				<?php
				}
				?>
			</div>
		</article>

		<!-- The cart starts here -->
		<article class="container cartContainer">
			<h2 class="sectionHeader">Cart</h2>
			<div class="cartRow">
				<span class="cartItem cartHeader cartColumn">ITEM</span>
				<span class="cartPrice cartHeader cartColumn">PRICE</span>
				<span class="cartRemove cartHeader cartColumn"></span>
			</div>
			<div class="cartItems">

				<!-- Loop through cart_table for all cart items to display  -->
				<?php
				while ($row = mysqli_fetch_assoc($cart)) {
					$cartSum += $row['item_price'];
				?>
					<div class="cartRow">
						<div class="cartItem cartColumn">
							<?php echo '<img class="cartItemImage" src="' . $row['item_img'] . '">'; ?>
							<span class="cartItemTitle"><?php echo $row['item_title']; ?></span>
						</div>
						<span class="cartPrice cartColumn"><?php echo $row['item_price']; ?></span>
						<div class="cartRemove cartColumn">
							<button class="btn btnDanger" type="button">REMOVE</button>
						</div>
					</div>
				<?php
				}
				?>
			</div>
			<div class="cartTotal">
				<strong class="cartTotalTitle">Total</strong>
				<span class="cartTotalPrice"><?php echo $cartSum ?></span>
			</div>
			<button class="btn btnPrimary btnPurchase" type="button" onclick="window.location.href='checkout.php';">PURCHASE</button>
		</article>

	</div>
	<footer>
		We are a made up video game company. Please do not attempt to buy from this store.
	</footer>
</body>

</html>