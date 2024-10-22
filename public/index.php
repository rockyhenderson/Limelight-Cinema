<?php
// This is the main landing page of the cinema website.
// It displays movie listings, showtimes, and links to member login, registration, and booking pages.
include '../includes/db_connection.php';  // Include the database connection file

$conn = connectDB();  // Try to connect to the database

if ($conn) {
    echo "<h1>Database connection successful!</h1>";
} else {
    echo "<h1>Database connection failed!</h1>";
    echo "Error: " . $conn->connect_error;  // Print the connection error
}

$conn->close();  // Close the connection
?>
