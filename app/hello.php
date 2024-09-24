<?php
// Retrieve the fname and lname from the URL parameters
$fname = isset($_GET['fname']) ? htmlspecialchars($_GET['fname']) : 'Guest';
$lname = isset($_GET['lname']) ? htmlspecialchars($_GET['lname']) : '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .message-box {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="message-box">
        <h1>Hello <?php echo $fname . ' ' . $lname; ?>!</h1>
        <p>Welcome to our system.</p>
    </div>
</body>
</html>
