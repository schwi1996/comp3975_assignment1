<?php
session_start();
require_once('../../custom_error_handler.inc.php');
require_once('../../connect_database.php');
spl_autoload_register(function($className) {
    require_once("../../classes/$className.php");
});
require_once("../../setup/inc_header.php");

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
            
            // Convert date from MM/DD/YYYY to YYYY-MM-DD
            $date = DateTime::createFromFormat('m/d/Y', $row[0])->format('Y-m-d');
            $category = Bucket::singleSortBucket($row[1]);
            if ($row[2] == '') {
                $row[2] = 0;
            }
            if ($row[3] == '') {
                $row[3] = 0;
            }
            $stmt = $db -> prepare('INSERT INTO Transactions (Date, Vendor, Spend, Deposit, Balance, Category) VALUES (:date, :vendor, :spend, :deposit, :balance, :category)');
            $stmt -> bindValue(':date', $date);
            $stmt -> bindValue(':vendor', $row[1]);
            $stmt -> bindValue(':spend', $row[2]);
            $stmt -> bindValue(':deposit', $row[3]);
            $stmt -> bindValue(':balance', $row[4]);
            $stmt -> bindValue(':category', $category);

            $stmt -> execute();
        }
        fclose($handle);

        $file_name = pathinfo($file['name'], PATHINFO_FILENAME);
        $path = $dir .  '/' . $file_name . '.imported';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] == 0) {
        check_file_type($_FILES['csvFile']);

        $imports_dir = __DIR__ . '/../../imports';
        create_imports_dir($imports_dir);

        process_CSV_file($_FILES['csvFile'], $db, $imports_dir);
        $organizeResult = Transaction::updateBalance();
        
        $db -> close();
        header('Location: /actions/landing/landing.php');
        exit();
    } else {
        $_SESSION['error'] = "Please select a file to upload.";
        header('Location: /actions/upload/upload.php');
        exit();
    }
}
?>