<?php
session_start();

// Check if admin is logged in, redirect to login page if not
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: AdminLogin.php");
    exit;
}

// Include database connection file
require_once "dbConnection.php";

// Check if page ID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: AdminDashboard.php");
    exit;
}

// Retrieve page ID from the URL
$page_id = $_GET['id'];

// Delete page from the database
$sql = "DELETE FROM pages WHERE id = ?";
if ($stmt = $mysqli->prepare($sql)) {
    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("i", $page_id);

    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        // Redirect to admin dashboard after successful deletion
        header("Location: AdminDashboard.php");
        exit;
    } else {
        echo "Error deleting page.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$mysqli->close();
?>
