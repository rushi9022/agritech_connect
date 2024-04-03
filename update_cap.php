<?php include ('nav3.php');  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CropBank Listings</title>
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
    <div class="container">
        <br>
        <center><h2>Update Your Banks Capacity</h2> </center> <br>

        
                    <?php
                    // Database connection
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "CropBankDB";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    ?>

        <div class="row">
            <?php
            // Retrieve CropBanks from the database
            $sql = "SELECT * FROM CropBank where name='rahul'";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="col-md-4">
                        <div class="card">
                            <img class="card-img-top" src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['name']; ?></h5>
                                <p class="card-text">City: <?php echo $row['city']; ?></p>
                                <p class="card-text">Crop Type: <?php echo $row['crop_type']; ?></p>
                                <p class="card-text">Capacity: <?php echo $row['capacity']; ?></p>
                                <button class="btn btn-primary btn-update-capacity" data-toggle="modal" data-target="#updateCapacityModal<?php echo $row['id']; ?>">Update Capacity</button>
                                <!-- Modal -->
                                <div class="modal fade" id="updateCapacityModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="updateCapacityModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="updateCapacityModalLabel<?php echo $row['id']; ?>">Update Capacity for <?php echo $row['name']; ?></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="update_capacity.php" method="POST">
                                                    <input type="hidden" name="cropbank_id" value="<?php echo $row['id']; ?>">
                                                    <div class="form-group">
                                                        <label for="new_capacity">New Capacity:</label>
                                                        <input type="number" class="form-control" id="new_capacity" name="new_capacity" placeholder="Enter new capacity" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "0 results";
            }

            $conn->close();
            ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
