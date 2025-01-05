<?php
// Set the database connection details
$servername = "localhost";  // Typically "localhost" when using XAMPP or local server
$username = "root";         // Default username in XAMPP is "root"
$password = "";             // Default password is an empty string in XAMPP
$dbname = "ApartmentManagementSystem";  // The database name you created earlier

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    // Uncomment to test the connection
    // echo "Connected successfully";
}
?>
