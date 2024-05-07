<?php
session_start();

// Check if the admin is already logged in, redirect to dashboard if true
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admin_dashboard.php");
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the username and password are correct (You need to replace these with your actual credentials check)
    $username = "admin";
    $password = "password";

    if ($_POST["username"] === $username && $_POST["password"] === $password) {
        // Authentication successful, set session variables
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        // Authentication failed
        $login_err = "Invalid username or password.";
    }
}
?>



<div class="login-container">
    <h2>Admin Login</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Login">
        </div>
        <?php if (isset($login_err)) { ?>
            <div class="alert alert-danger"><?php echo $login_err; ?></div>
        <?php } ?>
    </form>
</div>
