<?php 
require_once('../../utils.php');
require_once('../../setup/config_session.inc.php');
include("../../setup/inc_header.php"); ?>

<h1>Welcome Back!</h1>

<button onclick="location.href='../buckets/buckets.php'" class="btn btn-primary">View Buckets</button>
<button onclick="location.href='../reports/reports.php'" class="btn btn-primary">View Reports</button>
<button onclick="location.href='../upload/upload.php'" class="btn btn-primary">Upload CSV</button>
<button onclick="location.href='../create/create.php'" class="btn btn-success">Create New Transaction</button>
</br>
</br>

<?php include("../../database_setup.php"); ?>

<?php include("../../setup/inc_footer.php"); ?>