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

// Check if page ID is provided in the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Handle the case where the page ID is not provided or invalid
    echo "Invalid page ID";
    exit;
}

// Retrieve page ID from the URL
$page_id = $_GET['id'];

// Fetch page details from the database based on the provided ID
$sql = "SELECT * FROM pages WHERE id = ?";
if ($stmt = $mysqli->prepare($sql)) {
    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("i", $page_id);

    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        // Store result
        $result = $stmt->get_result();

        // Check if page exists
        if ($result->num_rows == 1) {
            // Fetch page details
            $page = $result->fetch_assoc();
        } else {
            // Page not found, redirect to dashboard
            header("Location: AdminDashboard.php");
            exit;
        }
    } else {
        echo "Error executing SQL statement.";
        exit;
    }

    // Close statement
    $stmt->close();
}

// Handle form submission to update page content
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $content = htmlspecialchars($_POST["content"]); // Sanitize input

    // Update page content in the database
    $sql_update = "UPDATE pages SET content = ? WHERE id = ?";
    if ($stmt_update = $mysqli->prepare($sql_update)) {
        // Bind variables to the prepared statement as parameters
        $stmt_update->bind_param("si", $content, $page_id);

        // Attempt to execute the prepared statement
        if ($stmt_update->execute()) {
            // Redirect to admin dashboard after successful update
            header("Location: AdminDashboard.php");
            exit;
        } else {
            echo "Error updating page content.";
            exit;
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
    <title>Edit Page</title>
    <link rel="stylesheet" href="StyleSheet.css">
</head>
<body>

<div class="edit-page-container">
    <h2>Edit Page: <?php echo htmlspecialchars($page['title']); ?></h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $pa
