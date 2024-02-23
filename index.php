<?php include("setup/inc_header.php"); 

require_once('connect_database.php');

$SQL_create_users_table = "CREATE TABLE IF NOT EXISTS Users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    first_name VARCHAR(80) NOT NULL,
    last_name VARCHAR(80) NOT NULL,
    email VARCHAR(80) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    verified_status BOOLEAN DEFAULT 1,
    role VARCHAR(20) DEFAULT 'user'
);";

$db -> exec($SQL_create_users_table);
?>


    
<h1>Welcome to the site</h1>

    <div class="buttons-container">
        <button class="action-button btn btn-small btn-primary" onclick="location.href='/actions/register/register.php' ">Register</button>
        <button class="action-button btn btn-small btn-success" onclick="location.href='/actions/login/login.php'">Login</button>
    </div>


<?php include("setup/inc_footer.php"); ?>