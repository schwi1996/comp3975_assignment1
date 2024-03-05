<?php 

declare(strict_types=1);
define('BYPASS_AUTH', true);

// function createUsersTableIfNotExists(object $db) { // TODO: move this elsewhere, to database setup

//     $db -> exec('CREATE TABLE IF NOT EXISTS Users (
//         id INTEGER PRIMARY KEY AUTOINCREMENT,
//         first_name VARCHAR(80) NOT NULL,
//         last_name VARCHAR(80) NOT NULL,
//         email VARCHAR(80) NOT NULL UNIQUE,
//         password VARCHAR(255) NOT NULL,
//         verified_status BOOLEAN DEFAULT 0,
//         role VARCHAR(20) DEFAULT "user"
//     )');
// }

function registerUser(object $db, string $firstName, string $lastName, string $email, string $password) {

    try {
        // createUsersTableIfNotExists($db); // TODO: move this elsewhere, don't call each time a user registers

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $insertUser = $db -> prepare('INSERT INTO Users (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)');
        $insertUser -> bindValue(':first_name', $firstName, SQLITE3_TEXT);
        $insertUser -> bindValue(':last_name', $lastName, SQLITE3_TEXT);
        $insertUser -> bindValue(':email', $email, SQLITE3_TEXT);
        $insertUser -> bindValue(':password', $passwordHash, SQLITE3_TEXT);

        if ($insertUser -> execute()) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        error_log($e -> getMessage());
        return false;
    }   
}

function email_exists(object $db, string $email) {

    try {
        $query = "SELECT email FROM Users WHERE email = :email";
        $stmt = $db -> prepare($query);
        $stmt -> bindValue(':email', $email);

        $result = $stmt -> execute();
        $result = $result -> fetchArray();

        if ($result) {
            return $result;
        } else {
            return false;
        }
    } catch (Exception $e) {
        error_log($e -> getMessage());
        return false;
    }
}