<?php
    if (isset($_POST['update'])) {
        include("../../utils.php");
        spl_autoload_register(function($className) {
            require_once("../../classes/$className.php");
        });

        extract($_POST);

        $id = $_POST['TransactionId'];

        $Date = sanitize_input($Date);
        $Vendor = sanitize_input($Vendor);
        $Spend = sanitize_input($Spend);
        $Deposit = sanitize_input($Deposit);
        $Balance = sanitize_input($Balance);

        $resultSet1 = Transaction::updateTransaction($id, $Date, $Vendor, $Spend, $Deposit, $Balance);
        $organizeResult = Transaction::updateBalance();
        $resultSet2 = Bucket::deleteBucket($id);
        $resultSet3 = Bucket::singleSortBucket($id, $Date, $Vendor);
    }

    if (($resultSet1 && $resultSet2 && $resultSet3) !== false) {
        header('Location: ../landing/landing.php');
        exit;
    }
?>