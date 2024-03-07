<?php 
require_once('../../setup/config_session.inc.php');
require_once('../../utils.php');

include("../../setup/inc_header.php"); ?>

<h1>View Buckets</h1>

<?php

include("../../connect_database.php");


$version = $db->querySingle('SELECT SQLITE_VERSION()');
// Fetch all transactions
$resultSet = $db->query('SELECT * FROM Buckets');

if ($resultSet->fetchArray() === false) {
    echo '<div class="form-group">';
    if ($_SESSION['role'] === 'admin') {
        echo '<a href="../admin/action_buckets/add_bucket.php" class="btn btn-small btn-success" style="margin-right: 8px;">Add Bucket</a>';
    }
    echo '<a href="../landing/landing.php" class="btn btn-small btn-primary">BACK</a>';
    echo '</div>';
    
    // No buckets exist
    echo "<p>No buckets have been made yet.</p>";
    
} else {
    echo '<div class="form-group">';
    if ($_SESSION['role'] === 'admin') {
        echo '<a href="../admin/action_buckets/add_bucket.php" class="btn btn-small btn-success" style="margin-right: 8px;">Add Bucket</a>';
    }
    echo '<a href="../landing/landing.php" class="btn btn-small btn-primary">BACK</a>';
    echo '</div>';
    
    // Buckets exist
    include("process_buckets.php");
}

$db->close();
?>

<?php include("../../setup/inc_footer.php"); ?>