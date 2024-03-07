<?php
require_once('../../setup/config_session.inc.php');
require_once('../../custom_error_handler.inc.php');
require_once('../../connect_database.php');

if ($_SESSION['role'] !== 'admin') {
    header('Location: /actions/landing/landing.php');
    exit();
}

include("../../setup/inc_header.php");
?>

<h1>Welcome Back Admin!</h1>    

<button onclick="location.href='../landing/landing.php'" class="btn btn-secondary">Back</button>

<?php include('admin_view.inc.php'); ?>

<?php include("../../setup/inc_footer.php");?>
