<?php
include("../../connect_database.php");
require_once("../../setup/config_session.inc.php");

$version = $db->querySingle('SELECT SQLITE_VERSION()');

$tableName = 'Buckets';
$resultSet = $db->query("SELECT * FROM $tableName");
echo "<div class='table-responsive'>";
echo "<table class='table table-hover table-bordered'>\n";
echo "<thead class='thead-dark'>";
echo "<table width='100%' class='table table-striped'>\n";
echo "<tr><th>Vendor</th>".
     "<th>Category</th>";

if ($_SESSION['role'] == 'admin') {
    echo "<th>Actions</th>";

}

echo "</tr>\n";
echo "</thead><tbody>";

while ($row = $resultSet->fetchArray()) {
    echo "<tr><td>{$row[1]}</td>";
    echo "<td>{$row[2]}</td>";
    echo "<td>";

    if ($_SESSION['role'] == 'admin') {
        echo "<a class='btn btn-small btn-primary' href='../admin/action_buckets/update_bucket.php?id={$row[0]}'>Update</a>";
        echo "&nbsp;";
        echo "<a class='btn btn-small btn-danger' href='../admin/action_buckets/delete_bucket.php?id={$row[0]}'>Delete</a>";
    }

    echo "</td></tr>\n";
}
echo "</tbody></table>\n";
echo "</div>";

$db->close();

?>