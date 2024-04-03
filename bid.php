<?php
include 'conn.php';

session_start();

if (!isset($_SESSION['bidder_id'])) {
    // Handle case when bidder is not logged in
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $crop_id = $_POST['crop_id'];
    $bidder_id = $_SESSION['u_name'];
    $bid_amount = $_POST['bid_amount'];

    // Insert bid into the database
    $sql = "INSERT INTO bids (crop_id, bidder_id, bid_amount) VALUES ('$crop_id', '$bidder_id', '$bid_amount')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Bid placed successfully');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT * FROM crops";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bid on Crop</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+gsOk1Elg/uFZcQ8NY8dc6Q/qjM559a6Ihzyj2H" crossorigin="anonymous">
    <style>
        body {
            padding: 20px;
        }
        .crop-card {
            margin-bottom: 20px;
        }
        .crop-card img {
            height: 200px;
            object-fit: cover;
        }
        .crop-card .card-title {
            font-size: 1.5rem;
        }
        .bid-form {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4">Bid on Crop</h2>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
            ?>
            <div class="col">
                <div class="card crop-card">
                    <img src="<?php echo $row['image_path']; ?>" class="card-img-top" alt="Crop Image">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['crop_name']; ?></h5>
                        <p class="card-text"><?php echo $row['description']; ?></p>
                        <p class="card-text">Start Price: <?php echo $row['start_price']; ?></p>
                        <p class="card-text">End Date: <?php echo $row['end_date']; ?></p>
                        <form method="post" class="bid-form">
                            <input type="hidden" name="crop_id" value="<?php echo $row['crop_id']; ?>">
                            <div class="mb-3">
                                <label for="bid_amount" class="form-label">Bid Amount:</label>
                                <input type="text" name="bid_amount" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Place Bid</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
                }
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-kfF8R5dzyl0WCLAJl+l443WPmVFOW1bweQaBz3u95tq0Ij4FJLsEx00u9bKmMbK+" crossorigin="anonymous"></script>
</body>
</html>
