<?php 
session_start();

// If the user is not logged in, redirect to the login page
if (!isset($_SESSION['authorized']) || $_SESSION['authorized'] !== true) {
    header('Location: ../login/login.php');
    exit;
}

include("../../setup/inc_header.php"); ?>

<h1>Welcome Back!</h1>

<form id="uploadForm" enctype="multipart/form-data">
        <label for="fileInput">Upload a CSV file to start organizing your finances!</label>
        <input type="file" id="fileInput" accept=".csv" required>
        <br><br>
        <button type="button" id="submitBtn" class="btn btn-primary" onclick="submitForm()">Submit</button>
        
</form>
<br><br>
<div class="form-group">
                <a href="../landing/landing.php" class="btn btn-small btn-primary">BACK</a>
                &nbsp;&nbsp;&nbsp;
                <input type="submit" value="Login" name="login" class="btn btn-success" />
</div>

<script>
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
    </script>

<?php include("../../setup/inc_footer.php"); ?>