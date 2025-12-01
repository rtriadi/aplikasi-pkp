<?php
// Script to update database schema
$mysqli = new mysqli("localhost", "root", "", "db_epkp");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

// Add target_period column to pkp_targets
$sql = "ALTER TABLE pkp_targets ADD COLUMN target_period ENUM('Bulanan', 'Triwulan', 'Tahunan') NOT NULL DEFAULT 'Bulanan' AFTER activity_name";

if ($mysqli->query($sql) === TRUE) {
    echo "Column target_period added successfully";
} else {
    echo "Error adding column: " . $mysqli->error;
}

$mysqli->close();
?>
