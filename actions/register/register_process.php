<?php
require('../../connect_database.php');

function createUsersTableIfNotExists($db) {
    $db -> exec('CREATE TABLE IF NOT EXISTS Users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        first_name VARCHAR(80) NOT NULL,
        last_name VARCHAR(80) NOT NULL,
        email VARCHAR(80) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        verified_status BOOLEAN DEFAULT 0,
        role VARCHAR(20) DEFAULT "user"
    )');
}

function registerUser($db, $firstName, $lastName, $email, $password) {
    createUsersTableIfNotExists($db);

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $insertUser = $db -> prepare('INSERT INTO Users (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)');
    $insertUser -> bindValue(':first_name', $firstName, SQLITE3_TEXT);
    $insertUser -> bindValue(':last_name', $lastName, SQLITE3_TEXT);
    $insertUser -> bindValue(':email', $email, SQLITE3_TEXT);
    $insertUser -> bindValue(':password', $passwordHash, SQLITE3_TEXT);
    $insertUser -> execute();
}

if (isset($_POST['register'])) {
    $firstName = $_POST['FirstName'];
    $lastName = $_POST['LastName'];
    $email = $_POST['Email'];
    $password = $_POST['Password'];

    registerUser($db, $firstName, $lastName, $email, $password);
    header('Location: ../../index.php');
}