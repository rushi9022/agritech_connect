<?php
require('nav2.php');
if (!isset($_SESSION['name'])) {
    echo "<script>alert('Login required'); window.location.href = 'login1.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sample Form</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS for background color and animation -->
    <style>
        .container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            background-color: #ff6666;
            border-color: #ff6666;
        }

        .btn-primary:hover {
            background-color: #ff3333;
            border-color: #ff3333;
            animation: pulse 0.5s ease infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
</head>

<body>
    <br>
    <center><h2>Upload Queries to For Expert</h2></center>
    <br>
    <div class="container">
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="dropdown">Select Crop:</label>
                <select id="dropdown" name="dropdown" class="form-control">
                    <?php
                    require('conn.php');
                    $query = "SELECT * FROM `pik`;";
                    $result = $conn->query($query);

                    while ($row = $result->fetch_assoc()) {
                        $optionName = $row['name'];
                        echo "<option value='$optionName'>$optionName</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="image">Upload an image:</label>
                <input type="file" id="image" name="choosefile" accept="image/*" class="form-control-file">
            </div>

            <div class="form-group">
                <label for="text">Enter some text:</label>
                <input type="text" id="text" name="text" class="form-control">
            </div>

            <input type="submit" value="Submit" name="submit" class="btn btn-primary">
        </form>
    </div>
</body>

</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["dropdown"]) || empty($_FILES["choosefile"]["name"]) || empty($_POST["text"])) {
        echo "<div class='alert alert-danger' role='alert'>Please fill in all fields.</div>";
    } else {
        // Sanitize user input
        $selectedOption = mysqli_real_escape_string($conn, $_POST["dropdown"]);
        $textInput = mysqli_real_escape_string($conn, $_POST["text"]);

        $filename = $_FILES["choosefile"]["name"];
        $tempfile = $_FILES["choosefile"]["tmp_name"];
        $fname = $_SESSION['name'];
        $folder = "image/" . $filename;
        $microtime = microtime(true) * 10000;
        $random = mt_rand(0, 999);
        $uniqueID = $microtime . $random;

        $query = "SELECT * FROM `$selectedOption` ORDER BY `job` ASC LIMIT 1";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $tbname = $row['tb_name'];
            $name = $row['name'];
            $updatequery = "UPDATE `$selectedOption` SET job=job+1 WHERE name='$name';";
            mysqli_query($conn, $updatequery);

            $insertQuery1 = "INSERT INTO `problems` (`id`, `farmer_name`, `img`, `disc`) VALUES ('$uniqueID', '$fname', '$filename', '$textInput')";
            $insertQuery = "INSERT INTO `$tbname` (`id`) VALUES ('$uniqueID')";

            if (mysqli_query($conn, $insertQuery1) && $conn->query($insertQuery)) {
                move_uploaded_file($tempfile, $folder);
                echo "<script>alert('Data inserted into the $tbname table successfully.\\nSelected Option: $selectedOption\\nUploaded Image: $filename\\nText Input: $textInput');</script>";

            } else {
                echo "<div class='alert alert-danger' role='alert'>Error inserting data: " . mysqli_error($conn) . "</div>";
            }
        } else {
            echo "<div class='alert alert-warning' role='alert'>No data found for the selected option.</div>";
        }
    }
}
?>
