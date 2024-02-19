<?php
define('BYPASS_AUTH', true);

require_once('../../setup/config_session.inc.php');
include("../../setup/inc_header.php"); 
require_once('register_view.inc.php');
?>

<h1>Register New User</h1>

<div class="row">
    <div class="col-md-4">

        <?php check_register_errors(); ?>

        <form action="register_contr.inc.php" method="post">
            <div class="form-group">
                <label for="FirstName" class="control-label">First Name</label>
                <input for="FirstName" class="form-control" name="FirstName" id="FirstName"/>
            </div>

            <div class="form-group">
                <label for="LastName" class="control-label">Last Name</label>
                <input for="LastName" class="form-control" name="LastName" id="LastName"/>
            </div>

            <div class="form-group">
                <label for="Email" class="control-label">Email</label>
                <input for="email" class="form-control" name="Email" id="Email"/>
            </div>

            <div class="form-group">
                <label for="Password" class="control-label">Password</label>
                <input for="password" class="form-control" name="Password" id="Password"/>
                <input type="checkbox" id="togglePassword"> Show Password
            </div>


            <div class="form-group">
                <a href="../../index.php" class="btn btn-small btn-primary">BACK</a>
                &nbsp;&nbsp;&nbsp;
                <input type="submit" value="Register" name="register" class="btn btn-success" />
            </div>
        </form>

        <script>
            var password = document.getElementById('Password');
            var togglePassword = document.getElementById('togglePassword');

            togglePassword.addEventListener('change', function() {
                if (this.checked) {
                    password.type = 'text';
                } else {
                    password.type = 'password';
                }
            });
        </script>
    </div>
</div>

<?php include("../../setup/inc_footer.php"); ?>