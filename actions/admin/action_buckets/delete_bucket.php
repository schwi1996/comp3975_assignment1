<?php 
require_once('../../../setup/config_session.inc.php');
require_once('../../../utils.php');
include("../../../setup/inc_header.php"); ?>

<h1>Delete Bucket</h1>

<?php
    if (isset($_GET['id'])) {
    
        spl_autoload_register(function($className) {
            require_once("../../../classes/$className.php");
        });

        $id = $_GET['id'];
        // Fetch the bucket
        $resultSet = Bucket::displayBucket($id);
        $Bucket_id = $resultSet['Bucket_id'];
        $Vendor = $resultSet['Vendor'];
        $Category = $resultSet['Category'];
    };

    if (isset($_SESSION['error'])) {
        echo "<div class='alert alert-danger' style='width: 30%'>
        <p class='error'>" .
        htmlspecialchars($_SESSION['error']) . "</p>";
        echo "</div>";
        unset($_SESSION['error']);
    }
?>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <tbody>
            <tr>
                <td style="width:25%;"><strong>ID:</strong></td>
                <td><?php echo $Bucket_id ?></td>
            </tr>
            <tr>
                <td style="width:25%;"><strong>Vendor:</strong></td>
                <td><?php echo $Vendor ?></td>
            </tr>
            <tr>
                <td style="width:25%;"><strong>Category:</strong></td>
                <td><?php echo $Category ?></td>
            </tr>
        </tbody>
    </table>
</div>

<br />
<form action="process_delete_bucket.php" method="post">
    <input type="hidden" value="<?php echo $Bucket_id ?>" name="Bucket_id" />
    <a href="../../buckets/buckets.php" class="btn btn-small btn-primary">BACK</a>
    &nbsp;&nbsp;&nbsp;
    <input type="submit" value="Delete" class="btn btn-danger" />
</form>

<br />


<?php include("../../../setup/inc_footer.php"); ?>