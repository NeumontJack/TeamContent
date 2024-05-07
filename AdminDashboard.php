<?php
session_start();

// Check if admin is logged in, redirect to login page if not
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: AdminLogin.php");
    exit;
}

// Include database connection file
require_once "config.php";

// Query to fetch existing pages
$sql = "SELECT * FROM pages";
$result = $mysqli->query($sql);

// Query to fetch existing categories
$sql_categories = "SELECT * FROM categories";
$result_categories = $mysqli->query($sql_categories);

// Query to fetch existing themes
$sql_themes = "SELECT * FROM themes";
$result_themes = $mysqli->query($sql_themes);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="StyleSheet.css"> <!-- Include CSS file -->
</head>
<body>

<div class="dashboard-container">
    <h2>Welcome to Admin Dashboard</h2>
    
    <h3>Manage Pages:</h3>
    <ul>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <li><?php echo $row['title']; ?> - <a href="edit_page.php?id=<?php echo $row['id']; ?>">Edit</a> | <a href="delete_page.php?id=<?php echo $row['id']; ?>">Delete</a></li>
        <?php } ?>
    </ul>
    
    <h3>Manage Categories:</h3>
    <ul>
        <?php while ($row_category = $result_categories->fetch_assoc()) { ?>
            <li><?php echo $row_category['name']; ?> - <a href="edit_category.php?id=<?php echo $row_category['id']; ?>">Edit</a> | <a href="delete_category.php?id=<?php echo $row_category['id']; ?>">Delete</a></li>
        <?php } ?>
    </ul>
    
    <h3>Choose Theme:</h3>
    <form action="update_theme.php" method="post">
        <select name="theme">
            <?php while ($row_theme = $result_themes->fetch_assoc()) { ?>
                <option value="<?php echo $row_theme['id']; ?>"><?php echo $row_theme['name']; ?></option>
            <?php } ?>
        </select>
        <input type="submit" value="Change Theme">
    </form>
    
    <br>
    <a href="AdminLogout.php">Logout</a>
</div>

</body>
</html>
