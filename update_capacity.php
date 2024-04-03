<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CropBankDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get cropbank_id and new_capacity from the form
    $cropbank_id = $_POST['cropbank_id'];
    $new_capacity = $_POST['new_capacity'];

    // Prepare update statement
    $sql = "UPDATE CropBank SET capacity = $new_capacity WHERE id = $cropbank_id";

    if ($conn->query($sql) === TRUE) {
        // If update is successful
        echo "<script>alert('Capacity updated successfully!');</script>";
        header("Location: update_cap.php");
    } else {
        // If there is an error in updating
        echo "<script>alert('Error updating capacity: " . $conn->error . "');</script>";
    }
}

// Close the database connection
$conn->close();
?>
