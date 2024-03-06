<?php
    if (isset($_POST['TransactionId'])) {
        include("../../utils.php");
        spl_autoload_register(function($className) {
            require_once("../../classes/$className.php");
        });

        extract($_POST);
        $id = $_POST['TransactionId'];
        $resultSet = Transaction::deleteTransaction($id);
        $organizeResult = Transaction::updateBalance();
        header('Location: ' . $resultSet);
    }
?>