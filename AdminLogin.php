<?php
session_start();

// Check if the admin is already logged in, redirect to dashboard if true
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: AdminDashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection file
    require_once "dbConnection.php";
    $mysqli = dbconnect();

    // Sanitize input
    $username = mysqli_real_escape_string($mysqli, $_POST["username"]);
    $password = mysqli_real_escape_string($mysqli, $_POST["password"]);

    // Query the database for the provided username and password
    $sql = "SELECT * FROM admins WHERE username = ? AND password = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("ss", $username, $password);
        // Execute query
        $stmt->execute();
        // Store result
        $result = $stmt->get_result();
        // Check if a row exists
        if ($result->num_rows == 1) {
            // Authentication successful, set session variables
            $_SESSION['admin_logged_in'] = true;
            // Fetch the admin ID and store it in the session for later use
            $row = $result->fetch_assoc();
            $_SESSION['admin_id'] = $row['admin_id'];
            // Redirect to the dashboard
            header("Location: AdminDashboard.php");
            exit;
        } else {
            // Authentication failed
            $login_err = "Invalid username or password.";
        }
        // Close statement
        $stmt->close();
    }
    // Close connection
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="StyleSheet.css">
</head>
<body>
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

</body>
</html>