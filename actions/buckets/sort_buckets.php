<?php
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
        $SQL_insert_data = $db -> prepare("INSERT INTO Buckets (id, Date, Vendor, Category) VALUES (?, ?, ?, ?)");
        $SQL_insert_data->bindValue(1, $id, SQLITE3_INTEGER);
        $SQL_insert_data->bindValue(2, $date, SQLITE3_TEXT);
        $SQL_insert_data->bindValue(3, $vendor, SQLITE3_TEXT);
        $SQL_insert_data->bindValue(4, $category, SQLITE3_TEXT);
        $SQL_insert_data->execute();
    }
?>