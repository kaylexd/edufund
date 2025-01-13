<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php"); 
  exit();
}

$id = $_SESSION['user_id'];  

// Query to fetch personal details from the database
$query = "SELECT * FROM students WHERE id = ?";
$stmt = $conn->prepare($query);  
$stmt->bind_param("i", $id);  
$stmt->execute();
$result = $stmt->get_result();  
$row = $result->fetch_assoc();  
$stmt->close();
$semail = isset($row['semail']) ? $row['semail'] : '';



$sql = "SELECT COUNT(*) as count FROM announcements WHERE student_id = ? AND is_read = 0";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$count = $result->fetch_assoc()['count'];


?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Student</title>

  <!-- Custom fonts -->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../vendor/fontawesome/css/all.min.css" rel="stylesheet">

    <!-- Custom styles -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Core JavaScript -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="../vendor/chart.js/Chart.min.js"></script>

    <!-- Parsley.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>

    <!-- Custom scripts -->
    <script src="../js/sb-admin-2.min.js"></script>
    <script src="../js/demo/datatables-demo.js"></script>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">


  
   <!-- Sidebar -->
   <ul class="navbar-nav bg-gray-700 sidebar sidebar-dark accordion" id="accordionSidebar">



<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
  <div class="sidebar-brand-icon">
  <img src="../img/logo.png" alt>
  </div>
  <div class="sidebar-brand-text mx-3">SCC</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item">
  <a class="nav-link" href="index.php">
  <i class="fa-solid fa-house"></i>
    <span>Dashboard</span></a>
</li>


<!-- Nav Item - Dashboard -->
<li class="nav-item">
  <a class="nav-link" href="apply.php">
  <i class="fa-solid fa-magnifying-glass"></i>
    <span>Apply</span></a>
</li>

<li class="nav-item">
  <a class="nav-link" href="profile.php">
  <i class="fa-solid fa-user"></i>
    <span>Profile</span></a>
</li>

<!-- Heading 
<div class="sidebar-heading">
  Interface
</div>
  -->


</ul>
<!-- End of Sidebar -->
    
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-dark navbar-crimson topbar mb-4 static-top shadow">

       

          

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-bell fa-fw text-white"></i>
                  <!-- Counter - Alerts -->
                  <span class="badge badge-danger badge-counter"><?php echo $count; ?></span>
              </a>
