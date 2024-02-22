<?php

declare(strict_types=1);

function is_verified_by_admin(object $db, string $email) {

    $verifiedQuery = $db -> prepare('SELECT verified_status FROM Users WHERE email = :email');
    $verifiedQuery -> bindValue(':email', $email);
    $result = $verifiedQuery -> execute();

    $row = $result -> fetchArray();

    // verified_status '1' means verified by admin, '0' means not verified
    return $row['verified_status'];
}

function is_credentials_correct(object $db, string $email, string $inputPassword) {

    $passwordQuery = $db -> prepare('SELECT password FROM Users WHERE email = :email');
    $passwordQuery -> bindValue(':email', $email);
    $result = $passwordQuery -> execute();

    $row = $result -> fetchArray();

    // If the email exists in the database
    if ($row) {
        echo 'User found. Validating password...';

        $storedPassword = $row['password']; 

        if (password_verify($inputPassword, $storedPassword)) {
            echo 'Password verified.';
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function get_user_id($db, $email) {
    $userIdQuery = $db -> prepare('SELECT id FROM Users WHERE email = :email');
    $userIdQuery -> bindValue(':email', $email, SQLITE3_TEXT);
    $result = $userIdQuery -> execute();

    $row = $result -> fetchArray(SQLITE3_ASSOC);

    return $row['id'];
}