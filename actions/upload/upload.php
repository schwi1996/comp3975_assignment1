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
<a href="../landing/landing.php" class="btn btn-small btn-primary">BACK</a>
<!-- <div class="form-group">
                <a href="../landing/landing.php" class="btn btn-small btn-primary">BACK</a>
                &nbsp;&nbsp;&nbsp;
                <button type="button" id="submitBtn" class="btn btn-primary" onclick="submitForm()">Submit</button>
</div> -->

<!-- <script>
        function submitForm() {
            const fileInput = document.getElementById('fileInput');
            const file = fileInput.files[0];

            if (file) {
                const formData = new FormData();
                formData.append('csvFile', file);

                // You can now send this formData to your server using AJAX or other methods

                // You can also access the content of the file using FileReader and parse it as needed
                const reader = new FileReader();
                reader.onload = function (e) {
                    const csvContent = e.target.result;
                    console.log('CSV Content:', csvContent);
                    // You can parse and process the CSV content here
                };
                reader.readAsText(file);
            } else {
                alert('Please choose a CSV file to upload.');
            }
        }
    </script> -->

<?php include("../../setup/inc_footer.php"); ?>