<?php
require_once("../../setup/inc_header.php");
require_once('../../custom_error_handler.inc.php');
require_once('../../connect_database.php');
// include("../buckets/process_buckets.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csvFile'])) {
    $csv_file = $_FILES['csvFile']['tmp_name'];

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
    }
    $db -> close();
    header('Location: /actions/landing/landing.php');
} else {
    echo "Error: No file uploaded.";
}


?>