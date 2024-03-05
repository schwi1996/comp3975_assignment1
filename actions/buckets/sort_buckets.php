<?php

    spl_autoload_register(function($className) {
        require_once("../../classes/$className.php");
    });

    $version = $db->querySingle('SELECT SQLITE_VERSION()');
    
    $resultSet = $db->query('SELECT * FROM Transactions');
    while ($row = $resultSet->fetchArray(SQLITE3_ASSOC)) {
        $id = $row['TransactionId'];
        $date = $row['Date'];
        $vendor = $row['Vendor'];
        
        $checkIdResult = Bucket::checkBucket($id);
        if ($checkIdResult > 0) {
            continue;  // Skip this iteration if the ID already exists
        }

        $sortResult = Bucket::sortBucket($db, $id, $date, $vendor);
    }

?>