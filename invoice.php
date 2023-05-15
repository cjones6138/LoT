<?php
require_once("mysql_connection.php");

// Query database and store query in variable to display items in shop
$cart = customerCart();
// Initialize Cart Sum variable to 0
$cartSum = 0;

// Insert Customer to customer_table using form data from checkout.php
global $conn;

if (isset($_POST['submit'])) {
    echo "Hello There";
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];

    $sql = "INSERT INTO lot_db.customer_table (`first_name`, `last_name`, `email`)
                            SELECT '$first_name', '$last_name', '$email'
                            WHERE NOT EXISTS
                                (SELECT `email`
                                FROM lot_db.customer_table
                                WHERE `email` = '$email');";

    if ($conn->query($sql) === TRUE) {
        null;
    } else {
        echo "Error creating customer: " . $conn->error;
    }
}

// Call php functions to create customer invoice
createCustomerCart();
createInvoiceView();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Shop - Lost Out There...</title>
    <link rel="stylesheet" href="./backend/stylesheet.css" />
</head>

<body>
    <header>
        <?php include("./modular/header.php") ?>
    </header>
    <div class="wrapper">

        <!-- The customer form starts here -->
        <article class="container contentSection">
            <!-- Line to confirm purchase  -->
            <h2 class="sectionHeader">Thank you for your purchase, <?php echo $_POST['first_name'] ?></h2>
        </article>

        <!-- The cart starts here -->
        <article class="container cartContainer">
            <h2 class="sectionHeader">Cart</h2>
            <div class="cartRow">
                <span class="cartItem cartHeader cartColumn">ITEM</span>
                <span class="cartPrice cartHeader cartColumn">PRICE</span>
            </div>

            <div class="cartItems">

                <!-- Loop through cart_table for all cart items to display.
                     Does not display price per item. -->
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