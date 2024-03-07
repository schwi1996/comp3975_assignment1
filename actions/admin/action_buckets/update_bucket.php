<?php
require_once("../../../connect_database.php");
require_once("../../../setup/config_session.inc.php");
require_once("../../../setup/inc_header.php");

if ($_SESSION['role'] != 'admin') {
    header('Location: ../../landing/landing.php');
    exit();
}

if (isset($_GET['id'])) {

    spl_autoload_register(function($className) {
        require_once("../../../classes/$className.php");
    });

    $id = $_GET['id'];
    $resultSet = Bucket::displayBucket($id);
    $_SESSION["Bucket_id"]= $resultSet['Bucket_id'];
    $_SESSION['Vendor'] = $resultSet['Vendor'];
    $_SESSION['Category'] = $resultSet['Category'];
};
?>

<h1>Update Bucket</h1>

    <?php
    if (isset($_SESSION['error'])) {
        echo "<div class='alert alert-danger' style='width: 30%'>
        <p class='error'>" . htmlspecialchars($_SESSION['error']) . "</p>";
        echo "</div>";
        unset($_SESSION['error']);
    }
    ?>

<div class="row">
    <div class="col-md-4">
        <form action="process_update_bucket.php" method="post">

            <div class="form-group">
                <input type="hidden" value="<?php echo $_SESSION["Bucket_id"]?>" name="Bucket_id" />
                <label class="control-label">ID: </label>
                <?php echo $_SESSION["Bucket_id"] ?>
            </div>

            <div class="form-group">
                <label for="Vendor" class="control-label">Vendor</label>
                <input for="Vendor" class="form-control" name="Vendor" id="Vendor" value="<?php echo $_SESSION['Vendor']; ?>" />
            </div>

            <div class="form-group">
                <label for="Category" class="control-label">Category</label>
                <input for="Category" class="form-control" name="Category" id="Category" value="<?php echo $_SESSION['Category']; ?>" />
            </div>

            <div class="form-group">
                <a href="../../buckets/buckets.php" class="btn btn-small btn-primary">BACK</a>    
                &nbsp;&nbsp;&nbsp;
                <input type="submit" value="Update" name="update" class="btn btn-warning" />
            </div>
        </form>
    </div>
</div>

<?php include("../../../setup/inc_footer.php"); ?>