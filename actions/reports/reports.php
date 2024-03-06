<?php include("../../setup/inc_header.php"); ?>
<?php 
    include("../../utils.php");
    include("../../connect_database.php");
?>

<h1>View Reports</h1>

<div class="form-group">
    <a href="../landing/landing.php" class="btn btn-small btn-primary">BACK</a>
</div>

<form action="" method="post">
    <label for="year">Select Year:</label>
    <select id="year" name="year">
        <?php for($i = date('Y'); $i >= 1970; $i--): ?>
            <option value="<?php echo $i; ?>" <?php if(isset($_POST['year']) && $_POST['year'] == $i) echo 'selected'; ?>><?php echo $i; ?></option>
        <?php endfor; ?>
    </select>
    <input type="submit" value="Submit" name="submit">
</form>

<?php 
    if (isset($_POST['year'])) {
        $year = $_POST['year'];
        $tableName = "Transactions";

        $checkYear = "SELECT Category, SUM(Spend) as totalSpend FROM $tableName WHERE SUBSTR(Date, 1, 4) = :year GROUP BY Category";
        $stmt = $db->prepare($checkYear);
        $stmt->bindValue(':year', $year, SQLITE3_TEXT);
        $resultSet = $stmt->execute();

        $dataPoints = [];
        while ($row = $resultSet->fetchArray(SQLITE3_ASSOC)) {
            $dataPoints[] = array("label" => $row['Category'], "y" => $row['totalSpend']);
        }
    }

    $db->close();
?>

<?php if (!empty($dataPoints)): ?> <!-- Check if $dataPoints is not empty -->
    <script>
        window.onload = function() {
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                title: {text: "Category Spendings for <?php echo $year; ?>"},
                data: [{
                    type: "pie",
                    yValueFormatString: "#,##0.00\"\"",
                    indexLabel: "{label} (${y})",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();
        }
    </script>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    
    <div class="d-flex justify-content-center">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Category</th>
                    <th scope="col">Total Spendings</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataPoints as $dataPoint): ?>
                    <tr>
                        <td><?php echo $dataPoint['label']; ?></td>
                        <td>$<?php echo $dataPoint['y']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    </br>
    <p>No transactions recorded for the selected year.</p>
<?php endif; ?>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<?php include("../../setup/inc_footer.php"); ?>