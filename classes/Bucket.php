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

        public static function displayBucket($_id) {
            include(__DIR__ . "/../connect_database.php");

            $version = $db->querySingle('SELECT SQLITE_VERSION()');

            $tableName = 'Buckets';

            // Check if ID exists
            $checkDuplicateQuery = "SELECT COUNT(*) AS 'rowCount' FROM $tableName WHERE id= ?";
            $checkStmt = $db->prepare($checkDuplicateQuery);
            $checkStmt->bindParam(1, $_id, SQLITE3_TEXT);
            $result = $checkStmt->execute();
            $rowCount = $result->fetchArray(SQLITE3_NUM);
            $rowCount = $rowCount[0];


            if ($rowCount == 0) {
                // The specified ID doesn't exist in the database
                echo "<p class='alert alert-danger'>Bucket entry with ID $_id does not exist.</p>";
                echo "<a href='../landing/landing.php' class='btn btn-small btn-primary'>&lt;&lt; BACK</a>";
                exit;
            }

            // Fetch transaction details
            $fetchQuery = "SELECT * FROM $tableName WHERE id = ?";
            $fetchStmt = $db->prepare($fetchQuery);
            $fetchStmt->bindParam(1, $_id, SQLITE3_TEXT);
            $result = $fetchStmt->execute();
            $row = $result->fetchArray(SQLITE3_ASSOC);

            // Assign values to variables
            $id= $row['id'];
            $Vendor= $row['Vendor'];
            $Category= $row['Category'];

            $db->close();

            return [
                'Bucket_id' => $id,
                'Vendor' => $Vendor,
                'Category' => $Category
            ];
           
        }
    }


?>