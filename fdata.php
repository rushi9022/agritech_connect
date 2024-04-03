<?php
// Database connection
$servername = "localhost"; // Change this if your MySQL server is hosted elsewhere
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "skn_bid"; // Your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$name = $_POST['name'];
$mobile_number = $_POST['mobile_number'];
$bid_amount = $_POST['bid_amount'];

// Prepare SQL statement to insert data into the database
$sql = "INSERT INTO merchant (name, mobile_number, bid_amount) VALUES ('$name', '$mobile_number', '$bid_amount')";

// Execute SQL statement
if ($conn->query($sql) === TRUE) {
    // Alert message after successful submission
    echo '<script>alert("Bid submitted successfully!");';
    echo 'window.location.href = "apply_bid_form.php";</script>';
    
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close database connection
$conn->close();
?>

