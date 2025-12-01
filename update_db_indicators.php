<?php
// Script to update database schema
$mysqli = new mysqli("localhost", "root", "", "db_epkp");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

// 1. Create pkp_indicators table
$sql = "CREATE TABLE IF NOT EXISTS `pkp_indicators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `indicator_name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($mysqli->query($sql) === TRUE) {
    echo "Table pkp_indicators created successfully.\n";
} else {
    echo "Error creating table: " . $mysqli->error . "\n";
}

// 2. Add indicator_id to pkp_targets
// Check if column exists first
$check = $mysqli->query("SHOW COLUMNS FROM `pkp_targets` LIKE 'indicator_id'");
if ($check->num_rows == 0) {
    $sql = "ALTER TABLE `pkp_targets` ADD `indicator_id` INT(11) NOT NULL AFTER `year_id`;";
    if ($mysqli->query($sql) === TRUE) {
        echo "Column indicator_id added to pkp_targets.\n";
    } else {
        echo "Error adding column: " . $mysqli->error . "\n";
    }
} else {
    echo "Column indicator_id already exists.\n";
}

$mysqli->close();
?>
