<?php

    class Bucket {
        public function __construct($_id, $_date, $_vendor, $_category) {
            $this->$_id = $_id;
            $this->$_date = $_date;
            $this->$_vendor = $_vendor;
            $this->$_category = $_category;
        }

        public static function deleteBucket($_id) {
            include("../../connect_database.php");

            $version = $db->querySingle('SELECT SQLITE_VERSION()');

            $tableName = 'Buckets';

            // Prepare and execute the INSERT query
            $SQL_delete_data = $db->prepare("DELETE FROM $tableName WHERE id = :TransactionId");
        
            // Bind parameters
            $SQL_delete_data->bindValue(':TransactionId', $_id, SQLITE3_INTEGER);
        
            // Execute the query
            $resultSet = $SQL_delete_data->execute();

            $db->close();

            return $resultSet;
        }

        public static function singleSortBucket($_vendor) {
            include("../../connect_database.php");

            $version = $db->querySingle('SELECT SQLITE_VERSION()');
            // if ($_spend == NULL || $_spend == 0) {
            //     return '../landing/landing.php';
            // }
                
            $tableName = 'Buckets';
            
            $selectQuery = "SELECT Category FROM $tableName WHERE LOWER(?) LIKE LOWER('%' || Vendor || '%')";
            $selectStmt = $db->prepare($selectQuery);

            // Bind the vendor to the vendor parameter in the SQL statement
            $selectStmt->bindParam(1, $_vendor, SQLITE3_TEXT);
            $result = $selectStmt->execute();

            // Fetch the category
            $selectResult = $result->fetchArray(SQLITE3_ASSOC);

            // If no category was found, set it to 'Miscellaneous'
            if ($selectResult === false || !isset($selectResult['Category'])) {
                $category = 'Miscellaneous';
            } else {
                $category = $selectResult['Category'];
            }
        
            return $category;
        }

        public static function loadDefaultBuckets($db) {
            $keywords = [
                'walmart' => 'Groceries',
                'safeway' => 'Groceries',
                'supers' => 'Groceries',
                'costco' => 'Groceries',
                'restaurant' => 'Entertainment',
                'subway' => 'Entertainment',
                'mcdonalds' => 'Entertainment',
                'tim hortons' => 'Entertainment',
                '7-eleven' => 'Entertainment',
                'icbc' => 'Insurance',
                'msp' => 'Insurance',
                'gas' => 'Utilities',
                'shaw' => 'Utilities',
                'rogers' => 'Utilities',
                'donation' => 'Donations',
                'charity' => 'Donations',
                'red cross' => 'Donations',
            ];
            $tableName = 'Buckets';
            $stmt = $db->prepare("INSERT INTO $tableName (Category, Vendor) VALUES (:category, :vendor)");
            
            foreach ($keywords as $keyword => $category) {
                $stmt->bindValue(':category', $category, SQLITE3_TEXT);
                $stmt->bindValue(':vendor', $keyword, SQLITE3_TEXT);
                $stmt->execute();
            }
            
            if ($stmt) {
                return;
            }
        }
    }


?>