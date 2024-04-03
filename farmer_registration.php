<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "skn_bid");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Geocoding Logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $location = $_POST['location']; // Assuming user enters the location
    $api_key = 'cbf75fe89a1cce4844462c1b094da096'; // Replace with your OpenWeather API key
    
    // Use OpenWeather API to fetch latitude and longitude
    $geo_api_url = "https://api.openweathermap.org/geo/1.0/direct?q=" . urlencode($location) . "&limit=1&appid={$api_key}";
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

        // Display the data in a table
        if (!empty($matched_cities)) {
            echo "<table border='1'>";
            foreach ($matched_cities as $matched_city) {
                $landowners_query = $conn->prepare("SELECT * FROM farmers WHERE location = ?");
                $landowners_query->bind_param("s", $matched_city);
                $landowners_query->execute();
                $landowners_result = $landowners_query->get_result();

                while ($row = $landowners_result->fetch_assoc()) {
                    // Display data here
                }
            }
            echo "</table>";
        } else {
            echo "No matching bids found in farmer table.";
        }
    } 
}

// Farmer Registration Logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Farmer Registration Logic
    if (isset($_POST['name'], $_POST['mobile_number'], $_POST['location'], $_POST['start_date'], $_POST['end_date'], $_POST['product_name'])) {
        // Retrieve form data
        $name = $_POST['name'];
        $mobile_number = $_POST['mobile_number'];
        $location = $_POST['location'];
        $start_time = $_POST['start_date'];
        $end_time = $_POST['end_date'];
        $product_name = $_POST['product_name'];

        // Handle file upload
        $target_dir = "uploads/"; // Specify the directory where you want to store the uploaded images
        $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["product_image"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
        
        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        
        // Check file size
        if ($_FILES["product_image"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars( basename( $_FILES["product_image"]["name"])). " has been uploaded.";
            } else {
                // echo "Sorry, there was an error uploading your file.";
            }
        }
        
        // Insert farmer data into the database
        $stmt = $conn->prepare("INSERT INTO farmers (name, mobile_number, location, product_image, start_time, end_time, product_name) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $name, $mobile_number, $location, $target_file, $start_time, $end_time, $product_name);

        // Execute SQL statement for farmer registration
        if ($stmt->execute()) {
            echo "Farmer registered successfully!";
            // Redirect to a new HTML page
            header("Location: new_page.html");
            exit(); // Ensure no further code is executed after redirection
        } else {
            echo "Failed to register farmer: " . $stmt->error;
        }
        // Close statement
        $stmt->close();
    }
}

// Close connection
$conn->close();
?>
