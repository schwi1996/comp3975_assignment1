<?php
session_start();

require('../../connect_database.php');

function verifyCredentials($db, $email, $inputPassword) {
    $passwordQuery = $db -> prepare('SELECT password FROM Users WHERE email = :email');
    $passwordQuery -> bindValue(':email', $email, SQLITE3_TEXT);
    $result = $passwordQuery -> execute();

    $row = $result -> fetchArray(SQLITE3_ASSOC);

    // If the email exists in the database
    if ($row) {
        echo 'User found. Validating password...';

        $storedPassword = $row['password']; 

        if (password_verify($inputPassword, $storedPassword)) {
            echo 'Password verified.';
            return true;
        } else {
            echo 'Invalid password.';
            return false;
        }
    } else {
        echo 'Email address does not exist.';
        return false;
    }
}

if(isset($_POST['login'])) {
    $email = $_POST['Email'];
    $password = $_POST['Password']; 

    $userVerified = verifyCredentials($db, $email, $password);

    if ($userVerified) {
        // TODO: COOKIE, session variable, redirect, etc
    }
}

