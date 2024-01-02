<?php
require('connect.php');
$check = false;
$tablesResult = $mysqli->query("SHOW TABLES");
if ($tablesResult) {
    $mysqli->query("SET FOREIGN_KEY_CHECKS = 0");
    while ($table = $tablesResult->fetch_assoc()) {
        $tableName = $table["Tables_in_" . $database];
        $dropTableQuery = "DROP TABLE IF EXISTS `$tableName`";
        $mysqli->query($dropTableQuery);
        if ($mysqli->error) {
            echo "Error dropping table $tableName: " . $mysqli->error . "<br>";
        } else {
            echo "Table $tableName dropped successfully<br>";
        }
    }
}
$tables = array(
    "user" => "CREATE TABLE `user` (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(20) NOT NULL,
                password VARCHAR(32) NOT NULL,
                role TINYINT NOT NULL,
                status TINYINT DEFAULT 0,
                created_at DATETIME NOT NULL,
                created_by INT NOT NULL,
                updated_at DATETIME DEFAULT NULL,
                updated_by INT DEFAULT NULL,
                deleted_at DATETIME,
                deleted_by INT DEFAULT NULL)",
   
   "shift" => "CREATE TABLE `shift` (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        start_date_time DATETIME,
        end_date_time DATETIME,
        status TINYINT DEFAULT 0,
        created_at DATETIME NOT NULL,
        created_by INT NOT NULL,
        updated_at DATETIME DEFAULT NULL,
        updated_by INT DEFAULT NULL,
        deleted_at DATETIME,
        deleted_by INT DEFAULT NULL)",

    "category" => "CREATE TABLE `category` (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(45) NOT NULL,
        parent_id INT UNSIGNED NOT NULL,
        image VARCHAR(150),
        status TINYINT DEFAULT 0,   
        created_at DATETIME NOT NULL,
        created_by INT NOT NULL,
        updated_at DATETIME DEFAULT NULL,
        updated_by INT DEFAULT NULL,
        deleted_at DATETIME,
        deleted_by INT DEFAULT NULL)",

    "item" => "CREATE TABLE `item` (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(45) NOT NULL,
        category_id INT UNSIGNED,
        price INT UNSIGNED NOT NULL,
        quantity INT UNSIGNED DEFAULT NULL,
        code_no VARCHAR(45) NOT NULL,
        image VARCHAR(150),
        status TINYINT DEFAULT 0,
        created_at DATETIME NOT NULL,
        created_by INT NOT NULL,
        updated_at DATETIME DEFAULT NULL,
        updated_by INT DEFAULT NULL,
        deleted_at DATETIME,
        deleted_by INT DEFAULT NULL,
        FOREIGN KEY (category_id) REFERENCES `category`(id) ON DELETE CASCADE)",

    "order" => "CREATE TABLE `order` (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        status TINYINT DEFAULT 0,
        payment INT UNSIGNED DEFAULT NULL,
        refund INT UNSIGNED DEFAULT NULL,
        created_at DATETIME NOT NULL,
        created_by INT NOT NULL,
        updated_at DATETIME DEFAULT NULL,
        updated_by INT DEFAULT NULL,
        deleted_at DATETIME,
        deleted_by INT DEFAULT NULL)",

    "order_detail" => "CREATE TABLE `order_detail` (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        quantity INT UNSIGNED DEFAULT NULL,
        sub_total INT UNSIGNED NOT NULL,
        status TINYINT DEFAULT 0,
        order_id INT UNSIGNED NOT NULL,
        item_id INT UNSIGNED NOT NULL,
        created_at DATETIME NOT NULL,
        created_by INT NOT NULL,
        updated_at DATETIME DEFAULT NULL,
        updated_by INT DEFAULT NULL,
        deleted_at DATETIME,
        deleted_by INT DEFAULT NULL,
        FOREIGN KEY (order_id) REFERENCES `order`(id) ON DELETE CASCADE,
        FOREIGN KEY (item_id) REFERENCES `item`(id) ON DELETE CASCADE,
        UNIQUE (item_id))",    

    "discount_promotion" => "CREATE TABLE `discount_promotion` (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(45) NOT NULL,
        amount INT UNSIGNED DEFAULT NULL,
        percentage INT UNSIGNED DEFAULT NULL,
        start_date DATETIME NOT NULL,
        end_date DATETIME NOT NULL,
        description MEDIUMTEXT DEFAULT NULL,
        status TINYINT DEFAULT 0,   
        created_at DATETIME NOT NULL,
        created_by INT NOT NULL,
        updated_at DATETIME DEFAULT NULL,
        updated_by INT DEFAULT NULL,
        deleted_at DATETIME,
        deleted_by INT DEFAULT NULL)",

    "discount_item" => "CREATE TABLE `discount_item` (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        item_id INT UNSIGNED NOT NULL,
        discount_id INT UNSIGNED NOT NULL,
        status TINYINT DEFAULT 0,   
        created_at DATETIME NOT NULL,
        created_by INT NOT NULL,
        updated_at DATETIME DEFAULT NULL,
        updated_by INT DEFAULT NULL,
        deleted_at DATETIME,
        deleted_by INT DEFAULT NULL,
        FOREIGN KEY (discount_id) REFERENCES `discount_promotion`(id) ON DELETE CASCADE,
        FOREIGN KEY (item_id) REFERENCES `item`(id) ON DELETE CASCADE
    )"  
);

foreach ($tables as $tableName => $tableDefinition) {
    $result = $mysqli->query($tableDefinition);

    if ($result === TRUE) {
        $check = true;
        echo "Table $tableName created successfully<br>";
    } else {
        echo "Error creating table $tableName: " . $mysqli->error . "<br>";
    }
    
}

$insertUserQuery = "INSERT INTO `user` (
    username,
    password,
    role,
    status,
    created_at,
    created_by
) VALUES (
    'admin',
    '83ae1fd0a55ee0d77be27c88892138df',
    1,
    0,
    NOW(),
    1
)";
if ($check){
$insertResult = $mysqli->query($insertUserQuery);

if ($insertResult === TRUE) {
    echo "One row inserted into the 'user' table successfully<br>";
} else {
    echo "Error inserting row into the 'user' table: " . $mysqli->error . "<br>";
}
}else{
    echo "Error creating table $tableName: " . $mysqli->error . "<br>";
}
?>