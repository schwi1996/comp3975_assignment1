<?php
require_once("../../setup/inc_header.php");
require_once('../../custom_error_handler.inc.php');
require_once('../../connect_database.php');
spl_autoload_register(function($className) {
    require_once("../../classes/$className.php");
});


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

        $file_name = pathinfo($_FILES['csvFile']['name'], PATHINFO_FILENAME);
        $path = '../../imports/' . $file_name . '.imported';
        if (!move_uploaded_file($csv_file, $path)) {
            echo "Error: Unable to move file.";
        }
    }
    $organizeResult = Transaction::updateBalance();
    
    Bucket::sortBucket(); 
    
    header('Location: /actions/landing/landing.php');

    $db -> close();
} else {
    echo "Error: No file uploaded.";
}


?>