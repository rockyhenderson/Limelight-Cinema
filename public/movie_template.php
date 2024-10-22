<?php
// movie_template.php

// This page dynamically displays details for a single movie based on the movie ID passed in the URL (e.g., movie_template.php?id=23).
// It fetches movie data such as the title, rating, description, and photo from the database.
// Additionally, it includes a comment section where users can view and post comments related to the movie.
// This template is used for every movie, making the page content dynamic.
error_reporting(E_ALL);  // Report all PHP errors
ini_set('display_errors', 1);  // Ensure errors are shown on the page

include '../includes/db_connection.php';  // Include the database connection file

$conn = connectDB();  // Connect to the database

// Check if the movie ID is passed in the URL
if (isset($_GET['id'])) {
    $movie_id = $_GET['id'];

    // Debug: Output the movie ID to ensure it's being retrieved correctly
    echo "<p>Movie ID: " . $movie_id . "</p>";

    // Prepare and execute the SQL query to fetch movie details
    $sql = "SELECT title, rating, description, photo_url FROM movies WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        // If query preparation fails, print the error
        die("Error preparing query: " . $conn->error);
    }

    // Bind the movie ID to the query and execute
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();

    // Bind the results to variables
    $stmt->bind_result($title, $rating, $description, $photo_url);

    if ($stmt->fetch()) {
        // If the movie is found, display its details
        echo "<h1>" . $title . "</h1>";
        echo "<p>Rating: " . $rating . "</p>";
        echo "<p>Description: " . $description . "</p>";
        echo "<img src='" . $photo_url . "' alt='" . $title . "'>";
    } else {
        // If no movie is found, print a message
        echo "<p>Movie not found.</p>";
    }

    // Close the statement
    $stmt->close();
} else {
    // If no movie ID is passed in the URL, print an error message
    echo "<p>No movie ID provided.</p>";
}

// Close the database connection
$conn->close();
?>
