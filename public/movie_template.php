<?php
// movie_template.php

error_reporting(E_ALL);  // Report all PHP errors
ini_set('display_errors', 1);  // Ensure errors are shown on the page

include '../includes/db_connection.php';  // Include the database connection file
$conn = connectDB();  // Connect to the database

// Check if the movie ID is passed in the URL
if (isset($_GET['id'])) {
    $movie_id = $_GET['id'];

    // Prepare and execute the SQL query to fetch movie details
    $sql = "SELECT title, rating, photo_url, description, runtime, genres, rotten_tomatoes, imdb_score FROM movies WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        // If query preparation fails, print the error
        die("Error preparing query: " . $conn->error);
    }

    // Bind the movie ID to the query and execute
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();

    // Bind the results to variables
    $stmt->bind_result($title, $rating, $photo_url, $description, $runtime, $genres, $rotten_tomatoes, $imdb_score);

    if ($stmt->fetch()) {
        // Split genres into an array
        $genres_array = json_decode($genres, true);
    } else {
        // If no movie is found, print a message and exit
        die("<p>Movie not found.</p>");
    }

    // Close the statement
    $stmt->close();
} else {
    // If no movie ID is passed in the URL, print an error message and exit
    die("<p>No movie ID provided.</p>");
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($title); ?></title>
    <script src="https://kit.fontawesome.com/b6b5f43622.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../public/css/styles.css">
</head>
<body>
    <div class="mobile">
        <div class="head-icons">
            <i class="fa-solid fa-arrow-left fa-2xl" style="color: white"></i>
            <div class="icon-wrapper-div">
                <i class="fa-solid fa-heart fa-2xl" style="color: white"></i>
                <i class="fa-solid fa-arrow-up-from-bracket fa-2xl" style="color: white"></i>
            </div>
        </div>
        <div class="head-wrapper">
        <div class="header-image" style="background-image: url('../public/src/<?php echo htmlspecialchars($photo_url); ?>');"></div>
            <div class="movie-head-wrapper">
                <div class="movie-info">
                    <div id="movie-title-container">
                        <h1 id="movie-title"><?php echo htmlspecialchars($title); ?></h1>
                    </div>
                    <p id="movie-genre"><?php echo htmlspecialchars(implode(', ', $genres_array)); ?> | <?php echo htmlspecialchars($runtime); ?>m</p>

                    <div class="info-wrapper">
                        <div class="age-language">
                            <p class="pill"><?php echo htmlspecialchars($rating); ?></p>
                            <p class="pill">English</p> <!-- STATIC FOR NOW CHANGE LATER -->
                        </div>
                        <div class="ratings">
                            <div id="imdb-rating" style="display: flex; align-items: center; height: 25px">
                                <img src="../public/src/IMDbLogo.png" alt="IMDb logo" style="height: 25px" />
                                <p style="margin-left: 5px"><?php echo htmlspecialchars($imdb_score); ?></p>
                            </div>
                            <p style="margin: 0px; margin-left: 15px; margin-right: 20px">|</p>
                            <div id="rottentom-rating" style="display: flex; align-items: center; height: 25px">
                                <img src="../public/src/RottenTomLogo.png" alt="Rotten Tomatoes logo" style="height: 25px" />
                                <p style="margin-left: 5px"><?php echo htmlspecialchars($rotten_tomatoes); ?>%</p>
                            </div>
                        </div>
                    </div>
                    <button class="book-ticket-btn">
                        <i class="fa-solid fa-ticket-simple"></i> Buy Ticket
                    </button>
                </div>

                <div class="movie-description">
                    <h2>Description</h2>
                    <p><?php echo htmlspecialchars($description); ?></p>
                </div>
            </div>
        </div>
        <div class="reviews">
            <h2>Reviews</h2>
            <!-- Reviews section would be dynamically populated similarly if needed -->
            <div class="review-item">
                <div class="review-box">
                    <strong>John Doe</strong>⭐⭐⭐⭐⭐<br />
                    <p> Amazing visuals and great action sequences! A must-watch for monster fans. </p>
                </div>
            </div>
            <div class="review-item">
                <div class="review-box">
                    <strong>Jane Smith</strong>⭐⭐⭐⭐⭐<br />
                    <p> Thrilling movie with great suspense. Storyline could have been a bit stronger, though. </p>
                </div>
            </div>
            <!-- See More Comments Button -->
            <button class="see-more-comments">See More Comments</button>
        </div>
        <div class="similar-movies">
            <h2>Similar Movies</h2>
            <div class="similar-movie-item">
                <img src="../public/src/dark_knight.jpg" alt="Dark Knight" />
                <span>Dark Knight</span>
            </div>
            <div class="similar-movie-item">
                <img src="../public/src/inception.jpg" alt="Inception" />
                <span>Inception</span>
            </div>
        </div>
    </div>
</body>
<script>
    function adjustFontSizeToFit(element) {
        const parent = element.parentElement;
        let currentFontSize = 100; // Start with a reasonably large font size
        element.style.fontSize = `${currentFontSize}px`;

        // Reduce the font size until the text fits within the container width and height
        while (
            element.scrollWidth > parent.offsetWidth ||
            element.scrollHeight > parent.offsetHeight
        ) {
            currentFontSize--;
            element.style.fontSize = `${currentFontSize}px`;

            // Prevent getting too small
            if (currentFontSize < 5) {
                break;
            }
        }
    }

    document.addEventListener("DOMContentLoaded", () => {
        const headerElement = document.getElementById("movie-title");
        adjustFontSizeToFit(headerElement);
    });

    // Optional: Re-adjust when the window size changes
    window.addEventListener("resize", () => {
        const headerElement = document.getElementById("movie-title");
        adjustFontSizeToFit(headerElement);
    });
</script>
</html>
