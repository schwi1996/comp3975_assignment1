<?php 
require_once('../../setup/config_session.inc.php');
require_once('../../custom_error_handler.inc.php');
require_once('../../utils.php');
include("../../setup/inc_header.php"); ?>

<h1>Welcome Back!</h1>

<form action="process_upload.php" method="post" enctype="multipart/form-data">
    <label for="fileInput" style="display: block; margin-bottom: 10px;">Upload a CSV file to start organizing your finances!</label>
    <input type="file" name="csvFile" id="fileInput" style="margin-bottom: 10px;"/>
    
    <div style="display: flex; align-items: center;">
        <input type="submit" value="Upload" name="submit" style="background-color: #4CAF50; color: white; padding: 7px 14px; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px;"/>
        <a href="../landing/landing.php" class="btn btn-primary">Back</a>
    </div>

    <br><br>
</form>

<?php 
    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']);
    } 
?>



<?php include("../../setup/inc_footer.php"); ?>