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
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Handle the case where the category ID is not provided or invalid
    echo "Invalid category ID";
    exit;
}

// Retrieve category ID from the URL
$category_id = $_GET['id'];

// Delete category from the database
$sql = "DELETE FROM categories WHERE id = ?";
if ($stmt = $mysqli->prepare($sql)) {
    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("i", $category_id);

    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        // Redirect to admin dashboard after successful deletion
        header("Location: AdminDashboard.php");
        exit;
    } else {
        // Handle the case where there's an error with the database query
        echo "Error deleting category.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$mysqli->close();

?>
