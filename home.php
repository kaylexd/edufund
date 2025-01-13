

<?php
// Define the URL of the background image
$backgroundImage = 'img/scc.jpeg'; // Replace with your image URL
$thirdImage = 'img/scc-logo.png'; // Replace with the URL of the third image
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The College EduFund System of St. Cecilia’s College</title>
    <link rel="stylesheet" href="css/about.css" />
    
    <style>
         body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
        }

        .main-section {
            background-image: url('<?php echo $backgroundImage; ?>'); /* Using PHP to set the background image */
            background-size: cover; /* Ensures the image covers the entire section */
            background-position: center; /* Centers the image */
            height: 100vh; /* Makes the section full height of the viewport */
            color: white; /* Text color for visibility */
            display: flex; /* Allows for centering content */
            flex-direction: column; /* Stacks items vertically */
            justify-content: center; /* Centers content vertically */
            align-items: center; /* Centers content horizontally */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7); /* Adds shadow for better readability */
        }
        .third-image {
      position: absolute;
      top: 30%; /* Position in the middle vertically */
      left: 50%; /* Center it horizontally */
      transform: translate(-50%, -50%); /* Adjust to center the image properly */
      width: 10%; /* Adjust size of the image */
      height: auto;
      animation: slideThirdImage 20s linear infinite; /* Infinite animation for sliding */
      z-index: 2; /* Ensure this image is above both background and second images */
    }





    </style>



  </head>
  <body 
> 
<header>
      
      <nav>
   
        <ul>
          <b></b>
          <li><h3 ><a href="home.php" class="about-link" style="text-decoration: none; color:white;">College Scholarship Application System of St.Cecilia's </a></h3></li>
          <li></li>
          <li></li>
          <li><a href="home.php" class="about-link" style="text-decoration: none; color:white;">Home</a></li>
  
          <li><a href="Aboutus.php" class="register-link"style="text-decoration: none; color:white;">About us</a></li>
          <li><a href="Scholarship.php" class="register-link"style="text-decoration: none; color:white;">Scholarships</a></li>
          <li><a href="register.php" class="register-link"style="text-decoration: none; color:white;">Register</a></li>
          <li><a href="login.php" class="about-link" style="text-decoration: none; color:white;">Login</a></li>
          


          

          </div>
        </ul>
      </nav>
    </header>


 
    <main class="main-section">
    <img src="<?php echo $thirdImage; ?>" alt="Third Image" class="third-image" />
   <h1 style="font-size:18px;letter-spacing: 20px;">WELCOME!</h1>
        <h1 style="letter-spacing: 5px; margin-bottom:5px">College Edufund of St. Cecilias College Cebu</h1>
        <p  style="text-align:center">We're excited to support passionate and dedicated students like you in your journey towards  academic excellence.
       </p>
            <br>
       <button style="font-size: 16px;      /* Text size */
    padding: 10px 20px;   /* Space around text */
    background-color: crimson; /* Button color */
    color: white;         /* Text color */
    border: none;         /* No border */
    border-radius: 5px;   /* Rounded corners */
    cursor: pointer; " type="button">Apply now!</button>
    </main>


    
 
 
   
    <footer>
      <div class="footer-content">
        <img src="img/scc-logo.png" alt="Logo" class="logo" />
        <div class="text-content3">
          <h3 style="color:white;">St.Cecilia's College</h3>
          <p style="color:white;">Supervised by the Lasallian School Supervision office (LASSO).</p>
        </div>
        <img src="img/ched.png" alt="R" class="logo1" />
        <div class="text-content3">
          <h3 style="color:white;">Commission on Higher Education</h3>
          <p style="color:white;">
            To promote equitable access and ensure quality and <br />relevance
            of higher education institution and their programs..
          </p>
        </div>
      </div>
      <div class="h1" style="padding-top: 30px"><h3>Contact Us</h3></div>
      <div class="footer-content">
        <img src="img/loc.png" alt="Logo" class="logo3" />
        <div class="text-content1">
          <p>
            Cebu South National Highway, <br />Pablaction Ward II , Minglanilla
            ,Cebu
          </p>
        </div>
        <img src="img/telephone.png" alt="Logo" class="logo4" />
        <div class="text-content1">
          <p>
            Tel. No. (032) 236 3677 /<br />
            (032) 497 0767 (032) 268 4746
          </p>
        </div>
      </div>

      <div class="footer-content">
        <img src="img/email.png" alt="Logo" class="logo3" />
        <div class="text-content1">
          <p>sccreg@gmail.com</p>
        </div>
        <img src="img/web.png" alt="Logo" class="logo3" />
        <div class="text-content1">
          <p>CollegeEdufund.scc.edu.ph</p>
        </div>
      </div>

      <div class="space"></div>

      <div class="footer-bottom">
        <p>&copy; 2024 CollegeEdufund. All rights reserved.</p>
        <br>
      </div>
    </footer>
  </body>
</html>
