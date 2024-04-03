<?php
require('nav2.php');
if(isset($_SESSION['name']))
{

}
else{
    exit();
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>expert</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Include Bootstrap CSS and JavaScript -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <center>
            <h1>Farmers Query</h1>
        </center>
        <ul class="list-group" style="margin-top: 10px;">
            <?php
            require('conn.php');
            $log_name = $_SESSION['name'];
            $query = "SELECT * FROM `$log_name`;";
            
            $result = $conn->query($query);
            
            while ($ro = $result->fetch_assoc()){
                $id=$ro['id'];
                $query1 = "SELECT * FROM `problems` WHERE id='$id';";
                $result1 = $conn->query($query1);
                while ($row = $result1->fetch_assoc()) {
                    $farmer_name = $row['farmer_name'];
                    $farmer_id = $row['id']; // Assuming you have a unique ID for each farmer
                    $img="./image/".$row['img'];
                    $sol=$row['que'];
                    // echo '<li class="list-group-item d-flex justify-content-between align-items-center">
                    // <div><h5 class="mt-2">' . $farmer_name . '</h5></div>
                    // <button class="btn btn-primary" data-toggle="modal" data-target="#farmerModal' . $farmer_id . '">View Query</button>
                    // </li>';
                    
                   if ($sol != null) {
                        echo '<li class="list-group-item d-flex justify-content-between align-items-center">
                                <div><h5 class="mt-2">' . $farmer_name . '</h5></div>
                                <button class="btn btn-danger" onclick="deleteEntry('.$farmer_id.')">Delete'.$farmer_id.'</button>
                                <button class="btn btn-primary" data-toggle="modal" data-target="#farmerModal' . $farmer_id . '">View Query</button>
                              </li>';
                              echo '<script>var farmerId2 = ' . json_encode($farmer_id) . ';</script>';
                    } else {
                        echo '<li class="list-group-item d-flex justify-content-between align-items-center">
                                <div><h5 class="mt-2">' . $farmer_name . '</h5></div>
                                <button class="btn btn-primary" data-toggle="modal" data-target="#farmerModal' . $farmer_id . '">View Query</button>
                              </li>';
                    }

                    // Create a modal for each farmer
                    echo '<div class="modal fade" id="farmerModal' . $farmer_id . '" tabindex="-1" role="dialog" aria-labelledby="farmerModalLabel' . $farmer_id . '" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="farmerModalLabel' . $farmer_id . '">' . $farmer_name . ' Query</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                    <div>
                    <img src="' . $img . '" alt="' . $farmer_name . '" class="img-fluid">
                    </div>
                                    <p> ' . $row['disc'] . '.</p>
                                    
                                    
                                    <form method="post" action="msg_exp.php">
                                    <input type="hidden" name="farmer_id" value="' . $id . '">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                    
                                    </div>
                                    
                                    
                                    
                                    </div>
                                    </div>
                                    </div>';
                                }}
                                ?>
            <script>
                function deleteEntry(farmerId) {
                farmerId:farmerId
                if (confirm("Are you sure you want to delete this entry?" + farmerId2)) {
                    // Send an AJAX request to delete the entry from the database
                    $.ajax({
                        type: "POST",
                        url: "delete_entry.php", // Replace with the actual URL to your delete script
                        data: {
                            farmerId: farmerId2
                        },
                        success: function(response) {
                            // Handle the response here if needed
                            // You can also reload the page or remove the entry from the list
                            location.reload(); // Reload the page to reflect the changes
                            //confirm(response);
                        },
                        error: function(xhr, status, error) {
                            // Handle the error here
                            console.error(error);
                        }
                    });
                }
            }
            </script>

        </ul>
    </div>
    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>