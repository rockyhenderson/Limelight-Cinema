<?php
// This file establishes a connection to the MySQL database.
// It will be included in any page that needs to interact with the database.
function connectDB() {
    $servername = "localhost";
    $username = "HNCWEBMR10";  // Update with your DB username
    $password = "GdPZUFCJ6V";      // Update with your DB password
    $dbname = "HNCWEBMR10";

    //  connection!!!
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection!!!
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
?>
