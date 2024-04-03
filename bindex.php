<?php include ('header.php');  ?>
  
<?php include ('nav5.php');  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farm Connect</title>
   
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha384-+d2iNhkDqMvB1p7ad8gT5Gh+6kMeJT4DvzrK+37Y4J7BFGb/in1zUm2r86YPSXHV" crossorigin="anonymous">
   
    <style>
    
        /* Custom CSS styles for the main content */
        .container {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    animation: fadeInUp 1.5s ease forwards;
   
    background-size: cover;
    background-position: center;
    padding: 50px;
}

    
        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate(-50%, 100%);
            }
            to {
                opacity: 1;
                transform: translate(-50%, -50%);
            }
        }
    </style>
    
</head>
<body
style="background-image: url('./farmland_1112-1235.jpg'); background-repeat: no-repeat; background-size: cover; ">

    <div class="container">
        <h1>Welcome to Bidding_System</h1>
        <p1>Add the Bid And got Max Price</p1>
    </div>

   
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>