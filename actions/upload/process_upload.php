<?php
session_start();
require_once("../../setup/inc_header.php");
require_once('../../custom_error_handler.inc.php');
require_once('../../connect_database.php');
// include("../buckets/process_buckets.php");

function check_file_type($file) {
    $file_type = pathinfo($file['name'], PATHINFO_EXTENSION);
    if ($file_type !== 'csv') {
        $_SESSION['error'] = "Only CSV files can be uploaded.";
        header('Location: /actions/upload/upload.php');
        die();
    }
}

function create_imports_dir($dir) {
    if (!is_dir($dir)) {
        if (!mkdir($dir, 0777, true)) {
            $_SESSION['error'] = "Error: Unable to create imports directory.";
            header('Location: /actions/upload/upload.php');
            die();
        }
    }
}

function process_CSV_file($file, $db, $dir) {
    if (($handle = fopen($file['tmp_name'], 'r')) !== false) {
        while (($row = fgetcsv($handle)) !== false) {
            $stmt = $db -> prepare('INSERT INTO Transactions (Date, Vendor, Spend, Deposit, Balance) VALUES (:date, :vendor, :spend, :deposit, :balance)');
            $stmt -> bindValue(':date', $row[0]);
            $stmt -> bindValue(':vendor', $row[1]);
            $stmt -> bindValue(':spend', $row[2]);
            $stmt -> bindValue(':deposit', $row[3]);
            $stmt -> bindValue(':balance', $row[4]);

            $stmt -> execute();
        }
        fclose($handle);

        $file_name = pathinfo($file['name'], PATHINFO_FILENAME);
        $path = $dir .  '/' . $file_name . '.imported';
        if (!move_uploaded_file($file['tmp_name'], $path)) {
            echo "Error: Unable to move file.";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] == 0) {
        check_file_type($_FILES['csvFile']);

        $imports_dir = __DIR__ . '/../../imports';
        create_imports_dir($imports_dir);

        process_CSV_file($_FILES['csvFile'], $db, $imports_dir);

        $db -> close();
        header('Location: /actions/landing/landing.php');
        die();
    } else {
        $_SESSION['error'] = "Please select a file to upload.";
        header('Location: /actions/upload/upload.php');
        die();
    }
} else {
    echo "Error: Invalid request.";
}
?>