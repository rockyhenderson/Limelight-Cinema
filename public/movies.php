<?php
// movies.php

include '../includes/db_connection.php';  // Include the database connection file
include '../includes/header.php'; 
$conn = connectDB();  // Connect to the database

// Fetch all movies from the database
$sql = "SELECT id, title, rating FROM movies";
$result = $conn->query($sql);

if ($result === false) {
    // If query fails, print the SQL error
    echo "<div class='error'>Error: " . $conn->error . "</div>";
} elseif ($result->num_rows > 0) {
    echo "<div class='movie-list'>";
    // Display each movie
    while ($row = $result->fetch_assoc()) {
        echo "<div class='movie-item'>";
        echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
        echo "<p>Rating: " . htmlspecialchars($row['rating']) . "</p>";
        echo "<a href='movie_template.php?id=" . urlencode($row['id']) . "'>View Details</a>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<div class='no-movies'>No movies found.</div>";
}

$conn->close();  // Close the database connection
?>
