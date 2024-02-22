<?php 
require_once('../../setup/config_session.inc.php');
require_once('../../utils.php');

echo $_SESSION['id'];


include("../../setup/inc_header.php"); 
    $error_message = isset($_GET['error']) ? $_GET['error'] : '';
?>

<h1>Create New Transaction</h1>

<div class="row">
    <div class="col-md-4">
        <form action="process_create.php" method="post">
            <div class="form-group">
                <label for="Date" class="control-label">Date</label>
                <input for="Date" class="form-control" name="Date" id="Date" required/>
            </div>

            <div class="form-group">
                <label for="Vendor" class="control-label">Vendor</label>
                <input for="Vendor" class="form-control" name="Vendor" id="Vendor" required/>
            </div>

            <div class="form-group">
                <label for="Spend" class="control-label">Spend</label>
                <input for="Spend" class="form-control" name="Spend" id="Spend" required/>
            </div>

            <div class="form-group">
                <label for="Deposit" class="control-label">Deposit</label>
                <input for="Deposit" class="form-control" name="Deposit" id="Deposit" required/>
            </div>

            <div class="form-group">
                <label for="Balance" class="control-label">Balance</label>
                <input for="Balance" class="form-control" name="Balance" id="Balance" required/>
            </div>

            <div class="form-group">
                <a href="../landing/landing.php" class="btn btn-small btn-primary">BACK</a>
                &nbsp;&nbsp;&nbsp;
                <input type="submit" value="Create" name="create" class="btn btn-success" />
            </div>
        </form>
    </div>
</div>

<?php include("../../setup/inc_footer.php"); ?>