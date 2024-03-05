<?php
session_start();
require_once("../../setup/inc_header.php");
require_once('../../custom_error_handler.inc.php');
require_once('../../connect_database.php');
// include("../buckets/process_buckets.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] == 0) {
        $csv_file = $_FILES['csvFile']['tmp_name'];
        
        $imports_dir = __DIR__ . '/../../imports';
        if (!is_dir($imports_dir)) {
            if (!mkdir($imports_dir, 0777, true)) {
                $_SESSION['error'] = "Error: Unable to create imports directory.";
                header('Location: /actions/upload/upload.php');
                die();
            }
        }

        if (($handle = fopen($csv_file, 'r')) !== false) {
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

            $file_name = pathinfo($_FILES['csvFile']['name'], PATHINFO_FILENAME);
            $path = $imports_dir .  '/' . $file_name . '.imported';
            if (!move_uploaded_file($csv_file, $path)) {
                echo "Error: Unable to move file.";
            }
        }
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