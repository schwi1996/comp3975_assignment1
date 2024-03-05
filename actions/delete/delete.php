<?php 
require_once('../../setup/config_session.inc.php');
require_once('../../utils.php');
include("../../setup/inc_header.php"); ?>

<h1>Delete Transaction</h1>

<?php
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

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <tbody>
            <tr>
                <td style="width:25%;"><strong>ID:</strong></td>
                <td><?php echo $TransactionId ?></td>
            </tr>
            <tr>
                <td style="width:25%;"><strong>Date:</strong></td>
                <td><?php echo $Date ?></td>
            </tr>
            <tr>
                <td style="width:25%;"><strong>Vendor:</strong></td>
                <td><?php echo $Vendor ?></td>
            </tr>
            <tr>
                <td style="width:25%;"><strong>Spend:</strong></td>
                <td><?php echo $Spend ?></td>
            </tr>
            <tr>
                <td style="width:25%;"><strong>Deposit:</strong></td>
                <td><?php echo $Deposit ?></td>
            </tr>
            <tr>
                <td style="width:25%;"><strong>Balance:</strong></td>
                <td><?php echo $Balance ?></td>
            </tr>
        </tbody>
    </table>
</div>

<br />
<form action="process_delete.php" method="post">
    <input type="hidden" value="<?php echo $TransactionId ?>" name="TransactionId" />
    <a href="../landing/landing.php" class="btn btn-small btn-primary">BACK</a>
    &nbsp;&nbsp;&nbsp;
    <input type="submit" value="Delete" class="btn btn-danger" />
</form>

<br />


<?php include("../../setup/inc_footer.php"); ?>