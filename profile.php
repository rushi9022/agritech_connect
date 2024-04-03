<?php
// echo "WelCome to the stage where we are ready to connect to a database<br>";
include ('header.php');  
 
include ('nav.php');
//wat to connect to a mysql database

//Connecting to database
$servername="localhost";
$username="root";
$password="";
$database="km_agri";
$n=$_SESSION["u_name"];

//Create a connection

$conn=mysqli_connect($servername,$username,$password,$database);
//Die if connection was not successful
if(!$conn){
    die("Sorry we failed to connect". mysqli_connect_error());
}
else{
    // echo "Connected<br>";
}

$sql="select * from `farmer_data` where u_name='$n'";
$result=mysqli_query($conn,$sql);

//find the number of record

$num= mysqli_num_rows($result);
// echo $num;
echo "<br>";
//display the rows

if($num>0)
{
    // while($row=mysqli_fetch_assoc($result)){
        
    //     // echo var_dump($row);
    //     echo "Hello"." ". $row['f_name'];
    //     echo "<br>";
    // }
    

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
<style>
    .profile-container {
        position: relative;
        display: inline-block;
    }

    .profile-img {
        border-radius: 50%;
        width: 150px; /* Adjust size as needed */
        height: 150px; /* Adjust size as needed */
    }

    .update-icon {
        position: absolute;
        bottom: -10px;
        right: -10px;
        background-color: #fff;
        border-radius: 50%;
        padding: 5px;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.5);
   }   
   
   .center-card {
            margin: 0 auto;
            margin-top: 0px;
        }
</style>
</head>
<body style="background:#E6E6FA;">
    <center><div class="profile-container" style="margin-top: 25px;" >
    <img src="profile.png" alt="Profile Image" class="profile-img" width="100">
     <br>
    
    </center>
</div>
<br>
<center>
    <?php
    $row=mysqli_fetch_assoc($result);
    echo "<h1>";
    echo "Hello"." ". $row['u_name'];
    echo "</h1>"
    ?>
</center>
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 center-card">
                <div class="card">
                    <div class="card-header">
                        <h3>User Info:</h3>
                    </div>
                    <div class="card-body">
                    <h5 style="text-align:center;"><?php  echo "Name: " . $row['f_name']; ?></h5>
                    <h5 style="text-align:center;"><?php echo "Role: " . ($row['exp'] == 0 ? "Farmer" : ($row['exp'] == 1 ? "Expert" :($row['exp'] == 2 ? "Admin" : ($row['exp'] == 3 ? "Crop Bank Owner" : "Land Owner")) )); ?></h5>
                    <h5  style="text-align:center;"><?php  echo "Mob: " . $row['mno']; ?></h5>

                  
                    </div>
                    <form method="post">                        
                    <center>  <button type="submit" name="logout" class="nav-link btn btn-primary" style="background: none; border: none; cursor: pointer;" >
                          
                                 <span class="text-blue nav-link-inner--text"><i class="text-white fas "></i>Logout</span>
                            </button>   </center>                        
                    </form>
                </div>                
            </div>
        </div>        
    </div>
</body>
</html>