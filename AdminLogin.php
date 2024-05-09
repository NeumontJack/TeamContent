<?php
session_start();

// Check if the admin is already logged in, redirect to dashboard if true
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: AdminDashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password from the form
    $input_username = $_POST["username"];
    $input_password = $_POST["password"];

    // Prepare a SQL statement to retrieve the admin details based on the username
    $sql = "SELECT admin_id, username, password FROM Admins WHERE username = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("s", $input_username);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Store result
            $stmt->store_result();

            // Check if username exists in the database
            if ($stmt->num_rows == 1) {
                // Bind result variables
                $stmt->bind_result($admin_id, $username, $hashed_password);

                // Fetch the result
                if ($stmt->fetch()) {
                    // Verify password
                    if (password_verify($input_password, $hashed_password)) {
                        // Password is correct, set session variables
                        $_SESSION['admin_logged_in'] = true;
                        $_SESSION['admin_id'] = $admin_id;
                        header("Location: AdminDashboard.php");
                        exit;
                    } else {
                        // Password is incorrect
                        $login_err = "Invalid username or password.";
                    }
                }
            } else {
                // Username doesn't exist
                $login_err = "Invalid username or password.";
            }
        } else {
            // Error executing SQL statement
            echo "Error executing SQL statement: " . $stmt->error;
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