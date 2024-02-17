<?php include("../../setup/inc_header.php"); ?>

<h1>Delete Transaction</h1>

<?php
    if (isset($_GET['id'])) {
    
        include("../../connect_database.php");

        $version = $db->querySingle('SELECT SQLITE_VERSION()');

        $id = $_GET['id'];
        $tableName = 'Transactions';

        // Check if ID exists
        $checkDuplicateQuery = "SELECT COUNT(*) AS 'rowCount' FROM $tableName WHERE TransactionId = ?";
        $checkStmt = $db->prepare($checkDuplicateQuery);
        $checkStmt->bindParam(1, $id, SQLITE3_TEXT);
        $result = $checkStmt->execute();
        $rowCount = $result->fetchArray(SQLITE3_NUM);
        $rowCount = $rowCount[0];


        if ($rowCount == 0) {
            // The specified ID doesn't exist in the database
            echo "<p class='alert alert-danger'>Transaction with ID $id does not exist.</p>";
            echo "<a href='../landing/landing.php' class='btn btn-small btn-primary'>&lt;&lt; BACK</a>";
            exit;
        }

        // Fetch student details
        $fetchQuery = "SELECT * FROM $tableName WHERE TransactionId = ?";
        $fetchStmt = $db->prepare($fetchQuery);
        $fetchStmt->bindParam(1, $id, SQLITE3_TEXT);
        $result = $fetchStmt->execute();
        $row = $result->fetchArray(SQLITE3_ASSOC);

        // Assign values to variables
        $TransactionId = $row['TransactionId'];
        $Date = $row['Date'];
        $Vendor = $row['Vendor'];
        $Spend = $row['Spend'];
        $Deposit = $row['Deposit'];
        $Balance = $row['Balance'];
    };

    $db->close();
?>

<table>
    <tr>
        <td>ID: </td>
        <td><?php echo $TransactionId ?></td>
    </tr>
    <tr>
        <td>Date: </td>
        <td><?php echo $Date ?></td>
    </tr>
    <tr>
        <td>Vendor: </td>
        <td><?php echo $Vendor ?></td>
    </tr>
    <tr>
        <td>Spend: </td>
        <td><?php echo $Spend ?></td>
    </tr>
    <tr>
        <td>Deposit: </td>
        <td><?php echo $Deposit ?></td>
    </tr>
    <tr>
        <td>Balance: </td>
        <td><?php echo $Balance ?></td>
    </tr>
</table>
<br />
<form action="process_delete.php" method="post">
    <input type="hidden" value="<?php echo $TransactionId ?>" name="TransactionId" />
    <a href="../landing/landing.php" class="btn btn-small btn-primary">BACK</a>
    &nbsp;&nbsp;&nbsp;
    <input type="submit" value="Delete" class="btn btn-danger" />
</form>

<br />


<?php include("../../setup/inc_footer.php"); ?>