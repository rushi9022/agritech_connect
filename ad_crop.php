<?php
include 'conn.php';

session_start();

if (!isset($_SESSION['u_name'])) {
    header("Location: login1.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $crop_name = $_POST['crop_name'];
    $description = $_POST['description'];
    $start_price = $_POST['start_price'];
    $end_date = $_POST['end_date'];
    $u_name = $_SESSION['u_name'];

    // File upload handling
    $target_dir = "uploads/"; // Directory where the file will be stored
    $target_file = $target_dir . basename($_FILES["crop_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["crop_image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["crop_image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["crop_image"]["tmp_name"], $target_file)) {
            $image_path = $target_file;

            // Insert data into database
            $sql = "INSERT INTO crops (u_name, crop_name, description, start_price, end_date, image_path) VALUES ('$u_name', '$crop_name', '$description', '$start_price', '$end_date', '$image_path')";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Crop added successfully');</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Crop</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        form {
            width: 50%;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        input[type="text"],
        textarea,
        input[type="datetime-local"],
        input[type="file"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        textarea {
            height: 100px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Add Crop</h2>
    <form method="post" enctype="multipart/form-data">
        <label>Crop Name:</label>
        <input type="text" name="crop_name" required><br>
        
        <label>Description:</label>
        <textarea name="description" required></textarea><br>
        
        <label>Start Price:</label>
        <input type="text" name="start_price" required><br>
        
        <label>End Date:</label>
        <input type="datetime-local" name="end_date" required><br>
        
        <label>Crop Image:</label>
        <input type="file" name="crop_image" accept="image/*" required><br>
        
        <input type="submit" value="Add Crop">
    </form>
</body>
</html>
