<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection
include '../../includes/db_connection.php';

// Create a connection by calling the function
$conn = connectDB();

// Check if the connection works
if ($conn) {
    echo "Database connection successful!<br>";
} else {
    echo "Database connection failed: " . mysqli_connect_error();
    exit;
}

// Debug: Print the request method and POST data to confirm what is received
echo "Request Method: " . $_SERVER['REQUEST_METHOD'] . "<br>";
echo "POST Data: ";
print_r($_POST);
echo "<br>";

// Check if the request method is POST and 'comment_id' is provided
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment_id'])) {
    // Get the comment_id from the POST request
    $commentId = intval($_POST['comment_id']);
    echo "Received comment ID: " . $commentId;
} else {
    echo "Error: Invalid request method or comment ID missing.";
}

// Close the database connection
$conn->close();
?>