</li>
            

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-white small">
                  
                <?php echo htmlspecialchars($semail); ?> 
                  
                </span>
                <img class="img-profile rounded-circle" src="../img/user-solid.svg">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->
 <!-- Begin Page Content -->
 <div class="container-fluid">

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  
  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>

          <form action="../home.php" method="POST"> 
          
            <button type="submit" name="logout_btn" class="btn btn-primary">Logout</button>

          </form>


        </div>
      </div>
    </div>
  </div>

       <!-- Header -->
       <form method="POST" action="non-academic_action.php" enctype="multipart/form-data"> <!-- Add enctype here -->
       <input type="hidden" name="grades_image_data" id="grades_image_data">
      <input type="hidden" name="moral_image_data" id="moral_image_data">
      <input type="hidden" name="indigency_image_data" id="indigency_image_data">
      <input type="hidden" name="medical_image_data" id="medical_image_data">

                                                      
       <div class="row justify-content-center"><div class="col-md-10">
        <h1 class="h3 mb-4 text-gray-800">Non-Academic Scholarship (NAS)<br>Application Form</h1>
          <span id="message"></span>
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a class="nav-link active_tab1" id="list_personal_details" style="border:1px solid #ccc">Personal Details</a>
            </li>
            <li class="nav-item">
              <a class="nav-link inactive_tab1" id="list_family_details" style="border:1px solid #ccc">Family Details</a>
            </li>
            <li class="nav-item">
              <a class="nav-link inactive_tab1" id="list_achievement_details" style="border:1px solid #ccc">Application Details</a>
            </li>
            <li class="nav-item">
              <a class="nav-link inactive_tab1" id="list_require_details" style="border:1px solid #ccc">Requirements Details</a>
            </li>
          </ul>
    <!-- Personal Details -->
      <div class="tab-content" style="margin-top:16px;">
        <div class="tab-pane show active" id="personal_details">
          <div class="card">
            <div class="card-header" style="font-weight: bold; font-size: 16px;">Fill Personal Details</div>
              <div class="card-body">
                <div class="form-group">
                  <h4 class="sub-title">Personal Details</h4>
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-3">
                      <label>First Name<span class="text-danger">*</span></label>
                      <input type="text" name="sfname" id="sfname" class="form-control" />
                      <span id="error_sfname" class="text-danger"></span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3">
                      <label>Middle Name<span class="text-danger">*</span></label>
                      <input type="text" name="smname" id="smname" class="form-control" />
                      <span id="error_smname" class="text-danger"></span>
                      </div>
                    <div class="col-xs-12 col-sm-12 col-md-3">
                      <label>Last Name<span class="text-danger">*</span></label>
                      <input type="text" name="slname" id="slname" class="form-control" />
                      <span id="error_slname" class="text-danger"></span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3">
                      <label>Select Suffix</label>
                      <select name="sfix" id="sfix" class="form-control" required>
                      <option value="">-Select-</option>
                      <option value="N/A">N/A</option>
                        <option value="Jr.">Jr.</option>
                        <option value="Sr.">Sr.</option>
                      </select>
                      <span id="error_sfix" class="text-danger"></span>
                    </div>
                    <div class="col-xs-10 col-sm-12 col-md-4">
                      <label>Date of Birth<span class="text-danger">*</span></label>
                      <input type="date" name="sdbirth" id="sdbirth" autocomplete="off" class="form-control" />
                      <span id="error_sdbirth" class="text-danger"></span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                      <label>Select Gender<span class="text-danger">*</span></label>
                      <select name="sgender" id="sgender" class="form-control" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                      </select>
                      <span id="error_sgender" class="text-danger"></span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                      <label>Citizenship<span class="text-danger">*</span></label>
                      <input type="text" name="sctship" id="sctship" class="form-control" />
                      <span id="error_sctship" class="text-danger"></span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                      <label>Address<span class="text-danger">*</span></label>
                      <input type="text" name="saddress" id="saddress" class="form-control" required>
                      <span id="error_saddress" class="text-danger"></span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                      <label>Contact Number<span class="text-danger">*</span></label>
                      <input type="text" name="scontact" id="scontact" class="form-control" />
                      <span id="error_scontact" class="text-danger"></span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 offset-md-4">
                      <label>Email Address<span class="text-danger">*</span></label>
                      <input type="text" name="semail" id="semail"  class="form-control" readonly />
                      <span id="error_semail" class="text-danger"></span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                      <label>Student Course<span class="text-danger">*</span></label>
                      <select name="scourse" id="scourse" class="form-control" required>
                                            <option value="">-Select-</option>
                                            <option value="BSIT">BSIT</option>
                                            <option value="BSBA">BSBA</option>
                                            <option value="BEED">BEED</option>
                                            <option value="BSED">BSED</option>
                                            <option value="BSCRIM">BSCRIM</option>
                                            <option value="BSHM">BSHM</option>
                                            <option value="BSTM">BSTM</option>
                                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 offset-md-4">
                      <label>Student Year Level<span class="text-danger">*</span></label>
                      <select name="syear" id="syear" class="form-control" required>
                                            <option value="">-Select-</option>
                                            <option value="1st Year">1st Year</option>
                                            <option value="2nd Year">2nd Year</option>
                                            <option value="3rd Year">3rd Year</option>
                                            <option value="4th Year">4th Year</option>
                                        </select>
                    </div>
                  </div>
                </div>
                <div class="form-group text-center">
                  <a class="btn btn-primary" href="apply.php" role="button">Back</a>
                  <button type="button" name="btn_personal_details" id="btn_personal_details" class="btn btn-success btn-md">Next</button>
                </div>
              </div>
          </div>
        </div>
    <!-- Family Details -->
      <div class="tab-pane" id="family_details">
        <div class="card">
        <div class="card-header" style="font-weight: bold; font-size: 16px;">Fill Family Details</div>
          <div class="card-body">
            <div class="form-group">
                  <h4 class="sub-title">Guardian Details</h4>
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                      <label>Full Name<span class="text-danger">*</span></label>
                      <input type="text" name="sgfname" id="sgfname" class="form-control" />
                      <span id="error_sgfname" class="text-danger"></span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                      <label>Address<span class="text-danger">*</span></label>
                      <input type="text" name="sgaddress" id="sgaddress" class="form-control" required>
                      <span id="error_sgaddress" class="text-danger"></span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                      <label>Contact Number<span class="text-danger">*</span></label>
                      <input type="text" name="sgcontact" id="sgcontact" class="form-control" />
                      <span id="error_sgcontact" class="text-danger"></span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                      <label>Occupation<span class="text-danger">*</span></label>
                      <input type="text" name="sgoccu" id="sgoccu" class="form-control" />
                      <span id="error_sgoccu" class="text-danger"></span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                      <label>Company<span class="text-danger">*</span></label>
                      <input type="text" name="sgcompany" id="sgcompany" class="form-control" />
                      <span id="error_sgcompany" class="text-danger"></span>
                    </div>
                </div>
              </div>
              <div class="form-group">
                  <h4 class="sub-title">Father Details</h4>
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                      <label>Full Name<span class="text-danger">*</span></label>
                      <input type="text" name="sffname" id="sffname" class="form-control" />
                      <span id="error_sffname" class="text-danger"></span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                      <label>Address<span class="text-danger">*</span></label>
                      <input type="text" name="sfaddress" id="sfaddress" class="form-control" required>
                      <span id="error_sfaddress" class="text-danger"></span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                      <label>Contact Number<span class="text-danger">*</span></label>
                      <input type="text" name="sfcontact" id="sfcontact" class="form-control" />
                      <span id="error_sfcontact" class="text-danger"></span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                      <label>Occupation<span class="text-danger">*</span></label>
                      <input type="text" name="sfoccu" id="sfoccu" class="form-control" />
                      <span id="error_sfoccu" class="text-danger"></span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                      <label>Company<span class="text-danger">*</span></label>
                      <input type="text" name="sfcompany" id="sfcompany" class="form-control" />
                      <span id="error_sfcompany" class="text-danger"></span>
                    </div>
                </div>
              </div>
              <div class="form-group">
                  <h4 class="sub-title">Mother Details</h4>
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                      <label>Full Name<span class="text-danger">*</span></label>
                      <input type="text" name="smfname" id="smfname" class="form-control" />
                      <span id="error_smfname" class="text-danger"></span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                      <label>Address<span class="text-danger">*</span></label>
                      <input type="text" name="smaddress" id="smaddress" class="form-control" required>
                      <span id="error_smaddress" class="text-danger"></span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                      <label>Contact Number<span class="text-danger">*</span></label>
                      <input type="text" name="smcontact" id="smcontact" class="form-control" />
                      <span id="error_smcontact" class="text-danger"></span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                      <label>Occupation<span class="text-danger">*</span></label>
                      <input type="text" name="smoccu" id="smoccu" class="form-control" />
                      <span id="error_smoccu" class="text-danger"></span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                      <label>Company<span class="text-danger">*</span></label>
                      <input type="text" name="smcompany" id="smcompany" class="form-control" />
                      <span id="error_smcompany" class="text-danger"></span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 offset-md-4">
                      <label>Parents Combine Yearly Income<span class="text-danger">*</span></label>
                      <input type="text" name="spcyincome" id="spcyincome" class="form-control" />
                      <span id="error_spcyincome" class="text-danger"></span>
                    </div>
                </div>
              </div>
              <div class="form-group text-center">
                <button type="button" name="previous_btn_family_details" id="previous_btn_family_details" class="btn btn-primary btn-md">Previous</button>
                <button type="button" name="btn_family_details" id="btn_family_details" class="btn btn-success btn-md">Next</button>
              </div>
          </div>
        </div>
      </div>
    <!-- Application Details -->
    <div class="tab-pane" id="achievement_details">
          <div class="card">
            <div class="card-header" style="font-weight: bold; font-size: 16px;">Fill Application Details</div>
              <div class="card-body">
                <div class="form-group">
                  <h4 class="sub-title">Application Details</h4>
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                      <label>Reasons/Special Circumstances for Applying NAS<span class="text-danger">*</span></label>
                      <textarea type="text" name="s_nas" id="s_nas" placeholder="Put N/A if None" class="form-control" required></textarea>
                      <span id="error_s_nas" class="text-danger"></span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                      <label>Basic Office Skills<span class="text-danger">*</span></label>
                      <textarea type="text" name="s_basic" id="s_basic" placeholder="Put N/A if None" class="form-control" required></textarea>
                      <span id="error_s_basic" class="text-danger"></span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                      <label>Special Skills<span class="text-danger">*</span></label>
                      <textarea type="text" name="s_skills" id="s_skills" placeholder="Put N/A if None" class="form-control" required></textarea>
                      <span id="error_s_skills" class="text-danger"></span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                      <label>Type of Work Interested In<span class="text-danger">*</span></label>
                      <textarea type="text" name="s_work" id="s_work" placeholder="Put N/A if None" class="form-control" required></textarea>
                      <span id="error_s_work" class="text-danger"></span>
                    </div>
                  </div>
                </div>
          <div class="form-group text-center">
            <button type="button" name="previous_btn_achievement_details" id="previous_btn_achievement_details" class="btn btn-primary btn-md">Previous</button>
            <button type="button" name="btn_achievement_details" id="btn_achievement_details" class="btn btn-success btn-md">Next</button>
          </div>
        </div>
        </div>
      </div>
    <!-- Requirement Details -->
        <div class="tab-pane" id="require_details">
            <div class="card">
              <div class="card-header" style="font-weight: bold; font-size: 16px;">Applicant Must Be:</div>
                <div class="card-body">
                  <ul class="list-group d-flex justify-content-center">
                    <li class="list-group-item">1. Senior High Graduate</li>
                    <li class="list-group-item">2. Enrolled of the said Institution</li>
                  </ul>
                </div>
            </div>
            <div class="card">
            <div class="card-header" style="font-weight: bold; font-size: 16px;">List of Requirements</div>
  <div class="card-body">
    <div class="form-group">
      <ul class="list-group d-flex justify-content-center">
        <li class="list-group-item" data-toggle="modal" data-target="#gradesModal" style="cursor: pointer;">
          <div class="d-flex align-items-center">
            <input type="checkbox" class="form-check-input ml-2" id="gradesCheck" disabled>
            <span class="ml-4">Photocopy of Report Card / Grades</span>
            <i class="fas fa-upload ml-auto"></i>
          </div>
        </li>
        <li class="list-group-item" data-toggle="modal" data-target="#moralModal" style="cursor: pointer;">
          <div class="d-flex align-items-center">
            <input type="checkbox" class="form-check-input ml-2" id="moralCheck" disabled>
            <span class="ml-4">Photocopy of Good Moral</span>
            <i class="fas fa-upload ml-auto"></i>
          </div>
        </li>
        <li class="list-group-item" data-toggle="modal" data-target="#indigencyModal" style="cursor: pointer;">
          <div class="d-flex align-items-center">
            <input type="checkbox" class="form-check-input ml-2" id="indigencyCheck" disabled>
            <span class="ml-4">Certificate / Barangay Indigency</span>
            <i class="fas fa-upload ml-auto"></i>
          </div>
        </li>
        <li class="list-group-item" data-toggle="modal" data-target="#medicalModal" style="cursor: pointer;">
          <div class="d-flex align-items-center">
            <input type="checkbox" class="form-check-input ml-2" id="medicalCheck" disabled>
            <span class="ml-4">Medical Certificate</span>
            <i class="fas fa-upload ml-auto"></i>
          </div>
        </li>
        <li class="list-group-item">
          <div class="d-flex align-items-center">
            <span class="ml-4">2x2 Colored Pictures</span>
          </div>
        </li>
      </ul>
    </div>
  </div>
