<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The College EduFund System of St. Cecilia’s College</title>
    <link rel="stylesheet" href="css/login.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  </head>
  <body>
  <header>
      
      <nav>
      <?php
// Define a condition to hide the Home link
$show_Scholarship_link = false; // Set to false to hide, or true to show

// Navigation menu
?>
        <ul>
          <b></b>
          <li><h3 ><a href="home.php" class="about-link" style="text-decoration: none; color:white;">College Edufund  of St.Cecilia's </a></h3></li>
          <li></li>
          <li></li>
          <li></li>
          
         
     
          <li><a href="home.php" class="about-link" style="text-decoration: none; color:white;">Home</a></li>
          <li><a href="Aboutus.php" class="register-link"style="text-decoration: none; color:white;">About us</a></li>
          <li><a href="register.php" class="register-link"style="text-decoration: none; color:white;">Register</a></li>
          <li><a href="login.php" class="about-link" style="text-decoration: none; color:white;">Login</a></li>
          <?php if ($show_Scholarship_link): ?>
            <li><a href="Scholarship.php" class="register-link"style="text-decoration: none; color:white;">Scholarships</a></li>
            <?php endif; ?>
          

          </div>
        </ul>
      </nav>
    </header>
    <main>
    
    <section class="Title">
      <img src="img/login1.png" alt="caputre1" />
          <div class="main-item">
            
           <div class="login-container">
              <img src="img/user2.png" alt="user2" />
             <h2>WELCOME BACK!</h2>
              <p style="padding: 0 ;">To keep connected  with us please 
              login with you personal info</p>
              <br>
              <?php
        if (isset($_SESSION['error'])) {
            echo "<div class='error'>" . $_SESSION['error'] . "</div>";
            unset($_SESSION['error']); // Clear the error after displaying it
        }
    ?>
            <form action="logincode.php" method="POST">
              <div class="input-container">
                  <i class="fas fa-user"></i>
                  <input type="text" name="username" placeholder="Enter email" class="input-field">
              </div>
            
              <div class="input-container">
                  <i class="fas fa-lock"></i>
                  <input type="password" name="password" placeholder="Password" class="input-field">
              </div>
            
                 <label class="custom-checkbox">
                    <input type="checkbox">
                      <span class="checkmark"></span>
                      <p>Remember me</p>
                    </label>
                  <a href="#" class="forgot-password">Forgot Password?</a>
                  <br>
                  <br>
                  <div class="button">
                    <button type="submit">Login</button>
                    <a href="register.php"><button type="button">Register</button></a>
                  </div>
                  
             </form>  
            </div>  
         </div>


      </div>
      
  </section>
    </main>
    <footer>
     
        <div class="footer-content">
          <img src="img/OIP.png" alt="Logo" class="logo">
          <div class="text-content">
              <h4>St.Cecilia's College</h4>
             <p>Supervised by the Lasallian School Supervision office (LASSO).</p>
          </div>
          <img src="img/R.png" alt="R" class="logo1">
          <div class="text-content">
              <h4 >Commission on Higher Education</h4>
             <p> To promote equitable access and  ensure 
              quality and <br>relevance of higher education institution and  their programs..</p>
          </div>
        </div>  
        <div class="h1" style="padding-top: 30px ;"> <h3>Contact Us </h3></div>
        <div class="footer-content">
          <img src="img/loc.png" alt="Logo" class="logo3">
          <div class="text-content1">
             <p>Cebu South National Highway, <br>Pablaction Ward II , Minglanilla ,Cebu</p>
          </div>
          <img  src="img/telephone.png" alt="Logo" class="logo4" >
          <div class="text-content1">
          
             <p> Tel. No. (032) 236 3677 /<br> (032) 497 0767
              (032) 268 4746</p>
          </div>
        </div>  

        <div class="footer-content">
          <img src="img/email2.png" alt="Logo" class="logo3">
          <div class="text-content1">
             <p>sccreg@gmail.com</p>
        </div>
          <img src="img/web.png" alt="Logo" class="logo3">
          <div class="text-content1"> 
             <p> CollegeEdufund.scc.edu.ph</p>
          </div>
        </div>  
       
        <div class="space"></div>
        
      <div class="footer-bottom">
          <p>&copy; 2024 CollegeEdufund. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>