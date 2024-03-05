<?php
declare(strict_types=1);
define('BYPASS_AUTH', true);
require_once('../../custom_error_handler.inc.php');

function is_input_empty(string $email, string $password) {
    if (empty($email) || empty($password)) {
        return true;
    } else {
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log('POST request received. Processing...');

    require_once('../../setup/config_session.inc.php');
    require('../../connect_database.php');
    require('../../utils.php');
    require('login_model.inc.php');

    $email = sanitize_input($_POST['Email']);
    $password = sanitize_input($_POST['Password']); 

    try {
        // ERROR HANDLERS
        $errors = [];

        if (is_input_empty($email, $password)) {
            $errors['empty_input'] = 'Please fill in all fields!';
        }

        if (empty($errors) && !is_credentials_correct($db, $email, $password)) {
            $errors['invalid_credentials'] = 'Invalid email or password.';
        }

        if (empty($errors) && !is_verified_by_admin($db, $email)) {
            $errors['not_verified'] = 'User not verified by admin. Access denied.';
        }

        if (!empty($errors)) {
            $_SESSION['errors_login'] = $errors;
            header('Location: login.php');
            exit();
        }

        // SUCCESS
        // Regenerate session ID to prevent session fixation attacks
        session_regenerate_id(true); 

        $user_details = get_user_details($db, $email);
        $_SESSION['id'] = $user_details['id'];
        $_SESSION['first_name'] = $user_details['first_name'];
        $_SESSION['last_name'] = $user_details['last_name'];
        $_SESSION['role'] = $user_details['role'];
        
        header('Location: ../landing/landing.php');
        exit();
    } catch (Exception $e) {
        error_log($e -> getMessage());
        header('Location: login.php');
    }
}