<?php 
require_once('../../setup/config_session.inc.php');
require_once('../../custom_error_handler.inc.php');
require_once('../../utils.php');
include("../../setup/inc_header.php"); ?>

<h1>Welcome Back!</h1>

<form action="process_upload.php" method="post" enctype="multipart/form-data">
    <label for="fileInput">Upload a CSV file to start organizing your finances!</label>
    <input type="file" name="csvFile" id="fileInput"/>
    <input type="submit" value="Upload" name="submit"/>
    <br><br>
</form>

<?php 
if ($_SESSION['role'] == 'admin') {
    echo '<a href="../admin/admin.php" class="btn btn-small btn-primary">BACK</a>';
} else {
    echo '<a href="../landing/landing.php" class="btn btn-small btn-primary">BACK</a>';
}

include("../../setup/inc_footer.php"); 
?>