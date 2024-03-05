<?php
// A custom error handler function to be included in other scripts 
// Logs customized script errors to error_log.txt file
function custom_error_handler($errno, $errstr, $errfile, $errline) {
    $message = "Error: [$errno] $errstr\n$errfile: $errline";
    error_log($message . PHP_EOL, 3, __DIR__ . "/error_log.txt");
}

// Set error handler so that custom_error_handler is invoked instead of the default PHP error handler
set_error_handler("custom_error_handler");