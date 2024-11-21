

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The College EduFund System of St. Cecilia’s College</title>
    <link rel="stylesheet" href="css/aboutt.css" />
  </head>

  <body>

  
  <header>
  <?php
// Define a condition to hide the Home link
$show_Aboutus_link = false; // Set to false to hide, or true to show

// Navigation menu
?>





      <nav>
        
        <ul>
          <b></b>
          <li><h3 ><a href="" class="about-link" style="text-decoration: none; color:white;">College Edufund of St.Cecilia's </a></h3></li>
          <li></li>
          <li></li>
          <li></li>
      
          <li><a href="home.php" class="about-link" style="text-decoration: none; color:white;">Home</a></li>
         
          <li><a href="Scholarship.php" class="register-link"style="text-decoration: none; color:white;">Scholarships</a></li>
         
          <li><a href="register.php" class="register-link"style="text-decoration: none; color:white;">Register</a></li>
          <li><a href="login.php" class="about-link" style="text-decoration: none; color:white;">Login</a></li>
          <?php if ($show_Aboutus_link): ?>
          <li><a href="Aboutus.php" class="register-link"style="text-decoration: none; color:white;">About us</a></li>
          <?php endif; ?>

          

          </div>
        </ul>
      </nav>
    </header>

 

   

   

      <section class="Title">
        <div class="logo-container">
        
          <div class="text-content">
            <h2>"Connect with St. Cecilia's College"</h2>
            <p style="color: black; text-align:left;; margin-left:80px;">
              Dedicated department within an educational institution or
              organization that manages and administers scholarships and
              financial aid for students. Our primary role is to support
              students by providing financial assistance, ensuring that
              deserving individuals can pursue their education without the
              burden of excessive financial strain.
          </p>
          </div>
          <div class="rotate-image">
          <img style="margin-right:80px" src="img/scc-logo.png" alt="Rotating Image" class="rotate-image" />
          </div>
        </div>
      </section>

      <section class="main">
        <div  class="main-item active">
          <h2 >MISSION</h2><br>
          <p  >
            To empower students by providing equitable access to financial
            resources and opportunities that foster academic achievement,
            personal growth, and career success. We are committed to supporting
            a diverse and inclusive community of learners through efficient
            management of scholarships and financial aid programs.
          </p>
        </div>
      </section>
          <br>
      <section class="main">
        <div  class="main-item active">
          <h2 >VISION</h2><br>
          <p >
            To be a leader in transforming lives by ensuring that financial
            barriers do not hinder any student's ability to pursue higher
            education. We aspire to create a future where every deserving
            student has access to the resources needed to achieve their
            educational and career aspirations.
          </p>
        </div>
      </section>
      <br>
      <section class="w">
        <div  class="main-item active">
          <h2 >WHO WE ARE</h2>
          <p ><br>
            Empowering Dreams Through Education:<br> We provide scholarships that
            pave the way for aspiring scholars to achieve their academic goals.
          </p>
        </div>
      </section>
      <br>
      <section class="menu">
        <div class="menu-item active">
          <img src="img/dagup.png" alt="daguplo" />
          <h2 style="color:red">Mr. Gemini S. Daguplo</h2>
          <p>Marketing & Scholarship Head Officer</p>
        </div>

        <div class="menu-item">
          <img src="img/gab.png" alt="gabriel" />
          <h2 style="color:red">Ms. Gabrielle B. Heruela</h2>
          <p>Marketing & Scholarship Secretary</p>
        </div>

        <div class="menu-item">
          <img src="img/james.png" alt="james" />
          <h2 style="color:red">Mr. James D. Deiparine</h2>
          <p>Marketing Officer</p>
        </div>
      </section>
  </div>
  </div> 
  
 
    <footer>
     
     <div class="footer-content">
       <img src="img/OIP.png" alt="Logo" class="logo">
       <div class="text-content1">
           <h3>St.Cecilia's College</h3>
          <p>Supervised by the Lasallian School Supervision office (LASSO).</p>
       </div>
       <img src="img/R.png" alt="R" class="logo1">
       <div class="text-content1">
           <h3>Commission on Higher Education</h3>
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
       <img src="img/telephone.png" alt="Logo" class="logo4">
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
