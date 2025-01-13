<?php
session_start();


include('../includes/db.php');
if (!isset($_SESSION['user_id'])) {
  // Redirect to the login page if not logged in
  header("Location: ../login.php");
  exit();
}
$user_id = $_SESSION['user_id'];

$check_status = "SELECT sa.s_account_status, ast.s_scholar_status, ast.is_scholar 
                 FROM students s
                 LEFT JOIN scholarship_applications sa ON s.id = sa.student_id
                 LEFT JOIN admin_status ast ON s.id = ast.student_id
                 WHERE s.id = ?";

$stmt = $conn->prepare($check_status);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$status = $result->fetch_assoc();

// Add null checks before accessing array values
if ($status) {
    if(isset($status['s_scholar_status']) && $status['s_scholar_status'] === 'Approved' 
       && isset($status['is_scholar']) && $status['is_scholar'] == 1) {
        $_SESSION['status_msg'] = "Your scholarship application has been approved.";
        header("Location: index.php");
        exit();
    } 
    elseif(isset($status['s_scholar_status']) && $status['s_scholar_status'] === 'Rejected') {
        $_SESSION['status_msg'] = "Your scholarship application has been rejected.";
        header("Location: index.php");
        exit();
    }
    elseif(isset($status['s_account_status']) && $status['s_account_status'] === 'Pending') {
        $_SESSION['status_msg'] = "You have already submitted a scholarship application.";
        header("Location: index.php");
        exit();
      }
      elseif (isset($status['s_account_status']) && $status['s_account_status'] === 'Invalid') {
          $_SESSION['status_msg'] = "Your scholarship application has been rejected.";
          header("Location: index.php");
          exit();
    }
}





$query = "SELECT semail FROM students WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();


$semail = isset($row['semail']) ? $row['semail'] : '';


// In the notifications dropdown
$sql = "SELECT * FROM announcements WHERE student_id = ? AND is_read = 0 ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);

$stmt->execute();
$result = $stmt->get_result();


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

  <script src="../vendor/jquery/jquery.min.js"></script>

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">
  <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="../vendor/fontawesome/css/all.min.css" rel="stylesheet">

  <!-- Include jQuery (make sure to include this in the <head> or before your script) -->
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <?php
$announcement_query = "SELECT message FROM announcements ORDER BY created_at DESC LIMIT 1";
$announcement_result = $conn->query($announcement_query);
$announcement_text = "No announcement at the moment";
if ($announcement_result->num_rows > 0) {
    $announcement_text = $announcement_result->fetch_assoc()['message'];
}
?>

<style>
@keyframes scroll-left {
    0% { transform: translateX(100%); }
    100% { transform: translateX(-100%); }
}
.marquee-container {
    overflow: hidden;
    background-color: #f8f9fc;
    padding: 8px 0;
    width: 100%;
}
.marquee-text {
    display: inline-block;
    animation: scroll-left 25s linear infinite;
    white-space: nowrap;
}
</style>

<div class="marquee-container">
    <div class="marquee-text">
    <span style="color: red;"><?php echo htmlspecialchars($announcement_text); ?></span>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <span style="color: red;"><?php echo htmlspecialchars($announcement_text); ?></span>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <span style="color: red;"><?php echo htmlspecialchars($announcement_text); ?></span>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <span style="color: red;"><?php echo htmlspecialchars($announcement_text); ?></span>
    </div>
</div>
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

          <!-- Nav Item - Alerts -->
          <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-bell fa-fw text-white"></i>
                  <!-- Counter - Alerts -->
                  <span class="badge badge-danger badge-counter"><?php echo $count; ?></span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                  <h6 class="dropdown-header">Alerts Center</h6>
                  <?php
                  $sql = "SELECT subject, message, created_at FROM announcements WHERE student_id = ? AND is_read = 0 ORDER BY created_at DESC";
                  $stmt = $conn->prepare($sql);
                  $stmt->bind_param("i", $_SESSION['user_id']);
                  $stmt->execute();
                  $result = $stmt->get_result();

                  // Loop through the results and display each notification
                  while ($row = $result->fetch_assoc()) {
                      echo "<div class='dropdown-item'>";
                      echo "<div class='font-weight-bold'>" . htmlspecialchars($row['subject']) . "</div>";
                      echo htmlspecialchars($row['message']);
                      echo "<div class='small text-gray-500'>" . $row['created_at'] . "</div>";
                      echo "</div>";
                  }

                  // Show all alerts link
                  echo "<a class='dropdown-item text-center small text-gray-500' href='#'>Show All Alerts</a>";
                  ?>
              </div>
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
         
          
            
<!-- Form -->
<form method="post" name="apply_form" id="apply_form">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class="h3 mb-4 text-gray-800">Student Application Management</h1>
            <div class="card">
                <div class="card-header" style="font-weight: bold; font-size: 18px;">Scholarships</div>
                <div class="card-body">
                <div class="form-group">
    <select name="select_sch" id="select_sch" class="form-control">
        <option value="" selected>Choose Scholarship</option>
        <?php
        // Fetch active scholarships
        $sql = "SELECT id, scholarship_name FROM scholarship_status WHERE status = 'open'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['scholarship_name']) . "</option>";
            }
        } else {
            echo "<option value=''>No scholarships available</option>";
        }
        ?>
    </select>
</div>

                    <div class="form-group text-center">
                        <button type="button" name="btn_choose" id="btn_choose" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>



<script>
    $('#btn_choose').click(function() {
    var sel = $('#select_sch').val();
    
    switch(sel) {
        case "1":
            window.location.href = "application.php";
            break;
        case "2":
            window.location.href = "non-academic.php";
            break;
        case "3":
            window.location.href = "admin_app.php";
            break;
        case "4":
            window.location.href = "cultural.php";
            break;
        default:
            alert("Please select a scholarship");
    }
});

    var title = [];
    $('#select_sch option').each(function() {
      title.push($(this).attr('title'));
    });

    $("ul.selectpicker li").each(function(i) {
      $(this).attr('title', title[i]).tooltip({ container: "#tooltipBox" });
    });
</script>


          <!-- /.container-fluid -->
        </div>
      

   
       <!-- Bootstrap core JavaScript-->
  
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>
  


  </div>
  <!-- End of Main Content -->

<!-- Footer -->
<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span>Copyright &copy;2024</span>
    </div>
  </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->

</body>

</html>