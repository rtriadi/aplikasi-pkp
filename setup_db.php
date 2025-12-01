<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS db_epkp";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully\n";
} else {
    echo "Error creating database: " . $conn->error . "\n";
}

$conn->select_db("db_epkp");

// SQL to create tables
$tables = [
    "users" => "CREATE TABLE IF NOT EXISTS `users` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `nip` varchar(50) NOT NULL UNIQUE,
        `password` varchar(255) NOT NULL,
        `full_name` varchar(100) NOT NULL,
        `role` enum('admin','pegawai') NOT NULL DEFAULT 'pegawai',
        `unit_id` int(11) DEFAULT NULL,
        `rank_id` int(11) DEFAULT NULL,
        `position_id` int(11) DEFAULT NULL,
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    )",
    "ref_years" => "CREATE TABLE IF NOT EXISTS `ref_years` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `year` int(4) NOT NULL,
        `is_active` tinyint(1) DEFAULT 0,
        PRIMARY KEY (`id`)
    )",
    "ref_units" => "CREATE TABLE IF NOT EXISTS `ref_units` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        PRIMARY KEY (`id`)
    )",
    "ref_ranks" => "CREATE TABLE IF NOT EXISTS `ref_ranks` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `rank_name` varchar(100) NOT NULL,
        `golongan` varchar(50) NOT NULL,
        PRIMARY KEY (`id`)
    )",
    "ref_positions" => "CREATE TABLE IF NOT EXISTS `ref_positions` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `position_name` varchar(255) NOT NULL,
        PRIMARY KEY (`id`)
    )",
    "pkp_targets" => "CREATE TABLE IF NOT EXISTS `pkp_targets` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,
        `year_id` int(11) NOT NULL,
        `activity_name` text NOT NULL,
        `target_qty` int(11) NOT NULL,
        `target_quality` int(11) DEFAULT 100,
        `target_unit` varchar(50) NOT NULL,
        `target_credit_score` float DEFAULT 0,
        PRIMARY KEY (`id`)
    )",
    "pkp_monthly" => "CREATE TABLE IF NOT EXISTS `pkp_monthly` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `target_id` int(11) NOT NULL,
        `month` int(2) NOT NULL,
        `real_qty` int(11) DEFAULT 0,
        `real_quality` int(11) DEFAULT 0,
        `is_active_print` tinyint(1) DEFAULT 1,
        PRIMARY KEY (`id`)
    )",
    "pkp_signatures" => "CREATE TABLE IF NOT EXISTS `pkp_signatures` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,
        `month` int(2) NOT NULL,
        `year_id` int(11) NOT NULL,
        `appraiser_name` varchar(100),
        `appraiser_nip` varchar(50),
        `appraiser_position` varchar(100),
        `atasan_appraiser_name` varchar(100),
        `atasan_appraiser_nip` varchar(50),
        `atasan_appraiser_position` varchar(100),
        PRIMARY KEY (`id`)
    )"
];

foreach ($tables as $name => $sql) {
    if ($conn->query($sql) === TRUE) {
        echo "Table $name created successfully\n";
    } else {
        echo "Error creating table $name: " . $conn->error . "\n";
    }
}

// Insert default admin user if not exists
$admin_nip = 'admin';
$admin_pass = password_hash('admin123', PASSWORD_BCRYPT);
$check_admin = "SELECT * FROM users WHERE nip = '$admin_nip'";
if ($conn->query($check_admin)->num_rows == 0) {
    $insert_admin = "INSERT INTO users (nip, password, full_name, role) VALUES ('$admin_nip', '$admin_pass', 'Administrator', 'admin')";
    if ($conn->query($insert_admin) === TRUE) {
        echo "Default admin user created\n";
    } else {
        echo "Error creating admin user: " . $conn->error . "\n";
    }
}

$conn->close();
?>
