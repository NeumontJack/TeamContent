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

// Query to fetch existing pages
//$sql = "SELECT * FROM pages";
//$result = $mysqli->query($sql);

//// Query to fetch existing categories
//$sql_categories = "SELECT * FROM categories";
//$result_categories = $mysqli->query($sql_categories);

// Query to fetch existing themes
$sql_themes = "SELECT * FROM teamcontent.themes";
$result_themes = $mysqli->query($sql_themes);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="StyleSheet.css">
</head>
<body>

<div class="dashboard-container">
    <h2>Welcome to Admin Dashboard</h2>
    

         <h3>Choose Theme:</h3>
            <form action="UpdateTheme.php" method="post">
                <select name="theme">
                    <?php while ($row_theme = $result_themes->fetch_assoc()) { ?>
                        <option value="<?php echo $row_theme['theme_id']; ?>"><?php echo $row_theme['name']; ?></option>
                    <?php } ?>
                </select>
                <input type="submit" value="Change Theme">
            </form>
    
            <br>
            <a href="AdminLogout.php">Logout</a>
</div>

</body>
</html>
