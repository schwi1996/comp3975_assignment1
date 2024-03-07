<?php
require_once("../../../connect_database.php");
require_once("../../../utils.php");
require_once("../../../setup/config_session.inc.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vendor = sanitize_input($_POST['vendor']);
    $category = sanitize_input($_POST['category']);

    if (empty($vendor) || empty($category)) {
        $_SESSION['error'] = "Error: All fields are required.";
        header("Location: add_bucket.php");
        die();
    }

    $check_duplicate_key = $db->querySingle("SELECT COUNT(*) as count FROM Buckets WHERE Vendor = '$vendor'");
    if ($check_duplicate_key > 0) {
        $_SESSION['error'] = "Error: Vendor is already paired with a category.";
        header("Location: add_bucket.php");
        die();
    }

    $stmt = $db->prepare("INSERT INTO Buckets (Vendor, Category) VALUES (:vendor, :category)");

    $stmt->bindValue(':vendor', $vendor, SQLITE3_TEXT);
    $stmt->bindValue(':category', $category, SQLITE3_TEXT);

    if ($stmt->execute()) {
        echo "New bucket added successfully.";
        header("Location: ../../buckets/buckets.php");
    } else {
        echo "Error: Could not add new bucket.";
    }
}

$db->close();
?>
