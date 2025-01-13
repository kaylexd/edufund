<?php

include('../includes/db.php');

$sql = "SELECT COUNT(*) AS pending_count FROM scholarship_applications WHERE s_account_status = 'pending'";
$result = $conn->query($sql);

// Fetch the count from the result
$pending_count = 0;
if ($result && $row = $result->fetch_assoc()) {
    $pending_count = $row['pending_count'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Officer</title>

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
  <img src="../img/logo.png" alt="logo">
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
  <a class="nav-link" href="students.php">
  <i class="fa-solid fa-address-card"></i>
    <span>Applicants</span></a>
</li>

<li class="nav-item">
  <a class="nav-link" href="account.php">
  <i class="fa-solid fa-users"></i>
    <span>Students</span></a>
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

          
            
            

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-white small">
                  
               Officer
                  
                </span>
                <img class="img-profile rounded-circle" src="../img/undraw_profile_1.svg">
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
        

        <div class="container-fluid mt-4">
<div class="row">
<div class="container-fluid mt-4">
<div class="row">
    <!-- Individual Scholarship Status Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-bg-gray text-uppercase mb-1">Total Applicants</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php $sql = "SELECT COUNT(*) as total_count 
        FROM students s
        JOIN admin_status a ON s.id = a.student_id
        JOIN officer o ON s.id = o.student_id
        JOIN scholarship_applications sa ON s.id = sa.student_id
        WHERE a.is_scholar = 0
        AND a.s_scholar_status = 'Pending'
        AND o.account_status = 'Active'
        AND sa.s_scholarship_type IN ('Academic', 'Non-Academic', 'Admin Scholar')";

$result = $conn->query($sql);
$row = $result->fetch_assoc();
echo htmlspecialchars($row['total_count']);
 ?>
                        </div>
                        <div class="mt-2">
                            <a href="students.php" class="text-primary" style="text-decoration: underline;">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                <div class="text-xs font-weight-bold text-bg-gray text-uppercase mb-1">Total Registered</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                <?php 
                        $sql = "SELECT COUNT(*) AS total_count 
                        FROM students s
                        LEFT JOIN officer o ON s.id = o.student_id
                        LEFT JOIN admin_status a ON s.id = a.student_id
                        WHERE (a.is_scholar = 0 OR a.is_scholar IS NULL)";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                echo htmlspecialchars($row['total_count']);
                
                
                        ?>
                        </div>
                        <div class="mt-2">
                            <a href="account.php" class="text-primary" style="text-decoration: underline;">View Details</a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

   
    
    
							<!-- Chart Container -->
<div class="col-xl-8 col-lg-7">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-gray-800">Active Scholarships Distribution</h6>
        </div>
        <div class="card-body">
            <div class="chart-area">
                <canvas id="myAreaChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
// Area Chart
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Academic", "Non-Academic", "Admin Scholar"],
        datasets: [{
            label: "Active Scholarships",
            backgroundColor: [
                'rgba(78, 115, 223, 0.8)',
                'rgba(28, 200, 138, 0.8)',
                'rgba(231, 74, 59, 0.8)'
            ],
            data: [
                <?php
                $sql = "SELECT 
                    SUM(CASE WHEN s_scholarship_type = 'Academic' THEN 1 ELSE 0 END) as academic,
                    SUM(CASE WHEN s_scholarship_type = 'Non-Academic' THEN 1 ELSE 0 END) as nonacademic,
                    SUM(CASE WHEN s_scholarship_type = 'Admin Scholar' THEN 1 ELSE 0 END) as admin
                FROM scholarship_applications 
                WHERE s_account_status = 'Valid'";
                
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                
                echo $row['academic'] . ", ";
                echo $row['nonacademic'] . ", ";
                echo $row['admin'];
                ?>
            ]
        }]
    },
    options: {
        maintainAspectRatio: false,
        layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
            }
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        legend: {
            display: false
        },
        title: {
            display: true,
            text: 'Active Scholarships Distribution'
        }
    }
});

</script>


							<!-- Program Distribution Chart -->
<div class="col-xl-4 col-lg-5">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-gray-800">Programs</h6>
        </div>
        <div class="card-body">
            <div class="chart-pie pt-4 pb-2">
                <canvas id="myPieChart"></canvas>
            </div>
            <div class="mt-4 text-center small">
                <?php
                $courses = ['BSIT', 'BSBA', 'BEED', 'BSED', 'BSCRIM', 'BSHM', 'BSTM'];
                $colors = ['text-primary', 'text-success', 'text-info', 'text-warning', 'text-danger', 'text-secondary', 'text-dark'];
                foreach($courses as $index => $course) {
                    echo "<span class='mr-2'><i class='fas fa-circle {$colors[$index]}'></i> {$course}</span>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ["BSIT", "BSBA", "BEED", "BSED", "BSCRIM", "BSHM", "BSTM"],
        datasets: [{
            data: [
                <?php
                foreach($courses as $course) {
                    $sql = "SELECT COUNT(*) as count FROM students WHERE scourse = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $course);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $count = $result->fetch_assoc()['count'];
                    echo $count . ",";
                }
                ?>
            ],
            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796', '#5a5c69'],
            hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#dda20a', '#be2617', '#60616f', '#373840'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
    },
    options: {
        maintainAspectRatio: false,
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
        },
        legend: {
            display: false
        },
        cutoutPercentage: 80,
    },
});
</script>




</div>
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

  
  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="..//jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
  

  <!-- Page level plugins -->
  <script src="../vendor/chart.js/Chart.min.js"></script>
  <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

 

  </div>
  <!-- End of Main Content -->



</div>
<!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->

</body>

</html>