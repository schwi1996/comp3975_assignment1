<?php 
session_start();

// If the user is not logged in, redirect to the login page
if (!isset($_SESSION['authorized']) || $_SESSION['authorized'] !== true) {
    header('Location: ../login/login.php');
    exit;
}

include("../../setup/inc_header.php"); ?>

<h1>Welcome Back!</h1>



<?php include("../../setup/inc_footer.php"); ?>