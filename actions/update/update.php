<?php 
require_once('../../setup/config_session.inc.php');
require_once('../../utils.php');
include("../../setup/inc_header.php"); ?>

<h1>Update Transaction</h1>

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

<div class="row">
    <div class="col-md-4">
        <form action="process_update.php" method="post">

            <div class="form-group">
                <input type="hidden" value="<?php echo $TransactionId ?>" name="TransactionId" />
                <label class="control-label">ID: </label>
                <?php echo $TransactionId ?>
            </div>

            <div class="form-group">
                <label for="Date" class="control-label">Date</label>
                <input for="Date" class="form-control" name="Date" id="Date" value="<?php echo $Date; ?>" />
            </div>

            <div class="form-group">
                <label for="Vendor" class="control-label">Vendor</label>
                <input for="Vendor" class="form-control" name="Vendor" id="Vendor" value="<?php echo $Vendor; ?>" />
            </div>

            <div class="form-group">
                <label for="Spend" class="control-label">Spend</label>
                <input for="Spend" class="form-control" name="Spend" id="Spend" value="<?php echo $Spend; ?>" />
            </div>

            <div class="form-group">
                <label for="Deposit" class="control-label">Deposit</label>
                <input for="Deposit" class="form-control" name="Deposit" id="Deposit" value="<?php echo $Deposit; ?>" />
            </div>

            <div class="form-group">
                <label for="Balance" class="control-label">Balance</label>
                <input for="Balance" class="form-control" name="Balance" id="Balance" value="<?php echo $Balance; ?>" />
            </div>

            <div class="form-group">
                <a href="../landing/landing.php" class="btn btn-small btn-primary">BACK</a>
                &nbsp;&nbsp;&nbsp;
                <input type="submit" value="Update" name="update" class="btn btn-warning" />
            </div>
        </form>
    </div>
</div>

<br />



<?php include("../../setup/inc_footer.php"); ?>