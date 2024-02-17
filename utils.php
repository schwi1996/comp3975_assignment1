<?php

    function sanitize_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function checkUserAuthentication() {
        session_start();

        // If the user is not logged in, redirect to the login page
        if (!isset($_SESSION['id'])) {
            header('Location: ../login/login.php');
            exit;
        }
    }

?>