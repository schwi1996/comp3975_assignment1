<?php
require_once("../../../connect_database.php");
require_once("../../../setup/config_session.inc.php");
spl_autoload_register(function($className) {
    require_once("../../../classes/$className.php");
});

if ($_SESSION['role'] != 'admin') {
    header('Location: ../../landing/landing.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bucketId = $_POST['Bucket_id'];

    $resultSet = Bucket::deleteBucket($bucketId);
    
    if ($resultSet) {
        echo "Bucket deleted successfully.";
        header("Location: ../../buckets/buckets.php");
    }
} else {
    $_SESSION['error'] = "Invalid request";
    header("Location: ../../process_delete_bucket.php");
}

$db->close();
