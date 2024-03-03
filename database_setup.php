<?php

include("connect_database.php");

$version = $db->querySingle('SELECT SQLITE_VERSION()');

$SQL_create_users_table = "CREATE TABLE IF NOT EXISTS Users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    first_name VARCHAR(80) NOT NULL,
    last_name VARCHAR(80) NOT NULL,
    email VARCHAR(80) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    verified_status BOOLEAN DEFAULT 1,
    role VARCHAR(20) DEFAULT 'user'
);";

$db -> exec($SQL_create_users_table);

// Create Students table if it does not exist
$SQL_create_table = "CREATE TABLE IF NOT EXISTS Transactions (
    TransactionId INTEGER PRIMARY KEY AUTOINCREMENT,
    Date TEXT NOT NULL,
    Vendor TEXT NOT NULL,
    Spend REAL,
    Deposit REAL,
    Balance REAL
);";

$db->exec($SQL_create_table);

$SQL_create_buckets = "CREATE TABLE IF NOT EXISTS Buckets (
    id INTEGER,
    Date TEXT NOT NULL,
    Vendor TEXT NOT NULL,
    Category TEXT NOT NULL,
    FOREIGN KEY (id) REFERENCES Transactions(TransactionId)
);";

$db->exec($SQL_create_buckets);

// Check if table is empty
$tableName = 'Transactions';
$query_rows = $db ->query("SELECT COUNT(*) AS 'rowCount' FROM $tableName");
$result = $query_rows->fetchArray(SQLITE3_ASSOC);
$rowCount = $result['rowCount'];

if ($rowCount == 0) {
    echo "No transactions have been made yet!";
    exit;
    // $SQL_insert_data = "INSERT INTO Transactions (Date, Vendor, Spend, Deposit, Balance) VALUES
    // ('2021-01-01', 'Walmart', 100.00, 0.00, 500.00),
    // ('2021-01-02', 'Target', 50.00, 0.00, 450.00),
    // ('2021-01-03', 'Salary', 0.00, 200.00, 650.00),
    // ('2021-01-04', 'Best Buy', 150.00, 0.00, 500.00),
    // ('2021-01-05', 'Bonus', 0.00, 100.00, 600.00)
    // ";

    // $db->exec($SQL_insert_data);
    // include("actions/buckets/sort_buckets.php");
}

$resultSet = $db->query("SELECT * FROM $tableName");

// $col0 = $resultSet->columnName(0);
// $col1 = $resultSet->columnName(1);
// $col2 = $resultSet->columnName(2);
// $col3 = $resultSet->columnName(3);
// $col4 = $resultSet->columnName(4);
// $col5 = $resultSet->columnName(5);


echo "<div class='table-responsive'>";
echo "<table class='table table-hover table-bordered'>\n";
echo "<thead class='thead-dark'>";
echo "<table width='100%' class='table table-striped'>\n";
echo "<tr><th style='width:5%;'>ID</th>".
     "<th style='width:10%;'>Date</th>".
     "<th style='width:45%;'>Vendor</th>".
     "<th>Spend</th>".
     "<th>Deposit</th>".
     "<th>Balance</th>".
     "<th>Actions</th></tr>\n";
echo "</thead><tbody>";

while ($row = $resultSet->fetchArray()) {
    echo "<tr><td>{$row[0]}</td>";
    echo "<td>{$row[1]}</td>";
    echo "<td>{$row[2]}</td>";
    echo "<td>{$row[3]}</td>";
    echo "<td>{$row[4]}</td>";
    echo "<td>{$row[5]}</td>";
    echo "<td>";
    echo "<a class='btn btn-small btn-primary' href='/actions/update/update.php?id={$row[0]}'>Update</a>";
    echo "&nbsp;";
    echo "<a class='btn btn-small btn-danger' href='/actions/delete/delete.php?id={$row[0]}'>Delete</a>";
    echo "</td></tr>\n";
}
echo "</tbody></table>\n";
echo "</div>";

$db->close();

?>