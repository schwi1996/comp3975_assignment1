<?php
require_once('../../connect_database.php');
require_once('admin_model.inc.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['users'])) {
        $users = json_decode($_POST['users'], true); 

        foreach ($users as $user) {
            $userId = $user['userId'];
            $verifiedStatus = $user['verifiedStatus'] == 1 ? 1 : 0;

            $result = update_verified_status($db, $userId, $verifiedStatus);

            if (!$result) {
                exit();
            }
        }
    }
    exit();
}
?>