<?php
session_start();

// Check if admin is logged in, redirect to login page if not
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: AdminLogin.php");
    exit;
}

// Include database connection file
require_once "dbConnection.php";

$mysqli = dbconnect();

// Check if category ID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: AdminDashboard.php");
    exit;
}

// Retrieve category ID from the URL
$category_id = $_GET['id'];

// Fetch category details from the database based on the provided ID
$sql = "SELECT * FROM categories WHERE id = ?";
if ($stmt = $mysqli->prepare($sql)) {
    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("i", $category_id);

    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        // Store result
        $result = $stmt->get_result();

        // Check if category exists
        if ($result->num_rows == 1) {
            // Fetch category details
            $category = $result->fetch_assoc();
        } else {
            // Category not found, redirect to dashboard
            header("Location: AdminDashboard.php");
            exit;
        }
    } else {
        echo "Error executing SQL statement.";
    }

    // Close statement
    $stmt->close();
}

// Handle form submission to update category name
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];

    // Update category name in the database
    $sql_update = "UPDATE categories SET name = ? WHERE id = ?";
    if ($stmt_update = $mysqli->prepare($sql_update)) {
        // Bind variables to the prepared statement as parameters
        $stmt_update->bind_param("si", $name, $category_id);

        // Attempt to execute the prepared statement
        if ($stmt_update->execute()) {
            // Redirect to admin dashboard after successful update
            header("Location: AdminDashboard.php");
            exit;
        } else {
            echo "Error updating category name.";
        }

        // Close statement
        $stmt_update->close();
    }
}

// Close connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <link rel="stylesheet" href="StyleSheet.css">
</head>
<body>

<div class="edit-category-container">
    <h2>Edit Category: <?php echo $category['name']; ?></h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $category_id; ?>" method="post">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="<?php echo $category['name']; ?>" class="form-control">
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Save">
        </div>
    </form>
</div>

</body>
</html>
