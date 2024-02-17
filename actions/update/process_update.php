<?php
    if (isset($_POST['update'])) {
        include("../../utils.php");
        include("../../connect_database.php");

        $version = $db->querySingle('SELECT SQLITE_VERSION()');

        extract($_POST);

        $tableName = 'Transactions';

        $TransactionId = sanitize_input($TransactionId);
        $Date = sanitize_input($Date);
        $Vendor = sanitize_input($Vendor);
        $Spend = sanitize_input($Spend);
        $Deposit = sanitize_input($Deposit);
        $Balance = sanitize_input($Balance);

        // Prepare and execute the INSERT query
        $SQL_update_data = $db->prepare("UPDATE $tableName SET Date = :Date, Vendor = :Vendor, Spend = :Spend, Deposit = :Deposit, Balance = :Balance WHERE TransactionId = :TransactionId");
        
        // Bind parameters
        $SQL_update_data->bindValue(':TransactionId', $TransactionId, SQLITE3_TEXT);
        $SQL_update_data->bindValue(':Date', $Date, SQLITE3_TEXT);
        $SQL_update_data->bindValue(':Vendor', $Vendor, SQLITE3_TEXT);
        $SQL_update_data->bindValue(':Spend', $Spend, SQLITE3_TEXT);
        $SQL_update_data->bindValue(':Deposit', $Deposit, SQLITE3_TEXT);
        $SQL_update_data->bindValue(':Balance', $Balance, SQLITE3_TEXT);
        
        // Execute the query
        $resultSet = $SQL_update_data->execute();
        
        $db->close();
    }

    if ($resultSet !== false) {
        header('Location: ../landing/landing.php');
        exit;
    }
?>