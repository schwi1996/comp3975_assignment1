<?php
    if (isset($_POST['create'])) {
        include("../../utils.php");
        // include("../../connect_database.php");

        spl_autoload_register(function($className) {
            require_once("../../classes/$className.php");
        });
        extract($_POST);

        // $version = $db->querySingle('SELECT SQLITE_VERSION()');

        // extract($_POST);

        $Date = sanitize_input($Date);
        $Vendor = sanitize_input($Vendor);
        $Spend = sanitize_input($Spend);
        $Deposit = sanitize_input($Deposit);
        $Balance = sanitize_input($Balance);
        
        $resultSet = Transaction::insertTransaction($Date, $Vendor, $Spend, $Deposit, $Balance);
        $organizeResult = Transaction::updateBalance();

        header('Location: ' . $resultSet);
        // include("../buckets/sort_buckets.php");
    }
?>