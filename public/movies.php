<?php
// movies.php

// This page lists all available movies in the cinema.
// It fetches movie data from the database, such as the title and rating,
// and displays them in a list format. Each movie links to its detailed page (movie_template.php).
// The page is accessible to all users, allowing them to browse through the available movies.
include '../includes/db_connection.php';  // Include the database connection file
include '../includes/header.php'; 
$conn = connectDB();  // Connect to the database

// Fetch all movies from the database
$sql = "SELECT id, title, rating FROM movies";
$result = $conn->query($sql);

if ($result === false) {
    // If query fails, print the SQL error
    echo "Error: " . $conn->error;
} elseif ($result->num_rows > 0) {
    // Display each movie
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h2>" . $row['title'] . "</h2>";
        echo "<p>Rating: " . $row['rating'] . "</p>";
        echo "<a href='movie_template.php?id=" . $row['id'] . "'>View Details</a>";
        echo "</div>";
    }
} else {
    echo "No movies found.";
}

$conn->close();  // Close the database connection
?>
