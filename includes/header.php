<?php
// This is the reusable header file.
// It contains the navigation bar and branding elements that appear on every page of the website.
session_start();
// For now, just display "username" on the right side of the navbar
$username = "username";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        /* Simple navbar styling */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background-color: #4a90e2;
        }

        .navbar-left {
            display: flex;
            gap: 20px;
        }

        .navbar-left a {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }

        .navbar-left a:hover {
            text-decoration: underline;
        }

        .navbar-right {
            color: white;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-left">
            <a href="index.php">Home</a>
            <a href="movies.php">Movies</a>
        </div>
        <div class="navbar-right">
            <?php echo $username; ?>
        </div>
    </nav>
</body>
</html>

