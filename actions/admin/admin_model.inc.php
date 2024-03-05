<?php
require_once('../../custom_error_handler.inc.php');

function get_all_users($db) {
    $stmt = $db -> prepare('SELECT * FROM Users WHERE role != "admin"');
    $result = $stmt -> execute();
    
    $users = [];
    while ($row = $result -> fetchArray()) {
        $users[] = $row;
    }

    return $users;
}

function update_verified_status($db, $userId, $verifiedStatus) {
    $stmt = $db -> prepare('UPDATE Users SET verified_status = :verifiedStatus WHERE id = :id');
    $stmt -> bindValue(':verifiedStatus', $verifiedStatus, SQLITE3_INTEGER);
    $stmt -> bindValue(':id', $userId, SQLITE3_INTEGER);
    return $stmt->execute();
}
?>