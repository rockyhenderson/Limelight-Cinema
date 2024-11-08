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

// Check if the request method is POST and 'comment_id' is provided
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment_id'])) {
    // Debug: Print raw value before converting
    echo "Raw comment ID received: " . $_POST['comment_id'] . "<br>";

    // Get the comment_id from the POST request
    $commentId = intval($_POST['comment_id']);
    echo "Converted comment ID: " . $commentId . "<br>";

    // Prepare the SQL statement to delete the movie
    $stmt = $conn->prepare("DELETE FROM comments WHERE id = ?");
    if ($stmt) {
        // Bind parameter
        $stmt->bind_param("i", $commentId);

        // Execute the query and check for errors
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "Comment deleted!";
            } else {
                echo "No comment found with the given ID: " . $commentId . ". Deletion not performed.<br>";
            }
        } else {
            echo "Failed to execute delete query: " . $stmt->error . "<br>";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Failed to prepare delete statement: " . $conn->error . "<br>";
    }
} else {
    echo "Error: Invalid request method or comment ID missing.<br>";
}

// Close the database connection
$conn->close();
?>
