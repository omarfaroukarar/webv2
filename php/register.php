<?php
// Database connection details for PostgreSQL
$host = 'autorack.proxy.rlwy.net';
$port = '11583';  
$user = 'postgres';
$password = 'DTBxoOTdGEtauzYrXUDIAAgkOZXYVxoG';
$database = 'railway';

// Connect to PostgreSQL
$conn = pg_connect("host=$host port=$port dbname=$database user=$user password=$password");

// Check connection
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = pg_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Check if the username already exists
    $check_user_query = "SELECT * FROM users WHERE username = '$username'";
    $check_user_result = pg_query($conn, $check_user_query);

    if (pg_num_rows($check_user_result) > 0) {
        echo "Username already exists. Please choose another.";
    } else {
        // Insert user into the database
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        
        $result = pg_query($conn, $sql);

        if ($result) {
            echo "Registration successful. <a href='login.html'>Login Here</a>";
        } else {
            echo "Error: " . pg_last_error($conn);
        }
    }
}

pg_close($conn);
?>
