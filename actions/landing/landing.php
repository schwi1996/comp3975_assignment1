<?php 
require_once('../../utils.php');
require_once('../../setup/config_session.inc.php');
include("../../setup/inc_header.php"); ?>

<h1>Welcome Back, <?php echo ucfirst($_SESSION['first_name']); ?>!</h1>

<?php
if ($_SESSION['role'] == 'admin') {
    echo "<button onclick=\"location.href='../admin/admin.php'\" class='btn btn-secondary'>View Users</button>";
}
?>

<form action="../logout/logout.php" method="post" style="display: inline;">
        <input type="hidden" name="action" value="logout">
        <button type="submit" class='btn btn-secondary'>Log Out</button>
</form>

</br>
</br>

<button onclick="location.href='../buckets/buckets.php'" class="btn btn-primary">View Buckets</button>
<button onclick="location.href='../reports/reports.php'" class="btn btn-primary">View Reports</button>
<button onclick="location.href='../upload/upload.php'" class="btn btn-primary">Upload CSV</button>
<button onclick="location.href='../create/create.php'" class="btn btn-success">Create New Transaction</button>
</br>
</br>
<?php 
    spl_autoload_register(function($className) {
        require_once("../../classes/$className.php");
    });
    include("../../database_setup.php");
    Transaction::printTransactions(); 
?>

<?php include("../../setup/inc_footer.php"); ?>