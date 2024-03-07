<?php
require_once("../../../connect_database.php");
require_once("../../../utils.php");
require_once("../../../setup/config_session.inc.php");
spl_autoload_register(function($className) {
    require_once("../../../classes/$className.php");
});
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vendor = sanitize_input($_POST['vendor']);
    $category = sanitize_input($_POST['category']);

    $resultSet = Bucket::addBucket($vendor, $category);

    if ($resultSet) {
        echo "New bucket added successfully.";
        header("Location: ../../buckets/buckets.php");
    } else {
        echo "Error: Could not add new bucket.";
    }
}

$db->close();
?>
