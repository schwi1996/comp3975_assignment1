<?php
include("../../../connect_database.php"); 
require_once("../../../setup/config_session.inc.php");
require_once("../../../utils.php");;

if ($_SESSION['role'] != 'admin') {
    header('Location: ../path/to/login_or_dashboard.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['Bucket_id'];
    $vendor = sanitize_input($_POST['Vendor']);
    $category = sanitize_input($_POST['Category']);
    
    // check if vendor and category are empty
    if (empty($vendor) || empty($category)) {
        $_SESSION['error'] = "Error: All fields are required.";
        header("Location: update_bucket.php");
        die();
    }

    // check if vendor is already paired with a category
    $check_duplicate_key = $db->querySingle("SELECT COUNT(*) as count FROM Buckets WHERE Vendor = '$vendor'");
    if ($check_duplicate_key > 0) {
        $_SESSION['error'] = "Error: Vendor is already paired with a category.";
        header("Location: update_bucket.php");
        die();
    }

    $stmt = $db->prepare("UPDATE Buckets SET Vendor = :vendor, Category = :category WHERE ID = :id");
    $stmt->bindValue(':vendor', $vendor, SQLITE3_TEXT);
    $stmt->bindValue(':category', $category, SQLITE3_TEXT);
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);

    if ($stmt->execute()) {
        unset($_SESSION['Bucket_id']);
        unset($_SESSION['Vendor']);
        unset($_SESSION['Category']);

        echo "Bucket updated successfully.";
        header("Location: ../../buckets/buckets.php");
    } else {
        echo "Error updating bucket.";
    }
} else {
    echo "Invalid request.";
    header("Location: ../../buckets/buckets.php");
}

$db->close();
?>
