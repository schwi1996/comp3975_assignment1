<?php 
require_once('../../setup/config_session.inc.php');
require_once('../../utils.php');
include("../../setup/inc_header.php"); ?>

<h1>Update Transaction</h1>

<?php
    $error_message = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
    $TransactionId = $Date = $Vendor = $Spend = $Deposit = $Balance = ''; // Initialize variables
    if (isset($_GET['id'])) {

        spl_autoload_register(function($className) {
            require_once("../../classes/$className.php");
        });

        $id = $_GET['id'];
        $resultSet = Transaction::displayTransaction($id);
        $TransactionId = $resultSet['TransactionId'];
        $Date = $resultSet['Date'];
        $Vendor = $resultSet['Vendor'];
        $Spend = $resultSet['Spend'];
        $Deposit = $resultSet['Deposit'];
        $Balance = $resultSet['Balance'];
    };
?>

<div class="row">
    <div class="col-md-4">
        <?php if (!empty($error_message)): ?>
            <!-- Display error message as a pop-up -->
            <div class="alert alert-danger">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <form action="process_update.php" method="post">
            <div class="form-group">
                <input type="hidden" value="<?php echo $TransactionId ?>" name="TransactionId" />
                <label class="control-label">ID: </label>
                <?php echo $TransactionId ?>
            </div>

            <div class="form-group">
                <label for="Date" class="control-label">Date</label>
                <input type="text" class="form-control" name="Date" id="Date" value="<?php echo $Date; ?>" required />
            </div>

            <div class="form-group">
                <label for="Vendor" class="control-label">Vendor</label>
                <input type="text" class="form-control" name="Vendor" id="Vendor" value="<?php echo $Vendor; ?>" required />
            </div>

            <div class="form-group">
                <label for="Spend" class="control-label">Spend</label>
                <input type="text" class="form-control" name="Spend" id="Spend" value="<?php echo $Spend; ?>" required />
            </div>

            <div class="form-group">
                <label for="Deposit" class="control-label">Deposit</label>
                <input type="text" class="form-control" name="Deposit" id="Deposit" value="<?php echo $Deposit; ?>" required />
            </div>

            <div class="form-group">
                <label for="Balance" class="control-label">Balance</label>
                <input type="text" class="form-control" name="Balance" id="Balance" value="<?php echo $Balance; ?>" required />
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