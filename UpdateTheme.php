<?php
session_start();

// Check if admin is logged in, redirect to login page if not
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}

// Include database connection file
require_once "config.php";

// Check if theme ID is provided in the POST request
if (isset($_POST['theme'])) {
    // Retrieve theme ID from the POST data
    $theme_id = $_POST['theme'];

    // Update the theme preference for the admin in the database
    $sql = "UPDATE admins SET theme_id = ? WHERE admin_id = ?"; // Assumed: have a table for admins with a column 'theme_id'
    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("ii", $theme_id, $_SESSION['admin_id']); // Assumed: store admin_id in the session upon login

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Theme preference updated successfully
            header("Location: AdminDashboard.php");
            exit;
        } else {
            echo "Error updating theme preference.";
        }

        // Close statement
        $stmt->close();
    }
}

// Close connection
$mysqli->close();
?>
