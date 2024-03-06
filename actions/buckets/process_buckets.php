<?php
include("../../connect_database.php");

$version = $db->querySingle('SELECT SQLITE_VERSION()');

$tableName = 'Buckets';
$resultSet = $db->query("SELECT * FROM $tableName");
echo "<div class='table-responsive'>";
echo "<table class='table table-hover table-bordered'>\n";
echo "<thead class='thead-dark'>";
echo "<table width='100%' class='table table-striped'>\n";
echo "<tr><th>Vendor</th>".
     "<th>Category</th></tr>\n";
echo "</thead><tbody>";

while ($row = $resultSet->fetchArray()) {
    echo "<tr><td>{$row[1]}</td>";
    echo "<td>{$row[2]}</td>";
    echo "<td>";
    echo "</td></tr>\n";
}
echo "</tbody></table>\n";
echo "</div>";

$db->close();

?>