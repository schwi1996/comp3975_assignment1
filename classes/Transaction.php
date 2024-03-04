<?php

    class Transaction {

        public function __construct($_date, $_vendor, $_spend, $_deposit, $_balance) {
            $this->$_date = $_date;
            $this->$_vendor = $_vendor;
            $this->$_spend = $_spend;
            $this->$_deposit = $_deposit;
            $this->$_balance = $_balance;
        }

        public static function insertTransaction($_date, $_vendor, $_spend, $_deposit, $_balance) {
            include("../../connect_database.php");

            $version = $db->querySingle('SELECT SQLITE_VERSION()');

            $tableName = 'Transactions';

            $SQL_insert_data = $db->prepare("INSERT INTO $tableName (Date, Vendor, Spend, Deposit, Balance) VALUES (:Date, :Vendor, :Spend, :Deposit, :Balance)");
            // Prepare and execute the INSERT query
            
            // Bind parameters
            $SQL_insert_data->bindValue(':Date', $_date, SQLITE3_TEXT);
            $SQL_insert_data->bindValue(':Vendor', $_vendor, SQLITE3_TEXT);
            $SQL_insert_data->bindValue(':Spend', $_spend, SQLITE3_TEXT);
            $SQL_insert_data->bindValue(':Deposit', $_deposit, SQLITE3_TEXT);
            $SQL_insert_data->bindValue(':Balance', $_balance, SQLITE3_TEXT);
            
            // Execute the query
            $resultSet = $SQL_insert_data->execute();
            
            $db->close();

            return '../landing/landing.php';
            
        }

        public static function displayTransaction($_id) {
            include("../../connect_database.php");

            $version = $db->querySingle('SELECT SQLITE_VERSION()');

            $tableName = 'Transactions';

            // Check if ID exists
            $checkDuplicateQuery = "SELECT COUNT(*) AS 'rowCount' FROM $tableName WHERE TransactionId = ?";
            $checkStmt = $db->prepare($checkDuplicateQuery);
            $checkStmt->bindParam(1, $_id, SQLITE3_TEXT);
            $result = $checkStmt->execute();
            $rowCount = $result->fetchArray(SQLITE3_NUM);
            $rowCount = $rowCount[0];


            if ($rowCount == 0) {
                // The specified ID doesn't exist in the database
                echo "<p class='alert alert-danger'>Transaction with ID $_id does not exist.</p>";
                echo "<a href='../landing/landing.php' class='btn btn-small btn-primary'>&lt;&lt; BACK</a>";
                exit;
            }

            // Fetch transaction details
            $fetchQuery = "SELECT * FROM $tableName WHERE TransactionId = ?";
            $fetchStmt = $db->prepare($fetchQuery);
            $fetchStmt->bindParam(1, $_id, SQLITE3_TEXT);
            $result = $fetchStmt->execute();
            $row = $result->fetchArray(SQLITE3_ASSOC);

            // Assign values to variables
            $TransactionId = $row['TransactionId'];
            $Date = $row['Date'];
            $Vendor = $row['Vendor'];
            $Spend = $row['Spend'];
            $Deposit = $row['Deposit'];
            $Balance = $row['Balance'];

            $db->close();

            return [
                'TransactionId' => $TransactionId,
                'Date' => $Date,
                'Vendor' => $Vendor,
                'Spend' => $Spend,
                'Deposit' => $Deposit,
                'Balance' => $Balance
            ];
           
        }

        public static function updateBalance() {
            include("../../connect_database.php");

            $version = $db->querySingle('SELECT SQLITE_VERSION()');

            $tableName = 'Transactions';

            $query_rows = $db ->query("SELECT COUNT(*) AS 'rowCount' FROM $tableName");
            $result = $query_rows->fetchArray(SQLITE3_ASSOC);
            $rowCount = $result['rowCount'];

            if ($rowCount == 0) {
                $db->close();
                return;
            }

            // Fetch the earliest transaction
            $earliestTransaction = $db->querySingle("SELECT * FROM $tableName ORDER BY Date ASC LIMIT 1", true);

            // Set the starting balance to the balance of the earliest transaction
            $balance = $earliestTransaction['Balance'];
            // TODO: What if there is an incorrect input for balance in the first transaction?

            // Fetch all transactions except the earliest one, sorted by date
            $resultSet = $db->query("SELECT * FROM $tableName WHERE TransactionId != {$earliestTransaction['TransactionId']} ORDER BY Date ASC");

            while ($row = $resultSet->fetchArray(SQLITE3_ASSOC)) {
                $balance -= floatval($row['Spend']);
                $balance += floatval($row['Deposit']);

                // Update the Balance column for the current row
                $db->exec("UPDATE $tableName SET Balance = $balance WHERE TransactionId = {$row['TransactionId']}");
            }

            $db->close();
        }

        public static function printTransactions() {
            include("../../connect_database.php");
            $version = $db->querySingle('SELECT SQLITE_VERSION()');
            
            $tableName = 'Transactions';

            $query_rows = $db ->query("SELECT COUNT(*) AS 'rowCount' FROM $tableName");
            $result = $query_rows->fetchArray(SQLITE3_ASSOC);
            $rowCount = $result['rowCount'];

            if ($rowCount == 0) {
                // $SQL_insert_data = "INSERT INTO Transactions (Date, Vendor, Spend, Deposit, Balance) VALUES
                // ('2021-01-01', 'Walmart', 100.00, 0.00, 500.00),
                // ('2021-01-02', 'Target', 50.00, 0.00, 450.00),
                // ('2021-01-03', 'Salary', 0.00, 200.00, 650.00),
                // ('2022-01-04', 'Best Buy', 150.00, 0.00, 500.00),
                // ('2019-01-05', 'Bonus', 0.00, 100.00, 600.00),
                // ('2023-01-06', 'Amazon', 200.00, 0.00, 400.00),
                // ('2024-01-07', 'Salary', 0.00, 300.00, 700.00),
                // ('2021-01-29', 'Walmart', 100.00, 0.00, 600.00),
                // ('2009-01-16', 'Amazon', 300.00, 0.00, 300.00),
                // ('2011-01-10', 'Salary', 0.00, 400.00, 700.00)
                // ";
                // $db->exec($SQL_insert_data);
                echo "<h3>No transactions have been made yet!</h3>";
                exit;
            }

            $resultSet = $db->query("SELECT * FROM $tableName ORDER BY Date ASC");

            echo "<div class='table-responsive'>";
            echo "<table class='table table-hover table-bordered'>\n";
            echo "<thead class='thead-dark'>";
            // echo "<table width='100%' class='table table-striped'>\n";
            echo "<tr><th style='width:5%;'>ID</th>".
                "<th style='width:10%;'>Date</th>".
                "<th style='width:45%;'>Vendor</th>".
                "<th>Spend</th>".
                "<th>Deposit</th>".
                "<th>Balance</th>".
                "<th>Actions</th></tr>\n";
            echo "</thead><tbody>";

            while ($row = $resultSet->fetchArray(SQLITE3_ASSOC)) {
                echo "<tr><td>{$row['TransactionId']}</td>";
                echo "<td>{$row['Date']}</td>";
                echo "<td>{$row['Vendor']}</td>";
                echo "<td>{$row['Spend']}</td>";
                echo "<td>{$row['Deposit']}</td>";
                echo "<td>{$row['Balance']}</td>";
                echo "<td>";
                echo "<a class='btn btn-small btn-primary' href='/actions/update/update.php?id={$row['TransactionId']}'>Update</a>";
                echo "&nbsp;";
                echo "<a class='btn btn-small btn-danger' href='/actions/delete/delete.php?id={$row['TransactionId']}'>Delete</a>";
                echo "</td></tr>\n";
            }
            echo "</tbody></table>\n";
            echo "</div>";
            $db->close();
        }

        public static function deleteTransaction($_id) {
            include("../../connect_database.php");

            $version = $db->querySingle('SELECT SQLITE_VERSION()');

            $tableName = 'Transactions';

            // Prepare and execute the INSERT query
            $SQL_delete_data = $db->prepare("DELETE FROM $tableName WHERE TransactionId = :TransactionId");
        
            // Bind parameters
            $SQL_delete_data->bindValue(':TransactionId', $_id, SQLITE3_INTEGER);
        
            // Execute the query
            $resultSet = $SQL_delete_data->execute();

            $db->close();

            return $resultSet;
        }

        public static function updateTransaction($_id, $_date, $_vendor, $_spend, $_deposit, $_balance) {
            include("../../connect_database.php");

            $version = $db->querySingle('SELECT SQLITE_VERSION()');

            $tableName = 'Transactions';

            // Prepare and execute the INSERT query
            $SQL_update_data = $db->prepare("UPDATE $tableName SET Date = :Date, Vendor = :Vendor, Spend = :Spend, Deposit = :Deposit, Balance = :Balance WHERE TransactionId = :TransactionId");


            // Bind parameters
            $SQL_update_data->bindValue(':TransactionId', $_id, SQLITE3_INTEGER);
            $SQL_update_data->bindValue(':Date', $_date, SQLITE3_TEXT);
            $SQL_update_data->bindValue(':Vendor', $_vendor, SQLITE3_TEXT);
            $SQL_update_data->bindValue(':Spend', $_spend, SQLITE3_TEXT);
            $SQL_update_data->bindValue(':Deposit', $_deposit, SQLITE3_TEXT);
            $SQL_update_data->bindValue(':Balance', $_balance, SQLITE3_TEXT);
            
            // Execute the query
            $resultSet = $SQL_update_data->execute();
            
            $db->close();

            return $resultSet;
        }
    }

?>