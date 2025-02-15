<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$id = $_SESSION['user_id'];

// Fetch student data
$query = "SELECT sfname, smname, slname, semail, spass FROM students WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Set default values if data is not found
$sfname = isset($row['sfname']) ? $row['sfname'] : '';
$smname = isset($row['smname']) ? $row['smname'] : '';
$slname = isset($row['slname']) ? $row['slname'] : '';
$semail = isset($row['semail']) ? $row['semail'] : '';
$s_pass = isset($row['spass']) ? $row['spass'] : '';

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
              <a class="dropdown-item" href="#" data-toggle="modal" data-target="#profileEditModal">
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
        



        <?php

$user_id = $_SESSION['user_id'];


$sql = "SELECT sa.s_account_status, ast.s_scholar_status, ast.is_scholar 
        FROM students s
        LEFT JOIN scholarship_applications sa ON s.id = sa.student_id
        LEFT JOIN admin_status ast ON s.id = ast.student_id
        WHERE s.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$display_status = 'No Application Found'; 

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    if ($row['s_scholar_status'] === 'Approved' && $row['is_scholar'] == 1) {
        $display_status = 'Scholarship Approved';
    } elseif ($row['s_account_status'] === 'Valid') {
        $display_status = 'Pending';
    } elseif ($row['s_scholar_status'] === 'Rejected') {
        $display_status = 'Rejected';
    } elseif ($row['s_account_status'] === 'Invalid') { 
        $display_status = 'Rejected';
    }
}

$stmt->close();

?>

<div class="container-fluid mt-4">
<div class="row">
    <!-- Individual Scholarship Status Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-bg-gray text-uppercase mb-1">Application Status</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800 mt-4">
                            <?php echo htmlspecialchars($display_status); ?>
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
                    <div class="text-xs font-weight-bold text-bg-gray text-uppercase mb-1">Available Scholarships</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800 mt-4">
                        <?php 
                        $sql = "SELECT COUNT(*) as open_count FROM scholarship_status WHERE status = 'Open'";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        echo $row['open_count'] . " Available";
                        ?>
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
                    <div class="text-xs font-weight-bold text-bg-gray text-uppercase mb-1">Application Form</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800 mt-4">
                    </div>
                    <div class="mt-2">
                        <a href="application.php" class="text-primary" style="text-decoration: underline;">View Application Form</a>
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


							<!-- Officers Card -->
<div class="col-xl-4 col-lg-5">
    <div class="card shadow mb-4">
        <!-- Card Header -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-gray-800">Scholarship Officers</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="text-center">
                <div class="mb-4">
                    <h5 class="font-weight-bold">Gemini Daguplo</h5>
                    <div class="text-xs font-weight-bold text-gray-800 text-uppercase mb-1">Scholarship Head</div>

                </div>
                <div class="mb-4">
                    <h5 class="font-weight-bold">Gabriel</h5>
                    <div class="text-xs font-weight-bold text-gray-800 text-uppercase mb-1">Scholarship Secretary</div>
                </div>
                <div class="mb-4">
                    <h5 class="font-weight-bold">James</h5>
                    <div class="text-xs font-weight-bold text-gray-800 text-uppercase mb-1">Scholarship Marketing Officer</div>
                </div>
            </div>
        </div>
    </div>
</div>





</div>



<!-- Profile Edit Modal -->
<div class="modal fade" id="profileEditModal" tabindex="-1" role="dialog" aria-labelledby="profileEditModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileEditModalLabel">Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="profileEditForm" method="POST" action="update_profile.php">
                <div class="modal-body">
                <?php if(isset($_SESSION['modal_msg'])): ?>
                  <div class="alert <?php echo isset($_SESSION['modal_success']) && $_SESSION['modal_success'] ? 'alert-success' : 'alert-danger'; ?>">
        <?php 
        echo $_SESSION['modal_msg'];
        if(isset($_SESSION['modal_success'])) {
            echo "<script>
                setTimeout(function() {
                    $('#profileEditModal').modal('hide');
                }, 3000);
            </script>";
        }
        unset($_SESSION['modal_msg']); 
        unset($_SESSION['modal_success']);
        unset($_SESSION['show_modal']);
        ?>
    </div>
