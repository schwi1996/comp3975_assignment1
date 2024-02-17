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

function checkIfVerifiedByAdmin($db, $email) {
    $verifiedQuery = $db -> prepare('SELECT verified_status FROM Users WHERE email = :email');
    $verifiedQuery -> bindValue(':email', $email, SQLITE3_TEXT);
    $result = $verifiedQuery -> execute();

    $row = $result -> fetchArray(SQLITE3_ASSOC);

    // verified_status '1' means verified by admin, '0' means not verified
    return $row['verified_status'];
}

// Store the current user's ID in a session variable so it can be referenced in other pages for database queries
function getUserId($db, $email) {
    $userIdQuery = $db -> prepare('SELECT id FROM Users WHERE email = :email');
    $userIdQuery -> bindValue(':email', $email, SQLITE3_TEXT);
    $result = $userIdQuery -> execute();

    $row = $result -> fetchArray(SQLITE3_ASSOC);

    return $row['id'];
}

if(isset($_POST['login'])) {
    $email = $_POST['Email'];
    $password = $_POST['Password']; 

    $credentialsVerified = verifyCredentials($db, $email, $password);

    if ($credentialsVerified) {
        // TODO: COOKIE....? 
        $verifiedByAdmin = checkIfVerifiedByAdmin($db, $email);
        if ($verifiedByAdmin) {
            echo 'User verified by admin. Access granted.';

            $id = getUserId($db, $email);
        
            // Set session variables
            $_SESSION['id'] = $id;
            $_SESSION['authorized'] = true;
            
            header('Location: ../landing/landing.php');
        } else {
            $_SESSION['error'] = 'User not verified by admin. Access denied.';
        }

    } else {
        $_SESSION['error'] = 'Invalid credentials. Access denied.';
        header('Location: login.php');
    }
}

