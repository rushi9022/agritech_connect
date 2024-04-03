<?php
session_start();

// Logout logic
if(isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login1.php"); // Redirect to login page after logout
    exit;
}
?>
<?php include ('header.php');  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crop Care</title>
</head>
<body>

<nav id="navbar-main" class="navbar navbar-main navbar-expand-lg bg-default navbar-light position-sticky top-0 shadow py-0">
    <div class="container-fluid">
        <ul class="navbar-nav navbar-nav-hover align-items-lg-center">
            <li class="nav-item dropdown">
                <a href="index.php" class="navbar-brand mr-lg-5 text-white">
                    <h1 class="text-white">AgriTech</h1>
                </a>
            </li>
        </ul>

        <button class="navbar-toggler bg-white" type="button" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon text-white"></span>
        </button>
        <div class="navbar-collapse collapse bg-default" id="navbar_global">
            <div class="navbar-collapse-header">
                <div class="row">
                    <div class="col-10 collapse-brand">
                        <a href="index.html">
                            <img src="assets/img/nav.png" />
                        </a>
                    </div>
                    <div class="col-2 collapse-close bg-danger">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>

          
                <?php if(isset($_SESSION['name'])): ?>
                   
                <?php else: ?>
                    <a class="nav-link text-white " href="login1.php" role="button">
                        <span class="text-white nav-link-inner--text"><i class="text-white fas "></i>Login/Signup</span> </a>
                <?php endif; ?>
                <?php if(isset($_SESSION['des']) && $_SESSION['des'] == 0): ?>
                    <ul class="navbar-nav align-items-lg-center ml-auto topnav" id="nav">
                <a class="nav-link text-white " href="hire.php" role="button">
                    <span class="text-white nav-link-inner--text"><i class="text-white fas "></i>Connect to Expert</span> </a>
                <a class="nav-link text-white " href="view_query_farmer.php" role="button">
                    <span class="text-white nav-link-inner--text"><i class="text-white fas "></i>Solution by Expert</span> </a>            
                <a class="nav-link text-white " href="http://127.0.0.1:5000/" role="button">
                    <span class="text-white nav-link-inner--text"><i class="text-white fas "></i>Solution By AI</span> </a>
                <a class="nav-link text-white " href="weather/index.html" role="button">
                    <span class="text-white nav-link-inner--text"><i class="text-white fas "></i>Check Weather</span> </a>

                <a class="nav-link text-white " href="community.php" role="button">
                    <span class="text-white nav-link-inner--text"><i class="text-white fas "></i>Community</span> </a>
                    <a href="profile.php"><img src="p.png" alt="profileimg" width="50"></a> 
                    <form method="post">
                        <li class="nav-item">
                            <button type="submit" name="logout" class="nav-link text-white" style="background: none; border: none; cursor: pointer;">
                                <?php echo $_SESSION['name']; ?>
                                <span class="text-white nav-link-inner--text"><i class="text-white fas "></i>Logout</span>
                            </button>
                        </li>
                    </form>
                <?php elseif(isset($_SESSION['des']) && $_SESSION['des'] == 1): ?>
                    <ul class="navbar-nav align-items-lg-center ml-auto topnav" id="nav">
                    <a class="nav-link text-white " href="view_query_expert.php" role="button">
                    <span class="text-white nav-link-inner--text"><i class="text-white fas "></i>View Farmers Queries</span> </a>                          
                <a class="nav-link text-white " href="http://127.0.0.1:5000/" role="button">
                    <span class="text-white nav-link-inner--text"><i class="text-white fas "></i>Solution By AI</span> </a>
                <a class="nav-link text-white " href="weather/index.html" role="button">
                    <span class="text-white nav-link-inner--text"><i class="text-white fas "></i>Check Weather</span> </a>

                <a class="nav-link text-white " href="community.php" role="button">
                    <span class="text-white nav-link-inner--text"><i class="text-white fas "></i>Community</span> </a>
                    <a href="profile.php"><img src="p.png" alt="profileimg" width="50"></a> 
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<div id="google_element"></div>
<script src="http://translate.google.com/translate_a/element.js?cb=loadGoogleTranslate"></script>
<script>
function loadGoogleTranslate () {
 new google.translate.TranslateElement("google_element");
}
</script>
<style>
    .topnav a {
        border-bottom: 3px solid transparent;
    }

    .topnav a:hover {
        border-bottom: 3px solid red;
    }

    .topnav a.activa {
        border-bottom: 3px solid red;
    }
</style>

<script>
    $("#nav li a").each(function() {
        if (this.href == window.location.href) {
            $(this).addClass("activaa");
        }
    });
</script>

</body>
</html>
