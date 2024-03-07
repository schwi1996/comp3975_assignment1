<?php
include("../../../connect_database.php"); 
require_once("../../../setup/config_session.inc.php");
require_once("../../../utils.php");;
spl_autoload_register(function($className) {
    require_once("../../../classes/$className.php");
});

if ($_SESSION['role'] != 'admin') {
    header('Location: ../path/to/login_or_dashboard.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['Bucket_id'];
    $vendor = sanitize_input($_POST['Vendor']);
    $category = sanitize_input($_POST['Category']);
    
    $resultSet = Bucket::updateBucket($id, $vendor, $category);

    if ($resultSet) {
        unset($_SESSION['Bucket_id']);
        unset($_SESSION['Vendor']);
        unset($_SESSION['Category']);

        header("Location: ../../buckets/buckets.php");
    }
} else {
    header("Location: ../../buckets/buckets.php");
}

$db->close();
?>
