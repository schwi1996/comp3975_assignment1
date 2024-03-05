<?php
include("../../setup/inc_header.php");
require_once('../../setup/config_session.inc.php');
require_once('../../custom_error_handler.inc.php');
require_once('../../connect_database.php');

if ($_SESSION['role'] !== 'admin') {
    header('Location: /actions/landing/landing.php');
    exit();
}

// require_once('admin_model.inc.php');
// $users = get_all_users($db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome Back Admin!</h1>    

    <button onclick="location.href='../landing/landing.php'" class="btn btn-secondary">Back</button>

    <?php include('admin_view.inc.php'); ?>

    <?php include("../../setup/inc_footer.php");?>
</body>
</html>