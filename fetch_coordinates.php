<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "skn_bid");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch city coordinates from the database
// Assuming you have a table named 'cities' with columns 'name', 'latitude', and 'longitude'
$sql = "SELECT name, latitude, longitude FROM cities";
$result = $conn->query($sql);

$cities_coordinates = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $cities_coordinates[] = $row;
    }
}

// Close connection
$conn->close();

// Send the fetched city coordinates as JSON response
header('Content-Type: application/json');
echo json_encode($cities_coordinates);
?>
