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

        public static function checkBucket($_id) {
            include("../../connect_database.php");

            $version = $db->querySingle('SELECT SQLITE_VERSION()');
            $tableName = 'Buckets';
            $checkIdResult = $db->query("SELECT COUNT(*) AS 'count' FROM $tableName WHERE id = $_id");
            $checkId = $checkIdResult->fetchArray();
            return $checkId;
        }

        public static function sortBucket() {
            include("../../connect_database.php");

            $version = $db->querySingle('SELECT SQLITE_VERSION()');

            $keywords = [
                'Groceries' => ['walmart', 'safeway', 'supers', 'costco'],
                'Entertainment' => ['restaurat', 'restaurant', 'restauran','subway', 'mcdonalds', 'tim hortons', '7-eleven'],
                'Insurance' => ['icbc', 'msp'],
                'Utilities' => ['gas', 'shaw', 'rogers'],
                'Donations' => ['donation', 'charity', 'red cross'],
                'Salary' => ['deposit', 'pay']
                // Add more categories and keywords as needed
            ];
    
            $resultSet = $db->query('SELECT * FROM Transactions');
            while ($row = $resultSet->fetchArray(SQLITE3_ASSOC)) {
                $id = $row['TransactionId'];
                $date = $row['Date'];
                $vendor = $row['Vendor'];
                
                $version = $db->querySingle('SELECT SQLITE_VERSION()');
                $tableName = 'Buckets';
                $checkIdResult = $db->query("SELECT COUNT(*) AS 'count' FROM $tableName WHERE id = $id");
                $checkId = $checkIdResult->fetchArray();
                
                if ($checkId['count'] > 0) {
                    continue;  // Skip this iteration if the ID already exists
                }

                // Determine the category based on the vendor
                $category = 'Miscellaneous';  // Default category
                foreach ($keywords as $cat => $words) {
                    foreach ($words as $word) {
                        if (stripos(strtolower($vendor), strtolower($word)) !== false) {
                            $category = $cat;
                            break 2;  // Break out of both loops
                        }
                    }
                }

                // Insert the data into the Buckets table
                $SQL_insert_data = $db -> prepare("INSERT INTO $tableName (id, Date, Vendor, Category) VALUES (?, ?, ?, ?)");
                $SQL_insert_data->bindValue(1, $id, SQLITE3_INTEGER);
                $SQL_insert_data->bindValue(2, $date, SQLITE3_TEXT);
                $SQL_insert_data->bindValue(3, $vendor, SQLITE3_TEXT);
                $SQL_insert_data->bindValue(4, $category, SQLITE3_TEXT);
                $SQL_insert_data->execute();

            }

            $db->close();

            return '../landing/landing.php';
            
        }

        public static function singleSortBucket($_id, $_date, $_vendor) {
            include("../../connect_database.php");

            $version = $db->querySingle('SELECT SQLITE_VERSION()');

            $keywords = [
                'Groceries' => ['walmart', 'safeway', 'supers', 'costco'],
                'Entertainment' => ['restaurat', 'restaurant', 'restauran','subway', 'mcdonalds', 'tim hortons', '7-eleven'],
                'Insurance' => ['icbc', 'msp'],
                'Utilities' => ['gas', 'shaw', 'rogers'],
                'Donations' => ['donation', 'charity', 'red cross'],
                'Salary' => ['deposit', 'pay']
                // Add more categories and keywords as needed
            ];
                
            $tableName = 'Buckets';
            
            // Determine the category based on the vendor
            $category = 'Miscellaneous';  // Default category
            foreach ($keywords as $cat => $words) {
                foreach ($words as $word) {
                    if (stripos(strtolower($_vendor), strtolower($word)) !== false) {
                        $category = $cat;
                        break 2;  // Break out of both loops
                    }
                }
            }

            // Insert the data into the Buckets table
            $SQL_insert_data = $db -> prepare("INSERT INTO $tableName (id, Date, Vendor, Category) VALUES (?, ?, ?, ?)");
            $SQL_insert_data->bindValue(1, $_id, SQLITE3_INTEGER);
            $SQL_insert_data->bindValue(2, $_date, SQLITE3_TEXT);
            $SQL_insert_data->bindValue(3, $_vendor, SQLITE3_TEXT);
            $SQL_insert_data->bindValue(4, $category, SQLITE3_TEXT);
            $SQL_insert_data->execute();

            $db->close();

            return '../landing/landing.php';
        }
    }


?>