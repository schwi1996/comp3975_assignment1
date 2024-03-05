<?php
include("../../setup/inc_header.php");
require_once('../../connect_database.php');
require_once('../../custom_error_handler.inc.php');
require_once('admin_model.inc.php');

$users = get_all_users($db);

if (empty($users)) {
    echo '<div class="alert alert-info" role="alert">No users found.</div>';
} else {
    echo '<div class="container mt-3">';
    echo '<h2>Users List</h2>';
    echo '<table class="table table-striped table-hover">'; 
    echo '<thead class="thead-dark">'; 
    echo '<tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Verified</th>
        </tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($users as $user) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($user['id']) . '</td>';
        echo '<td>' . htmlspecialchars($user['first_name']) . '</td>';
        echo '<td>' . htmlspecialchars($user['last_name']) . '</td>';
        echo '<td>' . htmlspecialchars($user['email']) . '</td>';

        echo '<td>';
        echo '<div class="custom-control custom-switch">';
        echo '<input type="checkbox" class="custom-control-input" id="user' 
            . $user['id'] . '" ' 
            . ($user['verified_status'] == 1 ? 'checked' : '') 
            . ' onchange="storeChange(' 
            . $user['id'] . ')">';
        echo '<label class="custom-control-label" for="user' . $user['id'] . '"></label>';
        echo '</div>';
        echo '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '<button type="button" class="btn btn-primary" onclick="saveChanges()">Save Changes</button>';
    echo '</div>';
}

?>

<script>
function saveChanges() {
    // Check which boxes are checked 
    var dataToSend = [];
    $('.custom-control-input').each(function() {
        var userId = this.id.replace('user', '');
        var verifiedStatus = $(this).is(':checked') ? 1 : 0;
        dataToSend.push({userId: userId, verifiedStatus: verifiedStatus});
    });

    $.ajax({
        url: 'admin_contr.inc.php', 
        type: 'POST',
        data: {users: JSON.stringify(dataToSend)},
        success: function(response) {
            alert('Update successful!');
        },
        error: function(xhr, status, error) {
            alert('Error updating user statuses.');
        }
    });
}
</script>

