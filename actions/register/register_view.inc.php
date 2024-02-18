<?php

declare(strict_types=1);

function check_register_errors() {

    if (isset($_SESSION['errors_register'])) {
        $errors = $_SESSION['errors_register'];

        $display_errors = "<div class='alert alert-danger'>";

        foreach ($errors as $error) {
            $display_errors .= "<p class='error'>" . htmlspecialchars($error) . "</p>";
        }
        $display_errors .= "</div>";

        echo $display_errors;

        unset($_SESSION['errors_register']);
    }
}