<?php
// Create connection to query database
$db_host = 'localhost';
$db_user = 'cjones';
$db_password = 'OpenSource';
$db_db = 'lot_db';

$conn = @new mysqli(
  $db_host,
  $db_user,
  $db_password,
  $db_db
);

function shopData()
{
  // Retrieves information to display shop items
  include_once("mysql_connection.php");
  global $conn;
  $shop_query = "SELECT * FROM inventory_table";
  $shop_result = mysqli_query($conn, $shop_query);
  return $shop_result;
}
function customerCart()
{
  // Retrieves information to view cart on page
  include_once("mysql_connection.php");
  global $conn;

  $cart_query = "SELECT inventory_table.item_title, inventory_table.item_img, inventory_table.item_price
                 FROM cart_table
                 INNER JOIN inventory_table
                 WHERE cart_table.item_code = inventory_table.item_code;";
  $cart_result = mysqli_query($conn, $cart_query);
  return $cart_result;
}
function createCustomerCart()
{
  // Creates the customer specific cart upon checkout
  include_once("mysql_connection.php");
  include_once("invoice.php");
  $first_name = $_POST['first_name'];
  global $conn;
  $cart_query = "CREATE TABLE " . $first_name . "_cart_table AS
                 SELECT inventory_table.item_code, item_title, item_img, item_price
                 FROM inventory_table
                 LEFT JOIN cart_table
                 ON cart_table.item_code = inventory_table.item_code
                 WHERE cart_table.item_qty >=1;";
  $cart_result = mysqli_query($conn, $cart_query);
  return $cart_result;
}
function createInvoiceView()
{
  // Creates a view invoice upon checkout with customer name and cart items
  include_once("mysql_connection.php");
  include_once("invoice.php");
  $first_name = $_POST['first_name'];
  global $conn;
  $invoice = "CREATE VIEW " . $first_name . "_customer_invoice AS
              SELECT customer_table.first_name, customer_table.last_name, customer_table.email, 
              " . $first_name . "_cart_table.item_title, " . $first_name . "_cart_table.item_img, " . $first_name . "_cart_table.item_price
              FROM customer_table, " . $first_name . "_cart_table;";

  if ($conn->query($invoice) === TRUE) {
    null;
  } else {
    echo "Error creating invoice: " . $conn->error;
  }
}

//Refernce fucntion to call JavaScript
if (isset($_GET['functionToCall']) && function_exists($_GET['functionToCall'])) {
  call_user_func($_GET['functionToCall']);
}

function insertChains()
{
  //Insert Chains of Ultimatum into cart_table
  include_once("mysql_connection.php");
  global $conn;

  $chains = "INSERT INTO cart_table (item_code, item_qty)
             SELECT 'COU001', 1
             WHERE NOT EXISTS
                (SELECT `item_code`
                  FROM lot_db.cart_table
                  WHERE `item_code` = 'COU001');";
  mysqli_query($conn, $chains);
}
function removeChains()
{
  //Remove Chains of Ultimatum from cart_table
  include_once("mysql_connection.php");
  global $conn;

  $removeItem = "DELETE FROM `cart_table` WHERE `cart_table`.`item_code` = 'COU001';";
  mysqli_query($conn, $removeItem);
}
function insertDaggers()
{
  //Insert Dark Matter Daggers into cart_table
  include_once("mysql_connection.php");
  global $conn;

  $daggers = "INSERT INTO cart_table (item_code, item_qty)
              SELECT 'DMD001', 1
              WHERE NOT EXISTS
                (SELECT `item_code`
                  FROM lot_db.cart_table
                  WHERE `item_code` = 'DMD001');";
  mysqli_query($conn, $daggers);

  echo "New record:" . mysqli_insert_id($conn);
}
function removeDaggers()
{
  //Remove Dark Matter Daggers from cart_table
  include_once("mysql_connection.php");
  global $conn;

  $removeItem = "DELETE FROM `cart_table` WHERE `cart_table`.`item_code` = 'DMD001';";
  mysqli_query($conn, $removeItem);
}
function insertStaff()
{
  //Insert Staff of Eternity into cart_table
  include_once("mysql_connection.php");
  global $conn;

  $staff = "INSERT INTO cart_table (item_code, item_qty)
            SELECT 'SOE001', 1
            WHERE NOT EXISTS
              (SELECT `item_code`
                FROM lot_db.cart_table
                WHERE `item_code` = 'SOE001');";
  mysqli_query($conn, $staff);
}
function removeStaff()
{
  //Remove Staff of Eternity from cart_table
  include_once("mysql_connection.php");
  global $conn;

  $removeItem = "DELETE FROM `cart_table` WHERE `cart_table`.`item_code` = 'SOE001';";
  mysqli_query($conn, $removeItem);
}
function insertSwords()
{
  //Insert Swords of Fission into cart_table
  include_once("mysql_connection.php");
  global $conn;

  $swords = "INSERT INTO cart_table (item_code, item_qty)
             SELECT 'SOF001', 1
             WHERE NOT EXISTS
                (SELECT `item_code`
                  FROM lot_db.cart_table
                  WHERE `item_code` = 'SOF001');";
  mysqli_query($conn, $swords);
}
function removeSwords()
{
  //Remove Swords of Fission from cart_table
  include_once("mysql_connection.php");
  global $conn;

  $removeItem = "DELETE FROM `cart_table` WHERE `cart_table`.`item_code` = 'SOF001';";
  mysqli_query($conn, $removeItem);
}
