<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('log_errors', 1); // Log errors to the server log
error_reporting(E_ALL); // Report all PHP errors

// Database configuration
$host = 'localhost:3307'; // or your MySQL server address
$user = 'root'; // your MySQL username
$password = ''; // your MySQL password
$database = 'mydata'; // your database name

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    // Output a detailed error message for debugging
    http_response_code(500); // Set HTTP status code to 500 for server error
    die(json_encode(array("error" => "Database connection failed: " . $conn->connect_error)));
}

// Insert data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Make sure POST variables are set and not empty
    if (!isset($_POST['fname']) || empty($_POST['fname']) || !isset($_POST['lname']) || empty($_POST['lname'])) {
        http_response_code(400); // Bad request
        die(json_encode(array("error" => "Invalid input: First and last names are required.")));
    }

    // Escape input to avoid SQL injection
    $fname = $conn->real_escape_string($_POST['fname']);
    $lname = $conn->real_escape_string($_POST['lname']);

    // Insert query
    $sql = "INSERT INTO students (fname, lname) VALUES ('$fname', '$lname')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to hello.php with fname and lname as query parameters
        header("Location: hello.php?fname=$fname&lname=$lname");
        exit(); // Ensure the script stops executing after the redirect
    } else {
        // Provide detailed error message if the query fails
        http_response_code(500); // Server error
        echo json_encode(array("error" => "Database query failed: " . $conn->error));
    }
} else {
    // If not POST request, return a method not allowed response
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("error" => "Only POST method is allowed."));
}

// Close connection
$conn->close();
?>