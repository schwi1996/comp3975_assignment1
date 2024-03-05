<?php

declare(strict_types=1);
define('BYPASS_AUTH', true);

function is_input_empty(string $email, string $password, string $first_name, string $last_name) {
    if (empty($email) || empty($password) || empty($first_name) || empty($last_name)) {
        return true;
    } else {
        return false;
    }
}

function is_email_invalid(string $email) {

    // built in PHP function to validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

function is_email_taken(object $db, string $email) {

    if (email_exists($db, $email)) {
        return true;
    } else {
        return false;
    }
}

function is_password_valid(string $password) {
    if (strlen($password) < 8) {
        return false;
    } else {
        return true;
    }
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    require_once('../../setup/config_session.inc.php'); 
    require_once('../../connect_database.php');
    require_once('register_model.inc.php'); 
    require_once('../../utils.php');


    $email = sanitize_input($_POST['Email']);
    $password = sanitize_input($_POST['Password']);
    $first_name = sanitize_input($_POST['FirstName']);
    $last_name = sanitize_input($_POST['LastName']);

    try {
        // ERROR HANDLERS
        $errors = [];

        if (is_input_empty($email, $password, $first_name, $last_name)) {
            $errors['empty_input'] = 'Please fill in all fields!';
        } 

        if (!empty($email) && is_email_invalid($email)) {
            $errors['invalid_email'] = 'Please enter a valid email!';
        }

        if (is_email_taken($db, $email)) {
            $errors['email_taken'] = 'Email already registered!';
        }

        if (!is_password_valid($password)) {
            $errors['invalid_password'] = 'Password must be at least 8 characters long!';
        }

        
        if ($errors) {
            $_SESSION['errors_register'] = $errors;
            header('Location: register.php');
        } else {

            registerUser($db, $first_name, $last_name, $email, $password);
                header('Location: ../landing/landing.php');
        }
    } catch (Exception $e) {
        die('Registration failed: ' . $error_message = $e->getMessage());
    }
}