</div>





<!-- Modal for Indigency -->
<div class="modal fade" id="indigencyModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title">Requirements</h5>
                    <p class="requirement-name">Certificate / Barangay Indigency</p>
                </div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="file" class="form-control-file" name="cert_file" id="indigencyFile" accept="image/*">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary save-modal">Submit</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal for Good Moral -->
<div class="modal fade" id="moralModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title">Requirements</h5>
                    <p class="requirement-name">Photocopy of Good Moral</p>
                </div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="file" class="form-control-file" name="moral_file" id="moralFile" accept="image/*">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary save-modal">Submit</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Grades -->
<div class="modal fade" id="gradesModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title">Requirements</h5>
                    <p class="requirement-name">Photocopy of Report Card / Grades</p>
                </div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="file" class="form-control-file" name="grades_file" id="gradesFile" accept="image/*">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary save-modal">Submit</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Medical Certificate -->
<div class="modal fade" id="medicalModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title">Requirements</h5>
                    <p class="requirement-name">Medical Certificate</p>
                </div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="file" class="form-control-file" name="grad_file" id="medicalFile" accept="image/*">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary save-modal">Submit</button>
            </div>
        </div>
    </div>
</div>

                  <div class="form-group">
                    <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault" style="font-style: italic; font-weight: normal;">
                      I certify that the entries above are true and correct to the best of my knowledge. I hereby authorize St. Cecilias Coolege - Cebu INC. to verify such entries.
                    </label>
                    </div>
                    <span id="error_flexCheckDefault" class="text-danger"></span>
                  </div>
                  <div class="form-group">
                    <div class="alert alert-warning" role="alert" style="font-style: italic;"><b>Note:</b> Please wait for announcements and provide the hard copy of the following requirements.</div>
                  </div>  
                  <div class="form-group text-center">
                    <button type="button" name="previous_btn_requirement" id="previous_btn_requirement" class="btn btn-primary btn-md">Previous</button>
                    <button type="submit" name="btn_submit" id="btn_submit" class="btn btn-success">Submit</button>
                  </div>
                </div>
            </div>
        </div>
      </div>
      </div></div>
      </form>

      <script>
    $(document).ready(function(){
      $(document).ready(function() {
    $('#sfname').val("<?php echo htmlspecialchars($row['sfname']); ?>");
    $('#smname').val("<?php echo htmlspecialchars($row['smname']); ?>");
    $('#slname').val("<?php echo htmlspecialchars($row['slname']); ?>");
    $('#sfix').val("<?php echo htmlspecialchars($row['sfix']); ?>");
    $('#sdbirth').val("<?php echo htmlspecialchars($row['sdbirth']); ?>");
    $('#sgender').val("<?php echo htmlspecialchars($row['sgender']); ?>");
    $('#sctship').val("<?php echo htmlspecialchars($row['sctship']); ?>");
    $('#saddress').val("<?php echo htmlspecialchars($row['saddress']); ?>");
    $('#scontact').val("<?php echo htmlspecialchars($row['scontact']); ?>");
    $('#semail').val("<?php echo htmlspecialchars($row['semail']); ?>");
    $('#scourse').val("<?php echo htmlspecialchars($row['scourse']); ?>");
    $('#syear').val("<?php echo htmlspecialchars($row['syear']); ?>");
});


$('.save-modal').click(function() {
    let modalId = $(this).closest('.modal').attr('id');
    let checkboxId = modalId.replace('Modal', 'Check');
    let fileInput = $(this).closest('.modal').find('input[type="file"]');
    
    // Only check the box if a file is selected
    if (fileInput[0].files.length > 0) {
        $(`#${checkboxId}`).prop('checked', true);
        $(this).closest('.modal').modal('hide');
    } else {
        // Optionally add visual feedback that a file is required
        alert('Please select a file before submitting');
    }
});



$('input[type="file"]').change(function(e) {
    let file = e.target.files[0];
    let reader = new FileReader();
    let modalId = $(this).closest('.modal').attr('id');
    let checkboxId = modalId.replace('Modal', 'Check');
    let hiddenInputId = modalId.replace('Modal', '_image_data');
    
    reader.onload = function(e) {
        $(`#${modalId} img`).attr('src', e.target.result).show();
        $(`#${checkboxId}`).prop('checked', true);
        $(`#${hiddenInputId}`).val(e.target.result);
    }
    
    if (file) {
        reader.readAsDataURL(file);
    }
});


  // Personal Details
    $('#btn_personal_details').click(function(){
    var error_sfname = '';
    var error_smname = '';
    var error_slname = '';
    var error_sfix = '';
    var error_sdbirth = '';
    var error_sgender = '';
    var error_sctship = '';
    var error_saddress = '';
    var error_scontact = '';
    var error_semail = '';
    var error_scourse = '';
    var error_syear = '';
    var pcnumval = /^[0-9]{10,15}$/;
    var emailPattern = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
    

    // Validate email
    if ($.trim($('#semail').val()).length == 0) {
            error_semail = 'Email Address is required';
            $('#error_semail').text(error_semail);
            $('#semail').addClass('has-error');
        } else if (!emailPattern.test($('#semail').val())) {
            error_semail = 'Invalid Email Format';
            $('#error_semail').text(error_semail);
            $('#semail').addClass('has-error');
        } else {
            error_semail = '';
            $('#error_semail').text(error_semail);
            $('#semail').removeClass('has-error');
        }

    if($.trim($('#scourse').val()).length == 0)
    {
    error_scourse = 'Student Course is required';
    $('#error_scourse').text(error_scourse);
    $('#scourse').addClass('has-error');
    }
    else
    {
    error_scourse = '';
    $('#error_scourse').text(error_scourse);
    $('#scourse').removeClass('has-error');
    }

    if($.trim($('#syear').val()).length == 0)
    {
    error_syear = 'Student Year Level is required';
    $('#error_syear').text(error_syear);
    $('#syear').addClass('has-error');
    }
    else
    {
    error_syear = '';
    $('#error_syear').text(error_syear);
    $('#syear').removeClass('has-error');
    }

    if($.trim($('#sfname').val()).length == 0)
    {
    error_sfname = 'First Name is required';
    $('#error_sfname').text(error_sfname);
    $('#sfname').addClass('has-error');
    }
    else
    {
    error_sfname = '';
    $('#error_sfname').text(error_sfname);
    $('#sfname').removeClass('has-error');
    }

    if($.trim($('#smname').val()).length == 0)
    {
    error_smname = 'Put N/A if None';
    $('#error_smname').text(error_smname);
    $('#smname').addClass('has-error');
    }
    else
    {
    error_smname = '';
    $('#error_smname').text(error_smname);
    $('#smname').removeClass('has-error');
    }
    
    if($.trim($('#slname').val()).length == 0)
    {
    error_slname = 'Last Name is required';
    $('#error_slname').text(error_slname);
    $('#slname').addClass('has-error');
    }
    else
    {
    error_slname = '';
    $('#error_slname').text(error_slname);
    $('#slname').removeClass('has-error');
    }

    //Suffix

    if($.trim($('#sfix').val()).length == 0)
    {
    error_sfix = 'Select N/A if None';
    $('#error_sfix').text(error_sfix);
    $('#sfix').addClass('has-error');
    }
    else
    {
    error_sfix = '';
    $('#error_sfix').text(error_sfix);
    $('#sfix').removeClass('has-error');
    }

    if($.trim($('#sdbirth').val()).length == 0)
    {
    error_sdbirth = 'Date of Birth is required';
    $('#error_sdbirth').text(error_sdbirth);
    $('#sdbirth').addClass('has-error');
    }
    else
    {
    error_sdbirth = '';
    $('#error_sdbirth').text(error_sdbirth);
    $('#sdbirth').removeClass('has-error');
    }

    if($.trim($('#sgender').val()).length == 0)
    {
    error_sgender = 'Gender is required';
    $('#error_sgender').text(error_sgender);
    $('#sgender').addClass('has-error');
    }
    else
    {
    error_sgender = '';
    $('#error_sgender').text(error_sgender);
    $('#sgender').removeClass('has-error');
    }

    if($.trim($('#sctship').val()).length == 0)
    {
    error_sctship = 'Citizenship is required';
    $('#error_sctship').text(error_sctship);
    $('#sctship').addClass('has-error');
    }
    else
    {
    error_sctship = '';
    $('#error_sctship').text(error_sctship);
    $('#sctship').removeClass('has-error');
    }

    if($.trim($('#saddress').val()).length == 0)
    {
    error_saddress = 'Address is required';
    $('#error_saddress').text(error_saddress);
    $('#saddress').addClass('has-error');
    }
    else
    {
    error_saddress = '';
    $('#error_saddress').text(error_saddress);
    $('#saddress').removeClass('has-error');
    }


      if($.trim($('#scontact').val()).length == 0)
      {
      error_scontact = 'Contact Number is required';
      $('#error_scontact').text(error_scontact);
      $('#scontact').addClass('has-error');
      }
      else
      {
        error_scontact = '';
        $('#error_scontact').text(error_scontact);
        $('#scontact').removeClass('has-error');
    //    }
      }

      if(error_sfname != '' || error_smname != '' 
      || error_slname != '' || error_sfix != ''
      || error_sdbirth != '' || error_sctship != '' 
      || error_saddress != '' || error_scontact != ''
      || error_semail != '' || error_scourse != ''
      || error_syear != ''
      )
      {
      return false;
      }
      else
      {
      $('#list_personal_details').removeClass('active active_tab1');
      $('#list_personal_details').removeAttr('href data-toggle');
      $('#personal_details').removeClass('active');
      $('#list_personal_details').addClass('inactive_tab1');
      $('#list_family_details').removeClass('inactive_tab1');
      $('#list_family_details').addClass('active_tab1 active');
      $('#list_family_details').attr('href', '#family_details');
      $('#list_family_details').attr('data-toggle', 'tab');
      $('#family_details').addClass('active in');
      }
    });
    
      $('#previous_btn_family_details').click(function(){
        $('#list_family_details').removeClass('active active_tab1');
        $('#list_family_details').removeAttr('href data-toggle');
        $('#family_details').removeClass('active in');
        $('#list_family_details').addClass('inactive_tab1');
        $('#list_personal_details').removeClass('inactive_tab1');
        $('#list_personal_details').addClass('active_tab1 active');
        $('#list_personal_details').attr('href', '#personal_details');
        $('#list_personal_details').attr('data-toggle', 'tab');
        $('#personal_details').addClass('active in');
      });
  

  // Family Details
    $('#btn_family_details').click(function(){
        var error_sgfname = '';
        var error_sglstatus = '';
        var error_sgeduc = '';
        var error_sgcontact = '';
        var error_sgaddress = '';
        var error_sgoccu = '';
        var error_sgcompany = '';
        var error_sffname = '';
        var error_sflstatus = '';
        var error_sfeduc = '';
        var error_sfcontact = '';
        var error_sfaddress = '';
        var error_sfoccu = '';
        var error_sfcompany = '';
        var error_smfname = '';
        var error_smlstatus = '';
        var error_smeduc = '';
        var error_smcontact = '';
        var error_smaddress = '';
        var error_smoccu = '';
        var error_smcompany = '';
        var error_snsibling = '';
        var error_spcyincome = '';
    // Guardian
        // Complete Name
        if($.trim($('#sgfname').val()).length == 0)
        {
        error_sgfname = 'First Name is required';
        $('#error_sgfname').text(error_sgfname);
        $('#sgfname').addClass('has-error');
        }
        else
        {
        error_sgfname = '';
        $('#error_sgfname').text(error_sgfname);
        $('#sgfname').removeClass('has-error');
        }

        if($.trim($('#sgmname').val()).length == 0)
        {
        error_sgmname = 'Put N/A if None';
        $('#error_sgmname').text(error_sgmname);
        $('#sgmname').addClass('has-error');
        }
        else
        {
        error_sgmname = '';
        $('#error_sgmname').text(error_sgmname);
        $('#sgmname').removeClass('has-error');
        }

        if($.trim($('#sglname').val()).length == 0)
        {
        error_sglname = 'Last Name is required';
        $('#error_sglname').text(error_sglname);
        $('#sglname').addClass('has-error');
        }
        else
        {
        error_sglname = '';
        $('#error_sglname').text(error_sglname);
        $('#sglname').removeClass('has-error');
        }

        //Guardian Suffix
        if($.trim($('#sgnext').val()).length == 0)
        {
        error_sgnext = 'Select N/A if none';
        $('#error_sgnext').text(error_sgnext);
        $('#sgnext').addClass('has-error');
        }
        else
        {
        error_sgnext = '';
        $('#error_sgnext').text(error_sgnext);
        $('#sgnext').removeClass('has-error');
        }

        // Guardian Address
        if($.trim($('#sgaddress').val()).length == 0)
        {
        error_sgaddress = 'Address is required';
        $('#error_sgaddress').text(error_sgaddress);
        $('#sgaddress').addClass('has-error');
        }
        else
        {
        error_sgaddress = '';
        $('#error_sgaddress').text(error_sgaddress);
        $('#sgaddress').removeClass('has-error');
        }

        // Guardian Contact
        if($.trim($('#sgcontact').val()).length == 0)
        {
        error_sgcontact = 'Contact Number is required';
        $('#error_sgcontact').text(error_sgcontact);
        $('#sgcontact').addClass('has-error');
        }
        else
        {
        //    if (!pcnumval.test($('#sgcontact').val()))
        //    {
        //     error_sgcontact = 'Invalid Contact Number';
        //     $('#error_sgcontact').text(error_sgcontact);
        //     $('#sgcontact').addClass('has-error');
        //    }
        //    else
        //    {
            error_sgcontact = '';
            $('#error_sgcontact').text(error_sgcontact);
            $('#sgcontact').removeClass('has-error');
        //    }
        }

        // Occupation
        if($.trim($('#sgoccu').val()).length == 0)
        {
        error_sgoccu = 'Put N/A if None';
        $('#error_sgoccu').text(error_sgoccu);
        $('#sgoccu').addClass('has-error');
        }
        else
        {
        error_sgoccu = '';
        $('#error_sgoccu').text(error_sgoccu);
        $('#sgoccu').removeClass('has-error');
        }

        // Company
        if($.trim($('#sgcompany').val()).length == 0)
        {
        error_sgcompany = 'Put N/A if None';
        $('#error_sgcompany').text(error_sgcompany);
        $('#sgcompany').addClass('has-error');
        }
        else
        {
        error_sgcompany = '';
        $('#error_sgcompany').text(error_sgcompany);
        $('#sgcompany').removeClass('has-error');
        }

    // Father
        // Complete Name
        if($.trim($('#sffname').val()).length == 0)
        {
        error_sffname = 'First Name is required';
        $('#error_sffname').text(error_sffname);
        $('#sffname').addClass('has-error');
        }
        else
        {
        error_sffname = '';
        $('#error_sffname').text(error_sffname);
        $('#sffname').removeClass('has-error');
        }

        if($.trim($('#sfmname').val()).length == 0)
        {
        error_sfmname = 'Put N/A if None';
        $('#error_sfmname').text(error_sfmname);
        $('#sfmname').addClass('has-error');
        }
        else
        {
        error_sfmname = '';
        $('#error_sfmname').text(error_sfmname);
        $('#sfmname').removeClass('has-error');
        }

        if($.trim($('#sflname').val()).length == 0)
        {
        error_sflname = 'Last Name is required';
        $('#error_sflname').text(error_sflname);
        $('#sflname').addClass('has-error');
        }
        else
        {
        error_sflname = '';
        $('#error_sflname').text(error_sflname);
        $('#sflname').removeClass('has-error');
        }

        //Father Suffix
        if($.trim($('#sfnext').val()).length == 0)
        {
        error_sfnext = 'Select N/A if none';
        $('#error_sfnext').text(error_sfnext);
        $('#sfnext').addClass('has-error');
        }
        else
        {
        error_sfnext = '';
        $('#error_sfnext').text(error_sfnext);
        $('#sfnext').removeClass('has-error');
        }

        // Address
        if($.trim($('#sfaddress').val()).length == 0)
        {
        error_sfaddress = 'Address is required';
        $('#error_sfaddress').text(error_sfaddress);
        $('#sfaddress').addClass('has-error');
        }
        else
        {
        error_sfaddress = '';
        $('#error_sfaddress').text(error_sfaddress);
        $('#sfaddress').removeClass('has-error');
        }

        // Contact
        if($.trim($('#sfcontact').val()).length == 0)
        {
        error_sfcontact = 'Contact Number is required';
        $('#error_sfcontact').text(error_sfcontact);
        $('#sfcontact').addClass('has-error');
        }
        else
        {
        
            error_sfcontact = '';
            $('#error_sfcontact').text(error_sfcontact);
            $('#sfcontact').removeClass('has-error');
        //    }
        }

        // Occupation
        if($.trim($('#sfoccu').val()).length == 0)
        {
        error_sfoccu = 'Put N/A if None';
        $('#error_sfoccu').text(error_sfoccu);
        $('#sfoccu').addClass('has-error');
        }
        else
        {
        error_sfoccu = '';
        $('#error_sfoccu').text(error_sfoccu);
        $('#sfoccu').removeClass('has-error');
        }

        // Company
        if($.trim($('#sfcompany').val()).length == 0)
        {
        error_sfcompany = 'Put N/A if None';
        $('#error_sfcompany').text(error_sfcompany);
        $('#sfcompany').addClass('has-error');
        }
        else
        {
        error_sfcompany = '';
        $('#error_sfcompany').text(error_sfcompany);
        $('#sfcompany').removeClass('has-error');
        }
        
    // Mother
        // Complete Name
        if($.trim($('#smfname').val()).length == 0)
        {
        error_smfname = 'First Name is required';
        $('#error_smfname').text(error_smfname);
        $('#smfname').addClass('has-error');
        }
        else
        {
        error_smfname = '';
        $('#error_smfname').text(error_smfname);
        $('#smfname').removeClass('has-error');
        }

        if($.trim($('#smmname').val()).length == 0)
        {
        error_smmname = 'Put N/A if None';
        $('#error_smmname').text(error_smmname);
        $('#smmname').addClass('has-error');
        }
        else
        {
        error_smmname = '';
        $('#error_smmname').text(error_smmname);
        $('#smmname').removeClass('has-error');
        }

        if($.trim($('#smlname').val()).length == 0)
        {
        error_smlname = 'Last Name is required';
        $('#error_smlname').text(error_smlname);
        $('#smlname').addClass('has-error');
        }
        else
        {
        error_smlname = '';
        $('#error_smlname').text(error_smlname);
        $('#smlname').removeClass('has-error');
        }

        //Mother Suffix
        if($.trim($('#smnext').val()).length == 0)
        {
        error_smnext = 'Select N/A if none';
        $('#error_smnext').text(error_smnext);
        $('#smnext').addClass('has-error');
        }
        else
        {
        error_smnext = '';
        $('#error_smnext').text(error_smnext);
        $('#smnext').removeClass('has-error');
        }

        // Address
        if($.trim($('#smaddress').val()).length == 0)
        {
        error_smaddress = 'Address is required';
        $('#error_smaddress').text(error_smaddress);
        $('#smaddress').addClass('has-error');
        }
        else
        {
        error_smaddress = '';
        $('#error_smaddress').text(error_smaddress);
        $('#smaddress').removeClass('has-error');
        }

        // Contact Number
        if($.trim($('#smcontact').val()).length == 0)
        {
        error_smcontact = 'Contact Number is required';
        $('#error_smcontact').text(error_smcontact);
        $('#smcontact').addClass('has-error');
        }
        else
        {
        
            error_smcontact = '';
            $('#error_smcontact').text(error_smcontact);
            $('#smcontact').removeClass('has-error');
        //    }
        }

        // Occupation
        if($.trim($('#smoccu').val()).length == 0)
        {
        error_smoccu = 'Put N/A if None';
        $('#error_smoccu').text(error_smoccu);
        $('#smoccu').addClass('has-error');
        }
        else
        {
        error_smoccu = '';
        $('#error_smoccu').text(error_smoccu);
        $('#smoccu').removeClass('has-error');
        } 

        // Company
        if($.trim($('#smcompany').val()).length == 0)
        {
        error_smcompany = 'Put N/A if None';
        $('#error_smcompany').text(error_smcompany);
        $('#smcompany').addClass('has-error');
        }
        else
        {
        error_smcompany = '';
        $('#error_smcompany').text(error_smcompany);
        $('#smcompany').removeClass('has-error');
        } 

        // ParentYearlyIncome
        if($.trim($('#spcyincome').val()).length == 0)
        {
        error_spcyincome = 'Parents Yearly Income is required';
        $('#error_spcyincome').text(error_spcyincome);
        $('#spcyincome').addClass('has-error');
        }
        else
        {
        error_spcyincome = '';
        $('#error_spcyincome').text(error_spcyincome);
        $('#spcyincome').removeClass('has-error');
        } 

        if( error_sgfname != '' ||
        error_sgaddress != '' ||
        error_sgcontact != '' ||
        error_sgoccu != '' ||
        error_sgcompany != '' ||
        error_sffname != '' ||
        error_sfaddress != '' ||
        error_sfcontact != '' ||
        error_sfoccu != '' ||
        error_sfcompany != '' ||
        error_smfname != '' ||
        error_smaddress != '' ||
        error_smcontact != '' ||
        error_smoccu != '' ||
        error_smcompany != '' ||
        error_spcyincome != '')
        {
        return false;
        }
        else
        {
            $('#list_family_details').removeClass('active active_tab1');
            $('#list_family_details').removeAttr('href data-toggle');
            $('#family_details').removeClass('active');
            $('#list_family_details').addClass('inactive_tab1');
            $('#list_achievement_details').removeClass('inactive_tab1');
            $('#list_achievement_details').addClass('active_tab1 active');
            $('#list_achievement_details').attr('href', '#achievement_details');
            $('#list_achievement_details').attr('data-toggle', 'tab');
            $('#achievement_details').addClass('active in');   
        }
        });

        $('#previous_btn_achievement_details').click(function(){
          $('#list_achievement_details').removeClass('active active_tab1');
          $('#list_achievement_details').removeAttr('href data-toggle');
          $('#achievement_details').removeClass('active in');
          $('#list_achievement_details').addClass('inactive_tab1');
          $('#list_family_details').removeClass('inactive_tab1');
          $('#list_family_details').addClass('active_tab1 active');
          $('#list_family_details').attr('href', '#family_details');
          $('#list_family_details').attr('data-toggle', 'tab');
          $('#family_details').addClass('active in');
        });

  // Achievement Details
        $('#btn_achievement_details').click(function(){
          
          var error_s_nas = '';
var error_s_basic = '';
var error_s_skills = '';
var error_s_work = '';

if($.trim($('#s_nas').val()).length == 0)
{
  error_s_nas = 'Reasons/Special Circumstances is required';
  $('#error_s_nas').text(error_s_nas);
  $('#s_nas').addClass('has-error');
}
else
{
  error_s_nas = '';
  $('#error_s_nas').text(error_s_nas);
  $('#s_nas').removeClass('has-error');
}

if($.trim($('#s_basic').val()).length == 0)
{
  error_s_basic = 'Basic Office Skills is required';
  $('#error_s_basic').text(error_s_basic);
  $('#s_basic').addClass('has-error');
}
else
{
  error_s_basic = '';
  $('#error_s_basic').text(error_s_basic);
  $('#s_basic').removeClass('has-error');
}

if($.trim($('#s_skills').val()).length == 0)
{
  error_s_skills = 'Special Skills is required';
  $('#error_s_skills').text(error_s_skills);
  $('#s_skills').addClass('has-error');
}
else
{
  error_s_skills = '';
  $('#error_s_skills').text(error_s_skills);
  $('#s_skills').removeClass('has-error');
}

if($.trim($('#s_work').val()).length == 0)
{
  error_s_work = 'Type of Work is required';
  $('#error_s_work').text(error_s_work);
  $('#s_work').addClass('has-error');
}
else
{
  error_s_work = '';
  $('#error_s_work').text(error_s_work);
  $('#s_work').removeClass('has-error');
}

if(error_s_nas != '' || 
   error_s_basic != '' ||
   error_s_skills != '' ||
   error_s_work != '')

          {
          return false;
          }
          else
          {
            $('#list_achievement_details').removeClass('active active_tab1');
            $('#list_achievement_details').removeAttr('href data-toggle');
            $('#achievement_details').removeClass('active');
            $('#list_achievement_details').addClass('inactive_tab1');
            $('#list_require_details').removeClass('inactive_tab1');
            $('#list_require_details').addClass('active_tab1 active');
            $('#list_require_details').attr('href', '#require_details');
            $('#list_require_details').attr('data-toggle', 'tab');
            $('#require_details').addClass('active in');  
          }
        });

        $('#previous_btn_requirement').click(function(){
          $('#list_require_details').removeClass('active active_tab1');
          $('#list_require_details').removeAttr('href data-toggle');
          $('#require_details').removeClass('active in');
          $('#list_require_details').addClass('inactive_tab1');
          $('#list_achievement_details').removeClass('inactive_tab1');
          $('#list_achievement_details').addClass('active_tab1 active');
          $('#list_achievement_details').attr('href', '#achievement_details');
          $('#list_achievement_details').attr('data-toggle', 'tab');
          $('#achievement_details').addClass('active in');
        });

  // Requirements Details
        $('#btn_submit').click(function(){
        });
      });


      

      

      </script>

 <!-- /.container-fluid -->
 </div>
      

 
 


 </div>
 <!-- End of Main Content -->

<!-- Footer -->
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->

</body>

</html>