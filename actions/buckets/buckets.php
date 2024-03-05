<?php 
require_once('../../setup/config_session.inc.php');
require_once('../../utils.php');

include("../../setup/inc_header.php"); ?>

<h1>View Buckets</h1>

<?php

include("../../connect_database.php");


$version = $db->querySingle('SELECT SQLITE_VERSION()');
// Fetch all transactions
$resultSet = $db->query('SELECT * FROM Transactions');

if ($resultSet->fetchArray() === false) {
    echo '<div class="form-group">';
    echo '<a href="../landing/landing.php" class="btn btn-small btn-primary">BACK</a>';
    echo '</div>';
    
    // No transactions
    echo "<p>No transactions have been made yet.</p>";
    
} else {
    echo '<div class="form-group">';
    echo '<a href="../landing/landing.php" class="btn btn-small btn-primary">BACK</a>';
    echo '</div>';
    
    // Transactions exist
    include("process_buckets.php");

    
}

$db->close();
?>

<?php include("../../setup/inc_footer.php"); ?>