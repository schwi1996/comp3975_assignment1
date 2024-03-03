<?php include("setup/inc_header.php"); 

require_once('connect_database.php');
require_once('database_setup.php');
require_once('custom_error_handler.inc.php');
?>


    
<h1>Welcome to the site</h1>

    <div class="buttons-container">
        <button class="action-button btn btn-small btn-primary" onclick="location.href='/actions/register/register.php' ">Register</button>
        <button class="action-button btn btn-small btn-success" onclick="location.href='/actions/login/login.php'">Login</button>
    </div>


<?php include("setup/inc_footer.php"); ?>