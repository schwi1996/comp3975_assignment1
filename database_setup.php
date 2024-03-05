<?php


include("connect_database.php");
require_once("vendor/autoload.php");
require("custom_error_handler.inc.php");

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Credentials for admin user
$admin_email = $_ENV['ADMIN_EMAIL'];
$admin_password = password_hash($_ENV['ADMIN_PASSWORD'], PASSWORD_BCRYPT); 

$version = $db->querySingle('SELECT SQLITE_VERSION()');

// Create Users table if it does not exist
$SQL_create_users_table = "CREATE TABLE IF NOT EXISTS Users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    first_name VARCHAR(80) NOT NULL,
    last_name VARCHAR(80) NOT NULL,
    email VARCHAR(80) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    verified_status BOOLEAN DEFAULT 1,
    role VARCHAR(20) DEFAULT 'user'
);";

$db -> exec($SQL_create_users_table);

// Check if admin user already exists
$result = $db->querySingle("SELECT COUNT(*) as count FROM Users WHERE email = '$admin_email'");
if ($result == 0) {
    // Insert admin user
    $stmt = $db -> prepare('INSERT INTO Users (first_name, last_name, email, password, verified_status, role) VALUES ("admin", "admin", :email, :password, 1, "admin")');
    $stmt -> bindValue(':email', $admin_email, SQLITE3_TEXT);
    $stmt -> bindValue(':password', $admin_password, SQLITE3_TEXT);
    $stmt -> execute();
}

// Create Transactions table if it does not exist
$SQL_create_table = "CREATE TABLE IF NOT EXISTS Transactions (
    TransactionId INTEGER PRIMARY KEY AUTOINCREMENT,
    Date TEXT NOT NULL,
    Vendor TEXT NOT NULL,
    Spend REAL,
    Deposit REAL,
    Balance REAL
);";

$db->exec($SQL_create_table);

$SQL_create_buckets = "CREATE TABLE IF NOT EXISTS Buckets (
    id INTEGER,
    Date TEXT NOT NULL,
    Vendor TEXT NOT NULL,
    Category TEXT NOT NULL,
    FOREIGN KEY (id) REFERENCES Transactions(TransactionId)
);";

$db->exec($SQL_create_buckets);

$db->close();

?>