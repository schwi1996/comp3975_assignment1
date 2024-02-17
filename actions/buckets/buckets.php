<?php 
require_once('../../utils.php');
session_start();
checkUserAuthentication();

include("../../setup/inc_header.php"); ?>

<h1>View Buckets</h1>

<?php
include("../../connect_database.php");

$version = $db->querySingle('SELECT SQLITE_VERSION()');
// Fetch all transactions
$resultSet = $db->query('SELECT * FROM Transactions');

if ($resultSet->fetchArray() === false) {
    // No transactions
    echo "<p>No transactions made yet.</p>";
    echo '<div class="form-group">';
    echo '<a href="../landing/landing.php" class="btn btn-small btn-primary">BACK</a>';
    echo '</div>';
} else {
    // Transactions exist
    include("process_buckets.php");

    echo '<div class="form-group">';
    echo '<a href="../landing/landing.php" class="btn btn-small btn-primary">BACK</a>';
    echo '</div>';
}

$db->close();
?>

<?php include("../../setup/inc_footer.php"); ?>