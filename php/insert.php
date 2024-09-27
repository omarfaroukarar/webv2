
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
    // Get form data and escape to prevent SQL injection
    $firstName = pg_escape_string($pdo, $_POST['fname']);
    $lastName = pg_escape_string($pdo, $_POST['lname']);

    // Prepare SQL statement
    $sql = "INSERT INTO students (fname, lname) VALUES ('$firstName', '$lastName')";
    
    // Execute the query
    $result = pg_query($pdo, $sql);

    if ($result) {
        echo "Data successfully inserted!";
    } else {
        echo "Error: " . pg_last_error($pdo);
    }
}

// Close the database connection (if using PDO, it's handled automatically)
?>
