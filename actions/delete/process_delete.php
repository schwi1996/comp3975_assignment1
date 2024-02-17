<?php
    if (isset($_POST['TransactionId'])) {
        include("../../utils.php");
        include("../../connect_database.php");

        $version = $db->querySingle('SELECT SQLITE_VERSION()');

        extract($_POST);

        $tableName = 'Transactions';

        $id = $_POST['TransactionId'];

        // Prepare and execute the INSERT query
        $SQL_delete_data = $db->prepare("DELETE FROM $tableName WHERE TransactionId = :TransactionId");
        
        // Bind parameters
        $SQL_delete_data->bindValue(':TransactionId', $id, SQLITE3_TEXT);
        
        // Execute the query
        $resultSet = $SQL_delete_data->execute();
        
        $db->close();
    }

    if ($resultSet !== false) {
        header('Location: ../landing/landing.php');
        exit;
    }
?>