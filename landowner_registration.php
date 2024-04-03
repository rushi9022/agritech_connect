<?php
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to your database
    $conn = new mysqli("localhost", "root", "", "skn_bid");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $city = $_POST['city']; // Assuming user enters the location
        $api_key = 'cbf75fe89a1cce4844462c1b094da096'; // Replace with your OpenWeather API key
        
        // Use OpenWeather API to fetch latitude and longitude
        $geo_api_url = "https://api.openweathermap.org/geo/1.0/direct?q=" . urlencode($city) . "&limit=1&appid={$api_key}";
        $geo_response = file_get_contents($geo_api_url);
        $geo_data = json_decode($geo_response);
    
        if ($geo_data && isset($geo_data[0])) {
            $latitude = $geo_data[0]->lat;
            $longitude = $geo_data[0]->lon;
    
            // Fetch nearby cities within 200 km radius
            $weather_api_url = "https://api.openweathermap.org/data/2.5/find?lat={$latitude}&lon={$longitude}&cnt=10&appid={$api_key}";
            $weather_response = file_get_contents($weather_api_url);
            $weather_data = json_decode($weather_response);
    
            // Process nearby cities data
            $matched_cities = [];
            if ($weather_data && isset($weather_data->list)) {
                foreach ($weather_data->list as $city) {
                    // Check if the city's village matches any village in the landowners table
                    $city_name = $city->name;
                    $landowners_query = $conn->prepare("SELECT * FROM farmers WHERE location = ?");
                    $landowners_query->bind_param("s", $city_name);
                    $landowners_query->execute();
                    $landowners_result = $landowners_query->get_result();
    
                    if ($landowners_result->num_rows > 0) {
                        // City's village found in landowners table, include it in the matched cities array
                        $matched_cities[] = $city_name;
                    }
                }
            }
            // Display the nearby matching cities
            echo "<h1>Nearby Matching Cities</h1>";
            // Display the data in a table
            if (!empty($matched_cities)) {
                echo "<table style='width: 100%; border-collapse: collapse; border: 1px solid #ccc;'>";
                echo "<tr><th style='background-color: #f2f2f2; padding: 10px; border: 1px solid #ccc;'>Name</th><th style='background-color: #f2f2f2; padding: 10px; border: 1px solid #ccc;'>Mobile Number</th><th style='background-color: #f2f2f2; padding: 10px; border: 1px solid #ccc;'>Village</th><th style='background-color: #f2f2f2; padding: 10px; border: 1px solid #ccc;'>Land Quantity</th><th style='background-color: #f2f2f2; padding: 10px; border: 1px solid #ccc;'>ID Proof</th><th style='background-color: #f2f2f2; padding: 10px; border: 1px solid #ccc;'>Countdown</th><th style='background-color: #f2f2f2; padding: 10px; border: 1px solid #ccc;'>Action</th></tr>";
                
                // Fetch and display details of landowners for matched cities
                foreach ($matched_cities as $matched_city) {
                    $landowners_query = $conn->prepare("SELECT * FROM farmers WHERE location = ?");
                    $landowners_query->bind_param("s", $matched_city);
                    $landowners_query->execute();
                    $landowners_result = $landowners_query->get_result();

                    while ($row = $landowners_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td style='padding: 10px; border: 1px solid #ccc;'>{$row['name']}</td>";
                        echo "<td style='padding: 10px; border: 1px solid #ccc;'>{$row['mobile_number']}</td>";
                        echo "<td style='padding: 10px; border: 1px solid #ccc;'>{$row['location']}</td>";
                        echo "<td style='padding: 10px; border: 1px solid #ccc;'>{$row['product_name']}</td>";
                        echo "<td style='padding: 10px; border: 1px solid #ccc;'><a href='{$row['product_image']}' download style='text-decoration: none; color: blue;'>product Image</a></td>";
                        
                        // Calculate countdown timer based on end_time
                        $end_time = strtotime($row['end_time']);
                        $current_time = time();
                        $countdown = $end_time - $current_time;
                        $countdown_hours = floor($countdown / 3600);
                        $countdown_minutes = floor(($countdown % 3600) / 60);
                        $countdown_seconds = $countdown % 60;

                        // Assign a unique identifier for each countdown timer
                        $countdown_id = 'countdown_' . $row['id']; // Assuming 'id' is the unique identifier in your farmers table
                        echo "<td style='padding: 10px; border: 1px solid #ccc;'><span id='$countdown_id' style='font-weight: bold; color: #ff6347;'>$countdown_hours:$countdown_minutes:$countdown_seconds</span></td>";

                        // Button to join bid
                        echo "<td style='padding: 10px; border: 1px solid #ccc;'><form method='post' action='apply_bid_form.php'><input type='hidden' name='bidder_id' value='{$row['id']}'>";
                        echo "<input type='submit' name='join_bid' value='Join Bid' onclick='redirectToAnotherPage()' style='padding: 8px 20px; background-color: #008000; color: #fff; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;'>";
                        echo "</form></td>";
                        echo "</tr>";
                        echo "</tr>";
                    }
                }
                echo "</table>";
            } else {
                echo "No matching bids found in farmer table.";
            }
        } else {
            // Handle case where geocoding fails
            echo json_encode(['status' => 'error', 'message' => 'Geocoding failed.']);
        }
    }

}
?>
<script>
function redirectToAnotherPage() {
    window.location.href = "apply_bid_form.php"; // Replace "another_page.html" with the URL of the page you want to redirect to
}
</script>
<?php
// Your existing PHP code

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Your existing PHP code
}

// Your existing PHP code

// Display the HTML form for applying bids
 // Include the HTML form file
?>
