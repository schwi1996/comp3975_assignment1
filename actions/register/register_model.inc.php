<?php 
declare(strict_types=1);
define('BYPASS_AUTH', true);

function registerUser(object $db, string $firstName, string $lastName, string $email, string $password) {

    try {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $insertUser = $db -> prepare('INSERT INTO Users (first_name, last_name, email, password, verified_status) VALUES (:first_name, :last_name, :email, :password, :verified_status)');
        $insertUser -> bindValue(':first_name', $firstName, SQLITE3_TEXT);
        $insertUser -> bindValue(':last_name', $lastName, SQLITE3_TEXT);
        $insertUser -> bindValue(':email', $email, SQLITE3_TEXT);
        $insertUser -> bindValue(':password', $passwordHash, SQLITE3_TEXT);
        $insertUser -> bindValue(':verified_status', 0, SQLITE3_INTEGER);

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