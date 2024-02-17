<?php 
session_set_cookie_params(3600); // 1 hour session cookie
session_start();
include("../../setup/inc_header.php"); 
?>

<h1>Login as Existing User</h1>

<div class="row">
    <div class="col-md-4">

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($_SESSION['error']); ?>
            </div>
        <?php 
            unset($_SESSION['error']); // remove the error message from the session, so it doesn't appear again
        endif; ?>

        <form action="login_process.php" method="post">

            <div class="form-group">
                <label for="Email" class="control-label">Email</label>
                <input for="email" class="form-control" name="Email" id="Email" required/>
            </div>

            <div class="form-group">
                <label for="Password" class="control-label">Password</label>
                <input for="password" class="form-control" name="Password" id="Password" required/>
                <input type="checkbox" id="togglePassword"> Show Password
            </div>

            <div class="form-group">
                <a href="../../index.php" class="btn btn-small btn-primary">BACK</a>
                &nbsp;&nbsp;&nbsp;
                <input type="submit" value="Login" name="login" class="btn btn-success" />
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