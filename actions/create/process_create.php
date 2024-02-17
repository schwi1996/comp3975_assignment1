<?php
    if (isset($_POST['create'])) {
        include("../../utils.php");
        include("../../connect_database.php");

        $version = $db->querySingle('SELECT SQLITE_VERSION()');

        extract($_POST);

        $tableName = 'Transactions';

        $Date = sanitize_input($Date);
        $Vendor = sanitize_input($Vendor);
        $Spend = sanitize_input($Spend);
        $Deposit = sanitize_input($Deposit);
        $Balance = sanitize_input($Balance);

        $SQL_insert_data = $db->prepare("INSERT INTO $tableName (Date, Vendor, Spend, Deposit, Balance) VALUES (:Date, :Vendor, :Spend, :Deposit, :Balance)");
        // Prepare and execute the INSERT query
        
        // Bind parameters
        $SQL_insert_data->bindValue(':Date', $Date, SQLITE3_TEXT);
        $SQL_insert_data->bindValue(':Vendor', $Vendor, SQLITE3_TEXT);
        $SQL_insert_data->bindValue(':Spend', $Spend, SQLITE3_TEXT);
        $SQL_insert_data->bindValue(':Deposit', $Deposit, SQLITE3_TEXT);
        $SQL_insert_data->bindValue(':Balance', $Balance, SQLITE3_TEXT);
        
        // Execute the query
        $resultSet = $SQL_insert_data->execute();

        include("../buckets/sort_buckets.php");
        
        $db->close();
    }

    if ($resultSet !== false) {
        header('Location: ../landing/landing.php');
        exit;
    }
?>