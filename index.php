<!DOCTYPE html>
<html>
<head>
<style>
      .slideshow-container {
    position: relative;
    max-width: 1250px;
    margin: auto;
  }
  
  .slides {
    display: none;
  }
  
  .om {
    width: 100%;
  }
  
  .fade {
    animation-name: fade;
    animation-duration: 1.5s;
  }
  
  @keyframes fade {
    from {
      opacity: .4;
    }
    to {
      opacity: 1;
    }
  }
  </style>
</head>
<?php include ('header.php');  ?>

  <body class="bg-white" id="top">
  
<?php include ('nav.php');  ?>

<center><div class="slideshow-container">
    <div class="slides fade">
      <img src="finder.png" alt="Image 1" width="90%" height="450px" class="om">
    </div>
    <div class="slides fade">
      <img src="cropcare.png" alt="Image 2"  width="90%" height="450px" class="om">
    </div>
    <div class="slides fade">
      <img src="cropPridiction.jpg" alt="Image 3"  width="90%" height="450px" class="om">
    </div>
    <div class="slides fade">
        <img src="yieldPridiction.jpg" alt="Image 3"  width="90%" height="450px" class="om">
      </div>
      <div class="slides fade">
        <img src="rainfallPridiction.png" alt="Image 3"  width="90%" height="450px" class="om">
      </div>
      <div class="slides fade">
        <img src="bid.png" alt="Image 3"  width="90%" height="450px" class="om">
      </div>
  </div>
</center>
    <div class="section features-6 text-dark bg-white" id="services">
      <div class="container ">

        <div class="row">
                <div class="col-md-8 mx-auto text-center">
                    <span class="badge badge-primary badge-pill mb-3">Insight</span>
                    <h3 class="display-3 ">Features</h3>
                </div>
            </div>
			<br>
			
        <div class="row align-items-center">
		
          <div class="col-lg-6">
            <div class="info info-horizontal info-hover-success">
              <div class="description pl-4">
                <h3 class="title" >Farmers</h3>
           <p class=" ">Farmers can get recommendations for crop and fertilizer and even 
            predictions for crop, yield and rainfall. All these are implemented using ML with proper dataset. </p>
                        
              </div>
            </div>

          </div>
		  
		  
          <div class="col-lg-6 col-10 mx-md-auto d-none d-md-block">
            <img class="ml-lg-5  pull-right" src="assets/img/agri.png" width="100%">
          </div>
        </div>
		
		

      </div>
    </div>

    <script>
    let slideIndex = 0;
showSlides();

function showSlides() {
  let slides = document.getElementsByClassName("slides");
  for (let i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}    
  slides[slideIndex-1].style.display = "block";  
  setTimeout(showSlides, 2000); // Change image every 2 seconds
}

 </script>
     
<!-- ======================================================================================================================================== -->

      <div class="section features-2 text-dark bg-white" id="features"> 
        <div class="container"> 
          <div class="row align-items-center"> 
            <div class="col-lg-5 col-md-8 mr-auto text-left"> 
              <div class="pr-md-5"> 
                <div class="icon icon-lg icon-shape icon-shape-primary shadow rounded-circle mb-5"> <i class="ni ni-favourite-28"> </i></div>
                <h3 class="display-3 text-justify">Features</h3>
                <p>The time is now for the next step in farming. We bring you the future of farming along with great tools for asisting the farmers.</p>
                <ul class="list-unstyled mt-5"> 
                  <li class="py-2"> 
                    <div class="d-flex align-items-center"> 
                      <div>
                        <div class="badge badge-circle badge-primary mr-3"> <i class="ni ni-settings-gear-65"> </i></div>
                      </div>
                      <div>
                        <h6 class="mb-0">Crop Prediction and Recommendation</h6>
                      </div>
                    </div>
                  </li>
                  <li class="py-2"> 
                    <div class="d-flex align-items-center"> 
                      <div>
                        <div class="badge badge-circle badge-primary mr-3"> <i class="ni ni-html5"> </i></div>
                      </div>
                      <div>
                        <h6 class="mb-0">Fertilizer Recommendation</h6>
                      </div>
                    </div>
                  </li>
                  <li class="py-2"> 
                    <div class="d-flex align-items-center"> 
                      <div>
                        <div class="badge badge-circle badge-primary mr-3"> <i class="ni ni-settings-gear-65"> </i></div>
                      </div>
                      <div>
                        <h6 class="mb-0">yield Prediction</h6>
                      </div>
                    </div>
                  </li>
                  <li class="py-2"> 
                    <div class="d-flex align-items-center"> 
                      <div>
                        <div class="badge badge-circle badge-primary mr-3"> <i class="ni ni-satisfied"> </i></div>
                      </div>
                      <div>
                        <h6 class="mb-0">Rainfall Prediction</h6>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
			

		  
            <div class="col-lg-7 col-md-12 pl-md-0"> 
 <img class="img-fluid ml-lg-5" src="assets/img/features.png" width="100%">
 </div>
			
			
          </div>
        </div>
        <span > </span>
      </div>
     
	<!-- ======================================================================================================================================== -->
 
	 


         

<?php require("footer.php");?>


</body>

</html>