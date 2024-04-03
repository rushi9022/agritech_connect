<?php include ('nav3.php');  ?>
<?php include ('header.php');  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Land Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f0f0;
        }
        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="text"],
        input[type="number"],
        input[type="email"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 15px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <center><h2>Register As a Land Owner</h2></center> 
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="city">City:</label>
        <input type="text" id="city" name="city" required><br>

        <label for="crop_type">Is Water Available:</label>
        <input type="text" id="crop_type" name="crop_type" required><br>

        <label for="capacity">How Many Land You Have :</label>
        <input type="number" id="capacity" name="capacity" required><br>

        <label for="contact_number">Contact Number:</label>
        <input type="text" id="contact_number" name="contact_number" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required><br>

        <label for="image">Upload Proof:</label>
        <input type="file" id="image" name="image" accept="image/*" required><br>

        <input type="submit" value="Submit">
    </form>

    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "CropBankDB";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Function to get latitude and longitude from city name using OpenCage API
    function getLatLong($city) {
        $apiKey = "9a81c00a3d67456ea74b68769544c6ee";
        $url = "https://api.opencagedata.com/geocode/v1/json?q=" . urlencode($city) . "&key=" . $apiKey;
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        if ($data && isset($data['results'][0]['geometry']['lat']) && isset($data['results'][0]['geometry']['lng'])) {
            return array('lat' => $data['results'][0]['geometry']['lat'], 'lng' => $data['results'][0]['geometry']['lng']);
        } else {
            return array('lat' => null, 'lng' => null);
        }
    }

    // Handle form submission
    $name = $_POST['name'];
    $city = $_POST['city'];
    $crop_type = $_POST['crop_type'];
    $capacity = $_POST['capacity'];
    
    // Check if optional fields are set
    $contact_number = isset($_POST['contact_number']) ? $_POST['contact_number'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';

    // Get latitude and longitude
    $latLong = getLatLong($city);
    $latitude = $latLong['lat'];
    $longitude = $latLong['lng'];

    // Image upload
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    // Insert into database
    $sql = "INSERT INTO sland (name, city, crop_type, capacity, contact_number, email, address, image, latitude, longitude) 
            VALUES ('$name', '$city', '$crop_type', '$capacity', '$contact_number', '$email', '$address', '$target_file', '$latitude', '$longitude')";

    if ($conn->query($sql) === TRUE) {
        // JavaScript alert after successful insertion
        echo '<script>alert("New record created successfully");</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>


</body>
</html>
