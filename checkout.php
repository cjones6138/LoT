<?php
require_once("mysql_connection.php");

// Query database and store query in variable to display items in shop
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

        <!-- The customer form starts here -->
        <article class="container contentSection">
            <h2 class="sectionHeader">Checkout</h2>
            <div class="checkoutSection">
                <span class="formHeader checkoutHeader">ORDER INFORMATION</span>
                <form class="checkoutForm" action="invoice.php" method="post">
                    <!-- Customer form collection input -->
                    <div class="firstName checkoutLabel">
                        <label class="label" for="first_name">First name:</label>
                        <input class="textbox" type="text" id="first_name" name="first_name" required>
                    </div>
                    <div class="lastName checkoutLabel">
                        <label class="label" for="last_name">Last name:</label>
                        <input class="textbox" type="text" id="last_name" name="last_name" required>
                    </div>
                    <div class="email checkoutLabel">
                        <label class="label" for="email">Email:</label>
                        <input class="textbox" type="email" id="email" name="email" required>
                    </div>

                    <button class="btn btnPrimary btnPurchase btnCheckout" value="submit" type="submit" name="submit">Submit</button>
                </form>
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
        </article>
    </div>
    <footer>
        We are a made up video game company. Please do not attempt to buy from this store.
    </footer>
</body>

</html>