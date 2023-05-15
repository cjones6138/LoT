<?php
// Create connection to phpMyAdmin
$db_host = 'localhost';
$db_user = 'cjones';
$db_password = 'OpenSource';

$conn = @new mysqli(
    $db_host,
    $db_user,
    $db_password,
);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS lot_db;";

if ($conn->query($sql) === TRUE) {
    null;
} else {
    echo "Error creating database: " . $conn->error;
}

// Create inventory_table
$sql =
    "CREATE TABLE IF NOT EXISTS lot_db.inventory_table (
    `item_code` varchar(6) NOT NULL UNIQUE DEFAULT 'XXX###',
    `item_title` varchar(255) NOT NULL,
    `item_img` varchar(255) NOT NULL,
    `item_price` float(10,2),
    PRIMARY KEY (item_code)
  ) ENGINE=InnoDB CHARSET=utf8;";

if ($conn->query($sql) === TRUE) {
    null;
} else {
    echo "Error creating inventory table: " . $conn->error;
}

// Enter inventory item to inventory_table
$sql = "INSERT INTO lot_db.inventory_table (`item_code`, `item_title`, `item_img`, `item_price`)
        SELECT 'COU001', 'Chains of Ultimatum','./images/chains.png', 9.99
        WHERE NOT EXISTS
            (SELECT `item_code`
             FROM lot_db.inventory_table
             WHERE `item_code` = 'COU001');";

if ($conn->query($sql) === TRUE) {
    null;
} else {
    echo "Error inserting to inventory table: " . $conn->error;
}

// Enter inventory item to inventory_table
$sql = "INSERT INTO lot_db.inventory_table (`item_code`, `item_title`, `item_img`, `item_price`)
        SELECT 'DMD001', 'Dark Matter Daggers', './images/dagger.png', 19.99
        WHERE NOT EXISTS
            (SELECT `item_code`
            FROM lot_db.inventory_table
            WHERE `item_code` = 'DMD001');";

if ($conn->query($sql) === TRUE) {
    null;
} else {
    echo "Error inserting to inventory table: " . $conn->error;
}

// Enter inventory item to inventory_table
$sql = "INSERT INTO lot_db.inventory_table (`item_code`, `item_title`, `item_img`, `item_price`)
        SELECT 'SOE001', 'Staff of Eternity', './images/staff.png', 19.99
        WHERE NOT EXISTS
            (SELECT `item_code`
             FROM lot_db.inventory_table
             WHERE `item_code` = 'SOE001');";

if ($conn->query($sql) === TRUE) {
    null;
} else {
    echo "Error inserting to inventory table: " . $conn->error;
}

// Enter inventory item to inventory_table
$sql = "INSERT INTO lot_db.inventory_table (`item_code`, `item_title`, `item_img`, `item_price`)
        SELECT 'SOF001', 'Swords of Fission', './images/sword.png', 19.99
        WHERE NOT EXISTS
            (SELECT `item_code`
             FROM lot_db.inventory_table
             WHERE `item_code` = 'SOF001');";

if ($conn->query($sql) === TRUE) {
    null;
} else {
    echo "Error inserting to inventory table: " . $conn->error;
}

// Create cart_table      
$sql =
    "CREATE TABLE IF NOT EXISTS lot_db.cart_table (
        `purchase_id` int NOT NULL AUTO_INCREMENT,
        `item_code` varchar(6) NOT NULL UNIQUE DEFAULT 'XXX###',
        `item_qty` int NOT NULL,     
        PRIMARY KEY (purchase_id),
        FOREIGN KEY (item_code) REFERENCES inventory_table(item_code)        
      ) ENGINE=InnoDB CHARSET=utf8;";

if ($conn->query($sql) === TRUE) {
    null;
} else {
    echo "Error creating cart table: " . $conn->error;
}

// Create customer
$sql =
    "CREATE TABLE IF NOT EXISTS lot_db.customer_table (
    `customer_id` int NOT NULL AUTO_INCREMENT,
    `first_name` varchar(50) NOT NULL,
    `last_name` varchar(50) NOT NULL,
    `email` varchar(255) UNIQUE,
    `item_code` varchar(6) DEFAULT 'XXX###',
    PRIMARY KEY (customer_id)
  ) ENGINE=InnoDB CHARSET=utf8;";

if ($conn->query($sql) === TRUE) {
    null;
} else {
    echo "Error creating customer table: " . $conn->error;
}

$conn->close();
