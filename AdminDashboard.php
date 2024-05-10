<?php
session_start();
include("AdminMenu.php");

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

// If a theme change request is submitted, update the database with the selected theme
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['theme'])) {
    $theme_id = $_POST['theme'];
    $admin_id = $_SESSION['admin_id']; // Assuming you have an admin ID stored in the session
    $update_sql = "UPDATE admins SET theme_id = ? WHERE admin_id = ?";
    $stmt = $mysqli->prepare($update_sql);
    $stmt->bind_param("ii", $theme_id, $admin_id);
    $stmt->execute();
    // Update the session with the new theme ID
    $_SESSION['theme'] = $theme_id;
}

// Retrieve the admin's theme preference from the database and store it in the session
$admin_id = $_SESSION['admin_id']; // Assuming you have an admin ID stored in the session
$select_sql = "SELECT theme_id FROM admins WHERE admin_id = ?";
$stmt = $mysqli->prepare($select_sql);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$stmt->bind_result($theme_id);
$stmt->fetch();
$_SESSION['theme'] = $theme_id;
$stmt->close();

// Determine the CSS file based on the retrieved theme ID
$css_file = '';
$theme_id = $_SESSION['theme'];
switch ($theme_id) {
    case 1:
        $css_file = 'theme1.css';
        break;
    case 2:
        $css_file = 'theme2.css';
        break;
    case 3:
        $css_file = 'theme3.css';
        break;
    default:
        $css_file = 'StyleSheet.css';
        break;
}

echo $_SESSION['theme'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="<?php echo $css_file ?>">
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
