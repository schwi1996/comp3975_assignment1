<?php

function custom_error_handler($errno, $errstr, $errfile, $errline) {
    $message = "Error: [$errno] $errstr\n$errfile: $errline";
    error_log($message . PHP_EOL, 3, __DIR__ . "/error_log.txt");
}

set_error_handler("custom_error_handler");