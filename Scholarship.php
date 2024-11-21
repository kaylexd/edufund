<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The College EduFund System of St. Cecilia’s College</title>
    <link rel="stylesheet" href="css/aboutt.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap"
      rel="stylesheet"
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    />
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
      
      <div class="scholarship-box">
        <div class="scholarship-content1">
          <!-- Logo beside the headline -->
          <img src="img/scc-logo.png" alt="Logo" class="scholarship-logo" />

          <!-- Heading and tagline -->
          <div class="scholarship-text">
            <h1 style="color:white;" class="scholarship-header">St. Cecilias College Scholarship</h1>
            <p class="scholarship-tagline">
              Empowering the brightest minds through excellence
            </p>
          </div>
        </div>
      </div>
      <section class="scholarship-section new-scholarship">
          <div class="scholarship-container">
            <div class="scholarship-content">
              <div class="scholarship-header">
                <h2> NON-ACADEMIC SCHOLARSHIP (NAS)</h2>
                <p>
                Student who balances academic responsibilities with part-time or full-time employment.
                This dual role allows them to gain work experience, develop time management skills,
                and often support their educational expenses while pursuing their studies.<br />
                </p>
              </div>
              <div class="scholarship-qualifications">
                <br />
                <h3>Qualifications</h3>
                <br />
                <ul>
                  <li>1. At least a Senior High graduate/ College level </li>
                  <li>2.  With good moral character</li>
                  <li> 3. Willing to work as a working scholar to assist teachers in preschool and in Grade 1-6</li>
                  <li> 4. Willing to work in the SCC-CI offices/ Teacher Aid</li>
                  <br />
                </ul>
              </div>
              <div class="scholarship-requirements">
                <h3>Requirements</h3>
                <br />
                <h4>
                  A. For Senior High School Graduates/High school Graduates
                </h4>
                <ul>
                  <li>1.  Form 138 or report card original</li>
                  <li>2.  Transcrip of Record (TOR)</li>
                  <li>3. Certificate for Good Moral Character</li>
                  <li> 4.Photocopy of NSO Cert</li>
                  <li> 5. 2x2 colored pictures</li>
                </ul>
                <br />
                <h4></h4>
                <ul>
                  
                </ul>
              </div>

              <div class="scholarship-discounts">
                <h3>Scholarship Benifits</h3>
                <ul>
                  <br />
                
                  <li>100% free school fees (enrolment fee, Tuition fee, Misc., and other fees)</li>
                </ul>
              </div>
              <div class="scholarship-apply-button">
                <br />
                <button >  Apply now</button>
              </div>
            </div>
            <div class="nonacaemic-image">
              <!-- Add the relevant image here for the new scholarship -->
              <img src="img/joma1.PNG" alt="New Scholarship" />
            </div>
          </div>
        </section>
      </section>
   

      

      

     



 <!-- Add the relevant image here for the new scholarship -->
      <section class="scholarship-section">
        <div class="scholarship-container">
          <div class="scholarship-image">
            <img style=" width: 600px; margin:0;" src="img/jeff.PNG" alt="Admin Scholarship Student" />
          </div>
          <div class="scholarship-content">
            <div class="scholarship-header">
              <h2>ADMIN SCHOLARSHIP</h2>
              <p>
              Are aimed at students who show strong leadership potential, organizational
              skills, and a commitment to managing and improving systems within various sectors.
              </p>
            </div>
              
            <div class="scholarship-qualifications">
              <br />
              <h3>Criteria/Qualifications</h3>
              <br />
              <ul>
              <li style="color:red;">Dependents of the regular Employee of SCC-CI can avail of the following discounts:
                </li>
                <br>
              <ul>A. The beneficiaries of Admin scholars must be two dependents per regular employee. </ul>
              <br>
              <ul>B. Who will qualify for admin scholar: (siblings and brother, sister, husband, and wife).
              They can avail 100% free on Tuition, Miscellaneous, Lab fee, and Enrollement fees</ul>
              <br>
              <ul>C.The immediate family members like nephews, nieces, first degree Cousins can avail of discounts on tuition fees only: </ul>
              <br>
              <ul> </ul>
              
            </div>

            <div class="scholarship-requirements">
              <br />
              <h3>Requirements</h3>
              <br />
              <ul>
                <ul>A. Certificate of Employment (COE)</ul>
                <br />
                <lu>B. Photocopy of PSA</ul>
                <br />
                <ul>C. Photocopy of Good Moral</ul>
                <br>
                <ul>D. Original copy of Form 138</ul>
               
                
              </ul>
            </div>
            <br />
            <div class="scholarship-discounts">
              <h3>Discounts</h3>
              <br />
              <p>A. 3-5 years regular – 50% Tuition Fee</p>
              <br />
              <p>B. 6-10 years regular – 100%Tuition Fee</p>
            </div>

            <div class="scholarship-apply-button">
              <br />
              <button>Apply Now</button>
            </div>
          </div>
        </div>
        
      </section>
 
  



      
     
      <section>
        <div class="scholarship-box">
          <div class="scholarship-content1">
            <!-- Logo beside the headline -->
            <img src="img/ched.png" alt="Logo" class="scholarship-logo" />

            <!-- Heading and tagline -->
            <div class="scholarship-text">
              <h1 style="color:white;" class="scholarship-header">Non-Academic Scholarship</h1>
              <p class="scholarship-tagline">
                Education system that is equitable and producing locally<br />
                responsive, innovative, and globally competitive graduates and
                lifelong learners
              </p>
            </div>
          </div>
        </div>
        <section class="scholarship-section new-scholarship">
          <div class="scholarship-container">
            <div class="scholarship-content">
              <div class="scholarship-header">
                <h2>(CHED UniFAST) </h2>
                <p>
                  (CHED UniFAST) St. Cecilia’s College– Minglanilla, in
                  partnership with CHED UniFAST (Unified Student Financial
                  Assistance System for Tertiary Education) under the Republic
                  Act No. 10931, the “Universal Access to Quality Tertiary
                  Education”, is giving an opportunity for those who wish to
                  pursue a college education but financially unstable.<br />
                </p>
              </div>
              <div class="scholarship-qualifications">
                <br />
                <h3>Qualifications</h3>
                <br />
                <ul>
                  <li>✔ Senior High school Graduates of Batch 2018</li>
                  <li>✔ High school Graduates of Batch 2015 downwards</li>
                  <li>✔ College Level</li>
                  <br />
                </ul>
              </div>
              <div class="scholarship-requirements">
                <h3>Requirements</h3>
                <br />
                <h4>
                  A. For Senior High School Graduates/High school Graduates
                </h4>
                <ul>
                  <li>✔ Report Card or Form 138</li>
                  <li>✔ Certificate of Good Moral Character</li>
                  <li>✔ 2pcs 2X2 ID Colored Picture w/ white background</li>
                  <li>✔ Birth Certificate Authenticated by NSO (Photocopy)</li>
                </ul>
                <br />
                <h4>B. For Transferees</h4>
                <ul>
                  <li>✔ TOR</li>
                  <li>✔ Certificate of Good Moral Character</li>
                  <li>✔ 2pcs 2X2 ID Colored Picture w/ white background</li>
                  <li>✔ Birth Certificate Authenticated by NSO (Photocopy)</li>
                  <br />
                </ul>
              </div>

              <div class="scholarship-discounts">
                <h3>Discounts</h3>
                <ul>
                  <br />
                  <li>50% Dis. on Tuition fee</li>
                  <li>Full scholarship for top-performing students</li>
                </ul>
              </div>
              <div class="scholarship-apply-button">
                <br />
                <button >  Apply now</button>
              </div>
            </div>
            <div class="nonacaemic-image">
              <!-- Add the relevant image here for the new scholarship -->
              <img src="img/unifast.png" alt="New Scholarship" />
            </div>
          </div>
        </section>
      </section>

 <!-- Add the relevant image here for the new scholarship -->
      <section class="scholarship-section">
        <div class="scholarship-container">
          <div class="scholarship-image">
            <img src="img/Admin.PNG" alt="Admin Scholarship Student" />
          </div>
          <div class="scholarship-content">
            <div class="scholarship-header">
              <h2>TES Scholarship Tertiary Education Subsidy</h2>
              <p>
              The CHED Tertiary Education Subsidy (TES) helps Filipino students 
              by providing financial aid for higher education, making college more accessible and affordable.
              </p>
            </div>

            <div class="scholarship-qualifications">
              <br />
              <h3>Criteria/Qualifications</h3>
              <br>
              <li style="color:red">To qualify for the CHED Tertiary Education Subsidy (TES), you must meet the following criteria: </li>
              <br />
              <ul>
                <li>
                Citizenship: You must be a Filipino citizen.</li>
                <br />
                <li> Enrollment Status: You must be enrolled in an undergraduate program at a State University or College (SUC), 
                  Local University or College (LUC), or a Private Higher Education Institution (HEI) recognized by CHED.</li>
                <br />
                <li> Program Duration: Your program should not exceed the standard duration of four to five years,
                plus a one-year grace period.</li>
                <br /> 

                <h3>Priority Beneficiaries:</h3>
                <br>
                <li> Students from households included in Listahanan 2.0, ranked by estimated per capita household income</li>
                <br />
                <li> tudents not in Listahanan 2.0, ranked by estimated per capita household income based on submitted proof, 
                  as determined by the UniFAST Board.</li>
                <br />
            </div>

            <div class="scholarship-requirements">
              <br />
              <h3>Requirements</h3>
              <br />
              <ul>
                <li>Enrollment List: Provide a certified copy or digital list of enrolled students, including your Certificate of 
                  Registration/Enrollment (CORS/COEs), to confirm enrollment and fees charged.</li>
                <br />
                <li>Certificate of Residency: Attach a certified Certificate of Residency from your Barangay Captain,
                   or use a valid government ID showing your name and residence.</li>
                <br />
                <li>Proof of Income: If not in Listahanan 2.0, submit documents like pay slips, 
                  contracts, or a case study by a Social Welfare Officer to verify household income.</li>
                <br />
                
              </ul>
            </div>

      

            <div class="scholarship-apply-button">
              <br />
              <button>Apply Now</button>
            </div>
          </div>
        </div>
        
      </section>

 <!-- Add the relevant image here for the new scholarship -->


    </main>
   
    <section class="testimonial-section">
      <div class="testimonial-container">
        <div class="testimonial-item">
          <img src="img/tes-grad.PNG" alt="Graduate" />
          <div class="testimonial-text">
            <h3>St.Cecilias Alumni</h3>
            <p><i>
              “As a student of St. Cecilia's, I was able to reach my full
              potential thanks to the mentorship and guidance of my professors.
              The scholarship program allowed me to focus on my studies and
              excel in my field without worrying about finances.”
            </p></i>
          </div>
        </div>
      </div>
    </section>
 
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
