<?php
    if (isset($_POST['TransactionId'])) {
        include("../../utils.php");
        spl_autoload_register(function($className) {
            require_once("../../classes/$className.php");
        });

        extract($_POST);
        $id = $_POST['TransactionId'];
        $resultSet1 = Transaction::deleteTransaction($id);
        $organizeResult = Transaction::updateBalance();
        $resultSet2 = Bucket::deleteBucket($id);
    }

    if (($resultSet1 && $resultSet2) !== false) {
        header('Location: ../landing/landing.php');
        exit;
    }
?>