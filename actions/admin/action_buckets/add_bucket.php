<?php 
require_once('../../../setup/config_session.inc.php');
require_once('../../../utils.php');
include("../../../setup/inc_header.php");

// only allow admin to access this page
if (($_SESSION['role']) !== 'admin') {
    header('Location: ../../landing/landing.php');
    die();
}
?>


    <h1>Add New Bucket</h1>

    <?php
    if (isset($_SESSION['error'])) {
        echo "<div class='alert alert-danger' style='width: 30%'>
        <p class='error'>" . htmlspecialchars($_SESSION['error']) . "</p>";
        echo "</div>";
        unset($_SESSION['error']);
    }   
    ?>

    <form action="process_add_bucket.php" method="post">
        <div class="form-group">
            <label for="vendor">Vendor:</label>
            <input type="text" id="vendor" name="vendor" class="form-control" style="width: 20%";>
        </div>
        <div class="form-group">
            <label for="category">Category:</label>
            <input type="text" id="category" name="category" class="form-control" style="width: 20%">
        </div>
        <button type="submit" class="btn btn-success">Save</button>
        <button type="button" class="btn btn-primary" onclick="window.location.href='../../buckets/buckets.php'">Back</button>
    </form>

<?php include("../../../setup/inc_footer.php"); ?>