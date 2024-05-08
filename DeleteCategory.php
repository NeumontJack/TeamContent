<?php
session_start();

// Check if admin is logged in, redirect to login page if not
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: AdminLogin.php");
    exit;
}

// Include database connection file
require_once "root@localhost:3306";

// Check if category ID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: AdminDashboard.php");
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
        echo "Error deleting category.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$mysqli->close();
?>