<?php endif; ?>

                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo htmlspecialchars($sfname); ?>" >
                    </div>
                    <div class="form-group">
                        <label>Middle Name</label>
                        <input type="text" class="form-control" name="middlename" id="middlename" value="<?php echo htmlspecialchars($smname); ?>">
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" name="lastname" id="lastname" value="<?php echo htmlspecialchars($slname); ?>">
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" class="form-control" name="email" id="email" value="<?php echo htmlspecialchars($semail); ?>">
                    </div>
                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" class="form-control" name="current_password" id="current_password">
                        <div id="current_password_message" class="text-danger"></div>
                    </div>
                  <div class="form-group">
                      <label>New Password</label>
                      <input type="password" class="form-control" name="new_password" id="new_password">
                      <small class="form-text text-muted">Leave blank if you don't want to change password</small>
                  </div>
                  <div class="form-group">
                      <label>Confirm New Password</label>
                      <input type="password" class="form-control" name="confirm_password" id="confirm_password">
                      <div id="password_match_message" class="text-danger"></div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Function to provide real-time feedback on form fields
    function validateFields() {
        const currentPassword = $('#current_password').val();
        const newPassword = $('#new_password').val();
        const confirmPassword = $('#confirm_password').val();

        // Show error if new password and confirm password do not match
        if (newPassword && confirmPassword && newPassword !== confirmPassword) {
            $('#password_match_message').html('Passwords do not match').addClass('text-danger').removeClass('text-success');
            $('#confirm_password').removeClass('is-valid').addClass('is-invalid');
        } else if (newPassword && confirmPassword && newPassword === confirmPassword) {
            $('#password_match_message').html('Passwords match').removeClass('text-danger').addClass('text-success');
            $('#confirm_password').removeClass('is-invalid').addClass('is-valid');
        } else {
            $('#password_match_message').html('');
            $('#confirm_password').removeClass('is-invalid is-valid');
        }

        // Show message if current password is missing when trying to change the password
        if (newPassword || confirmPassword) {
            if (!currentPassword) {
                $('#current_password_message').html('Current password is required for password changes').addClass('text-danger');
                $('#current_password').removeClass('is-valid').addClass('is-invalid');
            } else {
                $('#current_password_message').html('').removeClass('text-danger');
                $('#current_password').removeClass('is-invalid').addClass('is-valid');
            }
        } else {
            $('#current_password_message').html('');
            $('#current_password').removeClass('is-invalid is-valid');
        }
    }

    // Event listeners for real-time feedback
    $('#current_password, #new_password, #confirm_password').on('keyup', validateFields);
});




$(document).ready(function() {
    // Check if a session message is present and set a timer to close the modal
    <?php if (isset($_SESSION['modal_msg'])): ?>
        setTimeout(function() {
            $('#profileEditModal').modal('hide'); // Hide the modal after 3 seconds
        }, 3000); // 3-second timer
    <?php endif; ?>
});

// Poll notifications every 30 seconds
$(document).ready(function () {
    // Poll notifications every 30 seconds
    setInterval(fetchNotifications, 30000); // Check every 30 seconds

    // Fetch notifications
    function fetchNotifications() {
        $.ajax({
            url: 'check_announcements.php',
            dataType: 'json',
            success: function (data) {
                // Update notification count (badge)
                $('.badge-counter').text(data.count);

                // Update the dropdown notification list
                $('.dropdown-menu[aria-labelledby="alertsDropdown"]').html(data.notifications);
            },
            error: function () {
                console.error('Error fetching notifications.');
            }
        });
    }

    // Mark notifications as read when the bell is clicked
    $('.dropdown-toggle').on('click', function () {
        $.ajax({
            url: 'check_announcements.php',
            method: 'POST',
            data: { action: 'mark_read' },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('.badge-counter').text('0'); // Reset the notification count
                } else {
                    console.error('Failed to mark notifications as read:', response.error);
                }
            },
            error: function () {
                console.error('Error marking notifications as read.');
            }
        });
    });

    // Initial fetch on page load
    fetchNotifications();
});





</script>





<!-- Add status message display here -->
<?php if(isset($_SESSION['status_msg'])): ?>
    <div class="col-xl-12">
        <div class="alert alert-info">
            <?php 
            echo $_SESSION['status_msg'];
            unset($_SESSION['status_msg']); 
            ?>
        </div>
    </div>
<?php endif; ?>

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




  </div>
  <!-- End of Main Content -->



</div>
<!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->

</body>

</html>