<?php include ('nav3.php');  ?>
<?php include ('header.php');  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soil Testers</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .card {
            margin-bottom: 20px;
        }
        .card-img-top {
            height: 200px; /* Set the height for the images */
            object-fit: fit; /* Ensure the image covers the entire space */
        }
        .contact-details {
            display: none; /* Hide contact details by default */
        }
    </style>
</head>
<body>    
    <div class="container mt-3">
        <center><h1>Soil Testing Agencies</h1></center>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET" class="form-inline mb-3">
            <div class="form-group mr-2">
                <label for="city">Search by City:</label>
                <input type="text" name="city" id="city" class="form-control" placeholder="Enter City Name">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>            
            <a href="register_stester.php">Be A Soil Tester</a>
        </form>        
        <br>
        <div class="row">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                if (isset($_GET['city']) && !empty($_GET['city'])) {
                    $city = $_GET['city'];

                    // Database connection
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "CropBankDB";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Fetch latitude and longitude of the selected city
                    $cityQuery = "SELECT latitude, longitude FROM sdata WHERE city = '$city'";
                    $cityResult = $conn->query($cityQuery);
                    if ($cityResult->num_rows > 0) {
                        $row = $cityResult->fetch_assoc();
                        $cityLatitude = $row['latitude'];
                        $cityLongitude = $row['longitude'];

                        // Fetch crop banks within a certain radius (e.g., 50 km) of the selected city
                        $sql = "SELECT * FROM sdata";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // Output data of each row
                            while ($row = $result->fetch_assoc()) {
                                // Implement Haversine formula to calculate distance
                                $lat2 = $row['latitude']; // Crop bank's latitude
                                $lon2 = $row['longitude']; // Crop bank's longitude

                                $earth_radius = 6371; // Radius of the Earth in kilometers

                                $dLat = deg2rad($lat2 - $cityLatitude);
                                $dLon = deg2rad($lon2 - $cityLongitude);

                                $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($cityLatitude)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
                                $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                                $distance = $earth_radius * $c;

                                // If distance is less than or equal to 50 km, display the crop bank
                                if ($distance <= 90) {
                                    ?>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <img class="card-img-top" src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo $row['name']; ?></h5>
                                                <p class="card-text">City: <?php echo $row['city']; ?></p>
                                                <p class="card-text">Soil Type: <?php echo $row['crop_type']; ?></p>                                                
                                                <button class="btn btn-primary btn-contact" data-toggle="modal" data-target="#contactModal<?php echo $row['id']; ?>">Contact</button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="contactModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="contactModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="contactModalLabel<?php echo $row['id']; ?>"><?php echo $row['name']; ?> Contact Details</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Contact Person: <?php echo $row['name']; ?></p>
                                                                <p>Contact Number: <?php echo $row['contact_number']; ?></p>
                                                                <p>Email: <?php echo $row['email']; ?></p>
                                                                <p>Address: <?php echo $row['address']; ?></p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <a href="https://maps.app.goo.gl/kNN8ygEG39zD22A6A" target="_blank"><button type="button" class="btn btn-secondary">Directions</button></a> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        } else {
                            echo '<script>alert("No crop banks found within 50 km radius of the selected city.");</script>';
                        }
                    } else {
                        echo '<script>alert("City not found.");</script>';
                    }

                    $conn->close();
                } else {
                    echo '<script>alert("Please enter a city name.");</script>';
                }
            }
            ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
